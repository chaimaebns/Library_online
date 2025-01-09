<?php
$dsn = 'mysql:host=localhost;dbname=bibloithequernligne;charset=utf8';
$username = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reserve'])) {
    if (isset($_POST['membre_nom'], $_POST['id_livre'], $_POST['date_reservation'], $_POST['date_retour'])) {
        $membre_nom = trim($_POST['membre_nom']);
        $id_livre = intval($_POST['id_livre']);
        $date_reservation = $_POST['date_reservation'];
        $date_retour = $_POST['date_retour'];

      
        $stmt = $pdo->prepare("SELECT id_membre FROM membres WHERE nom = :nom LIMIT 1");
        $stmt->bindParam(':nom', $membre_nom, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $id_membre = $stmt->fetch(PDO::FETCH_ASSOC)['id_membre'];

        
            $insert_stmt = $pdo->prepare(
                "INSERT INTO reservation (id_livre, id_membre, date_reservation, date_fin_reservation) 
                 VALUES (:id_livre, :id_membre, :date_reservation, :date_retour)"
            );
            $insert_stmt->bindParam(':id_livre', $id_livre, PDO::PARAM_INT);
            $insert_stmt->bindParam(':id_membre', $id_membre, PDO::PARAM_INT);
            $insert_stmt->bindParam(':date_reservation', $date_reservation);
            $insert_stmt->bindParam(':date_retour', $date_retour);

            if ($insert_stmt->execute()) {
                echo "<script>alert('Réservation effectuée avec succès !');</script>";
            } else {
                echo "<script>alert('Erreur lors de la réservation.');</script>";
            }
        } else {
            echo "<script>alert('Aucun membre trouvé avec ce nom.');</script>";
        }
    } else {
        echo "<script>alert('Tous les champs sont obligatoires.');</script>";
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cancel'])) {
    $id_reservation = intval($_POST['id_reservation']);

    $delete_stmt = $pdo->prepare("DELETE FROM reservation WHERE id_reservation = :id_reservation");
    $delete_stmt->bindParam(':id_reservation', $id_reservation, PDO::PARAM_INT);

    if ($delete_stmt->execute()) {
        echo "<script>alert('Réservation annulée avec succès !');</script>";
    } else {
        echo "<script>alert('Erreur lors de l\'annulation.');</script>";
    }
}

$reservations_sql = "SELECT r.id_reservation, l.titre AS livre, m.nom AS membre, r.date_reservation, r.date_fin_reservation
                     FROM reservation r
                     JOIN livres l ON r.id_livre = l.id_livre
                     JOIN membres m ON r.id_membre = m.id_membre";
$reservations = $pdo->query($reservations_sql)->fetchAll(PDO::FETCH_ASSOC);


$livres_sql = "SELECT id_livre, titre FROM livres";
$livres = $pdo->query($livres_sql)->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réserver un livre</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<style>
    body {
        background-image: url('livre.jpg');
        background-size: cover;
        background-position: center;
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
        max-width: 800px;
        width: 100%;
    }
</style>
<div class="container">
    <h1>Réserver un livre</h1>
    <form action="" method="POST">
        <div class="mb-3">
            <label for="membre_nom" class="form-label">Nom du Membre :</label>
            <input type="text" class="form-control" id="membre_nom" name="membre_nom" placeholder="Entrez le nom du membre" required>
        </div>

        <div class="mb-3">
            <label for="id_livre" class="form-label">Livre :</label>
            <select class="form-control" id="id_livre" name="id_livre" required>
                <option value="">Sélectionnez un livre</option>
                <?php foreach ($livres as $livre) {
                    echo "<option value='{$livre['id_livre']}'>{$livre['titre']}</option>";
                } ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="date_reservation" class="form-label">Date de Réservation :</label>
            <input type="date" class="form-control" id="date_reservation" name="date_reservation" required>
        </div>

        <div class="mb-3">
            <label for="date_retour" class="form-label">Date de Retour :</label>
            <input type="date" class="form-control" id="date_retour" name="date_retour" required>
        </div>

        <button type="submit" name="reserve" class="btn btn-primary">Réserver ce livre</button>
    </form>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
