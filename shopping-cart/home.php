<?php
@include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:index.php');
    exit; 
}

$message = [];

if (isset($_POST['add_to_cart'])) {
    $pid = trim($_POST['pid']);
    $p_name = trim($_POST['p_name']);
    $p_price = trim($_POST['p_price']);
    $p_image = trim($_POST['p_image']);
    $p_qty = trim($_POST['p_qty']);



    // Check if item is already in cart
    $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
    $check_cart_numbers->bind_param("si", $p_name, $user_id);
    $check_cart_numbers->execute();
    $check_cart_numbers->store_result();

    if ($check_cart_numbers->num_rows > 0) {
        $message[] = 'already added to cart!';
    } else {
        // Insert item into cart
        $insert_cart = $conn->prepare("INSERT INTO `cart` (user_id, product_id, name, price, quantity, image) VALUES (?, ?, ?, ?, ?, ?)");
        $insert_cart->bind_param("isssis", $user_id, $pid, $p_name, $p_price, $p_qty, $p_image);
        $insert_cart->execute();
        $message[] = 'added to cart!';
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home page</title>
   <link rel="stylesheet" href="./css/index.css">
   <script src="https://kit.fontawesome.com/8a540d2ee7.js" crossorigin="anonymous"></script>

</head>
<body>
   
<?php include 'header.php'; ?>
<!-- slidshow -->
<div class="slideshow-container">

<div class="mySlides fade">

  <img src="./images/mob.jpg" style="width:100%">
</div>

<div class="mySlides fade">
  
  <img src="./images/mob1.jpg" style="width:100%">
</div>
<div class="mySlides fade">
  
  <img src="./images/mob2.jpg" style="width:100%">
</div>

<a class="prev" onclick="plusSlides(-1)">❮</a>
<a class="next" onclick="plusSlides(1)">❯</a>

</div>
<br>

<div style="text-align:center">
  <span class="dot" onclick="currentSlide(1)"></span> 
  <span class="dot" onclick="currentSlide(2)"></span> 
  <span class="dot" onclick="currentSlide(3)"></span> 
</div>
<!-- scrolling text -->
<div class="scrolling-text-container">
    <div class="scrolling-text-inner" style="--marquee-speed: 10s; --direction:scroll-right" role="marquee">
        <div class="scrolling-text">
            <div class="scrolling-text-item">50% Discounts On All Mobile Phones</div>
            <div class="scrolling-text-item">Iphone at lowset rate ever.</div>
			<div class="scrolling-text-item">Sale !!!</div>
			<div class="scrolling-text-item">MI sale 90%.</div>
			<div class="scrolling-text-item">Sale Sale Sale !!!</div>
			<div class="scrolling-text-item">Samsung Buyback Offer!</div>
        </div>
    </div>
</div>

  <!-- price range -->
  <section class="price-range-section">
        <h2 class="title">Price Range</h2>
        <div class="price-range-container">
            <a href="products_by_range.php?min=0&max=10000" class="price-range">Rs:(0 - 10,000)</a>
            <a href="products_by_range.php?min=10000&max=90000" class="price-range">Rs:(10,000 - 90,000)</a>
            <a href="products_by_range.php?min=90000" class="price-range">Rs:(90,000+)</a>
        </div>
    </section>
<!-- category display -->
<section class="category-section">

    <h1 class="title">Mobiles Category</h1>

    <div class="category-container">

	<div class="category-item">
            <img src="./images/apple.jpg" alt="Apple Logo" class="category-logo">
            <h3>Apple</h3>
            <a href="product_category.php?category=apple" class="category-link">Shop Now</a>
        </div>

        <div class="category-item">
            <img src="./images/sam12.png" alt="Samsung Logo" class="category-logo">
            <h3>Samsung</h3>
            <a href="product_category.php?category=samsung" class="category-link">Shop Now</a>
        </div>

        <div class="category-item">
		<img src="./images/mi.png" alt="Logo" class="category-logo">
            <h3>Xiaomi</h3>
            <a href="product_category.php?category=mi" class="category-link">Shop Now</a>
        </div>

        <div class="category-item">
		<img src="./images/oneplus.png" alt="Logo" class="category-logo">
            <h3>OnePlus</h3>
            <a href="product_category.php?category=oneplus" class="category-link">Shop now</a>
        </div>

    </div>

</section>
<!-- product details for all products as per ranking -->
<section class="products">

   <h1 class="title">All Items</h1>

   <div class="container">

   <?php
      $select_products = $conn->prepare("SELECT * FROM `products` ORDER BY pd_rank ASC");
      $select_products->execute();
      $result = $select_products->get_result();
      if($result->num_rows > 0){
         while($fetch_products = $result->fetch_assoc()){ 
   ?>
  <form action="" class="box" method="POST">
   <img src="submitted_img/<?= $fetch_products['image']; ?>" alt="">
   <div class="name"><?= $fetch_products['name']; ?></div>
   <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
   <input type="hidden" name="p_name" value="<?= $fetch_products['name']; ?>">
   <input type="hidden" name="p_price" value="<?= $fetch_products['price']; ?>">
   <input type="hidden" name="p_image" value="<?= $fetch_products['image']; ?>">
   <div class="price">Rs:<span><?= $fetch_products['price']; ?></span>/-</div>
   <input type="number" min="1" value="1" name="p_qty" class="qty">
   <input type="submit" value="add to cart" class="button" name="add_to_cart">
   <a href="product_view.php?pid=<?= $fetch_products['id']; ?>" class="button">View Item</a>
</form>
   <?php
      }
   }else{
      echo '<p class="empty">no products added yet!</p>';
   }
   ?>

   </div>

</section>
<script src="./slider.js"></script>

</body>
</html>