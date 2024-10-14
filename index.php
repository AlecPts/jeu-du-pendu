<?php
// Démarrage de la session
session_start();

require 'pdo.php';

// Récupération de la base de données
try {
    $stmt = $pdo->prepare("SELECT * FROM resultat_partie");
    $res = $stmt->execute();

} catch (PDOException $e) {
    die('Erreur PDO : ' . $e->getMessage());
} catch (Exception $e) {
    die('Erreur générale : ' . $e->getMessage());
}

// Confitions de changement de page
if (!empty($_POST["tf-joueur-1"]) && !empty($_POST["tf-joueur-2"])) {
    // Stockage des données dans la session
    $_SESSION["nom-j1"] = $_POST["tf-joueur-1"];
    $_SESSION["nom-j2"] = $_POST["tf-joueur-2"];

    header('Location: choix-mot.php');
    die();
}
?>

<!DOCTYPE html>
<html lang="fr">
<body>
<?php include 'header.php'; ?>

<h3>Liste des parties</h3>
<table border="1">
    <tr>
        <th>#</th>
        <th>Gagnant</th>
        <th>Perdant</th>
        <th>Mot a trouver</th>
        <th>Nombre de coups</th>
    </tr>

    <?php
    foreach ($stmt as $row) {
        echo "<tr>";
        echo "<td>" . $row['id_partie'] . "</td>";
        echo "<td>" . $row['nom_gagnant'] . "</td>";
        echo "<td>" . $row['nom_perdant'] . "</td>";
        echo "<td>" . $row['mot_trouve'] . "</td>";
        echo "<td>" . $row['nb_coups'] . "</td>";
        echo "</tr>";
    }
    ?>
</table>
<br>

<h3>Commencer une nouvelle partie</h3>
<form method="post" action="index.php" style="display: flex; flex-direction: column;">
    <label>
        Joueur 1 :
        <input type="text" name="tf-joueur-1" required></label>
    <label>
        Joueur 2 :
        <input type="text" name="tf-joueur-2" required></label>

    <input type="submit" name="bt-valider" value="Lancer la partie" style="max-width: 200px">
</form>

<?php include 'footer.php'; ?>
</body>
</html>