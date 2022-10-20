<?php require_once '../inc/header.inc.php'; 



if(!userIsAdmin()){
    header('location:../connexion.php');
    exit();
}




if($_POST){
    
    if (!empty($_POST['photo'])) {
        
        $pdo->query("INSERT INTO produit(reference, categorie, titre, description, couleur, taille, public, photo, prix,stock) VALUES('$_POST[reference]','$_POST[categorie]','$_POST[titre]','$_POST[description]','$_POST[couleur]','$_POST[taille]','$_POST[public]','$_POST[photo]','$_POST[prix]','$_POST[stock]')");
        
        if(!empty($_FILES['photo']['name'])){
            
        }
        else
    }
    else {

        $photoDefaut = '../photo/tshirt.jpg'; 
        $pdo->query("INSERT INTO produit(reference, categorie, titre, description, couleur, taille, public, photo, prix,stock) VALUES('$_POST[reference]','$_POST[categorie]','$_POST[titre]','$_POST[description]','$_POST[couleur]','$_POST[taille]','$_POST[public]','$photoDefaut','$_POST[prix]','$_POST[stock]')");

    }
}

?>
<?php require_once '../inc/footer.inc.php'; ?>


<h1 class="text-center">Gestion des produits</h1> 

<form  action="" method="POST" enctype="multipart/form-data" class="vh-100 gradient-custom">
<div class="container py-5 h-100">
    <div class="row justify-content-center align-items-center h-100">
        <div class="col-12 col-lg-9 col-xl-7">
        <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
            <div class="card-body p-4 p-md-5">
            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Enregistrer un produit</h3>
            <?php  $content; ?>
            <form>

            <div class="row">
                <div class="col-md-6 mb-4">

                <div class="form-outline">
                    <input type="text" id="reference" class="form-control form-control-lg" name="reference"/>
                    <label class="form-label" for="reference">Référence</label>
                </div>

                </div>
                <div class="col-md-6 mb-4">

                <div class="form-outline">
                    <input type="text" id="categorie" class="form-control form-control-lg" name="categorie" />
                    <label class="form-label" for="categorie">Catégorie</label>
                </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                <div class="form-outline">
                    <input type="text" class="form-control" id="titre" name="titre">
                    <label for="titre" class="form-label">Titre</label>
                </div>

                </div>
                <div class="col-md-6 mb-4">
                <div class="form-outline">
                    <input type="textarea" class="form-control" id="description" name="description">
                    <label for="description" class="form-label">Description</label>
                </div>
                
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                <div class="form-outline">
                    <select type="form-select" class="form-control" id="couleur" name="couleur">
                        <option value="">Rouge</option>
                        <option value="">Bleu</option>
                        <option value="">Vert</option>
                        <option value="">Noir</option>
                        <option value="">Blanc</option>
                        <option value="">Quadricolor</option>
                    </select>

                    <label for="couleur" class="form-label">Couleur</label>
                </div>

                </div>
                <div class="col-md-6 mb-4">
                <div class="form-outline">
                    <select type="form-select" class="form-control" id="taille" name="taille">
                        <option value="">XS</option>
                        <option value="">S</option>
                        <option value="">M</option>
                        <option value="">L</option>
                        <option value="">XL</option>
                        <option value="">XXL</option>
                        </select>
                    <label for="taille" class="form-label">Taille</label>
                </div>
                
                </div>
            </div>

            <div class="row">
                
                <div class="col-md-6 mb-4">

                    <h6 class="mb-2 pb-1">Genre</h6>

                    <div class="form-check form-check-inline">
                    <input type="radio" name="public" id="public" value="m" checked>
                    Homme
                    <input type="radio" name="public" id="public" value="f" checked>
                    Femme
                    <input type="radio" name="public" id="public" value="f" checked>
                    Mixte
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4 pb-2">

                    <div class="form-outline">
                        <input type="file" id="photo" class="form-control form-control-lg" name="photo" />
                        <label class="form-label" for="photo">Photo</label>
                    </div>

                </div>
                
                </div>

                <div class="row">
                <div class="col-md-6 mb-4 pb-2">

                <div class="form-outline">
                    <input type="text" id="prix" class="form-control form-control-lg" name="prix" />
                    <label class="form-label" for="prix">Prix</label>
                </div>

                </div>
                <div class="col-md-6 mb-4 pb-2">

                <div class="form-outline">
                    <input type="text" id="stock" class="form-control form-control-lg" name="stock" />
                    <label class="form-label" for="stock">Stock</label>
                </div>
                </div>
                </div>

            <div class="mt-4 pt-2">
                <input class="btn btn-primary btn-lg" type="submit" value="Valider" />
            </div>

            </form>
        </div>
        </div>
    </div>
    </div>
</div>
</form>
