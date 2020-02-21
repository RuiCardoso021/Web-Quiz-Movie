//variables for rollet
const $content = document.querySelectorAll('.wrapper-roulette ul li');
var bonus = 0;
let n = 0; 
let stop;
let random;

//global variables
var i=0;
var score=0;
var duration_time_game=400;
var pointExtra = 0;

//Quiz API
var apiQuiz = "https://opentdb.com/api.php?amount=50&category=11&difficulty=easy&type=multiple";

function main(){
    //hiden divs
    $("#quizdiv").hide();
    $(".caja").hide();
    $("#secound_time").hide();
    $("#new_quiz").hide();
    $("main").hide();

    //start music
    var audio = document.getElementById("myAudio");
    audio.play();

    //logaut
    $(".btn-outline-danger").click(function(){
        document.location.href = "index.php";
    });

    //function to start quiz game
    $("#button").click(function(){ 
        $("#button").hide(500);
        $(".caja").show();
        begin();
        
    });

    } main()

//CREATE TIMER TO BEGIN GAME
function begin(){
    var temoriza=5;
    let timerId = setInterval(() => {
        $("#caja").text(temoriza); 
        temoriza--; 
        }, 1000);

    // after 5 seconds stop and start quiz
    setTimeout(() => {
        clearInterval(timerId);
        $(".caja").hide(); 
        showQuiz(); 
        //timer();
    }, 6500);
}

//PLAY QUIZ GAME
function showQuiz()
{
    $.getJSON(apiQuiz, function (data) {
        $("#quizdiv").show(500)

        var segundos = 0;
        var temp_quiz = 0

        var temporizador_quiz = setInterval(timer, 1000); //1000 will  run it every 1 second

        //TIMER GAME QUIZ
        function timer()
        {
            segundos++;
            if (segundos <= duration_time_game){
                temp_quiz = segundos;
                $("#first_tempo").text(temp_quiz);
                $('#score').text(score);
                return temp_quiz;
            }else{
                //game over when 400 seconds ends
                if(temp_quiz == duration_time_game){

                    //AQUI (POST SELECT DATA BASE) PARA OS BEST
                    var bestScore = $('#bestScore').html();
                    var bestTempo = $('#bestTempo').html();
                    
            
                    //CURRIGIR BEST TEMPO (BUSCAR DADOS DOS BEST A BD (ONDE?)
                    if(score > bestScore || (score == bestScore && temp_quiz < bestTempo)){
                        $('#bestScore').text(score);
                        $("#bestTempo").text(temp_quiz);
            
                        //update bestTempo and bestScore in database
                       dataUpdate();
                    }
            
                    //end of game
                    setTimeout(playOurExitGame,1000);
                    clearInterval(temporizador_quiz); 
                }
            }
        }
        
        //QUIZ
        function go(){
            /* Saving JSON in localstorage and naming result "stored" */
            var source = data;
            localStorage.setItem('local', JSON.stringify(source));
            var stored = JSON.parse(localStorage.getItem('local'));
            console.log(stored);

            //game over when 50 questions finish
            if(i == 50){

                //AQUI (POST SELECT DATA BASE) PARA OS BEST
                var bestScore = $('#bestScore').html();
                var bestTempo = $('#bestTempo').html();
                
        
                //CURRIGIR BEST TEMPO (BUSCAR DADOS DOS BEST A BD (ONDE?)
                if(score > bestScore || (score == bestScore && temp_quiz < bestTempo)){
                    $('#bestScore').text(score);
                    $("#bestTempo").text(temp_quiz);
        
                    //update bestTempo and bestScore in database
                dataUpdate();
                }
        
                //end of game
                setTimeout(playOurExitGame,1000);
                clearInterval(temporizador_quiz); 
            }

            do {  
                var instance;
                /* Making an array out of one JSON result*/
                var qa = [
                    stored.results[ i ].correct_answer,
                    stored.results[ i ].incorrect_answers["0"],
                    stored.results[ i ].incorrect_answers["1"],
                    stored.results[ i ].incorrect_answers["2"]];

                var instance = shuffle(qa);            

                /* Adding correct answer on top, for correct answer check */
                instance.unshift(stored.results[ i ].correct_answer);

                /* Adding question on top.
                /* We now have an array that contains, in order:
                    the question
                    the correct answer
                    the 4 possibilities */
                instance.unshift(stored.results[ i ].question);

                /* Resetting and Displaying question */
                $('#question').html("");
                $('#question').html(instance[0]);

                /* Resetting and Displaying answers */
                $('#q1').html("").removeClass("correct").removeClass("wrong");
                $('#q2').html("").removeClass("correct").removeClass("wrong");
                $('#q3').html("").removeClass("correct").removeClass("wrong");
                $('#q4').html("").removeClass("correct").removeClass("wrong");
                $('#q1').html(instance[2]);
                $('#q2').html(instance[3]);
                $('#q3').html(instance[4]);
                $('#q4').html(instance[5]); 
                $(".questions").prop( "disabled", false );
                /* STILL BASIC - Question&Answer confrontation logic */
                
                $('.questions').off().click(function(){
                    var answer = $(this).html();
                    if (answer == instance[1]){
                        $(this).addClass("correct");
                        //Game Score
                        score++;

                        //soma perguntas seguidas
                        pointExtra++; 
                        
                        if(pointExtra == 3){
                            roleta();   
                            setTimeout(function(){
                                $(".body_game").show();
                                $("main").hide();
                                bonus = $('.select').text();
                                bonus = parseInt($('.select').text());
                                score = score + bonus;
                            }, 8000)
                            pointExtra = 0;
                            
                        }
                    } else {
                        $(this).addClass("wrong");
                        $('.questions:contains('+instance[1]+')').addClass("correct");
                        pointExtra = 0; 
                    }
                    
                    //desabled button questions
                    $(".questions").prop( "disabled", true );

                    setTimeout(go, 900);
                })
                //QUIZ END

                i++;
                
                $("#number_question").text(i + "/50")
                console.log(i);
                
            } while (i< stored.length);
        } go();    
    }) /*json call*/

}


