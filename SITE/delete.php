<?php

session_start();

define('ERROR_LOG_FILE',"./error.log");

// connexion à la base de données

$host = "localhost";
$username = "potato";
$password = "potato";
$db = "my_shop";

$options = array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                );
                
function connect_db($host, $username, $password, $port, $db){
                
    try{
        $dsn = "mysql:dbname=$db;host=$host;port=$port";
        $my_pdo = new PDO($dsn, "$username", "$password");
                
        return $my_pdo;
    }
                    
    catch(PDOException $e){
                
        $wrong = $e->getMessage();
        $error = "PDO ERROR: <$wrong> storage in <ERROR>\n". ERROR_LOG_FILE. "\n";
        file_put_contents(ERROR_LOG_FILE, $error, FILE_APPEND);
                
        echo $error;
    }
}

$my_pdo = connect_db("localhost", "potato", "potato", 3306, "my_shop");

$id = $_GET["id"];

$del = "DELETE FROM products WHERE id=$id";
$my_pdo->query($del);
header("Location: /products.php");

?>