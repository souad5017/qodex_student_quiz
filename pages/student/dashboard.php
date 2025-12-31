<?php
require_once '../../config/database.php';
require_once '../../classes/Database.php';

$db = Database::getInstance()->getConnection();


$stmt = $db->query("SELECT * FROM categories");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>
<?php include '../partials/header.php'; ?>

<?php include '../partials/nav_student.php'; ?>
<div class="pt-16">

    <!-- Header -->
    <div class="bg-gradient-to-r from-green-600 to-teal-600 text-white">
        <div class="max-w-7xl mx-auto px-6 py-12">
            <h1 class="text-4xl font-bold mb-3">Espace Étudiant</h1>
            <p class="text-xl text-green-100">
                Sélectionnez une catégorie pour commencer un quiz
            </p>
        </div>
    </div>

    <!-- Categories -->
    <div class="max-w-7xl mx-auto px-6 py-12">
        <h2 class="text-3xl font-bold text-gray-900 mb-8">
            Catégories Disponibles
        </h2>

        <?php if (empty($categories)): ?>
            <p class="text-gray-500">Aucune catégorie disponible.</p>
        <?php else: ?>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                <?php foreach ($categories as $cat): ?>
                    <a href="categories.php?category_id=<?= (int)$cat['id'] ?>"
                       class="bg-white rounded-xl shadow-md hover:shadow-xl transition duration-300 overflow-hidden">

                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-6 text-white">
                            <i class="fas fa-folder-open text-4xl mb-3"></i>
                            <h3 class="text-xl font-bold">
                                <?= htmlspecialchars($cat['nom']) ?>
                            </h3>
                        </div>

                        <div class="p-6">
                            <p class="text-gray-600 mb-4">
                                <?= htmlspecialchars($cat['description'] ?? 'Pas de description') ?>
                            </p>

                            <span class="text-green-600 font-semibold">
                                Explorer →
                            </span>
                        </div>

                    </a>
                <?php endforeach; ?>

            </div>

        <?php endif; ?>
    </div>

</div>

<?php include '../partials/footer.php'; ?>
