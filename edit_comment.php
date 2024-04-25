<?php
    session_start();
    include 'conn.php';

    if(isset($_POST['commentaire']) && isset($_POST['comment_id'])) {
        $commentaire = $_POST['commentaire'];
        $comment_id = $_POST['comment_id'];

        $stmt = $pdo->prepare('UPDATE commentaires SET commentaire = :commentaire WHERE id = :comment_id');
        
        try {
            $stmt->execute(['commentaire' => $commentaire, 'comment_id' => $comment_id]);
            $_SESSION['success'] = 'Commentaire modifié avec succès';
        } catch(PDOException $e) {
            $_SESSION['error'] = 'Erreur lors de la modification du commentaire : ' . $e->getMessage();
        }
    }

    // Redirection vers la page précédente

    header('location: index.php');
    
?>
