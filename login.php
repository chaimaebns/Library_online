<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Connexion</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

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
            max-width: 500px; 
            width: 100%;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">Formulaire de Connexion</h2>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form action="" method="POST" id="loginForm">
                <div class="mb-3">
                    <label for="email" class="form-label">Email :</label>
                    <input type="email" id="email" name="email" class="form-control" maxlength="50" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe :</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-success" id="loginButton">Se connecter</button>
                </div>
                <p class="box-register">Vous êtes nouveau ici? <a href="register.php">S'inscrire</a></p>
                <p class="box-register">Vous êtes administrateur? <a href="admin.php">Se connecter en tant qu'admin</a></p>
                <?php if (isset($message)) { ?>
                    <p class="text-danger text-center mt-3"><?php echo $message; ?></p>
                <?php } ?>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

<script>
    document.getElementById("loginForm").addEventListener("submit", function(event) {
        // Prevent the default form submission
        event.preventDefault();

        // Submit the form using JavaScript (or use AJAX if you prefer)
        var form = this;
        var formData = new FormData(form);

        fetch('login.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            // If login successful, redirect to indexu.php
            if (data.includes('Location: indexu.php')) {
                window.location.href = 'indexu.php';
            } else {
                // Show the message if there's an error (for example: incorrect password or email)
                document.querySelector('.text-danger').innerText = "Email ou mot de passe incorrect";
            }
        })
        .catch(error => console.error('Error:', error));
    });
</script>

</body>
</html>
