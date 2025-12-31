<?php
/**
 * PARTIAL: Navigation Étudiant
 * Barre de navigation pour les étudiants
 */


require_once __DIR__ . "/../../classes/Security.php";

// Nom de l'utilisateur
$userName = $userName ?? ($_SESSION['user_nom'] ?? 'User');
$initials = strtoupper(
    substr($userName, 0, 1) .
    substr(explode(' ', $userName)[1] ?? '', 0, 1)
);

// Déterminer le chemin de base
$basePath = '';
if (strpos($_SERVER['PHP_SELF'], '/etudiant/') !== false) {
    $basePath = '../';
}
?>

<!-- Navigation Étudiant -->
<nav class="bg-white shadow-lg fixed w-full z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <i class="fas fa-user-graduate text-3xl text-green-600"></i>
                    <span class="ml-2 text-2xl font-bold text-gray-900">Qodex</span>
                    <span class="ml-3 px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">
                        Étudiant
                    </span>
                </div>

                <!-- Menu -->
                <div class="hidden md:ml-10 md:flex md:space-x-8">
                    <a href="<?= $basePath ?>etudiant/dashboard.php"
                       class="<?= ($currentPage ?? '') === 'dashboard'
                            ? 'border-green-500 text-gray-900'
                            : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'
                       ?> inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        <i class="fas fa-home mr-2"></i>Tableau de bord
                    </a>

                    <a href="<?= $basePath ?>etudiant/categories.php"
                       class="<?= ($currentPage ?? '') === 'categories'
                            ? 'border-green-500 text-gray-900'
                            : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'
                       ?> inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        <i class="fas fa-folder mr-2"></i>Catégories
                    </a>

                    <a href="<?= $basePath ?>etudiant/mes_quiz.php"
                       class="<?= ($currentPage ?? '') === 'quiz'
                            ? 'border-green-500 text-gray-900'
                            : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'
                       ?> inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        <i class="fas fa-clipboard-list mr-2"></i>Mes Quiz
                    </a>

                    <a href="<?= $basePath ?>etudiant/mes_resultats.php"
                       class="<?= ($currentPage ?? '') === 'resultats'
                            ? 'border-green-500 text-gray-900'
                            : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'
                       ?> inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        <i class="fas fa-chart-bar mr-2"></i>Mes Résultats
                    </a>
                </div>
            </div>

            <!-- Profil -->
            <div class="flex items-center space-x-4">
                <div class="w-10 h-10 rounded-full bg-green-600 flex items-center justify-center text-white font-semibold">
                    <?= $initials ?>
                </div>

                <div class="hidden md:block">
                    <div class="text-sm font-medium text-gray-900">
                        <?= htmlspecialchars($userName) ?>
                    </div>
                    <div class="text-xs text-gray-500">Étudiant</div>
                </div>

                <a href="<?= $basePath ?>auth/logout.php?token=<?= Security::generateCSRFToken() ?>"
                   class="text-red-600 hover:text-red-700" title="Déconnexion">
                    <i class="fas fa-sign-out-alt text-xl"></i>
                </a>
            </div>
        </div>
    </div>
</nav>
