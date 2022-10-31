<?php require_once '../inc/header.inc.php'; 



if(!userIsAdmin()){
    header('location:../connexion.php');
    exit();
}

if($_POST)
{   
    
    foreach($_POST as $key => $value)
    {
        $_POST[$key] = htmlspecialchars(addslashes($value));
    }
    if(!empty($_FILES['photo']))
    {
        $nom_img = time() . '' . $POST['reference'] . '' . $_FILES['photo']['name'];
        
        $img_doc = RACINE . "photo/$nom_img";
        $img_bdd = URL . "photo/$nom_img";

        if($_FILES['photo']['size'] <= 8000000)
        {
            $data = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
            

            $tab = ['jpg', 'png', 'jpeg', 'gif', 'JPG', 'PNG', 'JPEG', 'GIF', 'Jpg', 'Png', 'Jpeg', 'Gif'];

            if(in_array($data, $tab))
            {
                move_uploaded_file($_FILES['photo']['tmp_name'], $img_doc);
            } else {
                $content .='<div class="alert alert-danger" role="alert">
                Format non autorisé 
                </div>';
            } 
        } else {
            $content .='<div class="alert alert-danger" role="alert">
            Vérifier la taille de votre image
            </div>';
        }
        $rep= $pdo->query("INSERT INTO produit (reference, categorie, titre, description, couleur, taille, public, photo, prix, stock) VALUES ('$_POST[reference]', '$_POST[categorie]', '$_POST[titre]', '$_POST[description]', '$_POST[couleur]', '$_POST[taille]', '$_POST[public]', '$img_bdd', '$_POST[prix]', '$_POST[stock]')");

    }
    
    $rep= $pdo->query("INSERT INTO produit (reference, categorie, titre, description, couleur, taille, public, photo, prix, stock) VALUES ('$_POST[reference]', '$_POST[categorie]', '$_POST[titre]', '$_POST[description]', '$_POST[couleur]', '$_POST[taille]', '$_POST[public]', '$img_bdd', '$_POST[prix]', '$_POST[stock]')");
}



if(isset($_GET['action']) && $_GET['action'] == 'supprimer')
{
    $pdo->query("DELETE FROM produit WHERE id_produit = '$_GET[id_produit]'");
    header ('location:products.php');
    $content .= '<div class="alert alert-success" role="alert">
    Le produit a bien été supprimé
    </div>';
}







$res = $pdo->query("SELECT * FROM produit");

echo '<table class=" table table-striped" border=\'2\'><tr>';

for($i = 0; $i < $res->columnCount(); $i++)
{
    $colonne = $res->getColumnMeta($i);
    echo "<th>".$colonne['name']."</th>";
}

echo "<th>Modifier</th>";
echo "<th>Supprimer</th>";
echo '</tr>';

while($ligne = $res->fetch(PDO::FETCH_ASSOC))
{
    echo '<tr>';
        foreach($ligne as $key=>$info) {
            if($key == 'photo')
            {
                echo "<td><img src='$info' width='100px'></td>";
            } else {
                echo "<td>$info</td>";
            }
        }
    echo '<td><a href="?action=modifier&id_produit='.$ligne['id_produit'].'">Modifier<i class="fas fa-edit"></i></a></td>';
    echo '<td><a href="?action=supprimer&id_produit='.$ligne['id_produit'].'">Supprimer<i class="fas fa-trash-alt"></i></a></td>';

}

$vuTable = '</table>';

?>
<?php require_once '../inc/footer.inc.php'; ?>



<?php echo $vuTable; ?></div>
    </div>
</div>



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
                    <select type="form-select" class="form-control" id="categorie" name="categorie">
                        <option >Polo et T-shirt</option>
                        <option >Pantalons</option>
                        <option >Chaussures</option>
                        <option >Accessoires</option>
                        <option >Robes et jupes</option>
                    </select>

                    <label for="categorie" class="form-label">Catégories</label>
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
                        <option >Rouge</option>
                        <option >Bleu</option>
                        <option >Vert</option>
                        <option >Noir</option>
                        <option >Blanc</option>
                        <option >Quadricolor</option>
                    </select>

                    <label for="couleur" class="form-label">Couleur</label>
                </div>

                </div>
                <div class="col-md-6 mb-4">
                <div class="form-outline">
                    <select type="form-select" class="form-control" id="taille" name="taille">
                        <option >XS</option>
                        <option >S</option>
                        <option >M</option>
                        <option >L</option>
                        <option >XL</option>
                        <option >XXL</option>
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
