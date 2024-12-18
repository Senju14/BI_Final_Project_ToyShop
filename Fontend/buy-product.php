<?php

include 'login.php';

include('../Admin/connection/connectionpro.php');
require_once '../Admin/connection/connectData.php';


if (!isset($_SESSION["user"])) {
    // Redirect user to the login page if not logged in
    header("Location: login.html");
    exit(); // Stop further execution of the script
}

$userName = $_SESSION["user"];
// print_r($userName);
$sqlLogin = "SELECT * FROM `login` WHERE userName = '$userName' ";
$queryLogin = mysqli_query($conn, $sqlLogin);
// print_r($queryLogin);
// Kiểm tra kết quả truy vấn

// Duyệt qua từng hàng dữ liệu từ kết quả truy vấn
$row = $queryLogin->fetch_assoc();
// Thêm thông tin từng hàng vào mảng $vuserLogin
$userLogin = array(
    "u_id" => $row["u_id"],
    "userName" => $row["userName"],
    "email" => $row["email"],
);

$sql = "SELECT * FROM product";
$query = mysqli_query($conn, $sql);


// Câu truy vấn SQL SELECT
$sqlOrder = "SELECT 
`order`.o_id, 
`order`.u_id, 
`order`.p_id, 
`order`.o_price, 
`order`.o_status, 
`order`.o_quantity,
`order`.Product_Name,
`order`.Product_Category,
`order`.Product_Cost,
`order`.Product_Price,
`order`.Stock_On_Hand,
`order`.Sale_ID,
`order`.o_date,
`order`.Store_Name,
`order`.Store_City,
`order`.Store_Location,
`order`.Store_Open_Date
FROM 
`order`
INNER JOIN 
product ON `order`.p_id = product.p_id";

// Thực hiện truy vấn
$resultOrder = $conn->query($sqlOrder);

// Mảng chứa thông tin các đơn hàng
$order_array = array();

// Kiểm tra kết quả truy vấn
if ($resultOrder->num_rows > 0) {
    // Duyệt qua từng hàng dữ liệu từ kết quả truy vấn
    while ($row = $resultOrder->fetch_assoc()) {
        if ($row['u_id'] == $userLogin['u_id'] && $row['o_status'] == 1) {
            // Thêm thông tin từng hàng vào mảng $order_array
            $order_array[] = array(
                "o_id" => $row["o_id"],                       // ID đơn hàng
                "u_id" => $row["u_id"],                       // ID người dùng
                "p_id" => $row["p_id"],                       // ID sản phẩm
                "o_price" => $row["o_price"],                 // Tổng giá trị đơn hàng
                "o_quantity" => $row["o_quantity"],           // Số lượng đơn hàng
                "o_status" => $row["o_status"],               // Trạng thái đơn hàng
                "Product_Name" => $row["Product_Name"],       // Tên sản phẩm
                "Product_Category" => $row["Product_Category"], // Loại sản phẩm
                "Product_Cost" => $row["Product_Cost"],       // Giá vốn sản phẩm
                "Product_Price" => $row["Product_Price"],     // Giá bán sản phẩm
                "Stock_On_Hand" => $row["Stock_On_Hand"],     // Số lượng hàng tồn
                "Sale_ID" => $row["Sale_ID"],                 // ID đơn hàng bán
                "o_date" => $row["o_date"],                   // Ngày tạo đơn hàng
                "Store_Name" => $row["Store_Name"],           // Tên cửa hàng
                "Store_City" => $row["Store_City"],           // Thành phố cửa hàng
                "Store_Location" => $row["Store_Location"],   // Vị trí cửa hàng
                "Store_Open_Date" => $row["Store_Open_Date"]  // Ngày mở cửa hàng
            );
        }
    };
} else {
    // echo "0 results";
}

function updateOrderStatus($u_id)
{
    global $conn;
    // Cập nhật trạng thái đơn hàng
    $sqlUpdate = "UPDATE `order` SET o_status = 1 WHERE u_id = '{$u_id}'";
    $result = $conn->query($sqlUpdate);

    if ($result) {
        header('location: your-order.php');
        // return true;
    } else {
        // Trả về false nếu cập nhật thất bại
        // return false;
    }
}

updateOrderStatus($userLogin["u_id"]);
