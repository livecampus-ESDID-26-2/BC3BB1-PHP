<?php
// Vérifie si l'utilisateur est connecté
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

// Redirige vers une URL donnée
function redirect($url) {
    header("Location: $url");
    exit;
}

// Échappe les caractères spéciaux pour l'affichage HTML (protection XSS)
function h($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
?>
