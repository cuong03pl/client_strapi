<?php
include './config/pagination.php';
// call api
$curl = curl_init();
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$pageSize = PAGE_SIZE;
$url = 'http://localhost:1337/api/products?pagination[page]=' . $page . '&pagination[pageSize]=' . $pageSize . '&populate=*';

if (isset($_GET['categoryId'])) {
  $cateId = $_GET['categoryId'];
  $url .= '&filters[category][id][$eq]=' . $cateId;
}
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

foreach ($data['data'] as $product) {
  $urlImg = $product['attributes']['image'];
  $id = $product['id'];
  $name = $product['attributes']['name'];
  $oldPrice = (int)  $product['attributes']['price'];
  $discount =  (int) $product['attributes']['discount'];
  $newPrice = $oldPrice - ($oldPrice * $discount) / 100;
  $route = 'details.php?id=' . $id;
  echo <<<HTML
    <div class="col-lg-3 col-md-6">
      <div class="single-product">
        <div style="position: relative;">
          <img style="border-radius: 16px; width: 190px; height: 190px; object-fit: contain;" class="img-fluid" src='{$urlImg}' alt="Product Image">
          <div style="background: #f44236; position: absolute; top: 6px; right: 10px;  
          border-radius: 16px; color: white; padding: 4px; height: 36px; width: 48px; display: flex; align-items: center; justify-content: center;">- {$discount}%</div>
        </div>
        <div class="product-details">
          <a style="font-size: 15px; min-height: 75px; font-weight: 700;  display: -webkit-box; -webkit-line-clamp: 3;
           -webkit-box-orient: vertical;  overflow: hidden;" href='$route' title='$name'>{$name}</a>
          <div class="price">
            <h6 style="color: red; font-size: 16px;">\${$newPrice}</h6>
            <h6 style="color: #7b7a7a; font-size: 14px; text-decoration: line-through;">\${$oldPrice}</h6>
          </div>
          <div class="prd-bottom">
              <button type="submit" id="liveToastBtn" class="btn btn-primary" style="border: none !important; padding: 0 12px; display: flex; line-height: 40px; align-items: center; gap: 8px;" onclick="addToCart({$id})">Add to Cart 
              <span style="font-size: 20px;" class="ti-shopping-cart"></span>
              </button>
          </div>
        </div>
      </div>
    </div>
 
HTML;
}
?>
<?php
include "./components/pagination.php";
?>

<script>
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