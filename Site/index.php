<?php
session_start();
require '../fake.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Accueil - E-commerce</title>
</head>
<body>
    <header>
        <h1>Bienvenue sur notre site e-commerce</h1>
    </header>

    <nav>
        <a href="product.php">Voir les produits</a>
        <a href="cart.php">Mon panier</a>
        <a href="login.php">Se connecter</a> <!-- Ajout du lien de connexion -->
    </nav>

    <main>
        <h2>Nos produits populaires</h2>
        <!-- Code pour afficher les produits, etc. -->
    </main>

    <footer>
        <p>&copy; 2024 Mon E-commerce</p>
    </footer>
</body>
</html>
