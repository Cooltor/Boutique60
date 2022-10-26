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
}


$content.= '</table>';
$content .= '</div>';
?>

<?php require_once './inc/header.inc.php'; ?>

<h1 class="text-center text-muted">Panier</h1>
<?php echo $content; ?>
<?php require_once './inc/footer.inc.php'; ?>





















