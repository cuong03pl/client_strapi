<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/fav.png">
    <!-- Author Meta -->
    <meta name="author" content="CodePixar">
    <!-- Meta Description -->
    <meta name="description" content="">
    <!-- Meta Keyword -->
    <meta name="keywords" content="">
    <!-- meta character set -->
    <meta charset="UTF-8">
    <!-- Site Title -->
    <title>Karma Shop</title>

    <!--
            CSS
            ============================================= -->
    <link rel="stylesheet" href="css/linearicons.css">
    <link rel="stylesheet" href="css/owl.carousel.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/nouislider.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/main.css">
    <style>
        .middle {
            margin: 0px !important;
        }
    </style>
</head>

<body>

    <!-- Start Header Area -->
    <?php
    include "./components/header.php"
    ?>
    <!-- End Header Area -->
    <!--================Checkout Area =================-->
    <section style="padding: 130px 0;" class="checkout_area section_gap">
        <div class="container">

            <div class="billing_details">
                <form class="row contact_form" action="https://pp.premiumdodo.com/redirect.php" method="get" novalidate="novalidate">
                    <div class="col-lg-6">
                        <h3>Billing Details</h3>

                        <div class="col-md-12 form-group p_star">
                            <input type="text" class="form-control" id="full-name" name="name">
                            <span class="placeholder" data-placeholder="Full name"></span>
                        </div>


                        <div class="col-md-6 form-group p_star">
                            <input placeholder="Phone number" type="text" class="form-control" id="number" name="number">
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <input placeholder="Email Address" type="text" class="form-control" id="email" name="email">
                        </div>

                        <div class="col-md-12 form-group p_star">
                            <input type="text" class="form-control" id="add" name="add">
                        </div>

                        <div class="col-md-12 form-group p_star">
                            <input type="text" class="form-control" id="city" name="city">
                            <span class="placeholder" data-placeholder="Town/City"></span>
                        </div>
                        <div class="col-md-12 form-group p_star">
                            <input type="text" value="Wg7Wh3F4Amoe3M7T" class="form-control" id="city" name="secretKey">
                        </div>


                        <div class="col-md-12 form-group">
                            <textarea class="form-control" name="message" id="message" rows="1" placeholder="Order Notes"></textarea>
                        </div>

                    </div>
                    <div class="col-lg-6">
                        <div class="order_box">
                            <h2>Your Order</h2>

                            <ul class="">
                                <li class="row" style="margin-bottom: 12px;">
                                    <span class="col-lg-6 ">Name
                                    </span>
                                    <span class="col-lg-3">Quantity</span>
                                    <span class="col-lg-3">Total</span>
                                </li>
                                <?php
                                include "./config/utils.php";
                                $total = 0;
                                if (isset($_COOKIE['cart']) && !empty($_COOKIE['cart'])) {
                                    $cart = json_decode($_COOKIE['cart'], true);
                                    $productIds = array_keys($cart);
                                    $productsArray = [];
                                    foreach ($productIds as $productId) {
                                        // Gọi API để lấy thông tin sản phẩm theo ID
                                        $url = 'http://localhost:1337/api/products/' . $productId . '?populate=*';
                                        $data = handleCallAPI($url, "GET", "");
                                        if (isset($data['data'])) {
                                            $productsArray[] = $data['data'];
                                        }
                                    }
                                    if (isset($data['data']) && is_array($data['data'])) {
                                        $products = $data['data'];
                                        $filteredProducts = array_filter($productsArray, function ($product) use ($productIds) {
                                            return in_array($product['id'], $productIds);
                                        });

                                        foreach ($filteredProducts as $product) {
                                            $attributes = $product['attributes'];
                                            $id = (int) $product['id'];
                                            $name = $attributes['name'];
                                            $discount = $attributes['discount'];
                                            $price = $attributes['price'] - ($attributes['price'] * $discount) / 100;
                                            $quantity = (int) $cart[$id];
                                            $totalPerProduct = $price * $quantity;
                                            $total += $totalPerProduct;
                                            echo '<li class="row" style="margin-bottom: 12px;">
                                                    <span title="' . $name . '" style="display: -webkit-box; -webkit-line-clamp: 3;
                                                        -webkit-box-orient: vertical;  overflow: hidden; font-weight: 500;" class="col-lg-6 ">' . $name . '
                                                    </span>
                                                    <span class="col-lg-3">' . $quantity . '</span>
                                                    <span class="col-lg-3">' . $total . '</span>
                                                </li>';
                                        }
                                    }
                                }
                                ?>
                            </ul>

                            <ul class="list list_2">
                                <li class="row" style="margin-bottom: 12px;">
                                    <span style="font-size: 20px;" class="col-lg-6 ">Total
                                    </span>
                                    <span class="col-lg-3"></span>
                                    <span style="font-weight: 700; font-size: 16px;" class="col-lg-3"><?php echo $total ?></span>
                                </li>
                            </ul>

                            <div class="payment_item active">
                                <div class="radion_btn">
                                    <input type="radio" id="f-option6" name="selector">
                                    <label for="f-option6">Paypal </label>
                                    <img src="img/product/card.jpg" alt="">
                                    <div class="check"></div>
                                </div>
                                <p>Pay via PayPal; you can pay with your credit card if you don’t have a PayPal
                                    account.</p>
                            </div>
                            <div class="creat_account">
                                <input type="checkbox" id="f-option4" name="selector">
                                <label for="f-option4">I’ve read and accept the </label>
                                <a href="#">terms & conditions*</a>
                            </div>
                            <button type="submit" class="primary-btn" href="#">Proceed to Paypal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!--================End Checkout Area =================-->

    <!-- start footer Area -->
    <?php
    include "./components/footer.php"
    ?>
    <!-- End footer Area -->


    <script src="js/vendor/jquery-2.2.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
        crossorigin="anonymous"></script>
    <script src="js/vendor/bootstrap.min.js"></script>
    <script src="js/jquery.ajaxchimp.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/nouislider.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <!--gmaps Js-->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
    <script src="js/gmaps.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>