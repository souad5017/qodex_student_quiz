<?php
require_once '../../classes/Quiz.php';
$quizObj = new Quiz();
$selectedCategoryId = $_GET['category_id'] ?? null;
$quizzes = [];
$categoryName = '';

if ($selectedCategoryId) {
    $categoryStmt = $db->prepare("SELECT * FROM categories WHERE id = ?");
    $categoryStmt->execute([$selectedCategoryId]);
    $category = $categoryStmt->fetch();
    
    if ($category) {
        $categoryName = $category['nom'];
        $quizzes = $quizObj->getByCategory($selectedCategoryId);
    }
}
?>

<div class="pt-16 max-w-7xl mx-auto px-6 py-12">

    <h2 class="text-3xl font-bold text-gray-900 mb-8">Catégories Disponibles</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <?php foreach ($categories as $cat): ?>
            <a href="quiz.php?category_id=<?= (int)$cat['id'] ?>"
               class="bg-white rounded-xl shadow-md hover:shadow-xl transition overflow-hidden">

                <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-6 text-white">
                    <i class="fas fa-folder-open text-4xl mb-3"></i>
                    <h3 class="text-xl font-bold"><?= htmlspecialchars($cat['nom']) ?></h3>
                </div>

                <div class="p-6">
                    <p class="text-gray-600 mb-4">
                        <?= htmlspecialchars($cat['description'] ?? 'Pas de description') ?>
                    </p>
                    <span class="text-green-600 font-semibold">Explorer →</span>
                </div>

            </a>
        <?php endforeach; ?>
    </div>

</div>
