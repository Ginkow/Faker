<?php
// product.php
require '../fake.php';

// Récupérer les produits de la base de données
$stmt = $db->query("SELECT * FROM product");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Produits</title>
</head>
<body>
    <header>
        <h1>Nos produits</h1>
        <nav>
            <a href="index.php">Accueil</a>
            <a href="cart.php">Mon panier</a>
        </nav>
    </header>
    <main>
        <?php foreach ($products as $product): ?>
            <div class="product">
                <h2><?php echo htmlspecialchars($product['name']); ?></h2>
                <p><?php echo htmlspecialchars($product['description']); ?></p>
                <p>Prix: €<?php echo number_format($product['price'], 2); ?></p>
                <form action="cart.php" method="post">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <input type="number" name="quantity" value="1" min="1">
                    <button type="submit">Ajouter au panier</button>
                </form>
            </div>
        <?php endforeach; ?>
    </main>
</body>
</html>
