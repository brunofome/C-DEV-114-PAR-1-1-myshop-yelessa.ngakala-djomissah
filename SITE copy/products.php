<?php

session_start();

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
    <div class="produit">
    <header>
        <nav class="navbar">
            <div class="part1">
                <ul class="nav nav-pills nav-fill gap-2 p-1 small bg-primary rounded-5 shadow-sm" id="pillNav2" role="tablist" style="--bs-nav-link-color: var(--bs-white); --bs-nav-pills-link-active-color: var(--bs-primary); --bs-nav-pills-link-active-bg: var(--bs-white);">
                    <li class="nav-item" role="presentation">
                        <a href="/" class="nav-link rounded-5" id="home-tab2" data-bs-toggle="tab" type="button" role="tab" aria-selected="false">PANEL</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="/membres.php" type="button" class="nav-link rounded-5" id="profile-tab2" data-bs-toggle="tab" type="button" role="tab" aria-selected="false">MEMBERS</a>
                    </li>
                    <li class="nav-item" role="presentation">
                      <a href="/products.php" type="button" class="nav-link active rounded-5" id="contact-tab2" data-bs-toggle="tab" type="button" role="tab" aria-selected="true">PRODUCTS</a>
                    </li>
                    <li>
                        <a href="/website.php" type="button" class="nav-link rounded-5" id="contact-tab2" data-bs-toggle="tab" role="tab" aria-selected="false">SHOP</a>
                    </li>
                  </ul>
            </div>
        </nav>
    </header>
        <h2>List of Products</h2>
        <a class="btn btn-primary" href="/create.php" role="button">New Product</a><br>
        <table class="table">
            <thead>
                <tr>
                    <th>Products</th>
                </tr>
            </thead>
            <tbody>
                <?php

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

                // récupération de toutes les lignes du tableau products 

                $my_pdo = connect_db("localhost", "potato", "potato", 3306, "my_shop");
                
                $recherche = "SELECT* FROM products";

                $result = $my_pdo->query($recherche);
                
                /*foreach($my_pdo->query($recherche) as $row){
                    print $row['name']. "\t";
                    print $row['id']. "\t";
                }*/
             

                if(!$result){ 
                    echo "There are no products for the moment.".PHP_EOL;
                    die("Invalid request: ".$my_pdo->error);

                }

                // récupération des données de chaque ligne

                while($row = $result->fetch()){

                    echo "
                    <tr>
                        <th>id</th>
                        <td>$row[id]</td>
                        <td>$row[name]</td>
                        <td>$row[description]</td>
                        <td>$row[picture]</td>
                        <td>$row[price]</td>
                        <td>
                            <a class='btn btn-primary btn-sm' href='/edit.php?id=$row[id]'>Edit</a>
                            <a class='btn btn-danger btn-sm' href='/delete.php?id=$row[id]'>Delete</a>
                        </td>
                    </tr>
                    ";
                }
                
                ?>
            </tbody>
        </table>
    </div>
    
</body>
</html>