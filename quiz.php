<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/output.css">

    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            align-items: center;
            justify-content: center;
        }

        .custom-bg {
            background-image: url('./assets/images/bg-3.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
            width: 100%;
            height: 100%;
            position: relative;
        }

        .content {
            text-align: center;
            display: flex;
            flex-direction: column; 
            align-items: center;
            max-width: clamp(200px, 80vw, 400px);
            margin: auto;
            height: -webkit-fill-available;
            justify-content: center ;
        }

        .wrapper{
            display: flex;
            flex-direction: column;
            flex-wrap: nowrap;
            justify-content: space-around;
            align-items: center;
            height: 100%;
        }

        .question-box {
            background-color: #fff;
            border-width: thick;
            border: 2px solid #8E7242;
            padding: 20px 40px 20px 40px;
            border-radius: 10px;
            color: #8E7242;
        }

        .answers{
            width: 100%;
        }

        h1{
            font-size: clamp(24px, 2vw, 28px);
            font-weight: bold;
        }

        
        .choices {
            /* margin-bottom: clamp(25px, 2vw, 40px); */
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.5);
            background-image: linear-gradient(to right, #2A68DC 0%, #4DA3FF 37%, #3677E4 100%);
        }
        
        
        .choices:hover {
            transition: all 0.5s ease 0s;
            background: #FFF;
        }

        .choices.selected {
            background: #fff;
            color: #8E7242;
        }
        
        button {
            display: block;
            width: 100%;
            font-size: clamp(12px, 2vw, 16px);
            border-color: #8E7242;
            padding: 10px;  
        }
        
        button.hover {
            transition: all 1s ease 0s;
            color: #8E7242;
            background: #fff;
        }
        
        .next {
            width: 100%;
        }
        
        
        .next-c {
            height: clamp(60px, 10vh, 80px);
            border-radius: 50px;
        }
    </style>
</head>
<body>
<?php
    $pageTitle = "Quiz";
    // include 'header.php';
    include 'db.php';
    session_start();

    if (!isset($_SESSION['selectedCategory'])) {
        header('Location: index.php');
        exit();
    }

    $_SESSION['userAnswers'] = array(); 
    $selectedCategory = $_SESSION['selectedCategory'];

    $query = "SELECT pq.pqID, pq.pqContent, pq.pqMinAnswer, a.answerID, a.answerContent
            FROM parent_question pq
            LEFT JOIN question_answer qa ON qa.pqID = pq.pqID 
            LEFT JOIN answer a ON a.answerID = qa.answerID
            WHERE pq.categoryID = '$selectedCategory'
            ORDER BY pq.pqOrder";
    $result = mysqli_query($conn, $query);

    $questions = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $pqID = $row['pqID'];
        $pqContent = $row['pqContent'];
        $pqMinAnswer = $row['pqMinAnswer'];
        $answerID = $row['answerID'];
        $answerContent = $row['answerContent'];

        if (!isset($questions[$pqID])) {
            $questions[$pqID] = array(
                'content' => $pqContent,
                'answers' => array(),
                'pqMinAnswer' =>  $pqMinAnswer, 
            );
        }

        if ($answerID !== null) {
            $questions[$pqID]['answers'][] = array(
                'id' => $answerID,
                'content' => $answerContent,
            );
        }
    }
?>


<div class="custom-bg">
    <div class="content" id="question-container">
        <div class="wrapper">
        <?php if (!empty($questions)): ?>
            <?php $firstQuestion = reset($questions); ?>
            <div class="question-box">
                <h1><?php echo $firstQuestion['content']; ?></h1>
            </div>
            <div class="answers">
                <?php if (!empty($firstQuestion['answers'])): ?>
                    <?php foreach ($firstQuestion['answers'] as $answer): ?>
                        <button class="choices text-white border-2 rounded-3xl px-auto py-auto text-center me-2 mb-2" data-answer-id="<?php echo $answer['id']; ?>" value="<?php echo $answer['id']; ?>"onclick="selectAnswer('<?php echo $answer['id']; ?>')">
                            <?php echo $answer['content']; ?>
                        </button><br>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No answers found for this question.</p>
                    <?php endif; ?>
                            <?php else: ?>
                                <p>No questions found for this category.</p>
                                <?php endif; ?>
            </div>
            <div class="next">
                <button class="next-c choices text-white text-3xl border-2 rounded-3xl px-auto py-auto text-center me-2 mb-2" id="next-button" onclick="nextQuestion()" disabled>NEXT</button>
            </div>
            <div class="spacer"></div>
        </div>
    </div>
 </div>
                    
<script>
    var currentQuestionIndex = 0;
    var questions = <?php echo json_encode(array_values($questions)); ?>;
    var selectedAnswers = [];

    function selectAnswer(answerID) {
    var questionContainer = document.getElementById('question-container');
    var answerButtons = questionContainer.getElementsByClassName('choices');
    var maxAnswer = questions[currentQuestionIndex]['pqMinAnswer'];

    var answerIndex = selectedAnswers.indexOf(answerID);
    
    if (answerIndex === -1) {
        if (selectedAnswers.length < maxAnswer) {
            selectedAnswers.push(answerID);
        }
    } else {
        selectedAnswers.splice(answerIndex, 1);
    }

    for (var i = 0; i < answerButtons.length; i++) {
        var currentAnswerID = answerButtons[i].getAttribute('data-answer-id');
        if (selectedAnswers.indexOf(currentAnswerID) !== -1) {
            answerButtons[i].classList.add('selected');
        } else {
            answerButtons[i].classList.remove('selected');
        }
    }

    var nextButton = document.getElementById('next-button');
    nextButton.disabled = selectedAnswers.length < maxAnswer;

}

function nextQuestion() {
    if (selectedAnswers.length < questions[currentQuestionIndex]['pqMinAnswer']) {
        alert('Please select at least ' + questions[currentQuestionIndex]['pqMinAnswer'] + ' answer(s).');
        return;
    }

    var sessionId = '<?php echo session_id(); ?>';
    var selectedAnswersData = JSON.stringify(selectedAnswers);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'store_answers.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send('sessionId=' + sessionId + '&selectedAnswers=' + selectedAnswersData);

    currentQuestionIndex++;

    if (currentQuestionIndex < questions.length) {
        var questionContainer = document.getElementById('question-container');
        questionContainer.innerHTML = '<div class="wrapper"><div class="question-box"><h1>' + questions[currentQuestionIndex]['content'] + '</h1></div><div class="answers">';

        if (questions[currentQuestionIndex]['answers']) {
            for (var i = 0; i < questions[currentQuestionIndex]['answers'].length; i++) {
                var answer = questions[currentQuestionIndex]['answers'][i];
                questionContainer.innerHTML += '<button class="choices text-white border-2 rounded-3xl px-auto py-auto text-center me-2 mb-2" data-answer-id="' + answer['id'] + '" onclick="selectAnswer(\'' + answer['id'] + '\')">' + answer['content'] + '</button>';
            }
        }

        questionContainer.innerHTML += '</div><div class="next"><button class="next-c choices text-white text-3xl border-2 rounded-3xl px-auto py-auto text-center me-2 mb-2" id="next-button" onclick="nextQuestion()" disabled>NEXT</button></div></div></div><div class="spacer"></div>';

        selectedAnswers = [];
    } else {
        window.location.href = "result.php";
    }
}


</script>
</body>
</html>