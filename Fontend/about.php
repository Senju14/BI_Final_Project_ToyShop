<?php
include 'login.php';

include ('../Admin/connection/connectionpro.php');
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
product.p_type, 
product.p_image, 
product.p_name, 
product.p_price 
FROM 
`order`
INNER JOIN 
product ON `order`.p_id = product.p_id";

// Thực hiện truy vấn
$resultOrder = $conn->query($sqlOrder);

// Kiểm tra kết quả truy vấn
if ($resultOrder->num_rows > 0) {
	// Duyệt qua từng hàng dữ liệu từ kết quả truy vấn
	while ($row = $resultOrder->fetch_assoc()) {
		// Thêm thông tin từng hàng vào mảng $order_array
		$order_array[] = array( // hãy giữ []
			"o_id" => $row["o_id"],
			"u_id" => $row["u_id"],
			"p_id" => $row["p_id"],
			"o_price" => $row["o_price"],
			"o_quantity" => $row["o_quantity"],
			"o_status" => $row["o_status"],
			"p_type" => $row["p_type"],
			"p_image" => $row["p_image"],
			"p_name" => $row["p_name"],
			"p_price" => $row["p_price"]
		);
	}
} else {
	// echo "0 results";
}


function sumTotalPrice($order_array, $u_id)
{
	$totalPrice = 0; // Khởi tạo biến tổng giá tiền

	// Duyệt qua từng sản phẩm trong giỏ hàng và tính tổng giá tiền
	foreach ($order_array as $item) {
		// Kiểm tra xem u_id của sản phẩm có khớp với u_id được chỉ định hay không
		if ($item["u_id"] == $u_id && $item["o_status"] == 0) {
			// Tính giá tiền của mỗi sản phẩm (giá tiền * số lượng)
			$productPrice = $item["p_price"] * $item["o_quantity"];

			// Cộng vào tổng giá tiền
			$totalPrice += $productPrice;
		}
	}

	return $totalPrice; // Trả về tổng giá tiền
}

// Truy vấn để đếm số dòng trong bảng order
$sql = "SELECT COUNT(*) AS total_rows FROM `order` WHERE u_id = '{$userLogin['u_id']}' AND o_quantity > 0 AND o_status = 0";
$result = $conn->query($sql);

// Kiểm tra và hiển thị kết quả
if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();
	$order_count = $row["total_rows"];
} else {
	// echo "Không có dữ liệu trong bảng order";
}

// Truy vấn để đếm số dòng trong bảng order
$sql = "SELECT COUNT(*) AS total_rows FROM wishlist";
$result = $conn->query($sql);

