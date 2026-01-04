<?php
require_once '../config/database.php';
require_once '../classes/Database.php';
require_once '../classes/Quiz.php';

if (!isset($_GET['category_id'])) {
    echo json_encode([]);
    exit();
}

$categoryId = (int)$_GET['category_id'];
$quizObj = new Quiz();
$quizzes = $quizObj->getByCategory($categoryId);

echo json_encode($quizzes);
