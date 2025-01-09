<?php
// Initialiser la session
session_start();

// Informations d'identification
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'bibliothequernligne'); // Ensure this matches your database name

// Connexion à la base de données MySQL
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Vérifier la connexion
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Vérifier si un livre est retourné
if (isset($_GET['return_id'])) {
    $return_id = intval($_GET['return_id']); // Convert to integer for security

    // Mettre à jour le statut du livre en "retourné"
    $sql = "UPDATE livres SET status = 'retourné', stock = stock + 1 WHERE id = $return_id";

    if (mysqli_query($conn, $sql)) {
        echo "Livre retourné avec succès.";
    } else {
        echo "Erreur lors du retour du livre : " . mysqli_error($conn);
    }
}

// Récupérer tous les livres avec un statut "emprunté"
$sql = "SELECT id, titre AS title, auteur AS author, genre, annee_publication AS year, stock FROM livres WHERE status = 'emprunté'";
$result = mysqli_query($conn, $sql);

// Vérifier si la requête a échoué
if (!$result) {
    die("Erreur de requête : " . mysqli_error($conn));
}
?>
