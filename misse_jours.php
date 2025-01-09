<?php
// Initialiser la session
session_start();

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

// Vérifier si un ID est passé via l'URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Récupérer les informations du livre avec cet ID
    $sql = "SELECT * FROM livres WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() == 1) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        echo "Livre non trouvé.";
        exit;
    }
} else {
    echo "Aucun livre sélectionné.";
    exit;
}

// Mettre à jour le livre si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $year = $_POST['year'];
    $stock = $_POST['stock'];

    // Requête de mise à jour
    $sql = "UPDATE livres SET title = :title, author = :author, genre = :genre, year = :year, stock = :stock WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':author', $author, PDO::PARAM_STR);
    $stmt->bindParam(':genre', $genre, PDO::PARAM_STR);
    $stmt->bindParam(':year', $year, PDO::PARAM_INT);
    $stmt->bindParam(':stock', $stock, PDO::PARAM_INT);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "Livre mis à jour avec succès.";
        header('Location: indexa.php');
        exit;
    } else {
        echo "Erreur lors de la mise à jour du livre.";
    }
}

$conn = null;  // Fermer la connexion PDO
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modifier un Livre - Bibliothèque</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Modifier un Livre</h1>

        <!-- Formulaire pour mettre à jour le livre -->
        <form action="edit-book.php?id=<?php echo $row['id']; ?>" method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Titre</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo $row['title']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="author" class="form-label">Auteur</label>
                <input type="text" class="form-control" id="author" name="author" value="<?php echo $row['author']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="genre" class="form-label">Genre</label>
                <input type="text" class="form-control" id="genre" name="genre" value="<?php echo $row['genre']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="year" class="form-label">Année de publication</label>
                <input type="number" class="form-control" id="year" name="year" value="<?php echo $row['year']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="stock" class="form-label">Stock</label>
                <input type="number" class="form-control" id="stock" name="stock" value="<?php echo $row['stock']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>