//PLAY OR STOP GAME
function playOurExitGame(){
    var conf = window.confirm("Começar quiz?")    
    if(conf == true){
        $("#quiz").hide();
        setTimeout(function(){
            document.location.href = "game.php";
            clearInterval();
        }, 3000);
    }else{
        $("#quiz").hide();
        setTimeout(function(){
            document.location.href = "index.php";
            clearInterval();
        }, 3000);
    }
} 

//UPDATE DATA IN DATABASE
function dataUpdate(){
    $.post("../QUIZ/data_quiz.php",
    {
        bestTempo: $("#bestTempo").html(),
        bestScore: $("#bestScore").html()
    },
    function(data_quiz_result,status){

        if(data_quiz_result == 1)
        {
            alert("GOOD! NEW RECORD!");
            
        }else{
            alert("FAIL DATABASE");
        }                
            
    });
}

//SHUFFLING ARRAY
function shuffle(arra1) {
    var ctr = arra1.length, temp, index;

    // While there are elements in the array
    while (ctr > 0) {
        // Pick a random index
        index = Math.floor(Math.random() * ctr) ;
        // Decrease ctr by 1
        ctr--;
        // And swap the last element with it
        temp = arra1[ctr];
        arra1[ctr] = arra1[index];
        arra1[index] = temp;
    }
    return arra1;
}

//ROULETTE
function roleta(){
    //enabled button questions
    $(".body_game").hide();
    $("main").show();

    varRoulete();
    clearInterval(startRoulette);
    startRoulette = setInterval(roulette, 100);
}

//RANDOM ROULETTE
function varRoulete() {
    stop = 0;
    random = Math.floor((Math.random() * 50) + 10);
  };
   
var startRoulette;

//CHOOSE RANDOM NUMBER IN ROULETTE
function roulette() { 
    if(n < 10 && stop != random){
        [].map.call($content, function(v, index, array) {
            v.classList.remove("active");
            array[n].classList.add("active"); 
            document.querySelector("body").classList.remove("active");
            v.classList.remove("select");
        }) 
        n++;
        stop++; 
    } else {
        n = 0;
        finish();
    }
};  

//SELECT BONUS OF ROULETTE
function finish() {
    if(stop == random) {
        const $select = document.querySelector('.wrapper-roulette ul .active');
        setTimeout(function(){
            $select.classList.add("select");
            document.querySelector("body").classList.add("active");
        }, 500)
    }
}