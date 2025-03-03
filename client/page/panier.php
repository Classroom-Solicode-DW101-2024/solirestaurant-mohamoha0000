<?php
// page/panier.php
require("config.php");

if(!isset($_SESSION["client"])) {
    header("Location:login.php");
}

// Initialize plats if not set
if(!isset($_SESSION["plats"])) {
    $_SESSION["plats"] = [];
}

// Handle quantity modifications and removal
if(isset($_GET["action"]) && isset($_GET["id"])) {
    $id = $_GET["id"];
    switch($_GET["action"]) {
        case "remove":
            unset($_SESSION["plats"][$id]);
            break;
        case "increase":
            $_SESSION["plats"][$id]++;
            break;
        case "decrease":
            if($_SESSION["plats"][$id]==1) {
               unset($_SESSION["plats"][$id]);
            }else{
                $_SESSION["plats"][$id]--;
            }
            break;
    }
    header("Location:panier.php#$id");
    exit();
}

// Fetch plat details from database
$plats_content = "";
$total_price = 0;

if(count($_SESSION["plats"]) > 0) {
    // Get unique plat IDs and their quantities
    $plat_counts = $_SESSION["plats"];
    
    // Prepare SQL to fetch all selected plats
    $placeholders = implode(',', array_fill(0, count(array_keys($plat_counts)), '?'));
    $sql = "SELECT * FROM plat WHERE idPlat IN ($placeholders)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array_keys($plat_counts));
    $plats = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Generate cart content
    $plats_content .= "<div class='cart-items'>";
    foreach($plats as $plat) {
        $quantity = $plat_counts[$plat["idPlat"]];
        $subtotal = $plat["prix"] * $quantity;
        $total_price += $subtotal;
        
        $plats_content .= "<div id='{$plat['idPlat']}' class='cart-item'>";
        $plats_content .= "<img src='{$plat['image']}' alt='{$plat['nomPlat']}' class='cart-image'>";
        $plats_content .= "<div class='cart-details'>";
        $plats_content .= "<h2>{$plat['nomPlat']}</h2>";
        $plats_content .= "<p>Catégorie: {$plat['categoriePlat']}</p>";
        $plats_content .= "<p>Prix unitaire: {$plat['prix']} MAD</p>";
        $plats_content .= "<div class='quantity-controls'>";
        $plats_content .= "<a href='panier.php?action=decrease&id={$plat['idPlat']}' class='qty-btn'>-</a>";
        $plats_content .= "<span class='quantity'>{$quantity}</span>";
        $plats_content .= "<a href='panier.php?action=increase&id={$plat['idPlat']}' class='qty-btn'>+</a>";
        $plats_content .= "</div>";
        $plats_content .= "<p>Sous-total: {$subtotal} MAD</p>";
        $plats_content .= "<a href='panier.php?action=remove&id={$plat['idPlat']}' class='remove-btn'>Supprimer</a>";
        $plats_content .= "</div>";
        $plats_content .= "</div>";
    }
    $plats_content .= "</div>";
    $plats_content .= "<div class='cart-total'>";
    $plats_content .= "<h2>Total: {$total_price} MAD</h2>";
    $plats_content .= "<button class='checkout-btn'>Passer la commande</button>";
    $plats_content .= "</div>";
} else {
    $plats_content = "<p class='empty-cart'>Votre panier est vide</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier - Restaurant</title>
    <link rel="stylesheet" href="../style.css?v=2">
    <style>
        .cart-items {
            max-width: 800px;
            margin: 20px auto;
        }
        .cart-item {
            display: flex;
            margin: 20px 0;
            border-bottom: 1px solid #ddd;
            padding-bottom: 20px;
        }
        .cart-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin-right: 20px;
        }
        .cart-details {
            flex-grow: 1;
        }
        .quantity-controls {
            margin: 10px 0;
        }
        .qty-btn {
            padding: 5px 10px;
            background: #ddd;
            text-decoration: none;
            color: #333;
            margin: 0 5px;
        }
        .quantity {
            padding: 0 10px;
        }
        .remove-btn {
            color: #fff;
            background: #ff4444;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
        }
        .cart-total {
            text-align: right;
            margin: 20px;
        }
        .checkout-btn {
            padding: 10px 20px;
            background: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .empty-cart {
            text-align: center;
            padding: 50px;
        }
    </style>
</head>
<body>
    <header>
        <a href="../index.php"><h1 class="main-title">Restaurant</h1></a>
        <div>
            <a href="../index.php?login=out"><button>log out</button></a>
            <a href="panier.php"><img src="../img/panie.png" alt="Panier" width="50px" height="50px"></a>
            <span><?= count($_SESSION["plats"]) ?></span>
        </div>
    </header>
    <main>
        <h1>Votre Panier</h1>
        <?= $plats_content ?>
    </main>
</body>
</html>