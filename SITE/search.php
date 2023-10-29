<?php

$db = mysqli_connect('localhost', 'username', 'password', 'database_name');

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if query parameter is set
if(isset($_GET['query'])) {
    $searchTerm = mysqli_real_escape_string($db, $_GET['query']);

    $sql = "SELECT * FROM products WHERE product_name LIKE '%$searchTerm%'";
    $result = mysqli_query($db, $sql);

    if (mysqli_num_rows($result) > 0) {
        while($product = mysqli_fetch_assoc($result)) {
            echo "<div>";
            echo $product["product_name"];
            // Display other product details as required
            echo "</div>";
        }
    } else {
        echo "No products found.";
    }
}
?>