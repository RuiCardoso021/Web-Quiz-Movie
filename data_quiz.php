<?php
include "models/conn.php";
session_start();

//TIME AND SCORE   
    $best_score = $_POST['bestScore'];
    $best_time = $_POST['bestTempo'];
    $user = $_SESSION['user'];

    $stmt = $conn->prepare("UPDATE utilizador SET best_score = $best_score, best_time = $best_time WHERE user = '$user'");

    $stmt->execute();

    $quiz_resultado = true;

    echo ($quiz_resultado);
?>