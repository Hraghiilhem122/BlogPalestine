<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Blog Palestine</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js"></script>
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
    <h1 class="text-center" style="margin-top:30px;">Merci de remplir tous les champs</h1>
    <hr>
    <div class="row justify-content-md-center">
        <div class="col-md-5">
            <?php
                if(isset($_SESSION['error'])){
                    echo "
                        <div class='alert alert-danger text-center'>
                            <i class='fas fa-exclamation-triangle'></i> ".$_SESSION['error']."
                        </div>
                    ";
  
                    //unset error
                    unset($_SESSION['error']);
                }
  
                if(isset($_SESSION['success'])){
                    echo "
                        <div class='alert alert-success text-center'>
                            <i class='fas fa-check-circle'></i> ".$_SESSION['success']."
                        </div>
                    ";
  
                    //unset success
                    unset($_SESSION['success']);
                }
            ?>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Créer un nouveau compte</h5>
                    <hr>
                    <form method="POST" action="register.php">
                        <div class="mb-3 row">
                            <label for="name" class="col-sm-3 col-form-label">Nom</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" id="name" name="name" placeholder="voter name" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="email" class="col-sm-3 col-form-label">Adresse e-mail</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="email" id="email" name="email"  placeholder="votre email" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="password" class="col-sm-3 col-form-label">Mot de passe</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="password" id="password" name="password" placeholder="votre mot de passe" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="confirm" class="col-sm-3 col-form-label">Confirmer votre mot de pase</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="password" id="confirm" name="confirm"  placeholder="Confirmer votre mot de passe" requiredz>
                            </div>
                        </div>
                    <hr>
                    <div class="text-center">
                        <button type="submit" class="btn btn-danger" name="register"><i class="far fa-user"></i> Créer votre compte</button>
                        <a href="index.php">Retour</a>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>