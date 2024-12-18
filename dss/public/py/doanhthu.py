import mysql.connector
from mysql.connector import Error
import pandas as pd
from sklearn.linear_model import LinearRegression  # Hồi quy tuyến tính

# Lấy dữ liệu từ MySQL
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

            # Truy vấn dữ liệu cảm xúc
            query_sentiment = """
            SELECT product_name, positive_percentage, negative_percentage
            FROM review_predictions
            """
            cursor.execute(query_sentiment)
            rows_sentiment = cursor.fetchall()

            # Truy vấn tổng số lượng bán hàng theo sản phẩm
            query_sales = """
            SELECT p.p_name AS product_name, SUM(o.o_quantity) AS total_quantity_sales
            FROM `order` o
            JOIN `product` p ON o.p_id = p.p_id
            GROUP BY p.p_name
            """
            cursor.execute(query_sales)
            rows_sales = cursor.fetchall()

            # Truy vấn doanh thu hàng tháng hiện tại
            query_monthly_revenue = """
            SELECT p.p_name AS product_name, SUM(o.o_price * o.o_quantity) AS current_month_revenue
            FROM `order` o
            JOIN `product` p ON o.p_id = p.p_id
            GROUP BY p.p_name
            """
            cursor.execute(query_monthly_revenue)
            rows_monthly_revenue = cursor.fetchall()

            # Tạo DataFrames
            df_sentiment = pd.DataFrame(rows_sentiment, columns=['product_name', 'positive_percentage', 'negative_percentage'])
            df_sales = pd.DataFrame(rows_sales, columns=['product_name', 'total_quantity_sales'])
            df_monthly_revenue = pd.DataFrame(rows_monthly_revenue, columns=['product_name', 'current_month_revenue'])

            return df_sentiment, df_sales, df_monthly_revenue

    except Error as e:
        print("Error while connecting to MySQL:", e)
        return None, None, None
    finally:
        if 'connection' in locals() and connection.is_connected():
            connection.close()

# Lấy dữ liệu
df_sentiment, df_sales, df_monthly_revenue = fetch_data()

if df_sentiment is not None and df_sales is not None and df_monthly_revenue is not None:
    # Gộp dữ liệu từ các bảng lại
    df_combined = df_sentiment.merge(df_sales, on='product_name', how='left')
    df_combined = df_combined.merge(df_monthly_revenue, on='product_name', how='left')

    # Xử lý giá trị NaN và chuyển đổi dữ liệu
    df_combined.fillna(0, inplace=True)

    # Chuẩn bị dữ liệu đầu vào (X) và đầu ra (y)
    X = df_combined[['positive_percentage', 'negative_percentage', 'total_quantity_sales']]
    y = df_combined['current_month_revenue']

    # Huấn luyện mô hình hồi quy tuyến tính
    model = LinearRegression()
    model.fit(X, y)

    # Dự đoán doanh thu
    df_combined['revenue'] = model.predict(X)

    # In kết quả dự đoán
    print("\nDự đoán doanh thu:")
    print(df_combined[['product_name', 'revenue']])

    # Lưu dự đoán vào MySQL
    try:
        connection = mysql.connector.connect(
            host='localhost',
            database='toy-shop',
            user='root',
            password=''
        )
        if connection.is_connected():
            cursor = connection.cursor()
            cursor.execute("DELETE FROM predictions")  # Xóa dữ liệu cũ nếu có

            insert_query = """
            INSERT INTO predictions (month, revenue)
            VALUES (%s, %s)
            """
            
            # Gán tháng mặc định và chuẩn bị dữ liệu chèn
            month_value = 1  # Ví dụ, tháng 1. Bạn có thể thay đổi nó theo yêu cầu.
            data_to_insert = [(month_value, revenue) for revenue in df_combined['revenue'].tolist()]
            cursor.executemany(insert_query, data_to_insert)
            connection.commit()
            print("Dự đoán doanh thu đã lưu vào bảng 'predictions'.")
    except Error as e:
        print("Error while connecting to MySQL:", e)
    finally:
        if 'connection' in locals() and connection.is_connected():
            connection.close()
else:
    print("Không có dữ liệu hợp lệ.")
