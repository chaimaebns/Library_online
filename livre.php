

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

// Récupérer les livres de la base de données
$sql = "SELECT * FROM livres";  // Remplacez 'livres' par le nom de votre table de livres
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Liste des Livres Bibliothèque</title>

    <!-- Lien vers le CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">

    <style>
        body {
            background-color: #f4f4f4;
            background-image: url('logo.jpg');
            background-size: cover;
            background-position: center;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            margin-top: 80px;
        }

        footer {
            background-color: rgba(0, 0, 0, 0.6);
            color: white;
            text-align: center;
            padding: 20px;
            width: 100%;
        }

        footer .footer-content p {
            margin: 5px;
            font-size: 16px;
        }

        .table {
            height: 200px;
            overflow-y: scroll;
        }

        table {
            width: 100%;
            text-align: left;
            border-collapse: collapse;
        }

        tr {
            border-bottom: 1px solid #f1f1f1;
        }

        td,
        th {
            padding-block: 10px;
        }

        .edit {
            color: #70d7a5;
            margin-right: 10px;
        }

        .delete {
            color: #e86786;
        }

        .pending {
            color: #f1d243;
        }

        .confirmed {
            color: #70d7a5;
        }

        .rejected {
            color: #e86786;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <header class="text-center py-4">
        <div class="logo">
            <h1>Ajouter des livres</h1>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container">
        <button class="btn btn-primary mb-4"><i class="ri-add-line"></i><a href="indexa.php"> Ajouter des Livres</a></button>
        
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID Livre</th>
                        <th>Titre</th>
                        <th>Auteur</th>
                        <th>Genre</th>
                        <th>Année Publication</th>
                        <th>Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <tbody>
                            <tr>
                            <td>4</td>
                            <td>L'Alchimiste</td>
                            <td>Paulo Coelho</td>
                            <td>Roman initiatique</td>
                            <td>1988</td>
                            <td>60</td>
                                <td class="pending">pending</td>
            <td><span><i class="ri-edit-line edit"></i><i class="ri-delete-bin-line delete"><a href="supprimer.php"></a></i></span></td>
                            </tr>
                       
                            <tr>
                            <td>5</td>
                            <td>To Kill a Mockingbird</td>
                             <td>Harper Lee</td>
                             <td>Roman social</td>
                           <td>1960</td>
                           <td>40</td>
                                <td class="confirmed">Confirmed</td>
            <td><span><i class="ri-edit-line edit"></i><i class="ri-delete-bin-line delete"></i></span></td>
                            </tr>
                            <tr>
                            <td>6</td>
    <td>La Peste</td>
    <td>Albert Camus</td>
    <td>Roman existentialiste</td>
    <td>1947</td>
    <td>30</td>
                                <td class="rejected">Rejected</td>
                                <td><span><i class="ri-edit-line edit"></i><i class="ri-delete-bin-line delete"></i></span></td>
                            </tr>
                            <tr>
                            <td>1</td>
    <td>Les Misérables</td>
    <td>Victor Hugo</td>
    <td>Roman historique</td>
    <td>1862</td>
    <td>50</td>
                                <td class="confirmed">Confirmed</td>
    <td><span><i class="ri-edit-line edit"></i><i class="ri-delete-bin-line delete"></i></span></td>
                            </tr>
                    
            </tbody>
                </tbody>
            </table>
        </div>
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
