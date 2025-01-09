<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- Lien vers le CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        
        body {
            background-color: #282c34;
            background-image: url('logo.jpg'); /* Remplacez par l'URL de votre image */
            background-size: cover;
            background-position: center;
            height: 100vh;
            margin: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between; /* Maintenir le footer en bas */
        }

        /* Conteneur principal */
        .container {
            background-color: rgba(255, 255, 255, 0.8); /* Fond blanc semi-transparent */
            padding: 30px;
            border-radius: 10px;
            max-width: 500px; /* Limite la taille du formulaire */
            width: 100%;
        }
        header {
            width: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            padding: 20px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }

        .logo h1 {
            font-size: 28px;
        }

        /* Menu de navigation */
        nav ul {
            list-style: none;
            display: flex;
            margin: 0;
            padding: 0;
            justify-content: center; /* Centrer les éléments de navigation */
            align-items: center;
        }

        nav ul li {
            margin: 5px;
        }
        nav ul li a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
        }

        nav ul li a:hover {
            color: #03a9f4;
        }
        /* Section principale */
        .main-content {
            height: auto;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin-top: 100px; /* Décaler le contenu vers le bas */
        }

        .box {
            text-align: center;
            padding: 20px;
        }

        .box h1,
        .box h2 {
            margin: 10px 0;
        }

        .box button {
            cursor: pointer;
            width: 300px;
            height: 50px;
            background: black;
            border: none;
            color: #03a9f4;
            font-weight: bold;
        }

        .box button:hover {
            background-color: #03a9f4;
            color: white;
        }

        /* Footer */
        footer {
            background-color: rgba(0, 0, 0, 0.6);
            color: white;
            text-align: center;
            padding: 20px;
            position: relative;
            bottom: 0;
            width: 100%;
        }

        .footer-content p {
            margin: 5px;
            font-size: 16px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            header {
                flex-direction: column;
                text-align: center;
            }

            header .logo img {
                max-width: 40px;
            }

            nav ul {
                flex-direction: column;
                align-items: center;
                margin-top: 10px;
            }

            .container {
                padding: 20px;
                width: 90%;
            }

            .box button {
                width: 100%;
            }

            footer {
                padding: 15px 0;
            }

            .footer-content p {
                font-size: 14px;
            }
        }
    </style>
    </style>
</head>
<body>

    <!-- Header -->
    <header>
    
            <h1>LEBRARY</h1>

        <!-- Menu de navigation -->
        <nav>
            <ul>
                <li><a href="feedback.php"><img src="index.php" alt="" /> COMMENTAIRES</a></li>
                <li><a href="login.php"><img src="login.PNG" alt="Utilisateur" /> UTILISATEUR</a></li>
                <li><a href="login.php"><img src="login.PNG" alt="Admin" /> ADMIN</a></li>
                <li><a href="login.php"><img src="login.PNG" alt="loug out" /> Loug out</a></li> 
            </ul>
        </nav>
    </header>
<br><br><br>
    <!-- Contenu principal -->
    <section class="main-content">
        <div class="container">
            <div class="box">
                <h1>Welcome to the Library</h1>
                <h2>Ouvert à: 09:00</h2>
                <h2>Fermé à: 16:00</h2>
                <p>
                    <a href="login.php">
                        <button>Commencer comme utilisateur &nbsp; &gt;</button>
                    </a>
                </p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <p>Email: library.Online@gmail.com</p>
            <p>Mobile: +21289******</p>
        </div>
    </footer>

    <!-- Scripts Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>


