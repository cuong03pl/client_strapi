<?php

$url = 'https://www.amazon.com/Coway-AP-1512HH-Mighty-Purifier-White/dp/B01728NLRG?ref=dlx_deals_dg_dcl_B01728NLRG_dt_sl14_0b&th=1';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, như Gecko) Chrome/129.0.6668.59 Safari/537.36");

$html = curl_exec($ch);
curl_close($ch);

if (!empty($html)) {
    $thispage = new DOMDocument;
    libxml_use_internal_errors(true);
    $thispage->loadHTML($html);
    libxml_clear_errors();

    $xpath = new DOMXPath($thispage);

    $nodes = $xpath->query("//span[@id='productTitle']");

    if ($nodes->length > 0) {
        echo trim($nodes->item(0)->textContent);
    } else {
        echo "Không tìm thấy tiêu đề sản phẩm.";
    }
} else {
    echo "Không thể tải nội dung trang.";
}
