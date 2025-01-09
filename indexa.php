<?php
// Initialiser la session
session_start();

// Informations d'identification
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'bibloithequernligne');

// Connexion à la base de données MySQL avec PDO
try {
    $conn = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    // Configurer le mode de récupération des erreurs de PDO
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Récupérer les livres de la base de données avec PDO
$sql = "SELECT id_livre, titre, auteur, genre, annee_publication, stock, photo FROM livres";
$stmt = $conn->prepare($sql);
$stmt->execute();
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestion de Bibliothèque</title>

    <!-- Lien vers le CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
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
            color: rgb(35, 191, 113);
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
    <!-- Header -->
    <header>
        <div class="logo">
            <h1>Gestion De Bibliothèque</h1>
        </div>
        <nav>
            <ul>
                <li><a href="indexa.php">Accueil</a></li>
                <li><a href="commentaire.php">Commentaires</a></li>
                <li><a href="ajouter.php">Ajouter Livre</a></li>
                <li><a href="indexu.php">Utilisateur</a></li>
                <li><a href="reservationa.php">modifier reservation</a></li>

                <a href="logout.php" class="list-group-item list-group-item-action">Logout</a>
            </ul>
        </nav>
        <div class="search-bar-container">
            <form action="indexa.php" method="get">
                <input type="text" name="search" class="form-control" placeholder="Chercher un livre">
                <button type="submit" class="btn btn-light">Rechercher</button>
            </form>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container">
        <h2 class="text-center mb-4">Liste des livres</h2>
        <div class="container">
            <button class="btn btn-primary mb-4"><i class="ri-add-line"></i><a href="ajouter.php"> Ajouter des Livres</a></button>
        
            <!-- Table displaying books -->
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID Livre</th>
                        <th>Titre</th>
                        <th>Auteur</th>
                        <th>Genre</th>
                        <th>Année de Publication</th>
                        <th>Stock</th>
                        <th>Photo</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count($books) > 0) {
                        foreach ($books as $row) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['id_livre']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['titre']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['auteur']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['genre']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['annee_publication']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['stock']) . "</td>";
                            echo "<td><img src='" . htmlspecialchars($row['photo']) . "' alt='" . htmlspecialchars($row['titre']) . "' width='100'></td>";
                            echo "<td>";
                            echo "<a href='modifier.php?modifier=" . urlencode($row['id_livre']) . "'><button class='btn btn-primary'>Modifier</button></a>";
                            echo "<a href='supp.php?supprime=" . $row['id_livre'] . "' onclick=\"return confirm('Voulez-vous vraiment supprimer ce livre ?')\"><button class='btn btn-danger'>Supprimer</button></a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8' class='text-center'>Aucun livre trouvé</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <br><br><br><br>

        <footer>
            <p>Email: library.online@gmail.com | Mobile: +21289******</p>
        </footer>

        <!-- Scripts Bootstrap -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    </body>
</html>
