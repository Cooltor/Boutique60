<!-- PARTIE TRAITEMENT -->

<?php
require_once './inc/init.php';

$resultat = $pdo->query('SELECT DISTINCT categorie FROM produit');

$produits = '';




$content .= $produits;
?>


























<!-- PARTIE AFFICHAGE -->

<?php require_once './inc/header.inc.php'; ?>

<h1 class="text-center">Projet boutique</h1> 

<div class=container></div>

    <div id="categories"></div>
    <div class="col-3">
      <h2>Catégories</h2>
      <ul class="list-group">
        <?php while($categorie = $resultat->fetchAll(PDO::FETCH_ASSOC)){
            echo "
            <li class='list-group-item'>
            <a href='#'>$categorie[categorie]</a>
            </li>
            ";
        } ?>

      </ul>
    </div>

    <div id="produits"></div>


</div>


<?php require_once './inc/footer.inc.php'; ?>















