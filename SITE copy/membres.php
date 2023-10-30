<!DOCTYPE html>

<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>List of Members</title>

</head>

<body>
    <header>
        <nav class="navbar">
            <div class="part1">
                <ul class="nav nav-pills nav-fill gap-2 p-1 small bg-primary rounded-5 shadow-sm" id="pillNav2" role="tablist" style="--bs-nav-link-color: var(--bs-white); --bs-nav-pills-link-active-color: var(--bs-primary); --bs-nav-pills-link-active-bg: var(--bs-white);">
                    <li class="nav-item" role="presentation">
                        <a href="/" class="nav-link rounded-5" id="home-tab2" data-bs-toggle="tab" type="button" role="tab" aria-selected="false">PANEL</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="/membres.php" type="button" class="nav-link active rounded-5" id="profile-tab2" data-bs-toggle="tab" type="button" role="tab" aria-selected="true">MEMBERS</a>
                    </li>
                    <li class="nav-item" role="presentation">
                      <a href="/products.php" type="button" class="nav-link rounded-5" id="contact-tab2" data-bs-toggle="tab" type="button" role="tab" aria-selected="false">PRODUCTS</a>
                    </li>
                    <li>
                        <a href="/website.php" type="button" class="nav-link rounded-5" id="contact-tab2" data-bs-toggle="tab" role="tab" aria-selected="false">SHOP</a>
                    </li>
                  </ul>
            </div>
        </nav>
    </header>

    <?php

    session_start();

    $bdd = new PDO('mysql:host=127.0.0.1;dbname=my_shop;charset=utf8;', 'potato', 'potato');

    $req = $bdd->query('SELECT * FROM users');

    $users = $req->fetchAll();

 

    echo "<table>";

    echo "<tr><th>ID</th><th>USERNAME</th><th>Administrateur</th><th>Action</th></tr>";

    foreach($users as $users){

        echo "<tr>";

        echo "<td>".$users['id']."</td>";

        echo "<td>".$users['email']."</td>";

        echo "<td>";

        if($users['admin'] == 1){

            echo "Oui";

        }else{

            echo "Non";

        }

        echo "</td>";

        echo "<td>";

        echo "<a href='users.php?action=edit&id=".$users['id']."'>Edit (modifier)</a> ";

        echo "<a href='users.php?action=delete&id=".$users['id']."'>Supprimer</a> ";

        if($users['admin'] == 1){

            echo "<a href='users.php?action=retirer_admin&id=".$users['id']."'>Retirer les droits administrateur</a>";

        }else{

            echo "<a href='users.php?action=donner_admin&id=".$users['id']."'>Donner les droits admininstrateur</a>";

        }

        echo "</td>";

        echo "</tr>";

    }

    echo "</table>";

 

    if(isset($_GET['action']) && isset($_GET['id']) && $_GET['action'] == "edit"){

        $id = $_GET['id'];

        $req = $bdd->prepare('SELECT * FROM users WHERE id = :id');

        $req->execute(array('id' => $id));

        $users = $req->fetch();

 

        echo "<h2>Editer l'utilisateur ".$users['email']."</h2>";

        echo "<form method='post' action='users.php?action=update&id=".$users['id']."'>";

        echo "<label for='email'>Email:</label>";

        echo "<input type='text' name='email' value='".$users['email']."'><br>";

        echo "<label for='mot_de_passe'>Mot de passe:</label>";

        echo "<input type='password' name='mot_de_passe'><br>";

        echo "<label for='admin'>Admin:</label>";

        echo "<input type='checkbox' name='admin' value='1' ";

        if($users['admin'] == 1){

            echo "checked";

        }

        echo "><br>";

        echo "<input type='submit' value='Enregistrer'>";

        echo "</form>";

    }

 

    if(isset($_GET['action']) && isset($_GET['id']) && $_GET['action'] == "update"){

        $id = $_GET['id'];

        $email = $_POST['email'];

        $mot_de_passe = $_POST['mot_de_passe'];

        $admin = isset($_POST['admin']) ? 1 : 0;

 

        $req = $bdd->prepare('UPDATE users SET email = :email, admin = :admin WHERE id = :id');

        $req->execute(array('email' => $email, 'admin' => $admin, 'id' => $id));

 

        if(!empty($mot_de_passe)){

            $req = $bdd->prepare('UPDATE users SET mot_de_passe = :mot_de_passe WHERE id = :id');

            $req->execute(array('mot_de_passe' => password_hash($mot_de_passe, PASSWORD_DEFAULT), 'id' => $id));

        }

 

        echo "L'utilisateur a été mis à jour";

    }

 

    if(isset($_GET['action']) && isset($_GET['id']) && $_GET['action'] == "delete"){

        $id = $_GET['id'];

        $req = $bdd->prepare('DELETE FROM users WHERE id = :id');

        $req->execute(array('id' => $id));

        echo "The member has been deleted";

    }

 

    if(isset($_GET['action']) && isset($_GET['id']) && $_GET['action'] == "donner_admin"){

        $id = $_GET['id'];

        $req = $bdd->prepare('UPDATE users SET admin = 1 WHERE id = :id');

        $req->execute(array('id' => $id));

        echo "Admin privileges have been granted".$id;

    }

 

    if(isset($_GET['action']) && isset($_GET['id']) && $_GET['action'] == "retirer_admin"){

        $id = $_GET['id'];

        $req = $bdd->prepare('UPDATE users SET admin = 0 WHERE id = :id');

        $req->execute(array('id' => $id));

        echo "Admin privileges have been removed ".$id;

    }

    ?>

 

