<?php
include "models/conn.php";
session_start();


//LOGIN         
        $stmt = $conn->prepare("SELECT * FROM utilizador WHERE user = :user");
        $stmt->bindParam(':user', $_POST['user']);
        $stmt->execute();
        $utilizador = $stmt->fetch();

        if ($utilizador && password_verify($_POST['pass'], $utilizador['pass']))
        {
            //funciona
            $_SESSION['user'] = $_POST['user'];
            $resultado = true;
        }else{
            //nao funciona
            $resultado = false;
        }

        echo ($resultado);
?>