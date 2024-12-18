// Import các module cần thiết
const express = require('express');
const path = require('path'); // Để xử lý đường dẫn thư mục

// Khởi tạo ứng dụng Express
const app = express();

// Thiết lập cổng cho server
const PORT = process.env.PORT || 8080;

// Cấu hình EJS làm view engine
app.set('view engine', 'ejs');
app.set('views', path.join(__dirname, 'views')); // Thiết lập thư mục chứa các file EJS

// Định nghĩa một route
app.get('/', (req, res) => {
  res.render('index'); // Gửi dữ liệu vào view 'index.ejs'
});

// Khởi động server
app.listen(PORT, () => {
  console.log(`Server is running on http://localhost:${PORT}`);
});
