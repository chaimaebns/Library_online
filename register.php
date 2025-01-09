<?php
// Informations d'identification
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'bibloithequernligne');

try {
    // Connexion à la base de données avec PDO
    $conn = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    // Configurer PDO pour lancer une exception en cas d'erreur
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Gérer l'erreur si la connexion échoue
    die("ERREUR : Impossible de se connecter. " . $e->getMessage());
}

// Traitement du formulaire d'inscription en PHP
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Récupération des données du formulaire
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $adresse = $_POST['adresse'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hachage du mot de passe

    // Vérification si l'email existe déjà dans la base de données
    $check_email_sql = "SELECT * FROM membres WHERE email = :email";
    $stmt = $conn->prepare($check_email_sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    // Si un enregistrement existe avec cet email, afficher un message d'erreur spécifique
    if ($stmt->rowCount() > 0) {
        echo "<p style='color: red;'>Erreur : L'email '" . htmlspecialchars($email) . "' est déjà utilisé. Veuillez en choisir un autre.</p>";
    } else {
        // Préparer la requête d'insertion si l'email est unique
        $sql = "INSERT INTO membres (nom, email, telephone, adresse, password) 
                VALUES (:nom, :email, :telephone, :adresse, :password)";
        $stmt = $conn->prepare($sql);

        // Lier les paramètres pour la requête SQL
        $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':telephone', $telephone, PDO::PARAM_STR);
        $stmt->bindParam(':adresse', $adresse, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);

        // Exécuter la requête d'insertion
        if ($stmt->execute()) {
            header('location: login.php');
            exit;
        } else {
            echo "<p style='color: red;'>Erreur lors de l'inscription : " . $stmt->errorInfo()[2] . "</p>";
        }
    }
}

// Fermer la connexion PDO
$conn = null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'Inscription Membre</title>
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
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">Formulaire d'Inscription - Membre</h2>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom :</label>
                    <input type="text" id="nom" name="nom" class="form-control" maxlength="50" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email :</label>
                    <input type="email" id="email" name="email" class="form-control" maxlength="50" required>
                </div>

                <div class="mb-3">
                    <label for="telephone" class="form-label">Téléphone :</label>
                    <input type="text" id="telephone" name="telephone" class="form-control" maxlength="50" required>
                </div>

                <div class="mb-3">
                    <label for="adresse" class="form-label">Adresse :</label>
                    <textarea id="adresse" name="adresse" class="form-control" rows="4" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe :</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-success">S'inscrire</button>
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
