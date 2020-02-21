$(document).ready(function(){
    $("#logar").click(function(){
      $.post("../QUIZ/login.php",
      {
        user: $("#user").val(),
        pass: $("#pass").val()
      },
      function(data,status){
      
        var userTeste = document.getElementById('user').value;
        var passTeste = document.getElementById('pass').value;

        if (userTeste === "" || passTeste === ""){

          alert("Nome ou Pass Incorretas");

        }else{

          if(data == 1)
          {
              sessionStorage.setItem("user", $("#user").val());
              document.location.href = "game.php";   
          }else{
              alert("LOGIN FAIL");
              //$("#result")
              // document.getElementById("result").style.display="block";
          }

        }

           
      });
    });
  });



  