<?php
require_once '../../config/database.php';
require_once '../../classes/Database.php';

$db = Database::getInstance()->getConnection();

$categoryId = $_GET['category_id'] ?? null;

$quizzes = [];
$categoryName = '';

if ($categoryId) {
    $stmt = $db->prepare("SELECT nom FROM categories WHERE id = ?");
    $stmt->execute([$categoryId]);
    $categoryName = $stmt->fetchColumn();

    $stmt = $db->prepare("SELECT * FROM quiz WHERE categorie_id = ?");
    $stmt->execute([$categoryId]);
    $quizzes = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<?php include '../partials/header.php'; ?>
<?php include '../partials/nav_student.php'; ?>

<div class="pt-20 max-w-7xl mx-auto px-6 ">

    <h2 class="text-3xl font-bold mb-8">
        Quiz de la catégorie : <?= htmlspecialchars($categoryName) ?>
    </h2>

    <?php if (empty($quizzes)): ?>
        <p>Aucun quiz pour cette catégorie.</p>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php foreach ($quizzes as $q): ?>
                <div class="rounded-xl shadow-md p-6 
                    bg-gradient-to-br from-indigo-500 to-purple-600 
                    text-white hover:shadow-xl transition">

                    <h3 class="text-xl font-bold mb-2">
                        <?= htmlspecialchars($q['titre']) ?>
                    </h3>

                    <p class="text-indigo-100 mb-4">
                        <?= htmlspecialchars($q['description'] ?? '') ?>
                    </p>

                    <a
                        href="start_quiz.php?quiz_id=<?= $q['id'] ?>"
                        class="inline-block bg-white text-purple-700 
                       px-4 py-2 rounded-lg font-semibold
                       hover:bg-gray-100 transition">
                        Commencer →
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>

</div>

<?php include '../partials/footer.php'; ?>