<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'bibloithequernligne');

try {
    $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_livre = $_POST['id_livre'] ?? null;
    $id_membre = $_POST['id_membre'] ?? null;
    $commentaire = $_POST['commentaire'] ?? '';
    $note = $_POST['note'] ?? null;

    if ($id_livre && $id_membre && $note && !empty($commentaire)) {
        $sql = "INSERT INTO avis (id_livre, id_membre, commentaire, note) VALUES (:id_livre, :id_membre, :commentaire, :note)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':id_livre' => $id_livre,
            ':id_membre' => $id_membre,
            ':commentaire' => $commentaire,
            ':note' => $note,
        ]);
        echo "<div class='alert alert-success'>Commentaire ajouté avec succès !</div>";
    } else {
        echo "<div class='alert alert-danger'>Tous les champs sont obligatoires.</div>";
    }
}

if (isset($_GET['delete'])) {
    $id_avis = $_GET['delete'];
    $sql = "DELETE FROM avis WHERE id_avis = :id_avis";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_avis' => $id_avis]);
    echo "<div class='alert alert-success'>Commentaire supprimé avec succès !</div>";
}

$sql = "SELECT avis.id_avis, avis.commentaire, avis.note, livres.titre AS livre, membres.nom AS membre
        FROM avis
        JOIN livres ON avis.id_livre = livres.id_livre
        JOIN membres ON avis.id_membre = membres.id_membre
        ORDER BY avis.id_avis DESC";
$comments = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

$livres = $pdo->query("SELECT id_livre, titre FROM livres")->fetchAll(PDO::FETCH_ASSOC);
$membres = $pdo->query("SELECT id_membre, nom FROM membres")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Page de Feedback - Bibliothèque</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    body {
        background-color: #282c34;
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
    .btn {
        background-color: rgba(23, 87, 176, 0.8);
    }
</style>
<body>
  <div class="container mt-5">
    <h1 class="text-center mb-4">Donnez-nous votre avis !</h1>


    <form action="commentaire.php" method="POST">
      
      <div class="mb-3">
        <label for="id_livre" class="form-label">Livre :</label>
        <select name="id_livre" id="id_livre" class="form-select" required>
            <option value="">Sélectionnez un livre</option>
            <?php foreach ($livres as $livre): ?>
                <option value="<?= $livre['id_livre'] ?>"><?= htmlspecialchars($livre['titre']) ?></option>
            <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-3">
        <label for="id_membre" class="form-label">Membre :</label>
        <select name="id_membre" id="id_membre" class="form-select" required>
            <option value="">Sélectionnez un membre</option>
            <?php foreach ($membres as $membre): ?>
                <option value="<?= $membre['id_membre'] ?>"><?= htmlspecialchars($membre['nom']) ?></option>
            <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-3">
        <label for="commentaire" class="form-label">Commentaire :</label>
        <textarea name="commentaire" id="commentaire" class="form-control" rows="4" required></textarea>
      </div>

      <div class="mb-3">
        <label for="note" class="form-label">Note :</label>
        <select name="note" id="note" class="form-select" required>
            <option value="">Sélectionnez une note</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
      </div>

      <button type="submit" class="btn btn-primary">Ajouter le commentaire</button>
    </form>


    <h2>Liste des commentaires</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Livre</th>
                <th>Membre</th>
                <th>Commentaire</th>
                <th>Note</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($comments) > 0): ?>
                <?php foreach ($comments as $comment): ?>
                    <tr>
                        <td><?= htmlspecialchars($comment['livre']) ?></td>
                        <td><?= htmlspecialchars($comment['membre']) ?></td>
                        <td><?= htmlspecialchars($comment['commentaire']) ?></td>
                        <td><?= htmlspecialchars($comment['note']) ?></td>
                        <td>
                            <a href="?delete=<?= $comment['id_avis'] ?>" class="btn btn-danger">Annuler</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">Aucun commentaire disponible</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
  </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
