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

$titre = $blog['titre'] ?? '';
$contenu = $blog['contenu'] ?? '';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Modifier un blog</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
</head>
<style>
    body {
        background-image: url('./src/background1.png');
        background-size: cover;
        background-repeat: no-repeat;
        background-attachment: fixed;
        opacity: 0.90;
    }
</style>
<body>
<div class="container mt-5">
    <h1 class="text-center">Modifier un blog</h1>
    <hr>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <?php 
                if(isset($_SESSION['error'])){
                    echo "<div class='alert alert-danger'>".$_SESSION['error']."</div>";
                    unset($_SESSION['error']);
                }
            ?>
            <form method="POST" action="edit_blog_post.php?id=<?php echo $blog['id']; ?>" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="titre" class="form-label">Titre</label>
                    <input type="text" class="form-control" id="titre" name="titre" value="<?php echo $titre; ?>" required     >
                </div>
                <div class="mb-3">
                    <label for="contenu" class="form-label">Contenu</label>
                    <textarea class="form-control" id="contenu" name="contenu" rows="5" required><?php echo $contenu; ?></textarea>
                </div>

                <!-- Afficher l'image existante si elle est disponible -->

                <?php if (isset($blog['image']) && !empty($blog['image'])): ?>
                    <div class="mb-3">
                        <img src="./src/<?php echo $blog['image']; ?>" alt="Image du blog" style="max-width: 20%;">
                    </div>
                <?php endif; ?>

                <!-- Ajouter un champ de téléchargement de fichier -->
                <div class="mb-3">
                    <label for="image" class="form-label">Modifier l'image</label>
                    <input type="file" class="form-control" id="image" name="image">
                </div>
                
                <button type="submit" class="btn btn-primary" name="edit">Modifier</button>
                <a href="index.php" class="btn btn-secondary">Retour</a>
            </form> 
        </div>
    </div>
</div>
</body>
</html>
