import numpy as np
import pandas as pd
from sklearn.linear_model import LinearRegression
import mysql.connector
from mysql.connector import Error

# Hàm lấy dữ liệu từ MySQL
def fetch_data():
    try:
        connection = mysql.connector.connect(
            host='localhost',
            database='toy-shop',
            user='root',
            password=''
        )

        if connection.is_connected():
            cursor = connection.cursor()

            # Truy vấn tất cả sản phẩm có trong bảng `order`
            query_all_products = """
            SELECT DISTINCT p.p_name AS product_name
            FROM `order` o
            JOIN `product` p ON o.p_id = p.p_id
            """
            cursor.execute(query_all_products)
            all_products_rows = cursor.fetchall()

            product_data = {'product_name': [row[0] for row in all_products_rows]}
            df_all_products = pd.DataFrame(product_data)

            # Truy vấn dữ liệu: bảng dự đoán đánh giá cảm xúc
            query_sentiment = """
            SELECT product_name, positive_percentage, negative_percentage
            FROM review_predictions
            """
            cursor.execute(query_sentiment)
            sentiment_rows = cursor.fetchall()

            sentiment_data = {
                'product_name': [row[0] for row in sentiment_rows],
                'positive_percentage': [row[1] for row in sentiment_rows],
                'negative_percentage': [row[2] for row in sentiment_rows]
            }
            df_sentiment = pd.DataFrame(sentiment_data)

            # Truy vấn dữ liệu: bảng tổng số lượng bán theo sản phẩm
            query_sales = """
            SELECT p.p_name AS product_name, SUM(o.o_quantity) AS total_sold
            FROM `order` o
            JOIN `product` p ON o.p_id = p.p_id
            GROUP BY p.p_name
            """
            cursor.execute(query_sales)
            sales_rows = cursor.fetchall()

            sales_data = {
                'product_name': [row[0] for row in sales_rows],
                'total_quantity_sales': [row[1] for row in sales_rows]
            }
            df_sales = pd.DataFrame(sales_data)

            # Truy vấn dữ liệu: bán hàng theo tháng cho từng sản phẩm
            query_monthly_sales = """
            SELECT p.p_name AS product_name, YEAR(o.o_date) AS year, MONTH(o.o_date) AS month, SUM(o.o_quantity) AS total_quantity
            FROM `order` o
            JOIN `product` p ON o.p_id = p.p_id
            GROUP BY p.p_name, year, month
            """
            cursor.execute(query_monthly_sales)
            monthly_sales_rows = cursor.fetchall()

            monthly_sales_data = {
                'product_name': [row[0] for row in monthly_sales_rows],
                'year': [row[1] for row in monthly_sales_rows],
                'month': [row[2] for row in monthly_sales_rows],
                'total_quantity_monthly': [row[3] for row in monthly_sales_rows]
            }
            df_monthly_sales = pd.DataFrame(monthly_sales_data)

            return df_all_products, df_sentiment, df_sales, df_monthly_sales

    except Error as e:
        print("Error while connecting to MySQL:", e)
        return pd.DataFrame(), pd.DataFrame(), pd.DataFrame(), pd.DataFrame()
    finally:
        if 'connection' in locals() and connection.is_connected():
            connection.close()

# Lấy dữ liệu
df_all_products, df_sentiment, df_sales, df_monthly_sales = fetch_data()

# Đảm bảo dữ liệu được lấy thành công
if not df_all_products.empty:
    # Merge tất cả bảng với df_all_products
    df_combined = pd.merge(df_all_products, df_sentiment, on='product_name', how='left')
    df_combined = pd.merge(df_combined, df_sales, on='product_name', how='left')
    df_combined = pd.merge(df_combined, df_monthly_sales, on='product_name', how='left')

    # Xử lý giá trị NaN thành 0
    df_combined.fillna(0, inplace=True)

    # In bảng dữ liệu kết hợp
    print("Bảng dữ liệu kết hợp:")
    print(df_combined)

    # Tiền xử lý dữ liệu cho mô hình
    X = df_combined[['positive_percentage', 'negative_percentage', 'total_quantity_monthly']]
    y = df_combined['total_quantity_sales']

    if X.shape[0] > 0:
        model = LinearRegression()
        model.fit(X, y)
        df_combined['predicted_quantity'] = model.predict(X)

        print("\nDự đoán số lượng bán hàng:")
        print(df_combined[['product_name', 'predicted_quantity']])

        # Lưu dữ liệu vào bảng `product_predictions`
        try:
            connection = mysql.connector.connect(
                host='localhost',
                database='toy-shop',
                user='root',
                password=''
            )
            if connection.is_connected():
                cursor = connection.cursor()
                insert_query = """
                INSERT INTO product_predictions (product_name, total_quantity)
                VALUES (%s, %s)
                """
                data_to_insert = df_combined[['product_name', 'predicted_quantity']].values.tolist()
                cursor.executemany(insert_query, data_to_insert)
                connection.commit()
                print("Dữ liệu đã lưu vào bảng 'product_predictions'.")
        except Error as e:
            print("Error while connecting to MySQL:", e)
        finally:
            if 'connection' in locals() and connection.is_connected():
                connection.close()
else:
    print("Không có dữ liệu hợp lệ để huấn luyện mô hình.")
