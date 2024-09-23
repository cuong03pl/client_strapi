<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Elasticsearch</title>
</head>

<body>
    <h1>Search Elasticsearch</h1>
    <form action="elasticsearch_test.php" method="POST">
        <label for="query">Search Query:</label>
        <input type="text" id="query" name="query" required>
        <button type="submit">Search</button>
    </form>
</body>

</html>