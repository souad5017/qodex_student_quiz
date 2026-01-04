<?php
require_once '../../config/database.php';
require_once '../../classes/Database.php';
require_once '../../classes/Quiz.php';

$db = Database::getInstance()->getConnection();


$stmt = $db->query("SELECT * FROM categories");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>
<?php include '../partials/header.php'; ?>

<?php include '../partials/nav_student.php'; ?>
<div class="pt-16">

    <div class="bg-gradient-to-r from-green-600 to-teal-600 text-white">
        <div class="max-w-7xl mx-auto px-6 py-12">
            <h1 class="text-4xl font-bold mb-3">Espace Étudiant</h1>
            <p class="text-xl text-green-100">
                Sélectionnez une catégorie pour commencer un quiz
            </p>
        </div>
    </div>

   <?php include './category.php' ?>

</div>

<?php include '../partials/footer.php'; ?>
