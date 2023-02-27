<?php
include_once('environnement.php');
// var_dump($connexion);
// ON VERIFIE SI LES CHAMPS SONT REMPLIS ET PAS VIDE
if (isset($_POST['name']) && (isset($_POST['password']))) {
    if ((!empty($_POST['name'])) && (!empty($_POST['password']))) {
        $username = htmlspecialchars(trim(strtolower($_POST['name'])));
        $password = htmlspecialchars(trim($_POST['password']));
        $passwordCrypt = sha1(sha1('123' . $password . 'kpkoazf1516'));

        //VERIFICATION SI LE MOT DE PASSE EST CORRECT
        $query = $bdd->prepare('SELECT * 
                                FROM user
                                WHERE username = "'.$username.'" and password = "'.$passwordCrypt.'";');
        // var_dump($connexion);       

        $query->execute(array($username));


        while ($userData = $query->fetch()) {
            if ($passwordCrypt == $userData['password']) {
                $_SESSION['userName'] = $userData['username'];
                $_SESSION['userId'] = $userData['id'];
                $_SESSION['role'] = $userData['role'];
                header('Location:index.php?successconnect=1');
            } else {
                header('Location:connexion.php?errorconnect=1');
                //ERREUR MOT DE PASSE FAUX
            }
        }
    } else {
        header('Location:connexion.php?errorconnect=2');
        //ERREUR CHAMP VIDE
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="asset/css/style.css">
    <title>Document</title>
</head>
<body>
<main>
    <div class="titleContainer">
        <p>Connexion</p>
    </div>
    <div class="buttonReturn">
        <a href="./index.php"><div class="button"><p>< Retour</p></div></a>
    </div>
    <?php
    if (isset($_GET['successsubscribe'])) {
        echo '<p class="success">Vous pouvez maintenant vous connecter </p>';
    }
    ?>
    <main class="mainConnect">
        <form action="connexion.php" method="POST">
        <div class="userName">
            <label for="name">Votre nom:</label>
            <input type="text" name="name" id="name">
        </div>
        <div class="passName">
            <label for="password">Votre mot de passe:</label>
            <input type="password" name="password" id="password">
        </div>
        <div class="buttonConnect">
            <button>Connexion</button>
        </div>
        </form>
    </main>
    
</body>
</html>
