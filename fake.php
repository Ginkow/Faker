<?php
require_once 'vendor/autoload.php';

$faker = Faker\Factory::create();

try {
    // Connexion à la base de données SQLite existante
    $db = new PDO('sqlite:./Ecommerce.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Insertion de données dans la table "user"
    for ($i = 0; $i < 10; $i++) {
        $stmt = $db->prepare("INSERT INTO user (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$faker->name, $faker->email, password_hash($faker->password, PASSWORD_DEFAULT)]);
    }

    // Insertion de données dans la table "address"
    for ($i = 1; $i <= 10; $i++) {
        $stmt = $db->prepare("INSERT INTO address (id_user, address, city, postal) VALUES (?, ?, ?, ?)");
        $stmt->execute([$i, $faker->address, $faker->city, $faker->postcode]);
    }

    // Insertion de données dans la table "product"
    for ($i = 0; $i < 10; $i++) {
        $stmt = $db->prepare("INSERT INTO product (name, description, price) VALUES (?, ?, ?)");
        $stmt->execute([$faker->word, $faker->sentence, $faker->randomFloat(2, 5, 500)]);
    }

    // Insertion de données dans la table "cart"
    for ($i = 1; $i <= 10; $i++) {
        $stmt = $db->prepare("INSERT INTO cart (id_user) VALUES (?)");
        $stmt->execute([$i]);
    }

    // Insertion de données dans la table "command"
    for ($i = 1; $i <= 10; $i++) {
        $stmt = $db->prepare("INSERT INTO command (id_user) VALUES (?)");
        $stmt->execute([$i]);
    }

    // Insertion de données dans la table "invoice"
    for ($i = 1; $i <= 10; $i++) {
        $stmt = $db->prepare("INSERT INTO invoice (id_command) VALUES (?)");
        $stmt->execute([$i]);
    }

    // Insertion de données dans la table "junction" (produits dans le panier)
    // Insertion de données dans la table "junction" (produits dans le panier)
    for ($i = 1; $i <= 10; $i++) {
        for ($j = 1; $j <= 3; $j++) {
            $product_id = $faker->numberBetween(1, 10);
            
            // Vérifie si la paire id_cart et id_product existe déjà
            $checkStmt = $db->prepare("SELECT COUNT(*) FROM junction WHERE id_cart = ? AND id_product = ?");
            $checkStmt->execute([$i, $product_id]);
            $exists = $checkStmt->fetchColumn();
            
            // Si la paire n'existe pas, insère une nouvelle entrée
            if ($exists == 0) {
                $stmt = $db->prepare("INSERT INTO junction (id_cart, id_product, quantity) VALUES (?, ?, ?)");
                $stmt->execute([$i, $product_id, $faker->numberBetween(1, 5)]);
            }
        }
    }


    echo "Données insérées avec succès dans la base de données SQLite existante !";
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
