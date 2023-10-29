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
if (isset($GET[$id]) AND !empty($GET['$id'])){
    $getid = $GET['$id'];
    $recupUser = $bdd->prepare('SELECT FROM membres WHERE id = ?');
    $recupUser->execute(array($getid));
    if ($recupUser->rowCount() > 0){
        $BannirUser = $bdd->prepare('DELETE FROM membres WHERE id = ?');
        $BannirUser->execute(array($getid));

        header('Location:membres.php');

    }else{
        echo "Aucun membre n'a été trouvé !";
    }
  }else{
   echo "L'identifiant n'a pas pu etre récupéré ...";
}
?>