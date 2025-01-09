<!DOCTYPE html>
<html lang="fr">
<head>
	<title>GESTION DE BIBLIOTHEQUE</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script>
		// JavaScript function to dynamically filter books
		function searchBooks() {
			const searchTerm = document.getElementById('search-input').value.toLowerCase();
			const bookListItems = document.querySelectorAll('.book-list-item');
			
			bookListItems.forEach(item => {
				const bookTitle = item.textContent.toLowerCase();
				if (bookTitle.includes(searchTerm)) {
					item.style.display = 'block'; // Show matching book
				} else {
					item.style.display = 'none'; // Hide non-matching book
				}
			});
		}
	</script>
</head>

<body>
	<div class="wrapper">
		<header>
			<h1 style="color: white; margin-left: 10px;">GESTION DE BIBLIOTHEQUE</h1>
		</header>
		
		<nav>
			<div class="list-group">
				<a href="#" class="list-group-item list-group-item-action active">Dashboard</a>
				<a href="#" class="list-group-item list-group-item-action">Emprunt</a>
				<a href="#" class="list-group-item list-group-item-action">Available Books</a>
				<a href="#" class="list-group-item list-group-item-action">Activity</a>
				<a href="#" class="list-group-item list-group-item-action">Settings</a>
				<a href="logout.php" class="list-group-item list-group-item-action">Logout</a>
			</div>
		</nav>
		
		<section>
			<br><br><br>
			<div id="main-nav">
				<center>
					<div id="search">
						<!-- Search input field and button -->
						<form action="search_delete.php" method="GET">
							<input class="search-area" type="text" id="search-input" onkeyup="searchBooks()" placeholder="Chercher votre livre">
							<button class="search-btn" type="submit" name="search">
								<img src="image/search.png" alt="Search">
							</button>
						</form>
					</div>
				</center>
			</div>
			<br><br><br>
			
			<!-- Book List to Filter -->
			<ul id="book-list">
				<?php 
					include "../includes/function.php"; 
					// Assuming you have a function that gets the list of books
					$books = get_books(); 
					foreach ($books as $book) {
						echo '<li class="book-list-item">' . htmlspecialchars($book['title']) . '</li>';
					}
				?>
			</ul>
		</section>
	</div>
</body>
</html>
