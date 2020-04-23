<?php 
    $fileName = "quiz.json";
    $myTest = file_get_contents("./".$fileName);
    $json = json_decode($myTest);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <div id="test"></div>
    <button id="submit">Kontrolli vastuseid</button>
    <div id="results"></div>

<script>
    const quizContainer = document.getElementById('test');
    const resultsContainer = document.getElementById('results');
    const submitButton = document.getElementById('submit');
    const myQuestions = <?php echo $myTest; ?>;
    let i = 0;

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
            `<div class="question"> ${currentQuestion.question} </div>
            <div class="answers"> ${answers.join('')} </div>`
            );
            
        }
        );
        quizContainer.innerHTML = output;
        
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
            answerContainers[questionNumber].style.color = 'lightgreen';
            }
            // if answer is wrong or blank
            else{
            // color the answers red
            answerContainers[questionNumber].style.color = 'red';
            }
        });

        // show number of correct answers out of total
        resultsContainer.innerHTML = `${numCorrect} õige(t) ${myQuestions.length}-st`;
}

    buildTest();

    submitButton.addEventListener('click', showResults);

</script>
</body>
</html>
