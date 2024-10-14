<?php
session_start();

// Démarrage de la session
session_destroy();

require 'pdo.php';
include 'header.php';

// Affichage du résultat et insertion du résultat dans la BD
try {
    $stmt = $pdo->prepare(
        "INSERT INTO resultat_partie (resultat, nom_gagnant, nom_perdant, mot_trouve, nb_coups) VALUES (?, ?, ?, ?, ?)");
    $stmt->bindParam(1, $resultat);
    $stmt->bindParam(2, $nom_gagnant);
    $stmt->bindParam(3, $nom_perdant);
    $stmt->bindParam(4, $mot_trouve);
    $stmt->bindParam(5, $nb_coups);

    if ($_SESSION['a_gagne']) {
        echo "<h1>Gagné !</h1>";

        $resultat = "Victoire";
        $nom_gagnant = $_SESSION['nom-j2'];
        $nom_perdant = $_SESSION['nom-j1'];
    } else {
        echo "<h1>Perdu</h1>";

        $resultat = "Défaite";
        $nom_gagnant = $_SESSION['nom-j1'];
        $nom_perdant = $_SESSION['nom-j2'];
    }
    $mot_trouve = $_SESSION['mot-trouve'];
    $nb_coups = $_SESSION['nb-coups'];

    $stmt->execute();

    $pdo = null;

} catch (PDOException $e) {
    die('Erreur PDO : ' . $e->getMessage());
} catch (Exception $e) {
    die('Erreur générale : ' . $e->getMessage());
}

include 'footer.php';

