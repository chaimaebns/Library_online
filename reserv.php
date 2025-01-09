<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté, sinon rediriger vers la page de connexion
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Inclure la connexion à la base de données
include('connexion.php');

// Vérifier si l'ID du livre à réserver est passé dans l'URL
if (isset($_GET['id_livre'])) {
    $idLivre = $_GET['id_livre'];

    // Rechercher les détails du livre dans la base de données
    $sql = "SELECT * FROM livres WHERE id_livre = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$idLivre]);
    $livre = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifier si le livre existe
    if (!$livre) {
        echo "Livre non trouvé.";
        exit();
    }

    // Si le formulaire est soumis
    if (isset($_POST['reserver'])) {
        // Vérifier si le stock est disponible
        if ($livre['stock'] > 0) {
            // Insérer la réservation dans la base de données
            $username = $_SESSION['username'];
            $sqlReserve = "INSERT INTO reservations (id_livre, username, date_reservation) VALUES (?, ?, NOW())";
            $stmtReserve = $pdo->prepare($sqlReserve);
            $stmtReserve->execute([$idLivre, $username]);

            // Mettre à jour le stock du livre
            $newStock = $livre['stock'] - 1;
            $sqlUpdate = "UPDATE livres SET stock = ? WHERE id_livre = ?";
            $stmtUpdate = $pdo->prepare($sqlUpdate);
            $stmtUpdate->execute([$newStock, $idLivre]);

            // Message de succès
            echo "<div class='alert alert-success'>Votre réservation a été enregistrée avec succès !</div>";
        } else {
            // Message si le stock est épuisé
            echo "<div class='alert alert-danger'>Désolé, ce livre est en rupture de stock.</div>";
        }
    }
} else {
    echo "ID du livre non spécifié.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation de Livre</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- En-tête -->
    <header class="bg-primary text-white p-4">
        <div class="container">
            <h1>Réserver un Livre</h1>
        </div>
    </header>

    <!-- Détails du livre -->
    <div class="container mt-5">
        <h2 class="text-center">Détails du Livre</h2>
        <div class="card" style="width: 18rem;">
            <img src="<?php echo htmlspecialchars($livre['photo']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($livre['titre']); ?>">
            <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($livre['titre']); ?></h5>
                <p class="card-text"><strong>Auteur:</strong> <?php echo htmlspecialchars($livre['auteur']); ?></p>
                <p class="card-text"><strong>Genre:</strong> <?php echo htmlspecialchars($livre['genre']); ?></p>
                <p class="card-text"><strong>Année de publication:</strong> <?php echo htmlspecialchars($livre['annee_publication']); ?></p>
                <p class="card-text"><strong>Stock:</strong> <?php echo htmlspecialchars($livre['stock']); ?></p>
                <p class="card-text"><strong>Description:</strong> <?php echo htmlspecialchars($livre['description']); ?></p>
            </div>
        </div>

        <!-- Formulaire de réservation -->
        <div class="mt-4">
            <form method="post">
                <button type="submit" class="btn btn-success" name="reserver">Réserver ce Livre</button>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center p-3 mt-5">
        <p>&copy; 2024 Bibliothèque en Ligne</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
