<!-- PARTIE TRAITEMENT -->

<?php


require_once './inc/init.php';



$req = $pdo->query('SELECT * FROM membre WHERE pseudo = "$_POST[pseudo]"');
$user = $req->fetch(PDO::FETCH_ASSOC);
$profil = '';

$_SESSION["newsession"]=$user;

$profil .= "<div>" . 'Votre pseudo : ' . ($user['pseudo']) . "</div>" . 
                        "<div>" . 'Votre nom : ' . ($user['nom']) . "</div>" .
                        "<div>" . 'Votre prénom : ' . ($user['prenom']) . "</div>" .
                        "<div>" . 'Votre email : ' . ($user['email']) . "</div>" .
                        "<div>" . 'Votre civilité : ' . ($user['civilite']) . "</div>" .
                        "<div>" . 'Votre ville : ' . ($user['ville']) . "</div>" .
                        "<div>" . 'Votre code postal : ' . ($user['code_postal']) . "</div>" .
                        "<div>" . 'Votre adresse : ' . ($user['adresse']) . "</div>" ;

                        $content .= $profil;
?>















<?php require_once './inc/header2.inc.php'; ?>


<h1 class="text-center">PROFIL</h1>

<?php echo $content; ?>

<?php require_once './inc/footer.inc.php'; ?>