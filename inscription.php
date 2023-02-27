<?php
include_once('environnement.php');

if (isset($_POST['name']) && (isset($_POST['password'])) && (isset($_POST['passwordConfirm']))) {
    $username = htmlspecialchars(trim(strtolower($_POST['name'])));
    $password = htmlspecialchars(trim($_POST['password']));
    $role = 'USER';

    $passwordConfirm = htmlspecialchars(trim($_POST['passwordConfirm']));

    //Verification des champs de mot de passe et confirmation de mdp
    if ($password == $passwordConfirm) {
        // VERIFICATION SI UTILISATEUR DEJA EXISTANT EN BDD

        $rqCount = $bdd->prepare('  SELECT COUNT(*) AS usercount
                                    FROM user
                                    WHERE username = ?');

        $rqCount->execute([$username]);

        while ($count = $rqCount->fetch()) {
            $countVerify = $count['usercount'];

            if ($countVerify < 1) {
                //ENCRYPTAGE DU MOT DE PASSE
                $passwordCrypt = sha1(sha1('123' . $password . 'kpkoazf1516'));

                $request = $bdd->prepare('  INSERT INTO user(username,password)
                                            VALUES(?,?)');

                $request->execute(array($username, $passwordCrypt));
                header('Location:connexion.php?successsubscribe=1');
            } else {
                header('Location:inscription.php?userexist=1');
            }
        }
    } else {
        header('Location:inscription.php?passworderror=1');
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
    <div id="navInscription">Inscription</div>
    <main>
    <div class="buttonReturn">
        <a href="./index.php"><div class="button">< Retour</div></a>
    </div>
        <!--ERROR MESSAGES-->
        <?php
        if (isset($_GET['userexist'])) {
            echo '<p class="error">Le nom d\'utilisateur existe déjà! </p>';
        }
        if (isset($_GET['passworderror'])) {
            echo '<p class="error">Les mots de passes ne correspondent pas! </p>';
        }
        ?>
        <div class="mainInscription">
            <form action="inscription.php" method="POST">
                <label for="name">Votre nom:</label>
                    <div class="userName">
                        <input type="text" name="name" id="name">
                        <label for="password">Votre mot de passe:</label>
                    </div>
                    <div class="passName">
                        <input type="password" name="password" id="password">
                        <label for="passwordConfirm">Confirmez votre mot de passe:</label>
                        <input type="password" name="passwordConfirm" id="passwordConfirm">
                    </div>
                   
                        <button class="button">Valider</button>
        </div>            
</body>
</html>