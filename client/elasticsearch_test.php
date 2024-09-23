<?php
require 'vendor/autoload.php';

use  Elastic\Elasticsearch\ClientBuilder;

$hosts = [
    'https://localhost:9200/'
];

$client = ClientBuilder::create()
    ->setHosts($hosts)
    ->setBasicAuthentication('elastic', 's7aP8*H06BuT89gFxjw4')
    ->setSSLVerification(false)
    ->build();

$query = $_POST['query'];

$params = [
    'index' => 'api',
    'body'  => [
        'query' => [
            'wildcard' => [
                'name' => '*' . $query . '*'
            ]
        ]
    ]
];

$response = $client->search($params);
$result = $response->asArray();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
</head>

<body>
    <h1>Search Results</h1>
    <h2>Results:</h2>
    <?php foreach ($result['hits']['hits'] as $hit) {
        if (isset($hit['_source']['name'])) {
            $name = $hit['_source']['name'];
            echo '<p>' . $name . '  </p>';
        }
    } ?>


</body>

</html>