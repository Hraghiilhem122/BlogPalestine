<?php 
    session_start(); 
    include 'conn.php';

    // Vérification de l'authentification de l'utilisateur
    if(!isset($_SESSION['user_id'])){
        header('Location: index.php');
        exit();
    }

    $id = $_GET['id'] ?? null;

    $stmt = $pdo->prepare('DELETE FROM blogs WHERE id = :id AND user_id = :user_id');
    $stmt->execute(['id' => $id, 'user_id' => $_SESSION['user_id']]);

    $_SESSION['success'] = 'Blog supprimé avec succès';
    header('Location: index.php');
?>
