<?php require_once '../inc/header.inc.php'; ?>


<h1 class="text-center">Dashboard</h1> 

<?php
if(!userIsAdmin()){
    header('location:../connexion.php');
    exit();
}
?>
<?php require_once '../inc/footer.inc.php'; ?>





<!-- AFFICHAGE -->

<div class="container">
    <div class="row justify-content-center">
        <div class="col-10 text-center"></div>
        <ul class="list-group">
            <li class="list-group-item m-2 border"><a href="products.php">Gestion des produits</a></li>
            <li class="list-group-item m-2 border"><a href="gestion_commandes.php">Gestion des commandes</a></li>
            <li class="list-group-item m-2 border"><a href="gestion_membre.php">Gestion des membres</a></li>
        </ul>
        </div>
    </div>
</div>