// Kiểm tra và hiển thị kết quả
if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();
	$wishlist_count = $row["total_rows"];
} else {
	// echo "Không có dữ liệu trong bảng order";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>About Us</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v5.15.4/css/all.css">
	<!-- link icon -->
	<link rel="stylesheet" data-purpose="Layout StyleSheet" title="Web Awesome"
		href="/css/app-wa-8d95b745961f6b33ab3aa1b98a45291a.css?vsn=d">

	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/all.css">

	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-solid.css">

	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-regular.css">

	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-light.css">
	<!-- link icon -->
	<link rel="icon" type="image/png" href="images/icon.png" />
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/linearicons-v1.0.0/icon-font.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/slick/slick.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/MagnificPopup/magnific-popup.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/perfect-scrollbar/perfect-scrollbar.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v5.15.4/css/all.css">
	<!-- link icon -->
	<link rel="stylesheet" data-purpose="Layout StyleSheet" title="Web Awesome"
		href="/css/app-wa-8d95b745961f6b33ab3aa1b98a45291a.css?vsn=d">

	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/all.css">

	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-solid.css">

	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-regular.css">

	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-light.css">
	<!--===============================================================================================-->

	<!-- Light theme stylesheet -->
	<link href="light-theme.css" rel="stylesheet" id="theme-link">

</head>

<style>
	/* Format Image Team member*/
	.team-member-img img {
		border-radius: 50%;
		overflow: hidden;
		object-fit: cover;
		/* Ensure the image covers the entire container */
		width: 100%;
		/* Ensure the image fills the parent element */
	}

	.about-icon img {
		overflow: hidden;
		object-fit: cover;
		/* Ensure the image covers the entire container */
		width: 20%;
		/* Ensure the image fills the parent element */
		padding-right: 20px;
		padding-bottom: 15px;
	}

	/* Format Team member*/
	.team-member-info {
		text-align: center;
		font-family: Arial, sans-serif;
		/* Set font */
		font-size: 20px;
		font-weight: bold;
		color: #000;
		padding-top: 10px;
	}

	/* Set Padding icon for id*/
	#about-icon {
		padding-top: 25px;
	}

	/* Set Image Icon for id */
	#about-icon img {
		padding-right: 20px;
	}

	/* Set Font Size */
	#font-size {
		font-size: 20px;
	}

	.background-gray {
		background-color: rgb(231, 231, 231, 0.1);
		padding: 30px;
		background-image: url("images/background-image.png");
		background-position: center;
	}

	/* My Apology */
	.bubble-chat {
		position: relative;
		display: inline-block;
		padding: 10px 20px;
		border-radius: 20px;
		background-color: #f0f0f0;
		box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
		/* Add shadow */
	}

	.bubble-chat::after {
		content: '';
		position: absolute;
		bottom: -10px;
		left: 20px;
		border-style: solid;
		border-width: 10px 10px 0;
		border-color: #f0f0f0 transparent;
		display: block;
		width: 0;
	}

	.avatar {
		position: relative;
		perspective: 1000px;
		/* Create 3D effect */
	}

	.avatar img {
		width: 100%;
		height: auto;
		transition: transform 0.5s ease;
	}

	.avatar:hover img {
		transform: rotateY(180deg);
		background-color: rgba(255, 255, 255, 0.7);
	}

	.avatar .message {
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background-color: rgba(224, 224, 224, 0.7);
		color: white;
		display: flex;
		justify-content: center;
		align-items: center;
		opacity: 0;
		transition: opacity 0.5s ease;
	}

	.avatar:hover .message {
		opacity: 1;
		/* Display message on hover */
	}

	/* Button Facebook */
	.block2-btn {
		background-color: #FFEFEF;
	}

	@keyframes countup {
		from {
			opacity: 0;
		}

		to {
			opacity: 1;
		}
	}

	/* Counter Number */
	.counter-up {
		animation: countup 1.5s ease-in-out;
	}

	/* Resize Icon fa-2xl */
	.fa-2xl {
		font-size: 50px;
		/* or desired size */
	}


	/* Định dạng nút check out và view cart */
	#btn-cart {
		background-color: #F4538A;
		color: #FFEFEF;
	}

	#btn-cart:hover {
		background-color: black;
		color: #FFEFEF;
	}

	/* Định dạng nút delete */
	.btn-delete {
		color: black;
	}

	.btn-delete:hover {
		color: #F4538A;
	}
</style>


