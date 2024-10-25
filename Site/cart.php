<?php
// cart.php
require '../fake.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Rediriger vers la page de connexion
    header('Location: login.php');
    exit();
}

session_start();

// Gérer l'ajout au panier
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Ajout du produit au panier
    $_SESSION['cart'][$product_id] = isset($_SESSION['cart'][$product_id]) ? $_SESSION['cart'][$product_id] + $quantity : $quantity;
}

// Récupérer les produits dans le panier
$cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$products_in_cart = [];

if (!empty($cart_items)) {
    foreach ($cart_items as $id => $qty) {
        $stmt = $db->prepare("SELECT * FROM product WHERE id = ?");
        $stmt->execute([$id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        $products_in_cart[] = [
            'product' => $product,
            'quantity' => $qty
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Mon panier</title>
</head>
<body>
    <header>
        <h1>Mon panier</h1>
        <nav>
            <a href="index.php">Accueil</a>
            <a href="product.php">Produits</a>
        </nav>
    </header>
    <main>
        <?php if (empty($products_in_cart)): ?>
            <p>Votre panier est vide.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Quantité</th>
                        <th>Prix</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products_in_cart as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['product']['name']); ?></td>
                            <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                            <td>€<?php echo number_format($item['product']['price'] * $item['quantity'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </main>
</body>
</html>
