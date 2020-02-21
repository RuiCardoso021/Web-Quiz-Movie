<?php
    include "models/conn.php";

    $r_user = $_POST['r_user'];
    $r_pass = password_hash($_POST['r_pass'], PASSWORD_DEFAULT);

    if(empty($r_user) || empty($r_pass)){
        $r_resultado = false;
    }else{
        $sql = $conn->prepare("INSERT INTO utilizador (user, pass) VALUES ('$r_user','$r_pass')");
        $sql->execute();
        $r_resultado = true;
    }

    echo ($r_resultado);


?>