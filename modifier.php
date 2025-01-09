<?php
// Initialiser la session
session_start();

// Informations d'identification
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'bibloithequernligne');

// Connexion à la base de données MySQL
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Vérifier la connexion
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Vérifier si l'ID du livre à modifier est présent dans l'URL
if (isset($_GET['modifier'])) {
    $idLivre = $_GET['modifier'];

    // Récupérer les informations du livre depuis la base de données
    $sql = "SELECT * FROM livres WHERE id_livre = $idLivre";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $livre = mysqli_fetch_assoc($result);
    } else {
        echo "Livre non trouvé.";
        exit();
    }

    // Vérifier si le formulaire de modification a été soumis
    if (isset($_POST['modifier'])) {
        // Récupérer les nouvelles informations du livre
        $titre = $_POST['titre'];
        $auteur = $_POST['auteur'];
        $genre = $_POST['genre'];
        $annee_publication = $_POST['annee_publication'];
        $stock = $_POST['stock'];

        // Préparer la requête SQL pour mettre à jour les informations du livre
        $update_sql = "UPDATE livres SET titre = '$titre', auteur = '$auteur', genre = '$genre', annee_publication = '$annee_publication', stock = '$stock' WHERE id_livre = $idLivre";

        if (mysqli_query($conn, $update_sql)) {
            // Rediriger vers la page des livres après modification
            header("Location: indexa.php");
            exit();
        } else {
            echo "Erreur lors de la mise à jour: " . mysqli_error($conn);
        }
    }
} else {
    echo "ID de livre manquant.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modifier Livre</title>

    <!-- Lien vers le CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <style>
body {
            background-image: url('livre.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        header {
            background-color: #007bff;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .container {
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .book-card {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

    </style>
    <div class="container mt-5">
        <h2>Modifier le livre</h2>
        <form method="post">
            <div class="mb-3">
                <label for="titre" class="form-label">Titre</label>
                <input type="text" class="form-control" id="titre" name="titre" value="<?php echo htmlspecialchars($livre['titre']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="auteur" class="form-label">Auteur</label>
                <input type="text" class="form-control" id="auteur" name="auteur" value="<?php echo htmlspecialchars($livre['auteur']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="genre" class="form-label">Genre</label>
                <input type="text" class="form-control" id="genre" name="genre" value="<?php echo htmlspecialchars($livre['genre']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="annee_publication" class="form-label">Année de publication</label>
                <input type="number" class="form-control" id="annee_publication" name="annee_publication" value="<?php echo htmlspecialchars($livre['annee_publication']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="stock" class="form-label">Stock</label>
                <input type="number" class="form-control" id="stock" name="stock" value="<?php echo htmlspecialchars($livre['stock']); ?>" required>
            </div>
            <button type="submit" name="modifier" class="btn btn-primary">Modifier</button>
            <a href="indexa.php" class="btn btn-secondary">Annuler</a>
        </form>
    </div>

    <!-- Scripts Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>

<?php
// Fermer la connexion à la base de données
mysqli_close($conn);
?>
