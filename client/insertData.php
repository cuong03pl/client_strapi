<?php
// Đọc file JSON
$jsonFilePath = 'C:\xampp\htdocs\ecommerce_strpi\client\data\sample_products_2_100000.json';

$jsonData = file_get_contents($jsonFilePath);
$dataArray = json_decode($jsonData, true);

// URL API của Strapi
$api_url = 'http://localhost:1337/api/products';

// Hàm gọi API để import từng sản phẩm vào Strapi
function callAPI($product)
{
    global $api_url;

    $data = [
        "data" => [
            "name" => $product['Title'],
            "sku" => $product['SKU'],
            "description" => $product['Description'],
            "price" => (float)$product['Price'],
            "discount" => ((int)$product['Sale_Price'] / (int)$product['Price']) * 100,
            "image" => "http://localhost:1337/uploads/LEVOIT_Cordless_Vacuum_Cleaner_Stick_Vac_with_Tangle_Resistant_Design_Up_to_50_Minutes_Powerful_Suction_Rechargeable_Lightweight_and_Versatile_for_Carpet_Hard_Floor_Pet_Hair_Black_White_9d22b0bddf.jpg",
            "category" => 4,
            "status" => 1,
            "details" => "Chi tiết sản phẩm",

        ]
    ];

    $headers = [
        'Content-Type: application/json',
    ];

    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($http_code == 200) {
        echo "Import thành công sản phẩm: " . $product['Title'] . "\n";
    } else {
        echo "Lỗi khi import sản phẩm: " . $product['Title'] . "\n";
        echo "Mã lỗi: " . $http_code . "\n";
    }

    curl_close($ch);
}

// Lặp qua tất cả dữ liệu và gọi API
foreach ($dataArray as $product) {
    callAPI($product);
}
