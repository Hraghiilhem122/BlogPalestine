<?php
    session_start();
    include 'conn.php';

    if(isset($_GET['id'])) {
        $comment_id = $_GET['id'];

        $stmt = $pdo->prepare('DELETE FROM commentaires WHERE id = :comment_id');
        
        try {
            $stmt->execute(['comment_id' => $comment_id]);
            $_SESSION['success'] = 'Commentaire supprimé avec succès';
            
        } catch(PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
        }
    }

    header('location: index.php');
?>
