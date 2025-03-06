<?php

require "config.php";

// Update order status
if (isset($_POST['update_status'])) {
    $idCmd = $_POST['idCmd'];
    $newStatus = $_POST['status'];
    $stmt = $pdo->prepare("UPDATE commande SET Statut = :status WHERE idCmd = :idCmd");
    $stmt->execute(['status' => $newStatus, 'idCmd' => $idCmd]);
    $updateMessage = "Statut de la commande {$idCmd} mis à jour avec succès!";
}

// Get filter from POST or default to 'today'
$filter = isset($_POST['filter']) ? $_POST['filter'] : 'today';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gestion des Commandes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }
        h1 {
            color: #ff6200;
            border-bottom: 2px solid #ff6200;
            padding-bottom: 10px;
        }
        h2, h3 {
            color: #ff6200;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 25px;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        th {
            background-color: #ff6200;
            color: white;
            padding: 12px;
        }
        td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        tr:nth-child(even) {
            background-color: #fff3e6;
        }
        select, input[type="submit"] {
            padding: 5px;
            border: 1px solid #ff6200;
            border-radius: 4px;
            margin: 5px;
        }
        input[type="submit"] {
            background-color: #ff6200;
            color: white;
            border: none;
            padding: 6px 12px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #e55a00;
        }
        .success-message {
            color: #ff6200;
            background-color: #fff3e6;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <h1>Gestion des Commandes</h1>
    
    <?php if (isset($updateMessage)) { ?>
        <div class="success-message"><?php echo $updateMessage; ?></div>
    <?php } ?>

    <!-- Filter Form -->
    <form method="post">
        <label for="filter">Afficher les commandes :</label>
        <select name="filter" onchange="this.form.submit()">
            <option value="today" <?php echo $filter == 'today' ? 'selected' : ''; ?>>Aujourd'hui</option>
            <option value="week" <?php echo $filter == 'week' ? 'selected' : ''; ?>>Cette semaine</option>
            <option value="all" <?php echo $filter == 'all' ? 'selected' : ''; ?>>Toutes</option>
        </select>
    </form>

    <!-- Orders Display -->
    <h2>
        <?php 
        echo $filter == 'today' ? "Commandes du jour (" . date('Y-m-d') . ")" :
             ($filter == 'week' ? "Commandes de la semaine" : "Toutes les commandes");
        ?>
    </h2>
    <?php
    $sql = "SELECT c.*, cl.nomCl, cl.prenomCl FROM commande c JOIN client cl ON c.idCl = cl.idClient";
    $params = [];

    if ($filter == 'today') {
        $sql .= " WHERE DATE(c.dateCmd) = :date";
        $params['date'] = date('Y-m-d');
    } elseif ($filter == 'week') {
        $sql .= " WHERE YEARWEEK(c.dateCmd) = YEARWEEK(NOW())";
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($orders) > 0) {
        echo "<table>
            <tr>
                <th>ID Commande</th>
                <th>Date</th>
                <th>Client</th>
                <th>Statut</th>
                <th>Mettre à jour le statut</th>
            </tr>";
        
        foreach ($orders as $row) {
            echo "<tr>
                <td>{$row['idCmd']}</td>
                <td>{$row['dateCmd']}</td>
                <td>{$row['nomCl']} {$row['prenomCl']}</td>
                <td>{$row['Statut']}</td>
                <td>
                    <form method='post'>
                        <input type='hidden' name='idCmd' value='{$row['idCmd']}'>
                        <input type='hidden' name='filter' value='$filter'>
                        <select name='status'>
                            <option value='en attente'" . ($row['Statut'] == 'en attente' ? ' selected' : '') . ">En attente</option>
                            <option value='en cours'" . ($row['Statut'] == 'en cours' ? ' selected' : '') . ">En cours</option>
                            <option value='expédiée'" . ($row['Statut'] == 'expédiée' ? ' selected' : '') . ">Expédiée</option>
                            <option value='livrée'" . ($row['Statut'] == 'livrée' ? ' selected' : '') . ">Livrée</option>
                            <option value='annulée'" . ($row['Statut'] == 'annulée' ? ' selected' : '') . ">Annulée</option>
                        </select>
                        <input type='submit' name='update_status' value='Mettre à jour'>
                    </form>
                </td>
            </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Aucune commande pour cette période</p>";
    }
    ?>

    <!-- Statistics -->
    <h2>Statistiques</h2>
    <?php
    $totalCmd = $pdo->query("SELECT COUNT(*) FROM commande")->fetchColumn();
    $totalClients = $pdo->query("SELECT COUNT(*) FROM client")->fetchColumn();
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM commande WHERE Statut = 'annulée'");
    $stmt->execute();
    $totalCanceled = $stmt->fetchColumn();

    $sql_plats = "SELECT p.nomPlat, SUM(cp.qte) as quantite 
                  FROM commande_plat cp 
                  JOIN plat p ON cp.idPlat = p.idPlat 
                  JOIN commande c ON cp.idCmd = c.idCmd";
    $params_plats = [];
    
    if ($filter == 'today') {
        $sql_plats .= " WHERE DATE(c.dateCmd) = :date";
        $params_plats['date'] = date('Y-m-d');
    } elseif ($filter == 'week') {
        $sql_plats .= " WHERE YEARWEEK(c.dateCmd) = YEARWEEK(NOW())";
    }
    
    $sql_plats .= " GROUP BY p.idPlat, p.nomPlat";
    $stmt = $pdo->prepare($sql_plats);
    $stmt->execute($params_plats);
    $plats = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <table>
        <tr><th>Nombre total de commandes</th><td><?php echo $totalCmd; ?></td></tr>
        <tr><th>Nombre total de clients</th><td><?php echo $totalClients; ?></td></tr>
        <tr><th>Nombre de commandes annulées</th><td><?php echo $totalCanceled; ?></td></tr>
    </table>

    <h3>Plats commandés <?php echo $filter == 'today' ? "aujourd'hui" : ($filter == 'week' ? "cette semaine" : "au total"); ?></h3>
    <?php
    if (count($plats) > 0) {
        echo "<table>
            <tr>
                <th>Plat</th>
                <th>Quantité</th>
            </tr>";
        foreach ($plats as $row) {
            echo "<tr>
                <td>{$row['nomPlat']}</td>
                <td>{$row['quantite']}</td>
            </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Aucun plat commandé pour cette période</p>";
    }
    ?>
</body>
</html>