<?php

require_once   './inc/init.php' ;



if(isset($_POST['ajout_panier'])) {
    
    $req=$pdo->query("SELECT * FROM produit WHERE id_produit = '$_POST[id_produit]'");

    $produit = $req->fetch(PDO::FETCH_ASSOC);

    $id_produit = $produit['id_produit'];
    $quantite = $_POST['quantite'];
    $prix = $produit['prix'];


    ajoutProduit($id_produit, $quantite, $prix);

   
}

if(isset($_POST['payer'])){
    for($i=0; $i < count($_SESSION['panier']['id_produit']);$i++){
        // je fais une requête pour récupérer les datas des produits qui sont dans ma session
        $r = $pdo->query("SELECT * FROM produit WHERE id_produit = '".$_SESSION['panier']['id_produit'][$i]."' ");

        $data = $r->fetch(PDO::FETCH_ASSOC);

        // var_dump($data['stock']);

        // Si la quantité est inférieure à ce que j'ai en stock, alors on aura 2 cas possible :
        if($data['stock'] < $_SESSION['panier']['quantite'][$i]){

            if($data['stock']>0){// Si la quantité disponible est supérieure à 0 mais inférieure à ce que l'user demande

                $_SESSION['panier']['quantite'][$i] = $data['stock'];

            }else{// Sinon le produit n'est plus disponible

                $content = "Le produit demandé n'est plus en stock";
                retirerProduit($_SESSION['panier']['id_produit'][$i]);

                $i--;// Je refais un tour de panier afin de m'assurer que tout est ok avant la validation
            }

            // je déclare une variable s'il y'a un problème sur le stock
            $error = true;
        }
    }

    // S'il n'y a pas de problème sur le stock
    if(!isset($error)){

        $pdo->query("INSERT INTO commande(id_membre, montant, date_enregistrement, etat) VALUES ('".$_SESSION['membre']['id_membre']."','".montantTotal()."', NOW(), 'en cours de traitement' ) ");

        for($i=0; $i < count($_SESSION['panier']['id_produit']);$i++){

            $pdo->query("INSERT INTO details_commande(id_commande, id_produit, quantite, prix) VALUES ('".$pdo->lastInsertId()."','".$_SESSION['panier']['id_produit'][$i]."','".$_SESSION['panier']['quantite'][$i]."','".$_SESSION['panier']['prix'][$i]."' ) ");

            $pdo->query("UPDATE produit SET stock = stock - '".$_SESSION['panier']['quantite'][$i]."' WHERE id_produit = '".$_SESSION['panier']['id_produit'][$i]."' ");
        }


    }


}


$content.= '<div class="container text-center">';
$content.= '<table class="table table-hover">';
$content.= '<thread><tr><th scope="col">id produit</th><th scope="col">Quantité</th><th scope="col">Prix</th></tr></thread>';

if(empty($_SESSION['panier']['id_produit'])) {
    $content.= '<tr><td colspan="3">Votre panier est vide</td></tr>';
} else {
    for($i = 0; $i < count($_SESSION['panier']['id_produit']); $i++) {
        $content.= '<tr>';
        $content.= '<td>' . $_SESSION['panier']['id_produit'][$i] . '</td>';
        $content.= '<td>' . $_SESSION['panier']['quantite'][$i] . '</td>';
        $content.= '<td>' . $_SESSION['panier']['prix'][$i] . '</td>';
        $content.= '</tr>';
    }

    $content.= '<tr><td colspan="3">Montant total : ' . montantTotal() . '</td></tr>';

    if(!userConnected()){
        $content .= '<div class="alert alert-light" role="alert">Veuillez vous connecter ou vous inscrire </div>';
    }else{
        $content .= '<form action="" method="POST">';
        $content .= '<tr><td colspan="3"><input type="submit" name="payer" value="Valider le panier" class="btn btn-success btn-lg"></td></tr>';
        $content .= '</form>';
    
    }
}


$content.= '</table>';
$content .= '</div>';
?>

<?php require_once './inc/header.inc.php'; ?>

<h1 class="text-center text-muted">Panier</h1>
<?php echo $content; ?>
<?php require_once './inc/footer.inc.php'; ?>





















