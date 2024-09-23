<?php
$page =  1;
$curl = curl_init();
$url = 'http://localhost:1337/api/categories';
curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'Content-Type:  application/json'
    ),
));
$response = curl_exec($curl);

curl_close($curl);
$data = json_decode($response, true);

?>
<style>
    .category-list {
        padding: 0;
        margin: 0;
        list-style: none;
    }

    .category-list .list-group-item {
        background-color: #f8f9fa;
        /* Màu nền cho mục danh sách */
        color: #333;
        /* Màu chữ */
        font-weight: 500;
        padding: 10px 15px;
        text-decoration: none;
        display: block;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .category-list .list-group-item:hover {
        background-color: #e9ecef;
        /* Màu nền khi hover */
        color: #007bff;
        /* Màu chữ khi hover */
    }

    .category-list .list-group-item.active {
        background-color: #007bff;
        /* Màu nền cho mục đang chọn */
        color: #fff;
        /* Màu chữ cho mục đang chọn */
    }
</style>
<ul style=" width: 100%; height: 100%; background: #fff;" class="list-group category-list">
    <?php
    foreach ($data['data'] as $item) {
        if (isset($_GET['categoryId']) && $_GET['categoryId'] == $item['id']) {
            echo '<a href="index.php?categoryId=' . $item['id'] . '&page=1" class="list-group-item active" aria-current="true">' . $item['attributes']['CategoryName'] . '</a>';
        } else {
            echo '<a href="index.php?categoryId=' . $item['id'] . '&page=1" class="list-group-item">' . $item['attributes']['CategoryName'] . '</a>';
        }
    }
    ?>
</ul>