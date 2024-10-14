<?php
// Démarrage de la session
session_start();

$deja_trouve = false;
$nb_coups = $_SESSION['nb-coups'];
$faute = true;
$_SESSION['a_gagne'] = true;

if (!empty($_POST['tf-reponse-lettre'])) {
    $reponse_lettre = $_POST['tf-reponse-lettre'];

    // Ajout de la lettre choisie au tableau des lettres choisies
    if (!in_array($reponse_lettre, $_SESSION['tab_lettres_choisies'])) {
        $_SESSION['tab_lettres_choisies'][] = $reponse_lettre;
    } else {
        $deja_trouve = true;
    }

    // Validation du choix de la lettre choisie
    foreach ($_SESSION['tab_lettres'] as $index => $elt) {
        if (strtoupper($elt['lettre']) == strtoupper($reponse_lettre)) {
            $_SESSION['tab_lettres'][$index]['trouve'] = true;
            $faute = false;
        }

        if (!$_SESSION['tab_lettres'][$index]['trouve']) {
            $_SESSION['a_gagne'] = false;
        }
    }

    // Test si le joueur remplit les conditions de victoire
    if ($_SESSION['a_gagne'] || $_SESSION['nb-coups'] === 0) {
        header('Location: fin-partie.php');
    }

    // Décrementation si le lettre choisie n'est pas contenu dans le mot choisi
    if ($faute) {
        $_SESSION['nb-coups']--;
    }
}
?>

<!doctype html>
<html lang="fr">
<body>
<?php include('header.php'); ?>

<form method="post" action="jeu.php">
    <label>
        Choix de la lettre :
        <input type="text" name="tf-reponse-lettre" required></label>

    <input type="submit" name="bt-valider" value="Valider" style="max-width: 200px">
</form>
<br>
<div>
    <?php
    foreach ($_SESSION['tab_lettres'] as $elt) {
        if (!($elt['lettre'] == " ")) {
            if ($elt['trouve']) {
                echo $elt['lettre'] . " ";
            } else {
                echo "_ ";
            }
        } else {
            echo str_repeat('&nbsp;', 3);
        }
    }
    ?>
</div>
<br>
<div>
    Nombre de coups restants :
    <?php echo $_SESSION['nb-coups']; ?>
</div>

<div>
    Lettres déjà choisies :
    <?php
    foreach ($_SESSION['tab_lettres_choisies'] as $elt) {
        echo $elt;
    }
    ?>
</div>

<div>
    <?php
    if ($deja_trouve) {
        echo '<p style="color: red;">Tu as déjà choisi cette lettre !</p>';
    }
    ?>
</div>

<?php include('footer.php'); ?>
</body>
</html>