<body class="animsition">
	<!-- Header -->
	<header>
		<!-- Header desktop -->
		<div class="container-menu-desktop">
			<!-- Topbar -->
			<div class="top-bar">
				<div class="content-topbar flex-sb-m h-full container">
					<div class="left-top-bar">
						<div class="d-inline-flex align-items-center">
							<p style="color: #F4538A"><i class="fa fa-envelope mr-2"></i><a
									href="mailto:omachacontact@gmail.com"
									style="color: #000; text-decoration: none;">omachacontact@gmail.com</a></p>
							<p class="text-body px-3">|</p>
							<p style="color: #F4538A"><i class="fa fa-phone-alt mr-2"></i><a href="tel:+19223600"
									style="color: #000; text-decoration: none;">+1922 4800</a></p>
						</div>
					</div>

					<div class="col-lg-6 text-center text-lg-right">
						<div class="d-inline-flex align-items-center">
							<a class="text-primary px-3" href="https://www.facebook.com/profile.php?id=61557250007525"
								target="_blank" title="Visit the Reis Adventures fanpage.">
								<i style="color: #49243E;" class="fab fa-facebook-f"></i>
							</a>
							<a class="text-primary px-3" href="https://twitter.com/reis_adventures" target="_blank"
								title="Visit the Reis Adventures Twitter.">
								<i style="color: #49243E;" class="fab fa-twitter"></i>
							</a>
							<a class="text-primary px-3" href="https://www.linkedin.com/in/reis-adventures-458144300/"
								target="_blank" title="Visit the Reis Adventures Linkedin.">
								<i style="color: #49243E;" class="fab fa-linkedin-in"></i>
							</a>
							<a class="text-primary px-3"
								href="https://www.instagram.com/reis_adventures2024?igsh=YTQwZjQ0NmI0OA%3D%3D&utm_source=qr"
								target="_blank" title="Visit the Reis Adventures Instagram.">
								<i style="color: #49243E;" class="fab fa-instagram"></i>
							</a>
							<div class="data1">
								<i style="color: #49243E;" class=""></i>
								<a href="register.php" class="btn2 btn-primary2 mt-1"
									style="color: #49243E;"><b><?php echo $userLogin["u_id"]; ?>
										/</b></a>
							</div>
							<div class="data2">
								<i style="color: #49243E;" class=""></i>
								<a href="register.php" class="btn2 btn-primary2 mt-1"
									style="color: #49243E;"><b><?php echo $userLogin["userName"]; ?></b></a>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="wrap-menu-desktop" style="background-color: #FFEFEF;">
				<nav class="limiter-menu-desktop container" style="background-color: #FFEFEF;">

					<!-- Logo desktop -->
					<a href="index.php" class="navbar-brand">
						<h1 class="m-0 text-primary1 mt-3 "><span class="text-dark1"><img class="Imagealignment"
									src="images/icon.png">Omacha</h1>
					</a>

					<!-- Menu desktop -->
					<div class="menu-desktop">
						<ul class="main-menu">
							<li class="active-menu">
								<a href="index.php">Home</a>

							</li>

							<li class="label1" data-label1="hot">
								<a href="product2.php">Shop</a>
								<ul class="sub-menu">
									<li><a href="0_12months.php">0-12 Months</a></li>
									<li><a href="1_2years.php">1-2 Years</a></li>
									<li><a href="3+years.php">3+ Years</a></li>
									<li><a href="5+years.php">5+ Years</a></li>
								</ul>
							</li>

							<li>
								<a href="blog.php">Blog</a>
							</li>

							<li>
								<a href="contact.php">Contact</a>
							</li>

							<li>
								<a href="about.php">Pages</a>
								<ul class="sub-menu">
									<li><a href="about.php">About</a></li>
									<li><a href="FAQ.php">Faq</a></li>
								</ul>
							</li>
						</ul>
					</div>

					<!-- Icon header -->
					<div class="wrap-icon-header flex-w flex-r-m">
						<div class="icon-header-item cl13 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
							<i class="zmdi zmdi-search"></i>
						</div>

						<div class="icon-header-item cl13 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart"
							data-notify="<?php echo $order_count ?>">
							<i class="zmdi zmdi-shopping-cart"></i>
						</div>

						<a href="wishlist.php"
							class="dis-block icon-header-item cl13 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti"
							data-notify="<?php echo $wishlist_count ?>">
							<i class="zmdi zmdi-favorite-outline"></i>
						</a>
					</div>
				</nav>
			</div>
		</div>

		<!-- Header Mobile -->
		<div class="wrap-header-mobile">
			<!-- Logo moblie -->
			<div class="logo-mobile">
				<a href="index.php"><img src="images/icons/logo-01.png" alt="IMG-LOGO"></a>
			</div>

			<!-- Icon header -->
			<div class="wrap-icon-header flex-w flex-r-m m-r-15">
				<div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 js-show-modal-search">
					<i class="zmdi zmdi-search"></i>
				</div>

				<div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti js-show-cart"
					data-notify="2">
					<i class="zmdi zmdi-shopping-cart"></i>
				</div>

				<a href="#" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti"
					data-notify="0">
					<i class="zmdi zmdi-favorite-outline"></i>
				</a>
			</div>

			<!-- Button show menu -->
			<div class="btn-show-menu-mobile hamburger hamburger--squeeze">
				<span class="hamburger-box">
					<span class="hamburger-inner"></span>
				</span>
			</div>
		</div>


		<!-- Menu Mobile -->
		<div class="menu-mobile">
			<ul class="topbar-mobile">
				<li>
					<div class="left-top-bar ">
						Free shipping for standard order over $100
					</div>
				</li>

				<li>
					<div class="right-top-bar flex-w h-full">
						<a href="#" class="flex-c-m p-lr-10 trans-04">
							Help & FAQs
						</a>

						<a href="#" class="flex-c-m p-lr-10 trans-04">
							My Account
						</a>

						<a href="#" class="flex-c-m p-lr-10 trans-04">
							EN
						</a>

						<a href="#" class="flex-c-m p-lr-10 trans-04">
							USD
						</a>
					</div>
				</li>
			</ul>

			<ul class="main-menu-m">
				<li>
					<a href="index.php">Home</a>
					<ul class="sub-menu-m">
						<li><a href="index.php">Homepage 1</a></li>
						<li><a href="home-02.html">Homepage 2</a></li>
						<li><a href="home-03.html">Homepage 3</a></li>
					</ul>
					<span class="arrow-main-menu-m">
						<i class="fa fa-angle-right" aria-hidden="true"></i>
					</span>
				</li>

				<li>
					<a href="product2.php">Shop</a>
				</li>

				<li>
					<a href="shoping-cart.html" class="label1 rs1" data-label1="hot">Features</a>
				</li>

				<li>
					<a href="blog.php">Blog</a>
				</li>

				<li>
					<a href="about.php">About</a>
				</li>

				<li>
					<a href="contact.php">Contact</a>
				</li>

			</ul>
		</div>

		<!-- Modal Search -->
		<div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
			<div class="container-search-header">
				<button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
					<img src="images/icons/icon-close2.png" alt="CLOSE">
				</button>

				<form class="wrap-search-header flex-w p-l-15">
					<button class="flex-c-m trans-04">
						<i class="zmdi zmdi-search"></i>
					</button>
					<input class="plh3" type="text" name="search" placeholder="Search...">
				</form>
			</div>
		</div>
	</header>

	<!-- Cart -->
	<div class="wrap-header-cart js-panel-cart">
		<div class="s-full js-hide-cart"></div>

		<div class="header-cart flex-col-l p-l-65 p-r-25">
			<div class="header-cart-title flex-w flex-sb-m p-b-8">
				<span class="mtext-103 cl2">
					Your Cart
				</span>

				<div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
					<i class="zmdi zmdi-close"></i>
				</div>
			</div>

			<div class="header-cart-content flex-w js-pscroll">
				<ul class="header-cart-wrapitem w-full">
					<span>Congratulations! You&#39;ve got <strong>Free Shipping!</strong></span>
					<div class="progress1"></div>
					<br>
					<?php
					// Duyệt qua mỗi sản phẩm trong giỏ hàng và hiển thị thông tin
					foreach ($order_array as $item) {
						// Tách chuỗi hình ảnh thành mảng và loại bỏ khoảng trắng thừa
						$product_images = array_map('trim', explode(',', $item["p_image"]));
						// mới có u_id $userLogin["u_id"], 555
						if ($item["u_id"] == $userLogin["u_id"] && $item["o_quantity"] > 0 && $item["o_status"] == 0) {
							?>
							<li class="header-cart-item m-b-20">
								<div class="row">
									<div class="col-md-3">
										<div class="header-cart-item-img">
											<!-- Hiện hình trong giỏ hàng -->
											<img src="images/<?php echo $product_images[0]; ?>" alt="IMG">
										</div>
									</div>
									<div class="col-md-6">
										<div>
											<!-- Hiện tên sản phẩm trong giỏ hàng -->
											<a href="#"
												class="header-cart-item-name hov-cl1 trans-04"><?php echo $item["p_name"]; ?></a>
										</div>
										<!-- Hiện số lượng sản phẩm và giá tiền -->
										<span class="header-cart-item-info"><?php echo $item["o_quantity"]; ?> x
											$<?php echo $item["p_price"]; ?></span>
									</div>
									<div class="col-md-3">
										<form action="delete-cart2.php" method="post">
											<input type="hidden" name="p_id" value="<?php echo $item['p_id']; ?>">

											<!-- Nút xóa tại đây -->
											<input type="submit" value="X" name="delete-cart" class="btn-delete">
											<!-- <//?php print_r($item['p_id']); ?> -->
										</form>
									</div>
								</div>
							</li>
							<?php
						}
					}
					?>
				</ul>


				<div class="w-full">
					<div class="header-cart-total w-full p-tb-40">
						<?php $totalPrice = sumTotalPrice($order_array, $userLogin["u_id"]); ?> <!-- thay doi user -->
						<p>Total: $<?php echo $totalPrice; ?></p>
					</div>

					<div class="header-cart-buttons flex-w w-full">
						<a href="shopping-cart.php" id="btn-cart"
							class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10">
							View Cart
						</a>

						<a href="your-order.php" id="btn-cart"
							class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-10">
							Your Order
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>


	<!-- Title page -->
	<section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('images/background-image.png');">
		<h2 style="color: #000;" class="ltext-105 cl0 txt-center">
			About Us
		</h2>
	</section>


	<!-- Content page -->

	<!-- layer 01 -->
	<section class="bg0 p-t-75 p-b-120">
		<div class="container">
			<!-- Why choose toy time toys & games -->
			<div class="row p-b-30">
				<div class="col-md-7 col-lg-8">
					<div class="p-t-7 p-r-85 p-r-15-lg p-r-0-md">
						<h3 style="padding-left: 10%;" class="mtext-111 cl2 p-b-16">
							Why choose toy time toys & games
						</h3>

						<div id="about-icon" class="stext-113 cl6 p-b-26">
							<img src="images/About-Icon-1.webp" alt="IMG" height="50px">
							<b id="font-size">Premium Toys Products</b>
						</div>

						<div id="about-icon" class="stext-113 cl6 p-b-26">
							<img src="images/About-Icon-2.webp" alt="IMG" height="50px">
							<b id="font-size">More Than 60+ Unique Products: </b>
						</div>

						<div id="about-icon" class="stext-113 cl6 p-b-26">
							<img src="images/intro3.jpg" alt="IMG" height="50px">
							<b id="font-size">Free Shipping Available: </b>
						</div>
					</div>
				</div>

				<div class="col-11 col-md-5 col-lg-4 m-lr-auto">
					<div class="">
						<div class="hov-img0">
							<img src="images/About-Image.webp" alt="IMG">
						</div>
					</div>
				</div>
			</div>

			<!-- Material Product -->
			<section class="bg0 p-t-75 p-b-30">
				<div class="container">
					<h3 style="text-align: center; margin-bottom: 10px;" class="mtext-111 cl2 p-b-16">
						Materials in toys
					</h3>
					<div class="row background-gray">
						<!-- Icon 4 -->
						<div class="col-md-3 ">
							<div class="about-icon">
								<div style="color: #000; margin: 20px;">
									<img src="images/About-Icon-4.webp" alt="IMG">
									<b id="font-size">Cotton 76%</b>
									<p>Soft and breathable, making it suitable for cuddly toys and fabric-based toys.
									</p>
								</div>
							</div>
						</div>
						<!-- Icon 5 -->
						<div class="col-md-3">
							<div class="about-icon">
								<div style="color: #000; margin: 20px;">
									<img src="images/About-Icon-5.webp" alt="IMG">
									<b id="font-size">Wool 11%</b>
									<p>Provides warmth and texture, commonly used in plush toys and knit items.</p>
								</div>
							</div>
						</div>
						<!-- Icon 6 -->
						<div class="col-md-3">
							<div class="about-icon">
								<div style="color: #000; margin: 20px;">
									<img src="images/About-Icon-6.webp" alt="IMG">
									<b id="font-size">Rubber 10%</b>
									<p>Offers elasticity and durability, often used in bouncing balls and outdoor toys.
									</p>
								</div>
							</div>
						</div>
						<!-- Icon 7 -->
						<div class="col-md-3">
							<div class="about-icon">
								<div style="color: #000; margin: 20px;">
									<img src="images/About-Icon-7.jpg" alt="IMG">
									<b id="font-size">Polyester 3%</b>
									<p>Adds strength and wrinkle resistance, commonly found in stuffed animals and
										synthetic fabrics used in toys.</p>
								</div>
							</div>
						</div>
						<p></p>
					</div>
				</div>
			</section>

			<!-- The number of Account -->
			<section class="bg0 p-t-75 p-b-30">
				<div class="container">
					<h3 style="text-align: center; margin-bottom: 10px;" class="mtext-111 cl2 p-b-16">
						Statistical figures
					</h3>
					<div class="row background-gray mb-4">
						<!-- Icon 4 -->
						<div class="col-md-3">
							<div class="about-icon">
								<div style="color: #000; text-align: center; margin: 20px;">
									<i style="padding-top: 20px; color: #ff9ee5;"
										class="fa-duotone fa-user fa-bounce fa-2xl"></i>
									<div style="padding-top: 20px; font-size: 30px; font-weight: bold;"
										id="counter-user">1</div>
									<p style="font-size: 30px;">Users</p>
								</div>
							</div>
						</div>

						<!-- Icon 6 -->
						<div class="col-md-3">
							<div class="about-icon">
								<div style="color: #000; text-align: center; margin: 20px;">
									<i style="padding-top: 20px; color: #ff9ee5;"
										class="fa-duotone fa-teddy-bear fa-bounce fa-2xl"></i>
									<div style="padding-top: 20px; font-size: 30px; font-weight: bold;"
										id="counter-product">1</div>
									<p style="font-size: 30px;">Products</p>
								</div>
							</div>
						</div>

						<!-- Icon 5 -->
						<div class="col-md-3">
							<div class="about-icon">
								<div style="color: #000; text-align: center; margin: 20px;">
									<i style="padding-top: 20px; color: #ff9ee5;"
										class="fa-duotone fa-cart-shopping-fast fa-bounce fa-2xl"></i>
									<div style="padding-top: 20px; font-size: 30px; font-weight: bold;"
										id="counter-sold">1</div>
									<p style="font-size: 30px;">Quantity sold</p>
								</div>
							</div>
						</div>

						<!-- Icon 7 -->
						<div class="col-md-3">
							<div class="about-icon">
								<div style="color: #000; text-align: center; margin: 20px;">
									<i style="padding-top: 20px; color: #ff9ee5;"
										class="fa-duotone fa-truck-fast fa-bounce fa-2xl"></i>
									<div style="padding-top: 20px; font-size: 30px; font-weight: bold;"
										id="counter-delivery">1</div>
									<p style="font-size: 30px;">Orders</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>

			<div class="row p-b-148">
				<div class="col-md-7 col-lg-8">
					<div class="p-t-7 p-r-85 p-r-15-lg p-r-0-md">
						<h3 style="padding-left: 10%;" class="mtext-111 cl2 p-b-16">
							Our Story
						</h3>

						<p class="stext-113 cl6 p-b-26">
							We, the team at Omacha Store, take pride in being one of the leading destinations for
							providing quality and diverse toys for children. Our mission is not only to offer
							entertainment products but also to create enjoyable and educational experiences for every
							child.
						</p>

						<p class="stext-113 cl6 p-b-26">
							Starting from a simple idea, we have gradually built and developed our store with an
							unwavering commitment to providing the best products and the most attentive customer
							service. With a passion for children's development and happiness, we constantly seek new and
							creative ideas to provide exciting and educational experiences for kids.
						</p>

						<p class="stext-113 cl6 p-b-26">
							Over the years, Omacha Store has become a trusted destination for parents and children
							alike. The trust and support of our customers are the greatest motivation that helps us to
							continuously improve and grow every day.
						</p>

						<p class="stext-113 cl6 p-b-26">
							Join us on the journey to create memorable memories and nurture children's development
							through the world of play!
						</p>
					</div>
				</div>

				<div class="col-11 col-md-5 col-lg-4 m-lr-auto">
					<div class="how-bor1 ">
						<div class="hov-img0">
							<img src="images/About-Toy-1.webp" alt="IMG">
						</div>
					</div>
				</div>
			</div>

			<!-- layer 02 -->
			<div class="row">
				<div class="order-md-1 col-11 col-md-5 col-lg-4 m-lr-auto p-b-30">
					<div class="how-bor2">
						<div class="hov-img0">
							<img src="images/About-Toy-2.webp" alt="IMG">
						</div>
					</div>
				</div>

				<div class="order-md-2 col-md-7 col-lg-8 p-b-30">
					<div class="p-t-7 p-l-85 p-l-15-lg p-l-0-md">
						<h3 style="padding-left: 10%;" class="mtext-111 cl2 p-b-16">
							Our Mission
						</h3>

						<p class="stext-113 cl6 p-b-26">
							Our mission is to create a safe, convenient, and enjoyable shopping environment for parents
							and their children.
							We are committed to providing quality, safe, and age-appropriate toys that help children
							develop comprehensively in mind and spirit.
						</p>

						<div class="stext-113 cl6 p-b-26">
							<p class="stext-114 cl6 p-r-40 p-b-11">
								Additionally, we prioritize building a loving and supportive community where parents can
								share experiences, knowledge, and useful information about caring for and educating
								their children.
								We believe that support and sharing will help families become stronger and happier.
							</p>

							<div class="stext-113 cl6 p-b-26">
								<p class="stext-114 cl6 p-r-40 p-b-11">
									Through each product and service we provide, we hope to contribute to the
									development and happiness of every child, while creating memorable experiences for
									each of our customers' families.
								</p>

								<div class="bor16 p-l-29 p-b-9 m-t-22">
									<p class="stext-114 cl6 p-r-40 p-b-11">
										Coding with passion, creating with purpose, and innovating for a brighter
										future.
									</p>

									<span class="stext-111 cl8">
										- My Team Slogan
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>
	</section>

	<!-- Team Members -->
	<section class="bg0 p-t-75 p-b-30">
		<div class="container">
			<h3 style="text-align: center; " class="mtext-111 cl2 p-b-16">
				Our Team
			</h3>
			<div class="row">

				<!-- Team Member 1 -->
				<div class="col-md-3">
					<div class="team-member">
						<div class="team-member-img block2-pic hov-img0">
							<img src="images/ThuyKhanh1.jpg" alt="Team Member 1">
							<a href="#"
								class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
								<i class="fab fa-facebook"></i>
							</a>
						</div>
						<div class="team-member-info">
							<p>Nguyễn Thùy Khanh</p>
							<p class="stext-113 cl6">Leader</p>
							<p style="padding-top: 20px; font-weight: normal;">Welcome to our toy store! Explore a world
								full of colors and creativity with us.</p>
						</div>
					</div>
				</div>

				<!-- Team Member 2 -->
				<div class="col-md-3">
					<div class="team-member">
						<div class="team-member-img block2-pic hov-img0">
							<img src="images/HuuDat1.jpg" alt="Team Member 2">
							<a href="#"
								class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
								<i class="fab fa-facebook"></i>
							</a>
						</div>
						<div class="team-member-info">
							<p>Trần Hữu Đạt</p>
							<p class="stext-113 cl6">Customer Support</p>
							<p style="padding-top: 20px; font-weight: normal;">Let us help you find joy and happiness
								through each unique and exciting product</p>
						</div>
					</div>
				</div>

				<!-- Team Member 3 -->
				<div class="col-md-3">
					<div class="team-member">
						<div class="team-member-img block2-pic hov-img0">
							<img src="images/BinhQuyen1.jpg" alt="Team Member 3">
							<a href="#"
								class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
								<i class="fab fa-facebook"></i>
							</a>
						</div>
						<div class="team-member-info">
							<p>Trần Bỉnh Quyền</p>
							<p class="stext-113 cl6">Marketing Manager</p>
							<p style="padding-top:20px; font-weight: normal;">Experience the joy of childhood with our
								quality and safe products.</p>
						</div>
					</div>
				</div>

				<!-- Team Member 4 -->
				<div class="col-md-3">
					<div class="team-member">
						<div class="team-member-img block2-pic hov-img0">
							<img src="images/ThuyLinh1.jpg" alt="Team Member 4">
							<a href="#"
								class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
								<i class="fab fa-facebook"></i>
							</a>
						</div>
						<div class="team-member-info">
							<p>Dương Thị Thùy Linh</p>
							<p class="stext-113 cl6">Product Manager</p>
							<p style="padding-top:20px; font-weight: normal;">With the diversity and variety of our
								products, you'll surely find the perfect gift for every child in the family!</p>
						</div>
					</div>
				</div>

			</div>
		</div>
	</section>

	<!-- Footer -->
	<footer class="bg3 p-t-75 p-b-32">
		<div class="container">
			<div class="row">
				<div class="col-sm-6 col-lg-3 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						Categories
					</h4>

					<ul>
						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								Women
							</a>
						</li>

						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								Men
							</a>
						</li>

						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								Shoes
							</a>
						</li>

						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								Watches
							</a>
						</li>
					</ul>
				</div>

				<div class="col-sm-6 col-lg-3 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						Help
					</h4>

					<ul>
						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								Track Order
							</a>
						</li>

						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								Returns
							</a>
						</li>

						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								Shipping
							</a>
						</li>

						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								FAQs
							</a>
						</li>
					</ul>
				</div>

				<div class="col-sm-6 col-lg-3 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						GET IN TOUCH
					</h4>

					<p class="stext-107 cl7 size-201">
						Any questions? Let us know in store at 8th floor, 379 Hudson St, New York, NY 10018 or call us
						on (+1) 96 716 6879
					</p>

					<div class="p-t-27">
						<a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
							<i class="fa fa-facebook"></i>
						</a>

						<a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
							<i class="fa fa-instagram"></i>
						</a>

						<a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
							<i class="fa fa-pinterest-p"></i>
						</a>
					</div>
				</div>

				<div class="col-sm-6 col-lg-3 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						Newsletter
					</h4>

					<form>
						<div class="wrap-input1 w-full p-b-4">
							<input class="input1 bg-none plh1 stext-107 cl7" type="text" name="email"
								placeholder="email@example.com">
							<div class="focus-input1 trans-04"></div>
						</div>

						<div class="p-t-18">
							<button class="flex-c-m stext-101 cl0 size-103 bg1 bor1 hov-btn2 p-lr-15 trans-04">
								Subscribe
							</button>
						</div>
					</form>
				</div>
			</div>

			<div class="p-t-40">
				<div class="flex-c-m flex-w p-b-18">
					<a href="#" class="m-all-1">
						<img src="images/icons/icon-pay-01.png" alt="ICON-PAY">
					</a>

					<a href="#" class="m-all-1">
						<img src="images/icons/icon-pay-02.png" alt="ICON-PAY">
					</a>

					<a href="#" class="m-all-1">
						<img src="images/icons/icon-pay-03.png" alt="ICON-PAY">
					</a>

					<a href="#" class="m-all-1">
						<img src="images/icons/icon-pay-04.png" alt="ICON-PAY">
					</a>

					<a href="#" class="m-all-1">
						<img src="images/icons/icon-pay-05.png" alt="ICON-PAY">
					</a>

				</div>

				<p class="stext-107 cl6 txt-center">
					<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
					Copyright &copy;
					<script>
						document.write(new Date().getFullYear());
					</script> All rights reserved | Made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a
						href="https://colorlib.com" target="_blank">Colorlib</a> &amp; distributed by <a
						href="https://themewagon.com" target="_blank">ThemeWagon</a>
					<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->

				</p>
			</div>
		</div>
	</footer>


	<!-- Back to top -->
	<div class="btn-back-to-top" id="myBtn">
		<span class="symbol-btn-back-to-top">
			<i class="zmdi zmdi-chevron-up"></i>
		</span>
	</div>

	<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
	<script>
		$(".js-select2").each(function () {
			$(this).select2({
				minimumResultsForSearch: 20,
				dropdownParent: $(this).next('.dropDownSelect2')
			});
		})
	</script>
	<!--===============================================================================================-->
	<script src="vendor/MagnificPopup/jquery.magnific-popup.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
	<script>
		$('.js-pscroll').each(function () {
			$(this).css('position', 'relative');
			$(this).css('overflow', 'hidden');
			var ps = new PerfectScrollbar(this, {
				wheelSpeed: 1,
				scrollingThreshold: 1000,
				wheelPropagation: false,
			});

			$(window).on('resize', function () {
				ps.update();
			})
		});

		// Hieu ung con so chay
		let countUser = 0;
		const counterElementUser = document.getElementById('counter-user');

		const intervalIdUser = setInterval(() => {
			countUser = countUser + 6;
			counterElementUser.textContent = countUser;

			if (countUser >= 500) {
				clearInterval(intervalIdUser);
			}
		}, 15);

		let countDelivery = 0;
		const counterElementDelivery = document.getElementById('counter-delivery');

		const intervalIdDelivery = setInterval(() => {
			countDelivery = countDelivery + 9;
			counterElementDelivery.textContent = countDelivery;

			if (countDelivery >= 750) {
				clearInterval(intervalIdDelivery);
			}
		}, 15);

		let countProduct = 0;
		const counterElementProduct = document.getElementById('counter-product');

		const intervalIdProduct = setInterval(() => {
			countProduct = countProduct + 7;
			counterElementProduct.textContent = countProduct;

			if (countProduct >= 650) {
				clearInterval(intervalIdProduct);
			}
		}, 15);

		let countSold = 0;
		const counterElementSold = document.getElementById('counter-sold');

		const intervalIdSold = setInterval(() => {
			countSold = countSold + 21;
			counterElementSold.textContent = countSold;

			if (countSold >= 2000) {
				clearInterval(intervalIdSold);
			}
		}, 15);

		// document.addEventListener('DOMContentLoaded', function() {
		// 	const themeToggle = document.getElementById('theme-toggle');
		// 	let isDarkMode = false;

		// 	themeToggle.addEventListener('click', function() {
		// 		isDarkMode = !isDarkMode;
		// 		if (isDarkMode) {
		// 			document.body.classList.add('dark-theme'); // Thêm lớp dark-theme cho body
		// 		} else {
		// 			document.body.classList.remove('dark-theme'); // Loại bỏ lớp dark-theme khỏi body
		// 		}
		// 	});

		// 	// Kiểm tra nếu trình duyệt có hỗ trợ local storage và trạng thái chế độ tối đã được lưu trữ trước đó
		// 	if (window.localStorage && localStorage.getItem('theme')) {
		// 		const savedTheme = localStorage.getItem('theme');
		// 		if (savedTheme === 'dark') {
		// 			document.body.classList.add('dark-theme');
		// 			isDarkMode = true;
		// 		}
		// 	}
		// });

		// // Lưu trạng thái chế độ tối hoặc sáng vào local storage khi người dùng thay đổi
		// document.addEventListener('DOMContentLoaded', function() {
		// 	const themeToggle = document.getElementById('theme-toggle');
		// 	let isDarkMode = false;

		// 	themeToggle.addEventListener('click', function() {
		// 		isDarkMode = !isDarkMode;
		// 		if (isDarkMode) {
		// 			localStorage.setItem('theme', 'dark');
		// 		} else {
		// 			localStorage.setItem('theme', 'light');
		// 		}
		// 	});
		// });

		const btn = document.querySelector(".btn-toggle");
		const theme = document.querySelector("#theme-link");

		// Lắng nghe sự kiện click vào button
		btn.addEventListener("click", function () {
			// Nếu URL đang là "ligh-theme.css"
			if (theme.getAttribute("href") == "light-theme.css") {
				// thì chuyển nó sang "dark-theme.css"
				theme.href = "dark-theme.css";
			} else {
				// và ngược lại
				theme.href = "light-theme.css";
			}
		});
	</script>
	<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>

</html>