<?php

require_once '../../classes/Database.php';
require_once '../../classes/Quiz.php';
require_once '../../config/database.php';
if(session_status()===PHP_SESSION_NONE){ session_start(); }


$quizId = $_POST['quiz_id'] ?? $_GET['quiz_id'] ?? null;
if (!$quizId) die('Quiz non trouvé');

$quiz = new Quiz();
$questions = $quiz->getQuestions($quizId);

$score = 0;
$total = count($questions);

foreach($questions as $q){
    $answer = $_POST['answers'][$q['id']] ?? null;
    if($answer && $answer == $q['correct_option']){
        $score++;
    }
}

$db = Database::getInstance()->getConnection();
$stmt = $db->prepare("INSERT INTO results (quiz_id, etudiant_id, score, total_questions) VALUES (?,?,?,?)");
$stmt->execute([$quizId, $_SESSION['user_id'], $score, $total]);

header("Location: ./results.php?quiz_id=".$quizId);
exit;
