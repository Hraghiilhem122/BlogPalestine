<?php

include 'conn.php';

//start PHP session
session_start();

require 'vendor/autoload.php';

use Respect\Validation\Validator as v;

//check if login form is submitted
if(isset($_POST['login'])){
    //assign variables to post values
    $email = $_POST['email'];
    $password = $_POST['password'];

    //validate email and password
    $emailValidator = v::notEmpty()->email();
    $passwordValidator = v::notEmpty();

    if (!$emailValidator->validate($email)) {
        $_SESSION['error'] = 'Adresse e-mail invalide';
    } elseif (!$passwordValidator->validate($password)) {
        $_SESSION['error'] = 'Mot de passe requis';
    } else {
        //include our database connection
        include 'conn.php';

        //get the user with email
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');

        try{
            $stmt->execute(['email' => $email]);

            //check if email exist
            if($stmt->rowCount() > 0){
                //get the row
                $user = $stmt->fetch();

                //validate inputted password with $user password
                if(password_verify($password, $user['password'])){
                    //action after a successful login
                    $_SESSION['success'] = 'Vérification de l\'utilisateur réussie';
                }
                else{
                    $_SESSION['error'] = 'Mot de passe incorrect';
                }

            }
            else{
                $_SESSION['error'] = 'Aucun compte associé à l\'email';
            }

        }
        catch(PDOException $e){
            $_SESSION['error'] = $e->getMessage();
        }
    }
}
else{
    $_SESSION['error'] = 'Remplissez d\'abord le formulaire de connexion';
}

header('location: index.php');
exit; 

?>
