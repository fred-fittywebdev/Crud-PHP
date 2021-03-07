<?php

class MonPDO {
    private const HOST_NAME = "localhost";
    private const DB_NAME = "jeux";
    private const USER_NAME = "root";
    private const PWD = "fittywebdev81000";

    private static $monPDOinstance = null;

    public static function getPDO(){
        if(is_null(self::$monPDOinstance)){
            try{
                $options = array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                );
                $connexion = "mysql:host=".self::HOST_NAME.";dbname=".self::DB_NAME;
                self::$monPDOinstance = new PDO($connexion,self::USER_NAME,self::PWD,$options);

            } catch(PDOException $e){
                $message = "Erreur de connexion à la BD". $e->getMessage();
                die($message);
            }
        }
        return self::$monPDOinstance;
    }
   
}