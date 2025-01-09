<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css" />
</head>
<body>
<?php
require('config.php');
if (isset($_REQUEST['username'], $_REQUEST['email'], $_REQUEST['password'])){
	récupérer le nom d'utilisateur et supprimer les antislashes ajoutés par le formulaire
	$username = $_REQUEST['username'];
	$username = mysqli_real_escape_string($conn, $username); 
	récupérer l'email et supprimer les antislashes ajoutés par le formulaire
	$email = $_REQUEST['email'];
	$email = mysqli_real_escape_string($conn, $email);
	récupérer le mot de passe et supprimer les antislashes ajoutés par le formulaire
	$password = $_REQUEST['password'];
	$password = mysqli_real_escape_string($conn, $password);
  requéte SQL + mot de passe crypté
    $query = "INSERT into `users` (username, email, password)
              VALUES ('$username', '$email', '".hash('sha256', $password)."')";
	Exécute la requête sur la base de données
    $res = mysqli_query($conn, $query);
    if($res){
       echo "<div class='sucess'>
             <h3>Vous êtes inscrit avec succès.</h3>
             <p>Cliquez ici pour vous <a href='login.php'>connecter</a></p>
			 </div>";
    }
}else{
?>
  
	<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="card login-container" style="width: 25rem;">
      <div class="card-body">
        <h1 class="card-title text-center mb-4">S'inscrire</h1>
        <form>
          <div class="mb-3">
            <label for="email" class="form-label">Adresse e-mail</label>
            <input type="email" class="form-control" id="email" placeholder="Entrez votre e-mail" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="password" placeholder="Entrez votre mot de passe" required>
          </div>
          <button type="submit" class="btn btn-custom w-100">Se connecter</button>
          <p class="box-register">Vous êtes nouveau ici? <a href="register.php">S'inscrire</a></p>
    <p class="box-register">Déjà inscrit? <a href="login.php">Connectez-vous ici</a></p>
</form>
<?php } ?>
</body>
</html>