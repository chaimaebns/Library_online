<html>
<head>
	<title>
		LEBRARY
	</title>
	
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
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

        nav ul {
            list-style: none;
            display: flex;
            margin: 0;
            padding: 0;
            justify-content: center;
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

        .container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 30px;
            border-radius: 10px;
            max-width: 500px;
            width: 100%;
            margin-top: 80px;
        }

        footer {
            background-color: rgba(0, 0, 0, 0.6);
            color: white;
            text-align: center;
            padding: 20px;
            position: relative;
            bottom: 0;
            width: 100%;
        }

        footer .footer-content p {
            margin: 5px;
            font-size: 16px;
        }

        .book-table {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 30px;
            border-radius: 10px;
            margin-top: 100px;
        }

        .book-table img {
            width: 100px;
            height: 150px;
            object-fit: cover;
        }

        /* Styling for search bar on the left bottom of the page */
        .search-bar-container {
            position: absolute;
            bottom: 20px;
            left: 20px;
            background-color: rgba(0, 0, 0, 0.6);
            padding: 10px;
            border-radius: 5px;
        }
        .search-bar-container input {
            width: 250px;
            padding: 5px;
            margin-right: 10px;
        }

    </style>

<body>
	<div class="wrapper">
		<header>

			<h1 style="color: white; margin-left: 10px;">LEBRARY</h1>
		</div>

        <nav>
            <ul>
                <li><a href="index.php"><img src="login.PNG" alt="ACCUIEL" />ACCUIEL</a></li>
                <li><a href="feedback.php"><img src="login.PNG" alt="COMMENTAIRES" />COMMENTAIRES</a></li>
                <li><a href="ajouter.php"><img src="login.PNG" alt="AJOUTER_LIVRE" />AJOUTER_LIVRE</a></li>
                <li><a href="index.php"><img src="login.PNG" alt="Admin" />ADMIN</a></li>
            </ul>
        </nav>
		</header>
		<section>
		<br><br><br>
		<div id="main-nav">
				<center>
				<div id="search">
					<form action="search_update.php" method="GET">
						<input class="search-area" type="text" name="searcharea" placeholder="chercher votre livre">
						<button class="search-btn" type="submit" name="search"><img src="image/search.png"></button>
					</form>
				</div>
				</center>
		</div>
		<br><br><br>
		<ul>
			<?php include "function.php"; ?>
			<?php get_pro_update(); ?>
		</ul>
		<br><br><br><br><br><br>
		</section>
		<footer>
			<p style="color:white;text-align: center;">
				<br>
				Email:&nbsp; Online.library@gmail.com <br><br>
				Mobile:&nbsp; &nbsp; +21627******

			</p>
		</footer>

	</div>
</body>
</html>