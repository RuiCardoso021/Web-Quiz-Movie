$(document).ready(function(){
    $("#registar").click(function(){
    
        var userTest = document.getElementById('r_user').value;
        var passTest = document.getElementById('r_pass').value;

        if (userTest === "" || passTest === ""){

            alert ("prencha todos os campos");

        }else{
            $.post("../QUIZ/register.php",
            {
                r_user: $("#r_user").val(),
                r_pass: $("#r_pass").val()
            },
            function(data_r,status){
                if(data_r == 1)
                {
                    document.location.href = "index.php";
                    alert("O " + userTest + " foi criado com sucesso!")
                }else{
                    alert("ERROR TO CONNECT DB")   
                }
                
            });
        }
    });
});

  