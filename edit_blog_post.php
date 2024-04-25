<?php 
session_start(); 
include 'conn.php';

if(!isset($_SESSION['user_id'])){
    header('Location: index.php');
    exit();
}

$id = $_GET['id'] ?? null;

$stmt = $pdo->prepare('SELECT * FROM blogs WHERE id = :id AND user_id = :user_id');
$stmt->execute(['id' => $id, 'user_id' => $_SESSION['user_id']]);
$blog = $stmt->fetch();

if (!$blog) {
    $_SESSION['error'] = "Blog non trouvé ou vous n'avez pas la permission de le modifier.";
    header('Location: index.php');
    exit();
}

if(isset($_POST['edit'])){
    $titre = $_POST['titre'];
    $contenu = $_POST['contenu'];

    $image_name = $blog['']; // Gardez le nom de l'image actuelle

    // Si une nouvelle image est téléchargée, supprimez l'ancienne et enregistrez la nouvelle
    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        // Supprimez l'ancienne image si elle existe
        if (!empty($image_name)) {
            $imagimagee_path = './src/' . $image_name;
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }

        $image_tmp = $_FILES['image']['tmp_name'];
        $image_name = $_FILES['image']['name'];
        $image_path = './src/' . $image_name;

        // Déplacez le nouveau fichier téléchargé
        move_uploaded_file($image_tmp, $image_path);
    }

    $stmt = $pdo->prepare('UPDATE blogs SET titre = :titre, contenu = :contenu, image = :image WHERE id = :id AND user_id = :user_id');
    $stmt->execute(['titre' => $titre, 'contenu' => $contenu, 'image' => $image_name, 'id' => $id, 'user_id' => $_SESSION['user_id']]);

    $_SESSION['success'] = 'Blog modifié avec succès';
    header('Location: index.php');
}
?>
