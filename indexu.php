<?php
session_start();

// Database connection settings
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'bibloithequernligne');

try {
    // Create a PDO instance
    $conn = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // Handle connection error
    die("Connection failed: " . $e->getMessage());
}

// SQL query to retrieve books
$sql = "SELECT id_livre, titre, auteur, genre, annee_publication, stock, photo FROM livres";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Close the database connection
$conn = null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bibliothèque</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">

    <!-- Custom CSS -->
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

        .logo h1 {
            font-size: 24px;
            margin: 0;
        }

        nav ul {
            list-style: none;
            display: flex;
            margin: 0;
            padding: 0;
        }

        nav ul li {
            margin: 0 15px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }

        nav ul li a:hover {
            color: #ffc107;
        }

        .search-bar-container {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .search-bar-container input {
            width: 300px;
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
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

        .book-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }

        .book-details {
            margin-top: 15px;
        }

        .book-details h5 {
            margin-bottom: 10px;
        }

        footer {
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 15px 0;
            margin-top: 20px;
        }

        footer p {
            margin: 0;
        }
    </style>
</head>

<body>
    <header>
        <div class="logo">
            <h1>Gestion De Bibliothèque</h1>
        </div>
        <nav>
            <ul>
                <li><a href="indexu.php">Accueil</a></li>
                <li><a href="feedback.php">Commentaires</a></li>
                <li><a href="reservatinu.php">Réserver Livre</a></li>
                <li><a href="logout.php" class="list-group-item list-group-item-action">Logout</a></li>
            </ul>
        </nav>
        <div class="search-bar-container">
            <form action="indexu.php" method="get">
                <input type="text" name="search" class="form-control" placeholder="Chercher un livre">
                <button type="submit" class="btn btn-light">Rechercher</button>
            </form>
        </div>
    </header>

    <div class="container">
        <h2 class="text-center mb-4">Liste des livres</h2>
        <div class="row">
            <?php
            if (count($result) > 0) {
                foreach ($result as $row) {
                    echo "<div class='col-md-4'>";
                    echo "<div class='book-card'>";
                    echo "<img src='" . htmlspecialchars($row['photo']) . "' alt='" . htmlspecialchars($row['titre']) . "'>";
                    echo "<div class='book-details'>";
                    echo "<h5>" . htmlspecialchars($row['titre']) . "</h5>";
                    echo "<p><strong>Auteur:</strong> " . htmlspecialchars($row['auteur']) . "</p>";
                    echo "<p><strong>Genre:</strong> " . htmlspecialchars($row['genre']) . "</p>";
                    echo "<p><strong>Année de publication:</strong> " . htmlspecialchars($row['annee_publication']) . "</p>";
                    echo "<p><strong>Stock:</strong> " . htmlspecialchars($row['stock']) . "</p>";
                    echo "<a href='reservatinu.php?id_livre=" . $row['id_livre'] . "' class='btn btn-primary mt-2'>Réserver</a>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p class='text-center'>Aucun livre trouvé</p>";
            }
            ?>
        </div>
    </div>

    <footer>
        <p>Email: library.online@gmail.com | Mobile: +21289******</p>
    </footer>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>
