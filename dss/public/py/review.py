import mysql.connector
import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.feature_extraction.text import CountVectorizer
from sklearn.naive_bayes import MultinomialNB
from sklearn.metrics import classification_report

# Kết nối MySQL và lấy dữ liệu
def fetch_data():
    try:
        conn = mysql.connector.connect(
            host='localhost',
            user='root',
            password='',
            database='toy-shop'
        )
        if conn.is_connected():
            print("Kết nối MySQL thành công.")

            # Truy vấn dữ liệu từ bảng review
            query_review = """
                SELECT r_description, r_star, p_name 
                FROM review 
                JOIN product ON review.p_id = product.p_id
            """
            
            # Truy vấn dữ liệu từ bảng comments
            query_comments = """
                SELECT commentText AS r_description, 'neutral' AS r_star, comments.p_id, product.p_name
                FROM comments
                JOIN product ON comments.p_id = product.p_id
            """
            
            df_review = pd.read_sql(query_review, conn)
            df_comments = pd.read_sql(query_comments, conn)
            
            # Gộp hai bảng dữ liệu lại
            combined_df = pd.concat([df_review, df_comments], ignore_index=True)
            return combined_df, df_comments
    except mysql.connector.Error as e:
        print(f"Lỗi kết nối MySQL: {e}")
        return pd.DataFrame(), pd.DataFrame()
    finally:
        if 'conn' in locals() and conn.is_connected():
            conn.close()
            print("Đã đóng kết nối MySQL.")

# Lấy dữ liệu từ bảng review và comments
df_combined, df_comments = fetch_data()

# Kiểm tra dữ liệu không rỗng
if not df_combined.empty:
    # Chuẩn hóa dữ liệu: chuyển r_star thành nhãn cảm xúc
    def label_sentiment(star):
        try:
            star = int(star)
            if star >= 4:
                return 'positive'
            elif star <= 2:
                return 'negative'
            else:
                return 'neutral'
        except ValueError:
            return 'neutral'

    df_combined['sentiment'] = df_combined['r_star'].apply(label_sentiment)
    
    # Chỉ lấy dữ liệu positive và negative để huấn luyện
    df_combined = df_combined[df_combined['sentiment'] != 'neutral']
    df_combined['r_description'].fillna('', inplace=True)

    # Tách dữ liệu và nhãn
    X = df_combined['r_description']
    y = df_combined['sentiment']

    # Biến đổi văn bản thành ma trận đếm từ
    vectorizer = CountVectorizer()
    X_vect = vectorizer.fit_transform(X)

    # Chia dữ liệu thành tập huấn luyện và kiểm thử
    X_train, X_test, y_train, y_test = train_test_split(X_vect, y, test_size=0.2, random_state=42)

    # Huấn luyện mô hình Naive Bayes
    model = MultinomialNB()
    model.fit(X_train, y_train)

    # Dự đoán trên tập kiểm thử
    y_pred = model.predict(X_test)
    print("\nKết quả đánh giá mô hình:\n")
    print(classification_report(y_test, y_pred))

    # Dự đoán cảm xúc cho toàn bộ dữ liệu từ bảng review
    df_combined['sentiment_pred'] = model.predict(X_vect)

    # Dự đoán cảm xúc cho commentText từ bảng comments
    if not df_comments.empty:
        # Biến đổi commentText thành ma trận đếm từ
        X_comments_vect = vectorizer.transform(df_comments['r_description'])
        
        # Dự đoán cảm xúc cho commentText
        df_comments['sentiment_pred'] = model.predict(X_comments_vect)

        # Tính tỷ lệ positive và negative theo từng sản phẩm
        sentiment_count = df_comments.groupby('p_name')['sentiment_pred'].value_counts().unstack(fill_value=0)

        # Tính tỷ lệ
        sentiment_count['total'] = sentiment_count.sum(axis=1)
        sentiment_count['positive_percentage'] = (sentiment_count['positive'] / sentiment_count['total']) * 100
        sentiment_count['negative_percentage'] = (sentiment_count['negative'] / sentiment_count['total']) * 100

        # Chỉ lấy sản phẩm và tỷ lệ positive/negative
        sentiment_count = sentiment_count[['positive_percentage', 'negative_percentage']]

        print("\nTỷ lệ bình luận positive và negative theo sản phẩm:")
        print(sentiment_count)

        # Lưu tỷ lệ vào bảng review_predictions
        try:
            conn = mysql.connector.connect(
                host='localhost',
                user='root',
                password='',
                database='toy-shop'
            )
            cursor = conn.cursor()

            # Tạo bảng review_predictions nếu chưa có
            cursor.execute(""" 
                CREATE TABLE IF NOT EXISTS review_predictions (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    product_name VARCHAR(255),
                    positive_percentage DECIMAL(5, 2),
                    negative_percentage DECIMAL(5, 2)
                )
            """)

            # Xóa dữ liệu cũ trong bảng (nếu cần làm mới)
            cursor.execute("DELETE FROM review_predictions")
            conn.commit()

            # Thêm dữ liệu tỷ lệ của từng sản phẩm
            insert_query = """
                INSERT INTO review_predictions (product_name, positive_percentage, negative_percentage)
                VALUES (%s, %s, %s)
            """
            data_to_insert = sentiment_count.reset_index().values.tolist()
            cursor.executemany(insert_query, data_to_insert)
            conn.commit()
            print("Tỷ lệ bình luận positive và negative đã được lưu vào bảng review_predictions.")
        except mysql.connector.Error as e:
            print(f"Lỗi khi lưu dữ liệu: {e}")
        finally:
            if 'conn' in locals() and conn.is_connected():
                conn.close()

else:
    print("Không có dữ liệu để xử lý.")
