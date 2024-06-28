<?php
@include 'config.php';
session_start();
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$message = [];

function sanitizeInput($data)
{
    return trim($data);
}

if (isset($_POST['add_to_cart'])) {
    // Sanitize input data
    $pid = isset($_POST['pid']) ? sanitizeInput($_POST['pid']) : '';
    $p_name = isset($_POST['p_name']) ? sanitizeInput($_POST['p_name']) : '';
    $p_price = isset($_POST['p_price']) ? sanitizeInput($_POST['p_price']) : '';
    $p_image = isset($_POST['p_image']) ? sanitizeInput($_POST['p_image']) : '';
    $p_qty = isset($_POST['p_qty']) ? sanitizeInput($_POST['p_qty']) : '';

    // Handle cart items using cookies
    $cart_item = array(
        'pid' => $pid,
        'p_name' => $p_name,
        'p_price' => $p_price,
        'p_image' => $p_image,
        'p_qty' => $p_qty
    );

    // Initialize a flag to check if the item already exists in the cart
    $item_exists = false;

    // Check if the cart cookie exists and if the item already exists in the cart
    if (isset($_COOKIE['cart'])) {
        // Get existing cart items from cookie
        $cart = json_decode($_COOKIE['cart'], true);

        // Check if the item already exists in the cart
        foreach ($cart as $item) {
            if ($item['pid'] == $pid) {
                // Set the flag to true if the item already exists
                $item_exists = true;
                break;
            }
        }

        // If the item exists, show a message and do not add it again to the cart
        if ($item_exists) {
            $message[] = 'Item already in cart!';
        } else {
            // Append new item to cart array
            $cart[] = $cart_item;
            $message[] = 'Item added to cart!';
        }
    } else {
        // Create new cart array with the current item
        $cart = array($cart_item);
        $message[] = 'Item added to cart!';
    }

    // Store the updated cart array in a cookie if the item was not already in the cart
    if (!$item_exists) {
        setcookie('cart', json_encode($cart), time() + (86400 * 30), "/");
    }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home page</title>
    <!-- custom css file link  -->
    <link rel="stylesheet" href="./css/index.css">
    <script src="https://kit.fontawesome.com/8a540d2ee7.js" crossorigin="anonymous"></script>

</head>

<body>
    <!-- header -->
    <header class="main__container">

        <div class="header-flex">
            <nav class="navbar">
                <a href="home.php">MobileDukan</a>
            </nav>

            <div class="links">
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
            </div>


        </div>

    </header>
    <?php
    // to show messages
    if (isset($message)) {
        foreach ($message as $message) {
            echo '
  <div class="message">
	 <span>' . $message . '</span>
	 <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
  </div>
  ';
        }
    }

    ?>
    <!-- slideshow -->
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
        <div class="scrolling-text-inner" style="--marquee-speed: 5s; --direction:scroll-right" role="marquee">
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
    <!-- category -->
    <section class="category-section">

        <h1 class="category-title">Mobiles Category</h1>

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
    <!-- product  -->

    <section class="products">

        <h1 class="title">All Items</h1>

        <div class="container">

            <?php
            $select_products = $conn->prepare("SELECT * FROM `products` ORDER BY pd_rank ASC");
            $select_products->execute();
            $result = $select_products->get_result();
            if ($result->num_rows > 0) {
                while ($fetch_products = $result->fetch_assoc()) {
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
            } else {
                echo '<p class="empty">no products added yet!</p>';
            }
            ?>

        </div>

    </section>
    <script src="./slider.js"></script>

</body>

</html>