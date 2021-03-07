<?php

/* Connexion à une base MySQL avec l'invocation de pilote */
// $dsn = 'mysql:dbname=jeux;host=localhost;charset=utf8';
// $user = 'root';
// $password = 'fittywebdev81000';

// $options = array(
//     PDO::MYSQL_ATTR_INIT_COMMAND -> "SET NAMES utf8"
// );

// // $options = array(
// //     PDO::MYSQL_ATTR_INIT_COMMAND => "SET MANES utf8"
// // );

// try {
//     $pdo = new PDO($dsn, $user, $password, $options);
// } catch (PDOException $e) {
//     echo 'Connexion échouée : ' . $e->getMessage();
// }


require_once("catalogue.dao.php");
require_once('gestionImage.php');



$cours = getjeuxBD();
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
    <title>Catalogue</title>
</head>
<body>
    <div class="titre">
    <h1>Catalogue de mes jeux Switch</h1>
    </div>
    <div class="titre1">
    <a href="ajout.php" class="btn btn-info">Ajouter</a>
    <?php
    if(isset($_GET['type']) && $_GET['type'] === 'suppression') {
        $jeuxToDelete = getJeuxToDeleteBD($_GET['idJeux']);
        ?>
        <div class="alert alert-warning m-3" role="alert">
        Tu es sur de vouloir <b class="text-danger">supprimer</b> le jeu <b><?= $jeuxToDelete ?></b>?
        <a href="?delete=<?= $_GET['idJeux'] ?>" class="btn btn-sm btn-danger">Supprimer !</a>
        <a href="index.php" class="btn btn-sm btn-success">Non !</a>
        </div>

        
    <?php


    }
    // suppression
    if(isset($_GET['delete'])) {
        $imageToDelete = getImageToDelete($_GET['delete']);
        deleteImage("jeux/", $imageToDelete);
        $success = deleteJeuxBD($_GET['delete']);
        if($success) { ?>
            <div class="alert alert-success m-3" role="alert">
                la suppression s'est bien déroulée.
            </div>
            <?php } else { ?>
                <div class="alert alert-danger m-3" role="alert">
                la suppression n'a pas fonctionnée.
            </div>
            <?php } 
    }

    if(isset($_POST['type']) && $_POST['type'] === "modificationJeux2") {
        $nomNouvelleImage = "";
        if($_FILES['imageJeux']['name'] !== ""){
            $imageToDelete = getImageToDelete($_POST['idJeux']);
            deleteImage("jeux/", $imageToDelete);

            $fileImage = $_FILES['imageJeux'];
            $repertoire = "jeux/";
            try{
                $nomNouvelleImage = ajoutImage($fileImage, $repertoire, $_POST['nomJeux']);
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
        }
        $success = modfierJeuxBD($_POST['idJeux'], $_POST['nomJeux'], $_POST['descJeux'],(int)$_POST['typeID'], $nomNouvelleImage);
        if($success) { ?>
            <div class="alert alert-success m-3" role="alert">
                la modification s'est bien déroulée.
            </div>
            <?php } else { ?>
                <div class="alert alert-danger m-3" role="alert">
                la modification n'a pas fonctionnée.
            </div>
            <?php }
    }

    $cours = getjeuxBD();
    $type = getTypeBD();
    ?>
    </div>


    

<div class="container">
<div class="row no-gutters">
    <?php foreach($cours as $c) : ?>
    <div class="col-4">
    <div id="card" class="card m-2">
        <?php if(!isset($_GET['type']) || $_GET['type'] !== "modification" || $_GET['idJeux'] !== $c['idJeux']) {  ?>
            <img src="jeux/<?= $c['image'] ?>" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title"><?= $c['libelle'] ?></h5>
                <p class="card-text"><?= $c['description'] ?>.</p>
                <?php 
                $typeTxt = getTypes($c['typeID']);
                ?>
                <span id="span" class="badge badge-primary"><?= $typeTxt['libelle'] ?></span>
                <input id="type" type="hidden" value="<?= $typeTxt['libelle'] ?>">
            </div>
             <div class="row no-gutters p-2">
                    <form action="" method="GET" class="col-6 text-center">
                        <input type="hidden" name="idJeux" value="<?= $c['idJeux'] ?>">
                        <input type="hidden" name="type" value="modification">
                        <input type="submit" value="Modifier" class="btn btn-sm btn-outline-primary">
                    </form>
                    <form action="" method="GET" class="col-6 text-center">
                    <input type="hidden" name="idJeux" value="<?= $c['idJeux'] ?>">
                        <input type="hidden" name="type" value="suppression">
                        <input type="submit" value="Supprimer" class="btn btn-sm btn-outline-danger">
                    </form>
            </div>
         <?php } else {  ?>
         <form action="" method="POST" enctype="multipart/form-data">
         <input type="hidden" name="type" value="modificationJeux2">
         <input type="hidden" name="idJeux" value="<?= $c['idJeux'] ?>">
         <img src="jeux/<?= $c['image'] ?>" class="card-img-top" alt="...">
         <div class="card-body">
         <div class="form-group">
                <label for="">Image du jeu: </label>
                <input type="file" class="form-control-file" name="imageJeux">
            </div>
         <div class="form-group">
            <label for="">Nom du jeu: </label>
            <input type="text" class="form-control" name="nomJeux" value="<?= $c['libelle'] ?>">
         </div>
         <div class="form-group">
            <label for="">Description: </label>
            <textarea name="descJeux"  rows="3" class="form-control"><?= $c['description'] ?>.</textarea>
         </div>
         <select name="typeID" class="form-control">
         <?php foreach($type as $t) { ?>
            <option value="<?= $t['typeID']?> "
            <?= ($t['typeID'] === $c['typeID']) ? "selected" : "" ?>
            ><?= $t['libelle'] ?></option>
         <?php } ?>
            
         </select>
                
                <input id="type" type="hidden" value="<?= $typeTxt['libelle'] ?>">
        </div>
        <div class="row no-gutters p-2">
                <div class="col text-center">
                        <input type="submit" value="Valider"  class="btn btn-sm btn-outline-success">
                </div>
                <div class="col text-center">
                    <input type="submit" value="Annuler" onclick="cancelModifications(event)" class="btn btn-sm btn-outline-danger">
                </div>
         </div>
         </form>
         <?php } ?>
    </div>
    </div>
    <?php endforeach; ?>    
</div>
</div>
<script src="script.js"></script>
</body>
</html>