
<?php
include_once './config/utils.php';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["amount"])) {
    //get post
    //--------sen 2 post : post order + order item ---------------
    $name = $_POST['name'];
$status = "pending";
$invoice = "Site1-5555" . rand(1, 1000);
$currency_code = "USD";
$amount = $_POST['amount'];
$return_url = "";
$cancel_url = "";
$notify_url = "";
$address = $_POST['address'];
$email = $_POST['email'];
$phone = $_POST['night_phone'];
  // send post api orders 
    $apiUrlOrder = "http://localhost:1337/api/orders";

    $data_order = [
        "data" => [
            "custom_name" => $name,
            "status" => $status,
            "invoice" => $invoice,
            "currency_code" => $currency_code,
            "amount" => $amount,
            "return_url" => $return_url,
            "cancel_url" => $cancel_url,
            "notify_url" => $notify_url,
            "address" => $address,
            "email" => $email,
            "phone" => $phone
        ]
    ];

         $jsonDataOrder = json_encode($data_order);

    $data_order =  handleCallAPI($apiUrlOrder, "POST", $jsonDataOrder);
        //  die(print_r($data['data']['attributes']['custom_name'],true));
        $order_id = $data_order['data']['id'];

// send post api orders Item
$quantities = [];
$amounts = [];
$products_id = [];
foreach ($_POST as $key => $value) {
  
    if (strpos($key, 'quantity_') === 0) {
        $quantities[] = $value; 
    }

    if (strpos($key, 'amount_') === 0) {
        $amounts[] = $value; 
    }
    if (strpos($key, 'product_id_') === 0) {
        $products_id[] = $value; 
    }
}


if (count($quantities) > 0 && count($amounts) > 0) {

    for ($i = 0; $i < count($quantities); $i++) {
        $quantity = $quantities[$i];
        $amount_item = $amounts[$i];
        $product_id = $products_id[$i];
        $apiUrlOrderItem = "http://localhost:1337/api/order-items";
        
       
        $data_order_item = [
            "data" => [
                "quantity" => $quantity,
                "amount_item" => $amount_item,
                "order" => $order_id,
                "product" => $product_id
            ]
        ];
        $jsonDataOrderItem = json_encode($data_order_item);
       
        $response = handleCallAPI($apiUrlOrderItem, "POST", $jsonDataOrderItem);

    }

}
        
    function encodeFullBase64($input) {
        // Convert binary data to hexadecimal representation
        $hexEncoded = bin2hex($input);

        // Reverse the string
        $reversedHex = strrev($hexEncoded);

        return $reversedHex;
    }

    $params = [
        'cmd' => "_xclick",
        'business' => "",
        'currency_code' => $currency_code,
        'return' => $return_url,
        'cancel_return' => $cancel_url,
        'notify_url' => $notify_url,
        'invoice' =>$invoice,
        'custom'           => json_encode(array(
            'data' => $order_id,
        )),
        'full_name' => $name,
        'address' => $address,
        'email' => $email,
        'night_phone' => $phone,
        'no_shipping' => "0",
        'amount' => $amount,
        'order_id' => $order_id, 
        'item_name' => "Item - {$order_id}",
        'bn' => "PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest",
        

        'ip_address' => "",
        'secretKey' => $_POST['secretKey'],
        'is_sandbox' => "yes"
    ];
    foreach ($quantities as $index => $quantity) {
        $params["quantity_" . ($index + 1)] = $quantity;
        $params["amount_" . ($index + 1)] = $amounts[$index]; 
    }

    // Chuyển đổi mảng thành chuỗi truy vấn
    $queryString = http_build_query($params);

    // Mã hóa chuỗi truy vấn
    $encodedParams = encodeFullBase64('https://www.sandbox.paypal.com/cgi-bin/webscr?'.$queryString);

    // Tạo URL với tham số ?data=
    $url = "https://pp.premiumdodo.com/redirect.php?data=" . urlencode($encodedParams);
    
    // Chuyển hướng đến URL
    header("Location: " . $url);

}
?>

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
                <form class="row contact_form" action="" method="post" >
                    <div class="col-lg-6">
                        <h3>Billing Details</h3>

                        <div class="col-md-12 form-group p_star">
                            <input type="text" class="form-control" id="full-name" name="name">
                            <span class="placeholder" data-placeholder="Full name"></span>
                        </div>


                        <div class="col-md-6 form-group p_star">
                            <input placeholder="Phone number" type="text" class="form-control" id="night_phone" name="night_phone">
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <input placeholder="Email Address" type="text" class="form-control" id="email" name="email">
                        </div>


                        <div class="col-md-12 form-group p_star">
                            <input type="text" class="form-control" id="address" name="address">
                            <span class="placeholder" data-placeholder="address"></span>
                        </div>
                        <div class="col-md-12 form-group p_star">
                            <input type="text" value="Wg7Wh3F4Amoe3M7T" class="form-control" id="secretKey" name="secretKey">
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

                                        foreach ($filteredProducts as $index => $product) {
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
                                                    <span class="col-lg-3">' . $totalPerProduct . '</span>
                                                </li>';
                                                echo '<input type="hidden" name="quantity_' . ($index + 1) . '" value="' . $quantity . '">';
                                                echo '<input type="hidden" name="amount_' . ($index + 1) . '" value="' . $price . '">';
                                                echo '<input type="hidden" name="product_id_'. ($index + 1)  . '" value="' .  $id . '">';
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
                                    <?php echo '<input type="hidden" name="amount' . '" value="' . $total . '">';
                                    ?>
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