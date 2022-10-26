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

if (isset($_POST['payer'])) {
    for ($i = 0; $u < count($_SESSION['panier']['id_produit']); $i++) {
        $req = $pdo->query("SELECT * FROM produit WHERE id_produit = '". $_SESSION['panier']['id_produit'][$i]."'");

        $data = $req->fetch(PDO::FETCH_ASSOC);

        if($data['stock'] < $_SESSION['panier']['quantite'][$i]) {
            
            if($data['stock'] > 0) {
                $_SESSION['panier']['quantite'][$i] = $data['stock'];
                $msg .= '<div class="alert alert-danger">Le produit '. $data['titre'] .' n\'est plus en stock en entier, la quantité a été modifiée.</div>';
            } else {
                retirerProduit($_SESSION['panier']['id_produit'][$i]);
                $msg .= '<div class="alert alert-danger">Le produit '. $data['titre'] .' n\'est plus en stock, il a été retiré du panier.</div>';
            }
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





















