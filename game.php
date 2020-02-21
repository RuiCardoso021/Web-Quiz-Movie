<?php

	session_start();
        include "models/conn.php";
    if (!isset($_SESSION['user']))
        header("Location: index.php");

    $nome=$_SESSION['user'];

    //IMG
    if(isset($_POST['foto'])){
        
        
        if($_FILES["imagem"])
        {
            //FUNCTION TO UPLOAD IMG
            $img = $_FILES["imagem"];
            $dir = 'img/users/'; // Diretório que vai receber o arquivo.
            $tmpName = $img['tmp_name']; // Recebe o arquivo temporário.
            $lstname = $img['name']; // Recebe o nome do arquivo.
            $name = $_SESSION['user']; // Recebe o nome do arquivo.
            $ext = end(explode(".", $lstname)); //Obter a extensão do ficheiro enviado
            $name = $name.'.'.$ext; //Construir o nome final do ficheiro
            $i = $dir . $name; //Construir o destino final do ficheiro + o nome do ficheiro 
        
            move_uploaded_file( $tmpName, $dir . $name ); // move_uploaded_file irá realizar o envio do arquivo.									
        }

        
        //UPDATE DATABASE
        $stmt = $conn->prepare("UPDATE utilizador set img = :img where user = :user");
        $stmt->bindParam(':img', $name);			
        $stmt->bindParam(':user', $nome);	
        $stmt->execute(); 
    }

    try{
        //SELECT DATA
        $stmt = $conn->prepare("SELECT best_score, best_time, img FROM utilizador WHERE user = '$nome'");
        if ($stmt->execute()) {
            while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
?>

<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>MovieQuiz</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://bootswatch.com/4/slate/bootstrap.min.css" type="text/css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
        <link rel="stylesheet" href="css/game.css">
        <link rel="stylesheet" href="css/roleta.css">
        <link href="https://fonts.googleapis.com/css?family=Chilanka&display=swap" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </head>
    <head>
 
      

  </head>
  <body>
    <!--navbar-->
    <div class="container">
        <div class="row">
        <nav class="navbar fixed-top navbar-light bg-danger">
            <a class="navbar-brand" href="game.php" style="color: white;">
                <img src="img/icon.png" width="30" height="30" class="d-inline-block align-top" alt="">
                MovieQuiz
            </a>
            <div class="form-inline" style="padding:3px;">
                    <!--SHOW IMG-->
                    <a style="margin-right:10px" href="#footerModal" data-toggle="modal" data-target="#footerModal"><i class="fas fa-info-circle"></i></a>
                    <?php
                        if($rs->img == "")
                        {
                            echo '<a class="a-foto" type="button" data-toggle="modal" data-target="#exampleModal"><img src="img/users/no-image.png" alt="Profile Picture" alt="Image" class="img_perfil"/></a>';
                            
                        } else{
                            echo '<a class="a-foto" type="button" data-toggle="modal" data-target="#exampleModal"><img src="img/users/'.$rs->img.'" alt="Profile Picture" alt="Image" class="img_perfil"/></a>';
                        }
                    ?>
                    <span class="font-weight-bold" style="color: rgb(189, 173, 173); margin-right: 30px; margin-left: 7px;"><?php echo $_SESSION['user']; ?> </span>
                <button class="btn btn-outline-danger" type="button" style="color:white;">Logout</button>
            </div>
        </nav>
        </div>
        
        <!-- Modal info -->
        <div class="modal fade" id="footerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="footerModalLabel">INFO</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>This page is about a quiz game in which its theme is movies.</p>
                        <p> - Quiz have 50 questions;</p>
                        <p> - You have 400 seconds to finish the quiz;</p>
                        <p> - If you get 3 consecutive questions you get a bonus.</p>
                    <br>
                    <p>Be the best and appear in the TOP 5 of the game homepage!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
        </div>

        <!-- Modal Img -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Choose your profile picture!</p>
                    <form action="" method="POST"  enctype="multipart/form-data">
                        <label class="fileContainer">
                            Click here to trigger the file uploader!
                            <input type="file" name="imagem"/>
                        </label>
                        <div class="vai" style="width=100%; margin-top:10px;">
                            <button type="submit" name="foto" value="foto" class="btn btn-success">ok</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
        </div>

        <section class="body_game">
            <!--btn start-->
            <button class="glow-on-hover" type="button" id="button">START QUIZ</button>

            <!--timer go-->
            <div class="caja" id="caja">GO</div>

            <!--quiz-->
            <div class="container" id="quizdiv" style="margin-top:100px; margin-bottom:100px">
                <div class="row">   
                    <div class="col-md-3">
                        <div class="col-xs-4" id="first_time">
                            <div class="jumbotron text-center">
                                <h3 class="h3">Time</h3>
                                <h5 id="first_tempo">0</h5>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="jumbotron text-center">
                                <h3 class="h3">Score</h3>
                                <h5 id="score">0</h5s>
                            </div>
                        </div>

                        <div class="col-xs-4">
                            <div class="jumbotron text-center">
                                <h3 class="h3">Best Score</h3>
                                <h5 id="bestScore" name="bestScore"><?php echo "$rs->best_score";?></h5>
                                <h3 class="h3">Best Time</h3>
                                <h5 id="bestTempo" name="bestTempo"><?php echo "$rs->best_time";?></h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9" id ="quiz">
                        <div class="jumbotron text-center">
                            <h1>Movie Quiz</h1>
                            <h3 id="question">Loading question...</h3>
                            <div class="list">
                                <button class="questions" id="q1"></button>
                                <button class="questions" id="q2"></button>
                                <button class="questions" id="q3"></button>
                                <button class="questions" id="q4"></button>
                            </div>
                            <p id="number_question"></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- roleta -->
        <div class="main">
            <main style="">
                <div class="fog"></div>
                <article>
                    <div class="wrapper-roulette">
                        <ul>
                            <li class="roulette-one" ><span>0</span></li>
                            <li class="roulette-two" ><span>10</span></li>
                            <li class="roulette-three"><span>0</span></li>
                            <li class="roulette-four" ><span>0</span></li>
                            <li class="roulette-five" ><span>5</span></li>
                            <li class="roulette-six" ><span>0</span></li>
                            <li class="roulette-seven"><span>3</span></li>
                            <li class="roulette-eight"><span>0</span></li>
                            <li class="roulette-nine"><span>0</span></li>
                            <li class="roulette-ten"><span>15</span></li>
                        </ul>
                    </div>
                </article>
            </main>
        </div>
    </div>
    
    <!--music-->
    <audio id="myAudio">
        <source src="music/music.mp3" type="audio/ogg">
    </audio>
                        
     <!-- Footer -->
    <footer class="page-footer fixed-bottom font-small mdb-color lighten-3 pt-4 bg-danger">
        <!-- Copyright -->
        <div class="footer-copyright text-center py-3" style="color: wheat;">Develop by:
            <a href="linkedin.com/in/rui-cardoso-0a159b183">Rui Cardoso</a>
        </div>
    </footer> 
    <?php																					
                }
            } else {
                echo "Erro: Não foi possível recuperar os dados do banco de dados";
            }
        } catch (PDOException $erro) {
            echo "Erro: ".$erro->getMessage();
        }
    ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="js/game.js" async defer></script>
  </body>
</html>