<?php 
session_start(); 
include 'conn.php';

if(!isset($_SESSION['user_id'])){
    header('Location: index.php');
    exit();
}

if(isset($_POST['add'])){
    $titre = $_POST['titre'];
    $contenu = $_POST['contenu'];
    $user_id = $_SESSION['user_id'];


    // Vérification si un fichier a été téléchargé
    if(isset($_FILES['image'])) {
        // Supprimez l'ancienne image si elle existe


        $image_tmp = $_FILES['image']['tmp_name'];
        $image_name = $_FILES['image']['name'];
        $image_path = './src/' . $image_name;

        // Déplacez le nouveau fichier téléchargé
        move_uploaded_file($image_tmp, $image_path);
    }

    $stmt = $pdo->prepare('INSERT INTO blogs (user_id, titre, contenu, image) VALUES (:user_id, :titre, :contenu, :image)');
    $stmt->execute(['user_id' => $user_id, 'titre' => $titre, 'contenu' => $contenu, 'image' => $image_name]);

    $_SESSION['success'] = 'Blog ajouté avec succès';
    header('Location: index.php');
}
?>


