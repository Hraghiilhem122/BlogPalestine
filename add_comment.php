<?php
    session_start();
    include 'conn.php';

    if(isset($_POST['commentaire']) && isset($_POST['blog_id'])) {
        $commentaire = $_POST['commentaire'];
        $blog_id = $_POST['blog_id'];
        $user_id = $_SESSION['user_id'];

        $stmt = $pdo->prepare('INSERT INTO commentaires (blog_id, user_id, commentaire) VALUES (:blog_id, :user_id, :commentaire)');
        
        try {
            $stmt->execute(['blog_id' => $blog_id, 'user_id' => $user_id, 'commentaire' => $commentaire]);
            $_SESSION['success'] = 'Commentaire ajouté avec succès';
        } catch(PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
        }
    }

    header('location: index.php');
?>
