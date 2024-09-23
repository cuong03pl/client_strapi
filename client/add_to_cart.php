<?php
include "./config/utils.php";
if ($_SERVER["REQUEST_METHOD"] === "POST") {


    $id = (int) $_POST["id"];
    if (!empty($_POST["quantity"]) && !isset($_POST['update_quantity'])) {
        $apiUrl = 'http://localhost:1337/api/products/' . $id . '?populate=*';
        $data =  handleCallAPI($apiUrl, "GET", "");

        $product = $data['data']['attributes'];
        $quantity = (int) $_POST["quantity"];

        if ($product && $quantity > 0) {
            $cart = isset($_COOKIE['cart']) ? json_decode($_COOKIE['cart'], true) : array();

            if (array_key_exists($id, $cart)) {
                $cart[$id] += $quantity;
            } else {
                $cart[$id] = $quantity;
            }

            setcookie('cart', json_encode($cart), time() + (30 * 24 * 60 * 60), "/");

            $previous_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';

            header("Location: $previous_url");
        }
    }
}

if (isset($_POST['remove_item']) && isset($_POST['id'])) {
    $id = $_POST['id'];

    $cart = isset($_COOKIE['cart']) ? json_decode($_COOKIE['cart'], true) : array();

    if (isset($cart[$id])) {
        unset($cart[$id]);

        if (empty($cart)) {
            setcookie('cart', '', time() - 3600, "/");
        } else {
            setcookie('cart', json_encode($cart), time() + (30 * 24 * 60 * 60), "/");
        }
        $previous_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';

        header("Location: $previous_url");
    }
}


if (isset($_POST['update_quantity']) && isset($_POST['quantity'])) {
    $productId = $_POST['id'];
    $newQuantity = (int) $_POST['quantity'];

    if (is_numeric($newQuantity) && $newQuantity > 0) {
        $cart = isset($_COOKIE['cart']) ? json_decode($_COOKIE['cart'], true) : array();

        $cart[$productId] = $newQuantity;
        setcookie('cart', json_encode($cart), time() + (30 * 24 * 60 * 60), "/");
        $previous_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';

        header("Location: $previous_url");
    }
}
