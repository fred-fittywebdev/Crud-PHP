<?php
require_once('catalogue.dao.php');
require_once('gestionImage.php');

if(isset($_POST['libelle'])) {
    $fileImage = $_FILES['imageJeux'];
    $repertoire = "jeux/";
    try{
        $nomImage = ajoutImage($fileImage, $repertoire, $_POST['libelle']);
        $success = ajoutjeuxBD($_POST['libelle'], $_POST['description'], $_POST['typeID'], $nomImage);
    if($success) { ?>
        <div class="alert alert-success m-3" role="alert">
            l'ajout s'est bien déroulé.
        </div>
        <?php } else { ?>
            <div class="alert alert-danger m-3" role="alert">
            l' ajout n'a pas fonctionné.
        </div>
        <?php }
    }catch (Exception $e) {
        echo $e->getMessage();
    }
}

$type = getTypeBD();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Ajout</title>
</head>
<body>
<div class="titre titre2 bg-info text-white">
    <h1>Ajouter un jeu Switch</h1>
    <a href="index.php" class="btn btn-info">Acceuil</a>
    </div>
    <div class="container">
    <div class="m-3 row justify-content-lg-center">
        <div class="col-6">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="">Nom du jeu: </label>
                <input type="text" class="form-control" name="libelle" placeholder="Entrez le nom du jeu" required> 
            </div>
            <div class="form-group">
                <label for="">Description: </label>
                <textarea class="form-control" name="description" row="10" required></textarea>
            </div>
            <div class="form-group">
                <label for="">Catégorie du jeu: </label>
                <select name="typeID" class="form-control">
                    <?php foreach($type as $t) { ?>
                    <option value="<?= $t['typeID']?>"
                    ><?= $t['libelle'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="">Image du jeu: </label>
                <input type="file" class="form-control-file" name="imageJeux">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-info" value="Ajouter">
            </div>
        </div>
        </form>
    </div>
    </div>
    
</body>
</html>