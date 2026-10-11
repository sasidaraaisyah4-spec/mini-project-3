<?php
session_start();
function requireLogin() {
    if (!isset($_SESSION['user'])) { header('Location: /inventory-app/public/login.php'); exit; }
}
function requireAdmin() {
    requireLogin();
    if ($_SESSION['user']['role'] !== 'admin') {
        http_response_code(403); exit('Forbidden: Khusus Admin'); 
    }
}
?>
