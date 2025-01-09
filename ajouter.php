<?php
// Informations d'identification
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'bibloithequernligne');

try {
    // Connexion à la base de données avec PDO
    $conn = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connexion échouée: " . $e->getMessage());
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titre = $_POST['titre'];
    $auteur = $_POST['auteur'];
    $genre = $_POST['genre'];
    $annee_publication = (int) $_POST['annee_publication'];
    $stock = (int) $_POST['stock'];

    // Manipulation du fichier image
    if (isset($_FILES['img']) && $_FILES['img']['error'] == 0) {
        $img_name = basename($_FILES['img']['name']);
        $img_tmp = $_FILES['img']['tmp_name'];
        $img_folder = "uploads/" . $img_name;

        // Vérifier si le dossier 'uploads' existe, sinon le créer
        if (!is_dir("uploads")) {
            mkdir("uploads", 0777, true);
        }

        // Vérifier si le fichier est une image valide
        $allowed_types = ["image/jpeg", "image/png", "image/jpg"];
        if (in_array($_FILES['img']['type'], $allowed_types)) {
            if (move_uploaded_file($img_tmp, $img_folder)) {
                // Préparer la requête d'insertion avec PDO
                $query = "INSERT INTO livres (titre, auteur, genre, annee_publication, stock, photo) 
                          VALUES (:titre, :auteur, :genre, :annee_publication, :stock, :photo)";

                $stmt = $conn->prepare($query);

                // Lier les paramètres
                $stmt->bindParam(':titre', $titre);
                $stmt->bindParam(':auteur', $auteur);
                $stmt->bindParam(':genre', $genre);
                $stmt->bindParam(':annee_publication', $annee_publication);
                $stmt->bindParam(':stock', $stock);
                $stmt->bindParam(':photo', $img_name);

                // Exécuter la requête
                if ($stmt->execute()) {
                    echo "<div class='alert alert-success'>Livre ajouté avec succès!</div>";
                } else {
                    echo "<div class='alert alert-danger'>Erreur lors de l'ajout du livre.</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Erreur de téléchargement de l'image.</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Veuillez télécharger une image valide (JPEG, PNG).</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Erreur de téléchargement: " . $_FILES['img']['error'] . "</div>";
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
    <title>Ajouter un Livre</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f9;
            background-image: url('livre.jpg');
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 30px;
            border-radius: 10px;
            max-width: 500px;
            width: 100%;
        }
        .form-label {
            font-weight: bold;
        }
        .form-control {
            margin-bottom: 15px;
        }
        .btn-primary {
            width: 100%;
        }
        h1 {
            text-align: center;
            color: #333;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Ajouter un Livre</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="titre" class="form-label">Titre:</label>
            <input type="text" class="form-control" id="titre" name="titre" required>
        </div>
        <div class="mb-3">
            <label for="auteur" class="form-label">Auteur:</label>
            <input type="text" class="form-control" id="auteur" name="auteur" required>
        </div>
        <div class="mb-3">
            <label for="genre" class="form-label">Genre:</label>
            <input type="text" class="form-control" id="genre" name="genre" required>
        </div>
        <div class="mb-3">
            <label for="annee_publication" class="form-label">Année de publication:</label>
            <input type="number" class="form-control" id="annee_publication" name="annee_publication" required>
        </div>
        <div class="mb-3">
            <label for="stock" class="form-label">Stock:</label>
            <input type="number" class="form-control" id="stock" name="stock" required>
        </div>
        <div class="mb-3">
            <label for="img" class="form-label">Photo:</label>
            <input type="file" class="form-control" id="img" name="img" required>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter Livre</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
