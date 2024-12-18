import numpy as np
import pandas as pd
import mysql.connector
from mysql.connector import Error
from datetime import datetime, timedelta
from statsmodels.tsa.arima.model import ARIMA
import warnings

def fetch_data_comments_and_reviews():
    try:
        connection = mysql.connector.connect(
            host='localhost',
            database='toy-shop',
            user='root',
            password=''
        )
        if connection.is_connected():
            cursor = connection.cursor()
            query = """
            SELECT DATE(c.dateComment) AS date, 
                   COUNT(*) AS comment_count, 
                   IFNULL(AVG(r.r_star), 0) AS r_star, 
                   COUNT(r.r_id) AS review_count
            FROM comments c
            LEFT JOIN review r ON DATE(c.dateComment) = DATE(r.r_date)
            GROUP BY DATE(c.dateComment)
            ORDER BY DATE(c.dateComment)
            """
            cursor.execute(query)
            rows = cursor.fetchall()
            data = {
                'date': [row[0] for row in rows],
                'comment_count': [row[1] for row in rows],
                'r_star': [row[2] for row in rows],
                'review_count': [row[3] for row in rows]
            }
            df = pd.DataFrame(data)
            return df
    except Error as e:
        print("Error while connecting to MySQL:", e)
        return pd.DataFrame()
    finally:
        if 'connection' in locals() and connection.is_connected():
            cursor.close()
            connection.close()
            print("MySQL connection is closed")

def add_noise_to_constant_series(series):
    """
    Add small random noise to a constant series to make it slightly variable
    """
    if series.nunique() == 1:
        print("Warning: Constant series detected. Adding small random noise.")
        # Add small random noise, scaled to the magnitude of the original series
        base_value = series.iloc[0]
        noise = np.random.normal(0, base_value * 0.01, len(series))
        return series + noise
    return series

def prepare_data(df):
    """
    Prepare and preprocess the data for ARIMA modeling
    """
    # Ensure data is not empty
    if df is None or df.empty:
        raise ValueError("No data available for analysis")

    # Convert date column
    df['date'] = pd.to_datetime(df['date'])
    df.set_index('date', inplace=True)

    # Suppress the deprecation warning and use ffill
    with warnings.catch_warnings():
        warnings.simplefilter("ignore", FutureWarning)
        df.fillna(method='ffill', inplace=True)
    df.fillna(0, inplace=True)

    # Ensure numeric columns and add noise if constant
    numeric_columns = ['comment_count', 'r_star', 'review_count']
    for col in numeric_columns:
        df[col] = pd.to_numeric(df[col], errors='coerce')
        df[col] = add_noise_to_constant_series(df[col])

    return df

def main():
    # Suppress statsmodels warnings
    warnings.filterwarnings('ignore', category=UserWarning)
    warnings.filterwarnings('ignore', category=RuntimeWarning)

    # Fetch and prepare data
    try:
        df = fetch_data_comments_and_reviews()
        
        # Check if we have enough data
        if len(df) < 2:
            print("Insufficient data for prediction. Need at least 2 data points.")
            return

        df = prepare_data(df)

        # Select time series and exogenous variables
        comment_series = df['comment_count']

        # Use a simple forecasting method if ARIMA fails
        try:
            # Try ARIMA first
            model = ARIMA(comment_series, order=(1,0,0))
            model_fit = model.fit()
        except Exception as e:
            print(f"ARIMA model failed: {e}")
            
            # Fallback to simple mean-based forecast
            mean_value = comment_series.mean()
            print(f"Falling back to mean-based forecast. Mean comment count: {mean_value}")

            # Create future dates
            last_date = df.index[-1]
            future_dates = [last_date + timedelta(days=i) for i in range(1, 8)]

            # Create forecast DataFrame with mean value
            df_future = pd.DataFrame({
                'date': future_dates,
                'predicted_comment_count': [mean_value] * 7
            })

            print("Forecast Results:")
            print(df_future)

            # Save predictions to database
            save_predictions_to_db(df_future)
            return

        # Forecast next 7 days
        forecast_steps = 7
        forecast = model_fit.forecast(steps=forecast_steps)

        # Ensure non-negative predictions
        forecast = np.maximum(forecast, 0)

        # Create future dates
        last_date = df.index[-1]
        future_dates = [last_date + timedelta(days=i) for i in range(1, forecast_steps + 1)]

        # Create forecast DataFrame
        df_future = pd.DataFrame({
            'date': future_dates,
            'predicted_comment_count': forecast
        })

        print("Forecast Results:")
        print(df_future)

        # Save predictions to database
        save_predictions_to_db(df_future)

    except Exception as e:
        print(f"An error occurred during prediction: {e}")

def save_predictions_to_db(df_future):
    """
    Save forecast predictions to MySQL database
    """
    try:
        connection = mysql.connector.connect(
            host='localhost',
            database='toy-shop',
            user='root',
            password=''
        )
        if connection.is_connected():
            cursor = connection.cursor()
            cursor.execute("DELETE FROM comments_predictions")
            
            # Use parameterized query for safety
            insert_query = """
            INSERT INTO comments_predictions 
            (prediction_date, predicted_comment_count) 
            VALUES (%s, %s)
            """
            
            # Prepare data for batch insert - convert to string format
            predictions_data = [
                (row['date'].strftime('%Y-%m-%d'), float(row['predicted_comment_count'])) 
                for _, row in df_future.iterrows()
            ]
            
            cursor.executemany(insert_query, predictions_data)
            connection.commit()
            print("Predictions saved successfully.")
    
    except Error as e:
        print(f"Database error: {e}")
        # Print out the exact data to help diagnose
        print("Problematic data:", predictions_data)
    
    finally:
        if 'connection' in locals() and connection.is_connected():
            cursor.close()
            connection.close()
            print("MySQL connection closed")

if __name__ == "__main__":
    main()