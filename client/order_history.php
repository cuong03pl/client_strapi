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
    <title>Order History</title>

    <!--
            CSS
            ============================================= -->
    <link rel="stylesheet" href="css/linearicons.css">
    <link rel="stylesheet" href="css/owl.carousel.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/nouislider.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/main.css">

    <style>
        .cart_area {
            padding-top: 120px;
        }
    </style>
</head>

<body>

    <!-- Start Header Area -->
    <?php
    include "./components/header.php"
    ?>
    <!-- End Header Area -->
    <!--================Cart Area =================-->
    <section class="cart_area">
        <div class="container">
            <?php
            if (isset($_COOKIE['cart']) && !empty($_COOKIE['cart'])) {
                echo '<div class="cart_inner">
                                     <div class="table-responsive">
                                         <table class="table">
                                             <thead>
                                                 <tr>
                                                     <th scope="col"><h3>Product</h3></th>
                                                     <th scope="col"><h3>Price</h3></th>
                                                     <th scope="col"><h3>Quantity</h3></th>
                                                     <th scope="col"><h3>Total</h3></th>
                                                     <th scope="col"><h3>Date</h3></th>
                                                 </tr>
                                             </thead>
                                             <tbody>';
                $cart = json_decode($_COOKIE['cart'], true);
                $productIds = array_keys($cart);
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'http://localhost:1337/api/products?id=' . implode(',', $productIds) . '&populate=*',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json'
                    ),
                ));

                $response = curl_exec($curl);
                curl_close($curl);

                $data = json_decode($response, true);

                if (isset($data['data']) && is_array($data['data'])) {
                    $products = $data['data'];
                    $filteredProducts = array_filter($products, function ($product) use ($productIds) {
                        return in_array($product['id'], $productIds);
                    });

                    foreach ($filteredProducts as $product) {
                        $attributes = $product['attributes'];
                        $id = (int) $product['id'];
                        $name = $attributes['name'];
                        $discount = $attributes['discount'];
                        $price = $attributes['price'] - ($attributes['price'] * $discount) / 100;
                        $image = $product['attributes']['image'];
                        $quantity = (int) $cart[$id];
                        $route = 'details.php?id=' . $id;
                        echo ' 
                                 <tr>
                                     <td>
                                         <div class="media">
                                             <div class="d-flex">
                                                 <img style="max-width: 200px; border-radius: 12px;" src="' . $image . '" alt="">
                                             </div>
                                             <div class="media-body">
                                                 <a style="font-size: 20px;font-weight: 700; text-transform: uppercase;" href=' . $route . '>' . $name . '</a>
                                             </div>
                                         </div>
                                     </td>
                                     <td>
                                         <h4>$' . $price . '</h4>
                                     </td>
                                     <td>
                                     
                                     <div data-mdb-input-init class="form-outline">
                                        <h4>' . $quantity . '</h4>
                                     </div>
         
                                         </td>
                                     <td>
                                         <h4 id="total-price-' . $id . '">$' . $price * $quantity . '</h4>
                                     </td>
                                     <td>
                                         <h4>20/11/2023</h4>
                                     </td>
                                 </tr>
                                 <tr class="out_button_area">
                                    <td>
                                    </td>
                                    <td>
                                    </td>
                                    <td>
                                    </td>
                                    <td>
                                    </td>
                                    <td>
                                        <div style="display: flex; justify-content: center; align-items: center; gap:8px;">
                                            <h4 class="text-lg" >Total: </h4>
                                            <h3 class="text-lg" >10000</h3>
                                        </div>
                                    </td>
                                </tr>
                                <div class="dropdown-divider"></div>';
                    }
                }
                echo '
                     </tbody>
                 </table>
             </div>
         </div>';
            } else {
                include "./components/cart_empty.php";
            }


            ?>
        </div>
    </section>
    <!--================End Cart Area =================-->

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
    <script>
        function updateQuantity(productId, price) {
            var quantity = parseInt(document.getElementById('product-' + productId).value);


            $.ajax({
                url: 'add_to_cart.php',
                type: 'POST',
                data: {
                    id: productId,
                    quantity: quantity,
                    update_quantity: true,
                },
                success: function(response) {
                    var total = quantity * price;
                    document.getElementById("total-price-" + productId).innerHTML = "$" + total;
                },

            });
        }
    </script>
</body>

</html>