<!-- PARTIE TRAITEMENT -->

<?php


require_once './inc/init.php';

if(!userConnected())
{
    header('location:connexion.php');
}

if(userIsAdmin())
{
    $content .='<div class="alert alert-secondary" role="alert">
        Bonjour Le Boss !
        </div>';
}

$resultat = $pdo->query('SELECT * FROM membre WHERE pseudo = "$pseudo"');
$membre = $resultat->fetch(PDO::FETCH_ASSOC);
$profil = '';



$profil .= '<div class="text-center">' . 'Votre pseudo : ' . $_SESSION['membre']['pseudo'] . "</div>" . 
                        '<div class="text-center">' . 'Votre nom : ' . $_SESSION['membre']['nom'] . "</div>" .
                        '<div class="text-center">' . 'Votre prénom : ' .  $_SESSION['membre']['prenom'] . "</div>" .
                        '<div class="text-center">' . 'Votre email : ' . $_SESSION['membre']['email']  . "</div>" .
                        '<div class="text-center">' . 'Votre civilité : ' . $_SESSION['membre']['civilite'] . "</div>" .
                        '<div class="text-center">' . 'Votre ville : ' . $_SESSION['membre']['ville'] . "</div>" .
                        '<div class="text-center">' . 'Votre code postal : ' .$_SESSION['membre']['code_postal'] . "</div>" .
                        '<div class="text-center">' . 'Votre adresse : ' . $_SESSION['membre']['adresse'] . "</div>" ;

                        $content .= $profil;



















    require_once './inc/header.inc.php';

?>

<h1 class="text-center">PROFIL</h1>

<?php echo $content; ?>

<?php require_once './inc/footer.inc.php'; ?>