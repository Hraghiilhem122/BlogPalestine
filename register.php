<?php
    //start PHP session
    session_start();
  
    require 'vendor/autoload.php';

    use Respect\Validation\Validator as v;

    //check if register form is submitted
    if(isset($_POST['register'])){
        //assign variables to post values
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm = $_POST['confirm'];
  
        //validate email and password
        $emailValidator = v::notEmpty()->email(); 
        $passwordValidator = v::notEmpty()->length(8);

        if (!$emailValidator->validate($email)) {
            $_SESSION['error'] = 'Adresse e-mail invalide';
        } elseif (!$passwordValidator->validate($password)) {
            $_SESSION['error'] = 'Le mot de passe doit contenir au moins 8 caractères';
        } elseif ($password != $confirm){
            $_SESSION['error'] = 'Les mots de passe ne correspondent pas';
        } else{
            //include our database connection
            include 'conn.php';
  
            //check if the email is already taken
            $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
            $stmt->execute(['email' => $email]);
  
            if($stmt->rowCount() > 0){
                //return the values to the user
                $_SESSION['name'] = $name;
                $_SESSION['email'] = $email;
                $_SESSION['password'] = $password;
                $_SESSION['confirm'] = $confirm;
  
                //display error
                $_SESSION['error'] = 'Adresse e-mail déjà prise';
            }
            else{
                //encrypt password using password_hash()
                $password = password_hash($password, PASSWORD_DEFAULT);
  
                //insert new user to our database
                $stmt = $pdo->prepare('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');
  
                try{
                    $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);
  
                    $_SESSION['success'] = 'Utilisateur vérifié. Vous pouvez <a href="index.php">vous connecter</a> maintenant';
                }
                catch(PDOException $e){
                    $_SESSION['error'] = $e->getMessage();
                }
  
            }
  
        }
  
    }
    else{
        $_SESSION['error'] = 'Veuillez remplir les champs';
    }
  
    header('location: register_form.php');
?>