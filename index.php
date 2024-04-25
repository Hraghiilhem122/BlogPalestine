<?php 
session_start(); 
include 'conn.php';


// Fetch all blogs
$stmt = $pdo->prepare('SELECT b.*, u.name FROM blogs b INNER JOIN users u ON b.user_id = u.id ORDER BY b.date DESC');
$stmt->execute();
$blogs = $stmt->fetchAll();

// Traitement du formulaire de connexion
if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');

    try{
        $stmt->execute(['email' => $email]);

        if($stmt->rowCount() > 0){
            $user = $stmt->fetch();

            if(password_verify($password, $user['password'])){
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['success'] = 'Vérification de l\'utilisateur réussie';
            } else {
                $_SESSION['error'] = 'Mot de passe incorrect';
            }
        } else {
            $_SESSION['error'] = 'Aucun compte associé à l\'email';
        }

    } catch(PDOException $e){
        $_SESSION['error'] = $e->getMessage();
    }

    header('location: index.php');
    exit; // Assurez-vous de sortir du script après la redirection
}

// Logout
if(isset($_GET['logout'])){
    unset($_SESSION['user_id']);
    header('location: index.php');
    exit; // Assurez-vous de sortir du script après la redirection
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Blog Palestine</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
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
<div class="container">
    <h1 class="text-center" style="margin-top:30px;">Blogs</h1>
    <hr> 
    <div class="row justify-content-md-center">
        <div class="col-md-8">
            <?php 
                if(isset($_SESSION['error'])){
                    echo "
                        <div class='alert alert-danger text-center'>
                            <i class='fas fa-exclamation-triangle'></i> ".$_SESSION['error']."
                        </div>
                    ";
                    unset($_SESSION['error']);
                }
  
                if(isset($_SESSION['success'])){
                    echo "
                        <div class='alert alert-success text-center'>
                            <i class='fas fa-check-circle'></i> ".$_SESSION['success']."
                        </div>
                    ";
                    unset($_SESSION['success']);
                }
            ?>

            <!-- Si l'utilisateur est authentifié, afficher les blogs -->
            <?php if(isset($_SESSION['user_id'])): ?>
                <!-- Barre de navigation étendue sur toute la largeur de la page -->
                <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
                    <div class="container-fluid"> <!-- Utilisation de container-fluid pour étendre la barre de navigation sur toute la largeur -->
                        <a class="navbar-brand" href="#">Mon Blog</a>
                        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                            <!-- Bouton de déconnexion -->
                            <form class="form-inline my-2 my-lg-0" action="index.php?logout=true" method="POST">
                                <button class="btn btn-outline-danger my-2 my-sm-0" type="submit"> <i class="fas fa-sign-out-alt"></i> Déconnexion</button>
                            </form>
                        </div>
                    </div>
                </nav>
 
                <!-- Contenu principal -->
                <div class="container mt-5"> <!-- Ajout d'un conteneur pour centrer le contenu et ajouter une marge en haut -->
                    <div class="text-center mt-4">
                        <a href="add_blog.php" class="btn btn-success"><i class="fas fa-plus"></i> Ajouter un blog</a>
                    </div>
                    <!-- Display blogs -->
                    <?php foreach($blogs as $blog): ?>
                        <div class="card mb-4">
                            <div class="card-body">
                                <!--  htmlspecialchars une fonction en PHP qui convertit les caracteres speciaux < > " \ en entités HTML (sur mel affichage l les donnees affichage jeyin)  --->
                                <h5 class="card-title"><?php echo htmlspecialchars($blog['titre']); ?></h5>
                                <p class="card-text">
                                    <small class="text-muted">
                                        Publié par <?php echo htmlspecialchars($blog['name']); ?> le <?php echo date('d/m/Y H:i', strtotime($blog['date'])); ?>
                                    </small>
                                </p>
                                <?php if (isset($blog['image']) && !empty($blog['image'])): ?>
                                    <div class="mb-3">
                                        <img src="./src/<?php echo $blog['image']; ?>" alt="Image du blog" style="max-width: 20%;">
                                    </div>
                                <?php endif; ?>
                                <p class="card-text"><?php echo htmlspecialchars($blog['contenu']); ?></p>
                                
                                <!-- Afficher les commentaires existants -->
                                <?php 
                                    $stmt = $pdo->prepare('SELECT c.*, u.name as username FROM commentaires c 
                                    INNER JOIN users u 
                                    ON c.user_id = u.id 
                                    WHERE c.blog_id = :blog_id');
                                    $stmt->execute(['blog_id' => $blog['id']]);
                                    $commentaires = $stmt->fetchAll();
                                ?>
                                
                                <!-- Parcourir affichage commentaire-->
                                <?php foreach($commentaires as $commentaire): ?>
                                    <div class="card mt-3" id="commentaire-<?php echo $commentaire['id']; ?>">
                                        <div class="card-body d-flex justify-content-between align-items-center"> <!-- Conteneur pour le texte du commentaire -->
                                            <div id="texte-commentaire-<?php echo $commentaire['id']; ?>">
                                                <p class="card-text">
                                                    <small class="text-muted">Commenté par <?php echo htmlspecialchars($commentaire['username']); ?></small>
                                                </p>
                                                <p><?php echo htmlspecialchars($commentaire['commentaire']); ?></p>
                                            </div>
                                            
                                            <!-- Boutons pour modifier et supprimer le commentaire -->

                                            <?php if ($_SESSION['user_id'] == $commentaire['user_id']): ?>
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-sm btn-primary" onclick="afficherFormulaireModification(<?php echo $commentaire['id']; ?>)"><i class="fas fa-edit"></i> Modifier</button>
                                                    <a href="delete_comment.php?id=<?php echo $commentaire['id']; ?>" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Supprimer</a>
                                                </div>
                                            <?php endif; ?>

                                        </div>
                                    </div>
                                <?php endforeach; ?>
    
                                
                                <!-- Formulaire pour ajouter un commentaire -->
                                <form method="POST" action="add_comment.php" class="mt-3">
                                    <div class="form-group">
                                        <label for="commentaire">Ajouter un commentaire :</label>
                                        <textarea class="form-control" id="commentaire" name="commentaire" rows="3" required></textarea>
                                    </div>
                                    <input type="hidden" name="blog_id" value="<?php echo $blog['id']; ?>">
                                    <button type="submit" class="btn btn-primary">Ajouter</button>
                                </form>


                            </div>
                            
                            <?php if($_SESSION['user_id'] == $blog['user_id']): ?>
                                <div class="card-footer text-center">
                                    <div class="btn-group " role="group">
                                        <a href="edit_blog.php?id=<?php echo $blog['id']; ?>" class="btn btn-primary"><i class="fas fa-edit"></i> Modifier</a>
                                        <a href="delete_blog.php?id=<?php echo $blog['id']; ?>" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Supprimer</a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>

            <!-- Sinon, afficher le formulaire de connexion -->
            <?php else: ?>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center">Se connecter avec votre compte</h5>
                        <hr>
                        <form method="POST" action="index.php">
                            <div class="mb-3">
                                <label for="email">Adresse e-mail</label>
                                <input class="form-control" type="email" id="email" name="email" placeholder="votre email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password">Mot de passe</label>
                                <input class="form-control" type="password" id="password" name="password" placeholder="votre mot de passe" required>
                            </div>
                            <hr>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary" name="login"><i class="fas fa-sign-in-alt"></i> Se connecter</button>
                                <a href="register_form.php">Créer un nouveau compte</a>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>

<!-- Script JavaScript pour afficher le formulaire de modification -->
<script>
    function afficherFormulaireModification(commentaireId) {
        const divCommentaire = document.getElementById('texte-commentaire-' + commentaireId);
        const contenuActuel = divCommentaire.querySelector('p:nth-of-type(2)').innerText;

        const formulaire = `
            <form method="POST" action="edit_comment.php" class="mt-3">
                <div class="form-group">
                    <!-- Définition de la hauteur en CSS -->
                    <textarea class="form-control" name="commentaire" style="width: 550px;">${contenuActuel}</textarea>
                </div>
                <input type="hidden" name="comment_id" value="${commentaireId}">
                <button type="submit" class="btn btn-primary">Modifer</button>
            </form>
        `;

        divCommentaire.innerHTML = formulaire;
    }
</script>

</html>
