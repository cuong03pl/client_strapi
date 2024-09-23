<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


?>
<style>
    .nav-link {
        font-size: 18px !important;
    }

    .dropdown-item {
        padding: 8px 24px;
    }

    .dropdown-item:hover {
        color: #16181b;
        text-decoration: none;
        background-color: #e2e5e9;
    }

    .dropdown-divider {
        margin: 0px;
    }
</style>
<header class="header_area sticky-header">
    <div class="main_menu">
        <nav class="navbar navbar-expand-lg navbar-light main_box">
            <div class="container">
                <a class="navbar-brand logo_h" href="index.php"><img src="img/logo.png" alt=""></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                    <ul class="nav navbar-nav menu_nav ml-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item submenu dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Shop</a>
                            <ul class="dropdown-menu">
                                <li class="nav-item"><a class="nav-link" href="category.html">Shop Category</a></li>
                                <li class="nav-item"><a class="nav-link" href="single-product.html">Product Details</a></li>
                                <li class="nav-item"><a class="nav-link" href="checkout.html">Product Checkout</a></li>
                                <li class="nav-item"><a class="nav-link" href="cart.html">Shopping Cart</a></li>
                                <li class="nav-item"><a class="nav-link" href="confirmation.html">Confirmation</a></li>
                            </ul>
                        </li>
                        <li class="nav-item submenu dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Blog</a>
                            <ul class="dropdown-menu">
                                <li class="nav-item"><a class="nav-link" href="blog.html">Blog</a></li>
                                <li class="nav-item"><a class="nav-link" href="single-blog.html">Blog Details</a></li>
                            </ul>
                        </li>
                        <li class="nav-item submenu dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Pages</a>
                            <ul class="dropdown-menu" style="display: none;">
                                <li class="nav-item"><a class="nav-link" href="login.html">Login</a></li>
                                <li class="nav-item"><a class="nav-link" href="tracking.html">Tracking</a></li>
                                <li class="nav-item"><a class="nav-link" href="elements.html">Elements</a></li>
                            </ul>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="contact.html">Contact</a></li>
                    </ul>
                    <ul class="nav navbar-nav menu_nav ml-auto">
                        <?php
                        $maxLength = 12;
                        $username = isset($_SESSION["username"]) ? $_SESSION["username"] : "";
                        if (strlen($username) > $maxLength) {
                            $username = substr($username, 0, $maxLength) . '...';
                        }

                        $cart = isset($_COOKIE['cart']) ? json_decode($_COOKIE['cart'], true) : [];
                        $productIds = array_keys($cart);
                        echo !isset($_SESSION["jwt"]) ? '
                        <a href="login.php" class="btn btn-primary ">Login</a>' :
                            '<li class="nav-item" style="display: block; position: relative;    ">
                        <a href="cart.php" class=" nav-link">
                            <span style="font-size: 20px; font-weight: 700;" class="ti-shopping-cart"></span>
                            <span style="    top: -10px;left: 10px; position: absolute;   background: red;   color: white;   padding: 0px 8px; border-radius: 50%; font-size: 12px;">' . count($productIds) . '</span>
                        </a>
                        <li class="nav-item" style="display: block;"> 
                         <div class="dropdown">
                            <span class="nav-link dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton" aria-expanded="false">
                                <span style="font-size: 20px; font-weight: 700;" class="ti-user"></span>
                                <span title=' . $_SESSION["username"] . '>' . ($username)  . '</span>
                            </span>
                             <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                              <a class="dropdown-item" href="order_history.php">My products</a>
                                <div class="dropdown-divider"></div>
                                <form id="logout-form" action="logout.php" method="POST" style="display: inline; ">
                                    <button style="display: flex; gap:12px;align-items: center;" class="dropdown-item" href="#">Log out 
                                        <span style="font-size: 16px; font-weight: 700;" class="ti-export">
                                        </span>
                                    </button>
                                </form>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item" style="display: block;">
                            <div class=" nav-link">
                                <span style="font-size: 20px; font-weight: 700;" class="lnr lnr-magnifier" id="search"></span>
                            </div>  
                        </li>
                       
                        ' ?>


                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <div class="search_input" id="search_input_box" style="display: none;">
        <div class="container">
            <form class="d-flex justify-content-between">
                <input type="text" class="form-control" id="search_input" placeholder="Search Here">
                <button type="submit" class="btn"></button>
                <span class="lnr lnr-cross" id="close_search" title="Close Search"></span>
            </form>
        </div>
    </div>
</header>