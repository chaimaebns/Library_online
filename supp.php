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

// Vérifier si l'ID du livre à supprimer est présent dans l'URL
if (isset($_GET['supprime'])) {
    $idLivre = $_GET['supprime'];

    // Préparer la requête SQL pour supprimer le livre de la base de données
    $delete_sql = "DELETE FROM livres WHERE id_livre = $idLivre";

    if (mysqli_query($conn, $delete_sql)) {
        // Rediriger vers la page d'accueil des livres après suppression
        header("Location: accuiel.php");
        exit();
    } else {
        echo "Erreur lors de la suppression: " . mysqli_error($conn);
    }
} else {
    echo "ID de livre manquant.";
    exit();
}

// Fermer la connexion à la base de données
mysqli_close($conn);
?>
