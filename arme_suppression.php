<?php
include_once('environnement.php');


$id = htmlspecialchars($_GET['id']);
//REQUETE POUR VERIFICATION DU USER A QUI APPARTIENT L'ARTICLE
$requestSelect = $bdd->prepare('SELECT * FROM creature 
                                WHERE id=?');
$requestSelect->execute([$id]);
while ($data = $requestSelect->fetch()) {
    //VERIFICATION DU CHAMP USERS_ID AVEC L'ID GARDE EN VARIABLE DE SESSION
    if ($_SESSION['userId'] == $data['id'] || $_SESSION['role'] == 'ADMIN') {
        //ON EXECUTE LA REQUETE SI CA CORRESPOND
        $request = $bdd->prepare('DELETE FROM creature
                          WHERE id=?');

        $request->execute([$id]);
        header('Location: bestiaire.php?success=3');
        exit();
    } else {
        //SINON ON RENVOIE SUR L'INDEX
        header('Location: index.php');
        exit();
    }
}