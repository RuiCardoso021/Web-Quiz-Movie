<?php
    include "models/conn.php";

    session_start();
    if(isset($_SESSION["user"]))
    {
        session_unset();
        session_destroy();
    }

    //SELECT
    $stmt = $conn->prepare("SELECT user, img, best_score, best_time FROM utilizador ORDER BY best_score DESC LIMIT 5");
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);																
    
?>





<!DOCTYPE <!DOCTYPE html>
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>WebSiteQuiz</title>
        <fabicon></fabicon>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>
    
        <!--navbar-->
        <nav class="navbar fixed-top navbar-light bg-danger">
            <a class="navbar-brand" href="#" style="color: white;">
                <img src="img/icon.png" width="30" height="30" class="d-inline-block align-top" alt="">
                MovieQuiz
            </a>
            <ul class="nav nav-pills float-right" id="myTab" role="tablist">
                <li class="nav-item" style="padding-right:10px;">
                    <a style="color: white;" class="nav-link btn  btn-outline-danger active" id="login-tab" data-toggle="tab" href="#login" role="tab" aria-controls="login" aria-selected="true">Login</a>
                </li>
                <li class="nav-item">
                    <a style="color: white;" class="nav-link btn btn-outline-danger" id="register-tab" data-toggle="tab" href="#register" role="tab" aria-controls="register" aria-selected="false">Register</a>
                </li>
            </ul>
        </nav>


    <!--login/register-->
    <section class="section1" id="section1">
        <div class="container">
            <div class="d-flex justify-content-center h-100">
                <div class="card">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab" style="margin-top: 30px">
                            
                            <div class="card-header">
                                <h3 class="h3">LOGIN</h3>
                                <div class="d-flex justify-content-end social_icon">
                                    <img src="img/quiz.png" class="logo img-fluid" alt="Responsive image">
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="login_form">
                                    <input type="hidden" name="accao" value="envia" />
                                    <div class="input-group form-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="username" name="user" id="user">
                                        
                                    </div>
                                    <div class="input-group form-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                                        </div>
                                        <input type="password" class="form-control" placeholder="password" name="pass" id="pass">
                                    </div>
                                    <div class="row align-items-center remember">
                                        <input type="checkbox">Remember Me
                                    </div>
                                    <div class="form-group">
                                        <button class="btn float-right login_btn" name="accao" id="logar" type="submit">Login</button>
                                    </div>
                                </div>
                                <img src="img/goku.png" class="goku d-inline-block align-top" alt="">
                            </div>
                        </div>
                        

                        
                        <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="profile-tab" style="margin-top: 30px">
                            <div class="card-header">
                                <h3 class=h3>REGISTER</h3>
                                <div class="d-flex justify-content-end social_icon">
                                <img src="img/quiz.png" class="logo img-fluid" alt="Responsive image">
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="register_form">
                                    <div class="input-group form-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="username" name="r_user" id="r_user">
                                        
                                    </div>
                                    <div class="input-group form-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                                        </div>
                                        <input type="password" class="form-control" placeholder="password" name="r_pass" id="r_pass">
                                    </div>
                                    <div class="form-group">
                                        <button class="btn float-right login_btn" name="save" id="registar"  type="submit">Register</button>
                                    </div>
                                </div>
                                <img src="img/goku.png" class="goku d-inline-block align-top" alt="">
                            </div>
                        </div>

                    </div>  
                </div>
            </div>
        </div>
    </section>

        <!--login/register-->
        <section class="section2">
        <div class="container">
            <div class="d-flex justify-content-center h-100">
            <div class="card card_top5 col-12">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab" style="margin-top: 30px">
                            
                            <div class="card-header">
                                <h3 class="h3 h3_top5">THE BEST OF QUIZ</h3>
                                <div class="d-flex justify-content-end social_icon">
                                    <img src="img/top5.png" class="logo_top5 img-fluid" alt="Responsive image">
                                </div>
                            </div>
                            <div class="card-body card_php">
                                <div class="row">
                                    <div class="col-6">
                                        <h1>NAME:</h1>
                                        <?php
                                        foreach ($rows as $row){  
                                            echo "<div class='form-inline'>";
                                            if($row['img'] == "")
                                            {
                                                echo '<img src="img/users/no-image.png" alt="Profile Picture" alt="Image" class="img_perfil"/>';
                                                
                                            } else{
                                                echo '<img src="img/users/'.$row['img'].'" alt="Profile Picture" alt="Image" class="img_perfil"/>';
                                            }
                                        
                                            echo "<p>".$row['user']."</p>
                                                    </div>";
                                        }
                                        ?>
                                    </div>
                                    <div class="col-6">
                                        <h1>SCORE/TIME</h1>
                                        <?php 
                                        foreach ($rows as $row){    
                                            echo "<div class='form-inline'>
                                                    <p>".$row['best_score']."</p>
                                                    <p class='space'>/</p>   
                                                    <p>".$row['best_time']."s</p>
                                                    </div>";
                                        }
                                        ?> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </section>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="js/login.js"></script>
        <script src="js/register.js"></script>
    </body>
</html>
