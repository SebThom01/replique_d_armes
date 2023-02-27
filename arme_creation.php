<?php
include_once('environnement.php'); 
include_once('nav.php');

 

if (!isset($_SESSION['userName'])) {
    header('Location:index.php');
}

if (isset($_POST['nom']) && isset($_POST['description'])) {
    $nom = htmlspecialchars($_POST['nom']);
    $description = htmlspecialchars($_POST['description']);

    if (isset($_FILES['image'])) {
        // NOM DU FICHIER IMAGE
        $image = $_FILES['image']['name'];
        $imageTmp = $_FILES['image']['tmp_name']; // NOM TEMPORAIRE DU FICHIER IMAGE
        $infoImage = pathinfo($image); //TABLEAU QUI DECORTIQUE LE NOM DE FICHIER
        $extImage = $infoImage['extension']; //EXTENSION 
        $imageName = $infoImage['filename']; //NOM DU FICHIER SANS L'EXTENSION
        //GENERATION D'UN NOM DE FICHIER UNIQUE
        $uniqueName = $imageName . time() . rand(1, 1000) . "." . $extImage;

        move_uploaded_file($imageTmp, 'asset/image/' . $uniqueName);
    }

    $request = $bdd->prepare('INSERT INTO arme(nom,description,image,users_id)
                              VALUES(?,?,?,?)');

    $request->execute(array($nom, $description, $uniqueName, $_SESSION['userId']));
    header('Location: article.php?success=1');
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta nom="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/image/livre-de-sortileges.png">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Création de l'article</title>
</head>

<body>
    
    <main>
        <h1>Création de l'article</h1>

        <!--Formulaire de Création-->
        <form action="creature_creation.php" method="POST" enctype="multipart/form-data">
            <label for="nom">Le nom de l'arme:</label>
            <input type="text" id="nom" name="nom">

            <label for="image">Ajouter une image:</label>
            <input type="file" id="image" name="image">

            <label for="description">La description de l'arme:</label>
            <textarea name="description" id="description" cols=" 30" rows="10"></textarea>
            <button>Ajouter</button>
        </form>
    </main>
</body>

</html>