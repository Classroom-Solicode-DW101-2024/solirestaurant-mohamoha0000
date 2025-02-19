<?php
$boxs = "";
require("config.php");
if(isset($_POST["search"]) && (!empty($_POST["type_s"]) || !empty($_POST["categorie_s"]))){
    $type_s = $_POST["type_s"];
    $categorie_s = $_POST["categorie_s"];
    if(!empty($type_s) && !empty($categorie_s)){
        $sql = "SELECT * FROM plat WHERE TypeCuisine = :type_s AND categoriePlat = :categorie_s";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':type_s', $type_s);
        $stmt->bindParam(':categorie_s', $categorie_s);
    }else if(!empty($type_s)){
        $sql = "SELECT * FROM plat WHERE TypeCuisine = :type_s";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':type_s', $type_s);
    }else{
        $sql = "SELECT * FROM plat WHERE categoriePlat = :categorie_s";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':categorie_s', $categorie_s);
    }
    $stmt->execute();
}else{
    $sql = "SELECT * FROM plat";
    $stmt = $pdo->query($sql);
}
/********** */
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$rowstype = [];
if (count($rows)>0){

    foreach ($rows as $row) {
        $rowstype[$row["TypeCuisine"]][] = $row;
    }
    foreach ($rowstype as $typec => $rowc) {
        $boxs .= "<section class='type-cuisine'>";
        $boxs .= "<h1 class='type-title'>" . $typec . "</h1>";
        $boxs .= "<div class='plats-container'>";
        foreach ($rowc as $row) {
            $boxs .= "<div class='box'>";
            $boxs .= "<img src='" . $row['image'] . "' alt='" . $row['nomPlat'] . "' class='plat-image'>";
            $boxs .= "<h2 class='plat-title'>" . $row['nomPlat'] . "</h2>";
            $boxs .= "<p class='plat-category'>" . $row['categoriePlat'] . "</p>";
            $boxs .= "<h2 class='plat-price'>" . $row['prix'] . " MAD</h2>";
            $boxs .= "<button class='btn commander-btn'>Commander</button>";
            $boxs .= "</div>";
        }
        $boxs .= "</div>";
        $boxs .= "</section>";
    }
}else{
    $boxs .= "<center><p class='no-plat'>Aucun plat disponible</p></center>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restorant</title>
    <link rel="stylesheet" href="style.css?v=1">
</head>
<body>
    <header>
        <h1 class="main-title">Restaurant</h1>
        <form method="POST">
            <select name="type_s" id="type_s">
                <option value="">Tous les types</option>
                <option value="Marocaine">Marocaine</option>
                <option value="Italienne">Italienne</option>
                <option value="Chinoise">Chinoise</option>
                <option value="Espagnole">Espagnole</option>
                <option value="Francaise">Francaise</option>
            </select>
            <select name="categorie_s" id="categorie_s">
                <option value="">Tous les categories</option>
                <option value="plat principal">plat principal</option>
                <option value="dessert">dessert</option>
                <option value="entrée">entrée</option>
           </select>
           <button name="search" >search</button>
        </form>
        
    </header>
    <main>
        <?= $boxs ?>
    </main>
    <script>
        document.getElementById("type_s").value="<?php echo $type_s; ?>";
        document.getElementById("categorie_s").value="<?php echo $categorie_s; ?>";
    </script>
</body>
</html>
