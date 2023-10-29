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

$name = "";
$description = "";
$picture = "";
$price = "";

$error_message = "";
$success_message = "";

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $name = $_POST['name'];
    $description = $_POST['description'];
    $picture = $_POST['picture'];
    $price = $_POST['price'];

    $error_message = "";
    $success_message ="";

    do{
        if(empty($name) || empty($description) ||empty($picture) ||empty($price)){
            $error_message = "Missing information";
            break;
        }

        // ajouter le nouveau produit à la base de données
        $ajout = "INSERT INTO products (name, price, picture, description) VALUES ('$name', '$price', '$picture', '$description')";
        
        $result = $my_pdo->query($ajout);

        $result->bindParam("name", $name);
        $result->bindParam("price", $price);
        $result->bindParam("picture", $picture);
        $result->bindParam("description", $description);

        if (!$result) {
            $error_message = "Invalid query:" . $my_pdo->error;
            break;
        }

        $name = "";
        $description = "";
        $picture ="";
        $price = "";

        $success_message =" Product succesfully added to the list!";
        header("Location: /products.php");
        exit;
    }

    while(false);

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
    <div class="container my-5">

        <h2>New Product</h2>

        <?php

        if(!empty($error_message)){
            echo "
                <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>$error_message</strong>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";  
        }

        ?>

            <form method="post"  enctype="multipart/form-data">
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Name</label>
                    <div class="col-sm-6">
                            <input type="text" name="name" class="form-control" value="<?php echo $name;?>">
                        </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Description</label>
                        <div class="col-sm-6">
                            <input type="text" name="description" class="form-control" value="<?php echo $description;?>">
                        </div>
                </div>   

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label" for="picture">Upload New Picture</label>
                        <div class="col-sm-6">
                            <input type="text" name="picture" id="picture" value="<?php echo $picture;?>">
                        </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Price</label>
                        <div class="col-sm-6">
                        <input type="number" id="my_number" value="<?php echo $price;?>" name="price">€
                        </div>
                </div>

                <?php

                if(!empty($success_message)){
                    echo "
                        <div class='row'>
                            <div class='offset-sm-3 col-sm-6'>fade
                                <div class='alert-success alert-dismissible  show' role='alert'>
                                    <strong>$success_message</strong>
                                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                </div>
                            </div>; 
                        </div>";
                }

                ?>

                <div class="row mb-3">
                    <div class="offset-sm-3 col-sm-3 d-grid">
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                    <div class="col-sm-3 d-grid">
                        <a class="btn btn-outline-primary" href="/products.php" role="button">Cancel</a>
                    </div>
                </div>
                
            </form>
    </div>
</body>
</html>