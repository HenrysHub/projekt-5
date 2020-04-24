<?php 
    $fileName = $_REQUEST['link'];
    $myTest = file_get_contents("./json_files/valikvastused/".$fileName);
    $json = json_decode($myTest);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../main.css">
    <link href="https://fonts.googleapis.com/css2?family=Bangers&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cuprum:ital@1&display=swap" rel="stylesheet">
    <title>Valikvastustega testid</title>
</head>
<body>
<div class="content">

        <header class="main">
            <div class="logo">
                <img src="../assets/logo.png" height="100" width="100">
            </div>
            <div class="title">
                <h1>Driller</h1>
            </div>
        </header>

        <div class="links">

            <div class="sidenav">
                <a href="../">Tagasi esilehele</a>
                <a href="#">Ajalugu</a>
            </div>

            <div class="quiz">
                <div id="test"></div>
                <button id="submit">Kontrolli vastuseid</button>
                <div id="results"></div>
            </div>

        </div>

    </div>

<script>
    const quizContainer = document.getElementById('test');
    const resultsContainer = document.getElementById('results');
    const submitButton = document.getElementById('submit');
    const myQuestions = <?php echo $myTest; ?>;

    function buildTest(){
        const output = [];        

        // for each question...
        myQuestions.forEach(
        (currentQuestion, questionNumber) => {

            // variable to store the list of possible answers
            const answers = [];

            // and for each available answer...
            for(letter in currentQuestion.answers){
                

            // ...add an HTML radio button
            answers.push(
                `<label>
                <input type="radio" name="question${questionNumber}" value="${letter}">
                ${letter} :
                ${currentQuestion.answers[letter]}
                </label>`                
            );
            }

            // add this question and its answers to the output
            output.push(
            `<div class="qa">
            <div class="question"> ${currentQuestion.question} </div>
            <div class="answers"> ${answers.join('')} </div>
            </div>`
            );
            
        }
        );
        quizContainer.innerHTML = output.join('');
        
        // finally combine our output list into one string of HTML and put it on the page
    }
    function showResults(){
        // gather answer containers from our quiz
        const answerContainers = quizContainer.querySelectorAll('.answers');

        // keep track of user's answers
        let numCorrect = 0;

        // for each question...
        myQuestions.forEach( (currentQuestion, questionNumber) => {

            // find selected answer
            const answerContainer = answerContainers[questionNumber];
            const selector = `input[name=question${questionNumber}]:checked`;
            const userAnswer = (answerContainer.querySelector(selector) || {}).value;

            // if answer is correct
            if(userAnswer === currentQuestion.correctAnswer){
            // add to the number of correct answers
            numCorrect++;

            // color the answers green
            answerContainers[questionNumber].style.color = 'darkgreen';
            }
            // if answer is wrong or blank
            else{
            // color the answers red
            answerContainers[questionNumber].style.color = 'red';
            }
        });

        // show number of correct answers out of total
        var protsent = (numCorrect / myQuestions.length) * 100;
        resultsContainer.innerHTML = `Teie tulemus: ${numCorrect} õiget ${myQuestions.length}-st, ${protsent}%`;
}

    buildTest();

    submitButton.addEventListener('click', showResults);

</script>
</body>
</html>
