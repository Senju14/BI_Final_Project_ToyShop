# Chọn image nền (base image)
FROM node:14

# Thiết lập thư mục làm việc trong container
WORKDIR /app

# Copy file package.json vào container
COPY package.json .

# Cài đặt các dependencies
RUN npm install

# Copy toàn bộ mã nguồn vào container
COPY . .

# Mở cổng ứng dụng
EXPOSE 3000

# Lệnh chạy ứng dụng khi container khởi động
CMD ["node", "app.js"]
