<?php
// Informations d'identification
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', ''); 
define('DB_NAME', 'bibloithequernligne');

// Démarrer la session
session_start();

// Connexion à la base de données avec PDO
try {
    $conn = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("ERREUR : Impossible de se connecter. " . $e->getMessage());
}

// Traitement du formulaire de connexion en PHP
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération des données du formulaire
    $user = $_POST['user'];
    $password = $_POST['password'];

    // Vérification si l'utilisateur existe dans la base de données
    $check = "SELECT id, user, password FROM admin WHERE user = :user";  

    // Préparation de la requête avec PDO
    $stmt = $conn->prepare($check);

    // Lier le paramètre
    $stmt->bindParam(':user', $user, PDO::PARAM_STR);

    // Exécuter la requête
    $stmt->execute();

    // Vérifier si un utilisateur a été trouvé
    if ($stmt->rowCount() > 0) {
        // Récupérer les données de l'utilisateur
        $user_data = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifier le mot de passe
        if (password_verify($password, $user_data['password'])) {
            // Mot de passe correct, connexion réussie
            $_SESSION['user'] = $user_data['user'];  // Enregistrer le nom d'utilisateur dans la session
            header("Location: indexa.php");  // Redirection vers la page indexa.php
            exit;  // Assurez-vous que l'exécution du script s'arrête ici
        } else {
            $message = "Mot de passe incorrect.";
        }
    } else {
        $message = "Utilisateur non trouvé.";
    }

    // Fermer la connexion à la base de données
    $conn = null;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <!-- Ajout de Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Ajout de l'image en arrière-plan */
        body {
            background-image: url('livre.jpg'); /* Remplacez par l'URL de votre image */
            background-size: cover;
            background-position: center;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Ajouter une légère opacité à l'arrière-plan */
        .container {
            background-color: rgba(255, 255, 255, 0.8); /* Fond blanc semi-transparent */
            padding: 30px;
            border-radius: 10px;
            max-width: 500px; /* Limite la taille du formulaire */
            width: 100%;
        }
        .btn {
            background-color: rgba(255, 255, 255, 0.8);
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">Connexion</h2>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="user" class="form-label">Nom d'utilisateur :</label>
                    <input type="text" id="user" name="user" class="form-control" maxlength="50" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe :</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-success"><a href="indexa.php">Se connecter</a></button>
    </div>
            </form>
        </div>
    </div>
</div>

<!-- Ajout de Bootstrap JS pour les composants interactifs si nécessaire -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>
