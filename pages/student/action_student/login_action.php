<?php
require_once '../../config/database.php';
require_once '../../classes/Database.php';
require_once '../../classes/Security.php';
require_once '../../classes/User.php';


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../pages/auth/login.php');
    exit();
}

if (!isset($_POST['csrf_token']) || !Security::verifyCSRFToken($_POST['csrf_token'])) {
    $_SESSION['login_error'] = 'Token de sécurité invalide';
    header('Location: ../pages/auth/login.php');
    exit();
}

$email = Security::clean($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    $_SESSION['login_error'] = 'Veuillez remplir tous les champs';
    header('Location: ../pages/auth/login.php');
    exit();
}

if (!Security::validateEmail($email)) {
    $_SESSION['login_error'] = 'Email invalide';
    header('Location: ../pages/auth/login.php');
    exit();
}

$user = new User();
$result = $user->login($email, $password);

if ($result && $_SESSION['user_role'] === 'student') {
    $_SESSION['user_id']   = $result['id'];       
    $_SESSION['user_nom']  = $result['nom'];     
    $_SESSION['user_role'] = 'student';   
    header('Location: ../pages/student/dashboard.php');

    exit();
} else {
    $_SESSION['login_error'] = 'Email ou mot de passe incorrect ou rôle invalide';
    header('Location: ../pages/auth/login.php');
    exit();
}
