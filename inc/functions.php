<?php



function userConnected() {
    if (isset($_SESSION['membre'])) {
        return true;
    } else {
        return false;
    }
}

function userIsAdmin() {
    if (userConnected() && $_SESSION['membre']['statut'] === 1) {
        return true;
    } else {
        return false;
    }
}

function creation_panier() {
    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = array();
        
        $_SESSION['panier']['id_produit'] = array();
        $_SESSION['panier']['quantite'] = array();
        $_SESSION['panier']['prix'] = array();
    }
}

function    ajoutProduit($id_produit, $quantite, $prix) {
    creation_panier();
    
    $position = array_search($id_produit, $_SESSION['panier']['id_produit']);
    
    if ($position !== false) {
        $_SESSION['panier']['quantite'][$position] += $quantite;
    } else {
        $_SESSION['panier']['id_produit'][] = $id_produit;
        $_SESSION['panier']['quantite'][] = $quantite;
        $_SESSION['panier']['prix'][] = $prix;
    }
}
function montantTotal() {
    $total = 0;
    
    for($i = 0; $i < count($_SESSION['panier']['id_produit']); $i++) {
        $total += $_SESSION['panier']['quantite'][$i] * $_SESSION['panier']['prix'][$i];
    }
    
    return round($total, 2);
}

function retirerProduit($id_produit) {
    $position = array_search($id_produit, $_SESSION['panier']['id_produit']);
    
    if ($position !== false) {
        array_splice($_SESSION['panier']['id_produit'], $position, 1);
        array_splice($_SESSION['panier']['quantite'], $position, 1);
        array_splice($_SESSION['panier']['prix'], $position, 1);
    }
}
?>

