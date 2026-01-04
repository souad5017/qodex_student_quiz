<?php

require_once '../../classes/Database.php';
require_once '../../classes/Quiz.php';
require_once '../../config/database.php';

$quizId = $_GET['quiz_id'] ?? null;
if (!$quizId) die('Quiz non trouvé');

$quizClass = new Quiz();
$quiz = $quizClass->getById($quizId);
if (!$quiz) die('Quiz non trouvé');

$questions = $quizClass->getQuestions($quizId);

$duration = 20 * 60;

if (!isset($_SESSION['quiz_start'][$quizId])) {
    $_SESSION['quiz_start'][$quizId] = time();
}

$time_elapsed = time() - $_SESSION['quiz_start'][$quizId];
$time_left = $duration - $time_elapsed;

if ($time_left <= 0) {
    header("Location: submit_quiz.php?quiz_id=$quizId");
    exit;
}

include '../partials/header.php';
include '../partials/nav_student.php';
?>

<div class="pt-20 max-w-4xl mx-auto px-6">
    <h2 class="text-3xl font-bold mb-4"><?= htmlspecialchars($quiz['titre']) ?></h2>
    <p class="font-semibold mb-4 text-red-600">Temps restant : <span id="timer"></span></p>

    <?php if (!empty($questions)): ?>
        <form action="submit_quiz.php" method="POST">
            <input type="hidden" name="quiz_id" value="<?= $quiz['id'] ?>">

            <?php foreach ($questions as $index => $q): ?>
                <div class="mb-6 p-4 border rounded shadow hover:shadow-md transition">
                    <p class="font-semibold mb-2"><?= ($index + 1) ?>. <?= htmlspecialchars($q['question']) ?></p>
                    <div class="space-y-2">
                        <label><input type="radio" name="answers[<?= $q['id'] ?>]" value="1"> <?= htmlspecialchars($q['option1']) ?></label><br>
                        <label><input type="radio" name="answers[<?= $q['id'] ?>]" value="2"> <?= htmlspecialchars($q['option2']) ?></label><br>
                        <label><input type="radio" name="answers[<?= $q['id'] ?>]" value="3"> <?= htmlspecialchars($q['option3']) ?></label><br>
                        <label><input type="radio" name="answers[<?= $q['id'] ?>]" value="4"> <?= htmlspecialchars($q['option4']) ?></label><br>
                    </div>
                </div>
            <?php endforeach; ?>

            <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded font-semibold hover:bg-purple-700 transition">
                Terminer le Quiz
            </button>
        </form>
    <?php else: ?>
        <p>Pas de questions pour ce quiz.</p>
    <?php endif; ?>
</div>

<script>
let timeLeft = <?= $time_left ?>;
const timerEl = document.getElementById('timer');

const countdown = setInterval(() => {
    let minutes = Math.floor(timeLeft / 60);
    let seconds = timeLeft % 60;
    timerEl.textContent = `${minutes}m ${seconds}s`;
    if (timeLeft <= 0) {
        clearInterval(countdown);
        document.forms[0].submit();
    }
    timeLeft--;
}, 1000);
</script>

<?php include '../partials/footer.php'; ?>
