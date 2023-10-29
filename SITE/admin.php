<?php

$host = "localhost";
$username = "potato";
$password = "potato";
$db = "my_shop";

function connect_db($host,$username,$password,$port,$db)

{
    try {
        $dsn = "mysql:dbname=$db;host=$host;port=$port"; /* host*/
        $the_pdo = new PDO($dsn, $username, $password);
      
        return $the_pdo;
    }
    
    catch(PDOException $error){
       echo "PDO ERROR:" . $error->getMessage() . "storage in <error_log_file>\n";
       file_put_contents(ERROR_LOG_FILE, $error, FILE_APPEND);
    }
}

        
    // ip du client
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
    $ip = $_SERVER['REMOTE_ADDR'];
    }
                                                               
    // time actuel
    $time = time();

    // on recherche l’utilisateur
    $sql_query = "SELECT * FROM connectes where ip='$ip'";
    $result = $conn->query($sql_query);
                                                               
    // si l'utilisateur n'est pas deja dans la table
    if($result->num_rows == 0)
    {
    $sql_query = "INSERT INTO connectes VALUES ('$ip', '$time')";
    $result = $conn->query($sql_query);
                                                                   

    }
    // mise-à-jour
    else
    {
    $sql_query = "UPDATE connectes SET derniere='$time' WHERE ip='$ip'";
                                                                   
    $result = $conn->query($sql_query);
                                                                   
    }
                                                               
    // temps d'incativité
    $time -= $temps * 60;
                                                               
    // on supprime ceux qui n'ont pas été connectés depuis assez longtemps
    $sql_query = "DELETE LOW_PRIORITY FROM connectes WHERE derniere <= $time";
    $result = $conn->query($sql_query);
                                                               
    /*******************
    Affichage des connectés
    *******************/

    $sql_query = "SELECT count(*) FROM connectes";
    $result = $conn->query($sql_query);

                                                                                   
    if($result)
    {
    $visiteurs = mysqli_fetch_array($result);
    echo '<li><br />Connect&eacute;s: ' . $visiteurs[0].'</li>';
                                  
    }


    $permissions = [
        'ROLE_ADMIN' => [
            'can_update_post',
            'can_create_post',
            'can_delete_post',
            'can_read_post',
        ],
           
         'ROLE_USER' => [
            'can_read_post',
         ]
             
         ];
      
      
      
      
         if(isset($_POST['formdeleteuser']) AND isset($_POST['datadelet'])){
            $datadelet = $_POST['datadelet'];
            $req = $DB->query("DELETE FROM user WHERE :idpublic = idpublic",array('idpublic' => $datadelet));
            header('Location: admin.php');
            $_SESSION['flash']['success'] = "Le compte à été supprimé";
            exit;
        }
        ?>

<form action="" method="post">
    <input type="hidden" name="datadelet" value="<?= $donnees['idpublic']; ?>">
    <button type="submit" name="formdeleteuser">Supprimer le compte</button>
</form>