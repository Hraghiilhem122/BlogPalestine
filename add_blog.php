<?php 
session_start(); 
include 'conn.php';

if(!isset($_SESSION['user_id'])){
    header('Location: index.php');
    exit();
}

?>




<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ajouter un blog</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
</head>
<style>
    /* CSS pour le body */
    body {
        background-image: url('./src/background1.png'); /* Image de fond */
        background-size: cover; /* Ajuste la taille de l'image pour couvrir tout le body */
        background-repeat: no-repeat; /* Empêche la répétition de l'image */
        background-attachment: fixed; /* Fixe l'image de fond */
        opacity: 0.90;

    }
    
</style>
<body>
<div class="container mt-5">
    <h1 class="text-center">Ajouter un blog</h1>
    <hr>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <?php  
                if(isset($_SESSION['error'])){
                    echo "<div class='alert alert-danger'>".$_SESSION['error']."</div>";

                    //supp session
                    unset($_SESSION['error']);
                }
            ?>
            <form method="POST" action="add_blog_post.php" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="titre" class="form-label">Titre</label>
                    <input type="text" class="form-control" id="titre" name="titre" required>
                </div>
                <div class="mb-3">
                    <label for="contenu" class="form-label">Contenu</label>
                    <textarea class="form-control" id="contenu" name="contenu" rows="5" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" class="form-control" id="image" name="image">
                </div>
                <button type="submit" class="btn btn-primary" name="add">Ajouter</button>
                <a href="index.php" class="btn btn-secondary">Retour</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>
