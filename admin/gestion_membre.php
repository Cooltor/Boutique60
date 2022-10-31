<?php require_once '../inc/header.inc.php'; ?>

<?php

//1-  Si l'user n'est pas admin je le redirige vers la page index de la boutique
if (!userIsAdmin()) {
    header('location:../index.php');
    exit();
}


// 3- Suppression d'un membre. Je récupère l'id du membre en GET et je fais une req DELETE
if (isset($_GET['action']) && $_GET['action'] == 'delete') {

    $pdo->query("DELETE FROM membre WHERE id_membre = '$_GET[id_membre]'");
    header('Location:gestion_membres.php');
}


// 2- Je récupère tous les membres de ma bdd que j'affiche dans une table html
$members = $pdo->query("SELECT * FROM membre");

$content .= '<table class="table table-striped"><tr>';


for ($i = 0; $i < $members->columnCount(); $i++) {

    $colone = $members->getColumnMeta($i);
    if ($colone['name'] != 'mdp' && $colone['name'] != 'statut') {
        $content .= '<th>' . $colone['name'] . '</th>';
    }
}

$content .= '<th>Detail</th>';
$content .= '<th>Delete</th>';

$content .= '</tr>';
while ($member = $members->fetch(PDO::FETCH_ASSOC)) {

    $content .= '<tr>';

    foreach ($member as $key => $value) {
        if ($key != 'mdp' && $key != 'statut') {
            $content .= "<td class=\"align-middle\">$value</td>";
        }
    }
    // Info me permet de voir les infos du membre
    // Delete  me permet de supprimer un membre
    $content .= "<td class=\"align-middle\"><a href=?action=show&id_membre=$member[id_membre]>Info</a></td>";
    $content .= "<td class=\"align-middle\"><a href=?action=delete&id_membre=$member[id_membre]>Delete</a></td>";


    $content .= '</tr>';
}

$content .= '</table>';





// 4- Affichage des infos d'un membre. Je fais une req sur l'id en GET pour récupérer les infos du membre
if (isset($_GET['action']) && $_GET['action'] == 'show') {

    $user = $pdo->query("SELECT * FROM membre WHERE id_membre = '$_GET[id_membre]'");

    $info = $user->fetch(PDO::FETCH_ASSOC);
    $content .= '<div class="container"><div class="row"><div class="col-4">';
    $content .= '<div class="card"><div class="card-body text-center">';
    $content .= "<h5 class=\"card-title\">$info[pseudo]</h5>";
    $content .= "<h6 class=\"card-subtitle mb-2 text-muted\">$info[civilite] :  $info[nom]  $info[prenom]</h6>";
    $content .= "<p class=\"card-text\">Adresse : $info[adresse]  $info[code_postal] $info[ville]</p>";
    // Je passe l'id du membre en GET dans le bouton Voir les commandes afin de pouvoir voir les commandes du membre
    $content .= "<a href=\"?action=order&id_membre=$info[id_membre]\" class=\"btn btn-primary\">Voir les commandes</a>";
    $content .= '</div></div></div></div></div>';
}




// 5 - Affichage de commandes d'un membre.
// Si dans l'url j'ai une action qui est order alors je récupère l'id du membre et je fais la req pour avoir la liste des commandes du memebre
if (isset($_GET['action']) && $_GET['action'] == 'order') {

    // j'affiche par odre décroissant sur la date
    $order = $pdo->query("SELECT id_commande,id_membre,montant,DATE_FORMAT(date_enregistrement,'%d/%m/%Y') AS date_enregistrement, DATE_FORMAT(date_enregistrement,'%H:%i%s') AS heure,etat FROM commande WHERE id_membre = '$_GET[id_membre]' ORDER BY date_enregistrement DESC");

    // Dans le cas ou le rowCount() <= 0 c'est que ce membre n'a pas encore fait de commande . Mais il a bien un compte
    if ($order->rowCount() <= 0) {
        $content .= '<div class="alert alert-warning fw-bold text-center" role="alert">Ce membre n\'a pas de commande sur le site</div>';
    } else { // Sinon je boucle sur le résulat pour afficher toutes les commandes 

        while ($orderInfo = $order->fetch(PDO::FETCH_ASSOC)) {
            $content .= '<div class="row d-flex mt-3"><div class="col-4">';
            $content .= '<div class="card"><div class="card-body text-center">';
            $content .= "<h4 class=\"card-title\">$orderInfo[id_commande]</h4>";
            $content .= "<p class=\"card-text\">Date order : $orderInfo[date_enregistrement] à $orderInfo[heure]</p>";
            $content .= "<h5 class=\"card-subtitle mb-2 text-muted\">$orderInfo[montant] €</h5>";
            $content .= "<h6 class=\"card-subtitle mb-2 text-muted\">$orderInfo[etat] </h6>";
            // Je passse en param l'id_commande afin de voir les détails de la commande 
            $content .= "<a href=\"?action=orderdetail&id_commande=$orderInfo[id_commande]\" class=\"btn btn-primary\">Order Details</a>";
            $content .= '</div>';
            $content .= '</div></div></div>';
        }
    }
}


// 6 - Affichage des détails
// Si j'ai une action qui orderdetail alors j'affiche les détails de la commande
if (isset($_GET['action']) && $_GET['action'] == 'orderdetail') {

    $orderDetail = $pdo->query("SELECT * FROM details_commande WHERE id_commande = '$_GET[id_commande]'");

    if ($orderDetail->rowCount() <= 0) {

        $content .= '<div class="alert alert-warning fw-bold text-center" role="alert">Cette commande a déjà été supprimé lors de nos tests</div>';
    }

    
    if ($orderDetail->rowCount() >= 1) {
        $details = $orderDetail->fetch(PDO::FETCH_ASSOC);

        // je récupère les détails de la commande qui est en GET
        $detailCard = $pdo->query("SELECT * FROM details_commande WHERE id_commande = '$details[id_commande]'");

        // Je récupère le montant de la commande qui correspond à l'id en GET
        $montantCmd = $pdo->query("SELECT montant FROM commande WHERE id_commande = '$details[id_commande]'");

        // Ici je fais un fetch car je sais que le montant sera unique pour une commande
        $montant = $montantCmd->fetch();

        
        // J'affiche les détails dans une table html
        $content .= '<h1 class="text-center display-4">Les détails de la commande ' . $details['id_commande'] .'</h1>';

        $content .= '<table class="table table-striped mt-5 mb-5"><tr>';

        for ($i = 0; $i < $detailCard->columnCount(); $i++) {

            $colone = $detailCard->getColumnMeta($i);

            if ($colone['name'] != 'id_commande') {// Je veux pas afficher l'id de la commande dans ma table car je l'ai déjà écris dans le h1
                $content .= '<th>' . $colone['name'] . '</th>';
            }
        }



        // Je boucle pour gérer l'affichage
        while ($row = $detailCard->fetch(PDO::FETCH_ASSOC)) {
            $content .= '<tr>';

            foreach ($row as $key => $value) {
                if ($key != 'id_commande') { //J'affiche tout sauf l'id
                    $content .= "<td class=\"align-middle\">$value</td>";
                }
            }

            $content .= '</tr>';
        }

        $content .= "<td class=\"align-middle text-center fw-bold\" colspan=\"4\">Montant total : $montant[montant]</td>";

        $content .= '</table>';
    }
}



?>






<h1 class="text-center display-4">GESTION DES MEMBRES</h1>

<?= $content; ?>




<?php require_once '../inc/footer.inc.php'; ?>