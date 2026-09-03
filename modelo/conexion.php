<?php

class Conexion{

    static public function conectar(){

        $host = "localhost";
        $db = "enviosbd";
        $user = "root";
        $pass = "";

        $link = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        $link->exec("set names utf8");

        return $link;

    }

}

?>
