<?php
require_once("MonPDO.class.php");

function getjeuxBD() {
    $pdo = MonPDO::getPDO();
    $req = "SELECT * FROM jeux";
    $stmt = $pdo->prepare($req);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getTypeBD() {
        $pdo = MonPDO::getPDO();
        $req = "SELECT * FROM type";
        $stmt = $pdo->prepare($req);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

function getTypes($typeID) {
        $pdo = MonPDO::getPDO();
        $req2 = "SELECT libelle FROM type WHERE typeID = :typeID";
        $stmt = $pdo->prepare($req2);
        $stmt->bindValue(":typeID",$typeID , PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getJeuxToDeleteBD($idJeux) {
        $pdo = MonPDO::getPDO();
        $req2 = 'SELECT CONCAT(idJeux, " : ", libelle) AS monJeux  FROM jeux WHERE idJeux = :jeu';
        $stmt = $pdo->prepare($req2);
        $stmt->bindValue(":jeu",$idJeux , PDO::PARAM_INT);
        $stmt->execute();
        $res =  $stmt->fetch(PDO::FETCH_ASSOC);
        return $res['monJeux'];
}

function deleteJeuxBD($idJeux) {
        $pdo = MonPDO::getPDO();
        $req2 = 'DELETE FROM jeux WHERE idJeux = :jeu';
        $stmt = $pdo->prepare($req2);
        $stmt->bindValue(":jeu",$idJeux , PDO::PARAM_INT);
        return $stmt->execute();
}

function modfierJeuxBD($idJeux, $libelle, $description, $typeID, $nomImage) {
        $pdo = MonPDO::getPDO();
        $req2 = '
                UPDATE jeux 
                set libelle = :libelle, description = :desc, typeID = :typeID';
        if($nomImage !== "") $req2 .=', image=:image';
        $req2 .=' WHERE idJeux = :jeu';
        $stmt = $pdo->prepare($req2);
        $stmt->bindValue(":jeu",$idJeux , PDO::PARAM_INT);
        $stmt->bindValue(":libelle",$libelle , PDO::PARAM_STR);
        $stmt->bindValue(":desc",$description , PDO::PARAM_STR);
        $stmt->bindValue(":typeID",$typeID , PDO::PARAM_INT);
        if($nomImage !== "")  $stmt->bindValue(":image", $nomImage, PDO::PARAM_STR);
        return $stmt->execute();
}

function ajoutjeuxBD($libelle, $descritpion, $typeID, $image) {
        $pdo = MonPDO::getPDO();
        $req2 = 'INSERT into jeux (libelle, description, typeID, image) values(:libelle, :description, :typeID, :image)';
        $stmt = $pdo->prepare($req2);
        $stmt->bindValue(":libelle",$libelle , PDO::PARAM_STR);
        $stmt->bindValue(":description",$descritpion , PDO::PARAM_STR);
        $stmt->bindValue(":typeID",$typeID , PDO::PARAM_INT);
        $stmt->bindValue(":image",$image , PDO::PARAM_STR);
        return $stmt->execute();
}

function getImageToDelete($idJeux) {
        $pdo = MonPDO::getPDO();
        $req2 = 'SELECT image  FROM jeux WHERE idJeux = :jeu';
        $stmt = $pdo->prepare($req2);
        $stmt->bindValue(":jeu",$idJeux , PDO::PARAM_INT);
        $stmt->execute();
        $res =  $stmt->fetch(PDO::FETCH_ASSOC);
        return $res['image'];
}
