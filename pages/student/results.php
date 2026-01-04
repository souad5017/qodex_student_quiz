<?php

require_once '../../classes/Database.php';
require_once '../../classes/Quiz.php';
require_once '../../config/database.php';
if(session_status()===PHP_SESSION_NONE){ session_start(); }

$quizId = $_GET['quiz_id'] ?? null;
if (!$quizId) die('Quiz non trouvé');

$db = Database::getInstance()->getConnection();
$stmt = $db->prepare("
    SELECT r.*, q.titre, q.description 
    FROM results r 
    JOIN quiz q ON r.quiz_id=q.id 
    WHERE r.quiz_id=? AND r.etudiant_id=?
");
$stmt->execute([$quizId, $_SESSION['user_id']]);
$result = $stmt->fetch();

if(!$result) die('Résultat non trouvé');

$score = $result['score'];
$total = $result['total_questions'];
$percentage = round($score/$total*100,2);

include '../partials/header.php';
include '../partials/nav_student.php';
?>

<div class="pt-16 max-w-4xl mx-auto px-6">
    <div class="bg-white shadow-xl rounded-xl p-8 text-center">
        <h2 class="text-3xl font-bold mb-4"><?= htmlspecialchars($result['titre']) ?></h2>
        <p class="text-gray-600 mb-6"><?= htmlspecialchars($result['description'] ?? '') ?></p>

        <div class="text-2xl font-semibold mb-2">
            Score : <?= $score ?> / <?= $total ?>
        </div>
        <div class="text-lg text-gray-700 mb-6">
            Pourcentage : <?= $percentage ?> %
        </div>

        <div class="bg-gray-200 rounded-full h-6 mb-6">
            <div class="bg-green-500 h-6 rounded-full" style="width: <?= $percentage ?>%;"></div>
        </div>

        <div class="flex justify-center gap-4">
            <a href="dashboard.php" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                Retour au Dashboard
            </a>
            <a href="start_quiz.php?quiz_id=<?= $quizId ?>" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                Refaire le Quiz
            </a>
        </div>
    </div>
</div>

<?php include '../partials/footer.php'; ?>
