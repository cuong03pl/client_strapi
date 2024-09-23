<?php
require 'vendor/autoload.php';
include "./config/utils.php";
if (isset($_GET['id'])) {
    $curl = curl_init();
    $id = $_GET['id'];
    $url = 'http://localhost:1337/api/products/' . $id . '?populate=*';
    $data =  handleCallAPI($url, "GET", "");

    $product = $data['data'];
    $imageUrl = $product['attributes']['image'];
    $name =  $product['attributes']['name'];
    $oldPrice = (int)  $product['attributes']['price'];
    $discount =  (int) $product['attributes']['discount'];
    $newPrice = $oldPrice - ($oldPrice * $discount) / 100;
    $details =  $product['attributes']['details'];
    $status =  $product['attributes']['status'];
    $description = $product['attributes']['description'];
    $parsedown = new Parsedown();
    $htmlContent = $parsedown->text($description);
    $brand = $product['attributes']['category']['data']['attributes']['CategoryName'];
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
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/nouislider.min.css">
    <link rel="stylesheet" href="css/ion.rangeSlider.css" />
    <link rel="stylesheet" href="css/ion.rangeSlider.skinFlat.css" />
    <link rel="stylesheet" href="css/main.css">
    <link href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/toasty.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />

    <style>
        .s_product_text {
            margin-top: 12px;
        }

        .details {
            padding: 0px !important;
            margin-bottom: 0 !important;
            display: -webkit-box;
            -webkit-line-clamp: 5;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .img-fluid {
            width: 100%;
        }

        .tab-pane p {
            margin-top: 32px;
        }

        .s_product_inner {
            margin-bottom: 12px;
        }

        /* custom slick slider  */
        .slick-prev,
        .slick-next {
            background-color: #007bff42;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 50%;
            transition: background-color 0.3s ease;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 1;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 30px;
            height: 30px;
        }

        .slick-prev {
            position: absolute;
            top: 50%;
            left: 10px;

        }

        .slick-next {
            position: absolute;
            top: 50%;
            right: 10px;

        }

        .slick-prev:hover,
        .slick-next:hover {
            background-color: #0056b3;
        }

        .slick-dots {
            position: absolute;
            bottom: 10px;
            width: 100%;
            text-align: center;
            cursor: pointer;
        }

        .slick-dots li {
            display: inline-block;
            margin: 0 5px;
        }

        .slick-dots li button {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            cursor: pointer;
            background-color: #ccc;
            border: none;
            transition: background-color 0.3s ease;
        }

        .slick-dots li.slick-active button {
            background-color: #007BFF;
        }

        .slick-dots li button::before {
            content: '';
        }

        .slick-dots li button {
            text-indent: -9999px;
        }
    </style>
</head>

<body>

    <!-- Start Header Area -->
    <?php
    include "./components/header.php"
    ?>
    <!-- End Header Area -->

    <!--================Single Product Area =================-->
    <div class="product_image_area">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <?php
                    include "./components/category.php"
                    ?>
                </div>
                <div class="col-lg-9">
                    <div class="row s_product_inner">
                        <div class="col-lg-4">
                            <div class="s_Product_carousel">
                                <?php
                                // foreach ($imageUrl as $imgItem) {
                                // $url = $imgItem['attributes']['url'];
                                echo ' <div class="single-prd-item">
                            <img style="border-radius: 12px;" class="img-fluid" src="' . $imageUrl . '"  alt="">
                        </div>';
                                // }
                                ?>
                            </div>

                        </div>
                        <div class="col-lg-8 ">
                            <div class="s_product_text">
                                <h3 style="font-size: 36px; font-weight: 700; text-transform: uppercase;"><?php echo $name ?></h3>
                                <div style="display: flex; gap: 10px; align-items: center; margin: 12px 0;">
                                    <div style="margin: 0; font-size: 32px; font-weight: 700; color: red;"><?php echo "$" .  $newPrice ?></div>
                                    <div style=" text-decoration: line-through; font-size: 24px;">
                                        $<?php echo $oldPrice; ?>
                                    </div>

                                </div>

                                <ul class="list">
                                    <li>
                                        <div style=" display: flex; align-items: center;" class="active" href="#"><span class="font-weight-bold" style="width: 90px; ">Category</span> : <?php echo $brand ?></div>
                                    </li>
                                    <li>
                                        <div style="display: flex; align-items: center;"><span class="font-weight-bold" style="width: 90px;">Availibility</span>: <?php echo $status ? "Yes" : "No" ?></div>
                                    </li>
                                </ul>
                                <p class="details"><?php echo $details ?></p>

                                <input type="hidden" name="id" value="{$id}">
                                <input type="hidden" name="quantity" value="1" min="1">
                                <button type="submit" class="btn btn-primary" style="border: none !important; padding: 0 12px; display: flex; line-height: 40px; align-items: center; gap: 8px; margin: 16px 0;" onclick="addToCart(<?php echo $id ?>)">Add to Cart
                                    <span style="font-size: 20px; font-weight: 700;" class="ti-shopping-cart"></span>
                                </button>

                            </div>
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <div class="tab-pane">
                        <div><?php echo $htmlContent; ?></div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <?php
    include "./components/footer.php"
    ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/vendor/jquery-2.2.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
        crossorigin="anonymous"></script>
    <script src="js/vendor/bootstrap.min.js"></script>
    <script src="js/jquery.ajaxchimp.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/nouislider.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
    <script src="js/gmaps.min.js"></script>
    <!-- <script src="js/main.js"></script> -->
    <script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/toasty.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    <script>
        $(".sticky-header").sticky();
        $(document).ready(function() {
            console.log(123);

            $('.s_Product_carousel').slick({
                dots: true,
                infinite: true,
                speed: 500,
                fade: true,
                cssEase: 'linear',

                prevArrow: '<button type="button" class="slick-prev slick-arrow"><span style="font-size: 20px; font-weight: 700;" class="ti-angle-left"></span></button>',
                nextArrow: '<button type="button" class="slick-next slick-arrow"><span style="font-size: 20px; font-weight: 700;" class="ti-angle-right"></span></button>',
                arrows: true
            });
        });

        function handleToast() {
            var options = {
                autoClose: true,
                progressBar: true,
            };
            var toast = new Toasty(options);
            toast.configure(options);
            toast.success("Thêm sản phẩm vào giỏ hàng thành công");
        }

        function addToCart(productId) {
            $.ajax({
                url: 'add_to_cart.php',
                type: 'POST',
                data: {
                    id: productId,
                    quantity: 1,
                },
                success: function(response) {
                    handleToast();

                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }
    </script>
</body>

</html>