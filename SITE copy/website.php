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

?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <link rel="stylesheet" href="site.css">

    <title>Website</title>
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="part1">
                <div class="logo101"><img src="Logo.png" id="logo"></div>
                <ul class="site">
                    <li><a href="#" class="menu">HOME</a> </li>
                    <li><a href="#" class="menu">RADIO</a></li>
                    <li><a href="#" class="menu">HIT</a></li>
                </ul>
            </div>
            <ul class="client">
                <li><a href="#"><img src="Cart Button.png" id="cart"></a></li>
                <li class="menu-icon"><img src="musicon.png" id="musicon"></li>
                <li><a href="/login.php" class="menu">LOG IN</a></li>
            </ul>
        </nav>
        <div class="recherche">
        
            <div class="motcle">
            <img src="Search.png" id="loupe">
            <form action="search.php" method="get">
                <div class="searching">
                    <input type="text" placeholder="Search for products" id="mySearch" name="mySearch" value="search"/> 
                    <span class="validity"></span>
                </div>
            </form>
            </div>

            <p class="search1">Powered by Algolia</p>
            <img src="Sajari Logo.png" id="tourbillon">
    
            <select name="option" id="filtre" class="BM">
                <option value="">Best Match</option>
            </select>
        </div>
    </header>

    <div class="contenu">
    
        <div class="deroulant">
            <label for="option-select" id="titre">Filter By</label><br>

            <select name="option" id="filtres" class="filtres">
                <option value="">Filtres</option>
            </select><br>
            <div class="categories">
                <select name="option" id="filtre-genres">
                    <option value="">Genres</option>
                </select><br>
                <select name="option" id="filtre-artistes">
                    <option value="">Artistes</option>
                </select><br>
                <select name="option" id="filtre-albums">
                    <option value="">Albums</option>
                </select><br>

                <div class="slidecontainer">
                    <input type="range" id="prix" name="prix" min="0" max="" step="1" class="slider"> 
                    <span id="prixValeur">€0</span> 
                </div>
            </div>
        </div>

        <div class="un">
            <section class="card">

            <?php

                while($row = $products->fetch())

                ?>
                <div class="Album">

                <div class="img"><img src="<?php echo $row["picture"];?>" alt="" width="300px"></div>

                <div class="son"><?php echo $row["name"];?></div>

                <div class="son">Alan Cavé</div>

                <div class="rate"><img src="Star - On.png" id="score"><img src="Star - On.png" id="score"><img src="Star - On.png" id="score"><img src="Star - On.png" id="score"><img src="Star - On.png" id="score"></div>

                <div class="box">

                    <div class="price"><?php echo $row["price"];?></div>

                    <button class="buy">Ajouter</button>

                </div>

                 </div>

                 <?php

                 ?>
            </section>
        
</body>

<div class="container">
    <div class="pagination">
    <button class="btn1" onclick="backBtn()">Page précédente</button>
    <ul> 
        <li class="link active" value="1" onclick="activeLink()">1</li>
        <li class="link" value="2" onclick="activeLink()">2</li>
        <li class="link" value="3" onclick="activeLink()">3</li>
        <li class="link" value="4" onclick="activeLink()">4</li>
        <li class="link" value="5" onclick="activeLink()">5</li>
        <li class="link" value="6" onclick="activeLink()">6</li>
        <li class="link" value="7" onclick="activeLink()">7</li>
        <li class="link" value="8" onclick="activeLink()">8</li>
        <li class="link" value="9" onclick="activeLink()">9</li>
        <li class="link" value="10" onclick="activeLink()">10</li>
    </ul>
    <button class="btn2" onclick="nextBtn()">Page suivante<image src="FLECHE_VERS_DROITE.jpg"></image></button>
</div>
    </div>

</html>