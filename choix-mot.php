<?php
session_start();

$ex_dico = null;

if (!empty($_POST['tf-choix-mot']) && !empty($_POST['nb-coups-max'])) {
    $_SESSION['mot-trouve'] = trim($_POST['tf-choix-mot']);
    $_SESSION['nb-coups'] = $_POST['nb-coups-max'];

    try {
        if (!dansDico()) {
            throw new Exception("Le mot choisi n'existe pas !");
        }

        // Initialisation d'un tableau contenant chaque lettre du mot
        $_SESSION['tab_lettres'] = [];

        // Initialisation d'un tableau des lettres déjà choisies par le joueur
        $_SESSION['tab_lettres_choisies'] = [];

        foreach (str_split($_SESSION['mot-trouve']) as $lettre) {
            if ($lettre == " ") {
                $_SESSION['tab_lettres'][] = [
                    'lettre' => $lettre,
                    'trouve' => true
                ];
            } else {
                $_SESSION['tab_lettres'][] = [
                    'lettre' => $lettre,
                    'trouve' => false
                ];
            }
        }

        header('Location: jeu.php');
        die();

    } catch (Exception $e) {
        $ex_dico = $e->getMessage();
    }
}

function dansDico(): bool
{
    $fdico = fopen('dico-frgut.txt', 'r');
    if ($fdico) {
        while (($ligne = fgets($fdico)) !== false) {
            if (trim($ligne) == $_SESSION['mot-trouve']) {
                return true;
            }
        }
        fclose($fdico);
    }
    return false;
}

?>

<!doctype html>
<html lang=fr>
<body>

<?php include 'header.php'; ?>

<h4><?php echo $_SESSION['nom-j1'] ?> choisis ton mot !</h4>
<form method="post" action="choix-mot.php" style="display: flex; flex-direction: column;">
    <label>
        Choix du mot :
        <input type="text" name="tf-choix-mot" required></label>
    <label>
        Nombre de coups max :
        <input type="number" name="nb-coups-max" min="0" max="100" required></label>

    <input type="submit" name="bt-valider" value="Valider" style="max-width: 200px">
</form>

<p style="color: red;"><?php echo $ex_dico; ?></p>

<?php include 'footer.php'; ?>

</body>
</html>
