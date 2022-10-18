<!-- PARTIE TRAITEMENT -->

<?php

// Etape 1
// en utilisant strlenn() pour vérifier la taille du pseudo (entre 3 et 20 caractères)
// en utilisant la fonction preg_match() pour vérifier si le pseudo contient les caractères autorisés
// '#^[a-zA-Z0-9._-]+$#' : expression régulière
// Vérifier si le pseudo est disponible dans la BDD


// Etape 2
// En utilisant la fc password_hash(), crypter le mdp de l'user dans la bdd

require_once './inc/init.php';

$err = '';

//if (isset($_POST['submit'])) {
//
//    if (!empty($_POST['pseudo'])) {
//        if (strlen($_POST['pseudo']) >= 3 && strlen($_POST['pseudo']) <= 20) {
//            if (preg_match('#^[a-zA-Z0-9._-]+$#', $_POST['pseudo'])) {
//                $pseudo = $_POST['pseudo'];
//            } else {
//               echo $err .= '<div class="alert alert-danger">Caractères autorisés : a-z A-Z 0-9 . _ -</div>';
//            }
//       } else {
//          echo  $err .= '<div class="alert alert-danger">Le pseudo doit contenir entre 3 et 20 caractères</div>';
//        }
//    } else {
//      echo  $err .= '<div class="alert alert-danger">Le pseudo est obligatoire</div>';
//    }
//
//    if (!empty($_POST['mdp'])) {
//        if (strlen($_POST['mdp']) >= 4 && strlen($_POST['mdp']) <= 20) {
//            $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
//        } else {
//            echo $err .= '<div class="alert alert-danger">Le mot de passe doit contenir entre 4 et 20 caractères</div>';
//        }
//    } else {
//        echo $err .= '<div class="alert alert-danger">Le mot de passe est obligatoire</div>';
//    }
//
//}


if($_POST) {
    
    $pseudo = $_POST['pseudo'];
    // Vérification de la longueur du pseudo
    if(strlen($pseudo) <3 || strlen($pseudo) > 20) {
        $err .= '<div class="alert alert-danger">Le pseudo doit contenir entre 3 et 20 caractères</div>';
    }

    // Vérification des caractères autorisés (regex)
    
    $monExpression = '#^[a-zA-Z0-9._-]+$#';
    if(!preg_match($monExpression, $pseudo)) {
        $err .= '<div class="alert alert-danger">Caractères autorisés : a-z A-Z 0-9 . _ -</div>';
    }

    // Vérification de la disponibilité du pseudo dans la BDD
    $r = $pdo->query("SELECT * FROM membre WHERE pseudo = '$pseudo'");
    if($r->rowCount() > 0) {
        $err .= '<div class="alert alert-danger">Le pseudo est déjà pris </div>';
    }


    // Insérer l'user ds la bdd
    if(empty($err)) {
        $pdo->query("INSERT INTO membre (pseudo,mdp,nom,prenom,email,civilite,ville, code_postal,adresse) VALUES ('$_POST[pseudo]', '$_POST[mdp]', '$_POST[nom]', '$_POST[prenom]', '$_POST[email]', '$_POST[civilite]', '$_POST[ville]', '$_POST[cp]', '$_POST[adresse]')");
    }









    $content .= $err;

}



?>


<!-- PARTIE AFFICHAGE -->

<?php require_once './inc/header.inc.php'; ?>


<?php echo $content; ?>

<form  action="" method="POST" class="vh-100 gradient-custom">
<div class="container py-5 h-100">
    <div class="row justify-content-center align-items-center h-100">
        <div class="col-12 col-lg-9 col-xl-7">
        <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
            <div class="card-body p-4 p-md-5">
            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Inscription</h3>
            <form>

            <div class="row">
                <div class="col-md-6 mb-4">

                <div class="form-outline">
                    <input type="text" id="firstName" class="form-control form-control-lg" name="nom"/>
                    <label class="form-label" for="nom">Nom</label>
                </div>

                </div>
                <div class="col-md-6 mb-4">

                <div class="form-outline">
                    <input type="text" id="lastName" class="form-control form-control-lg" name="prenom" />
                    <label class="form-label" for="prenom">Prénom</label>
                </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                <div class="form-outline">
                    <input type="text" class="form-control" id="pseudo" name="pseudo">
                    <label for="pseudo" class="form-label">Pseudo</label>
                </div>

                </div>
                <div class="col-md-6 mb-4">
                <div class="form-outline">
                    <input type="password" class="form-control" id="mdp" name="mdp">
                    <label for="mdp" class="form-label">Mot de passe</label>
                </div>
                
                </div>
            </div>

            



            <div class="row">
                
                <div class="col-md-6 mb-4">

                <h6 class="mb-2 pb-1">Genre</h6>

                <div class="form-check form-check-inline">
                <input type="radio" name="civilite" id="civilite" value="m" checked>
                Homme
                <input type="radio" name="civilite" id="civilite" value="f" checked>
                Femme
                </div>


                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4 pb-2">

                <div class="form-outline">
                    <input type="email" id="emailAddress" class="form-control form-control-lg" name="email" />
                    <label class="form-label" for="emailAddress">Email</label>
                </div>

                </div>
                
                </div>

                <div class="row">
                <div class="col-md-6 mb-4 pb-2">

                <div class="form-outline">
                    <input type="text" id="addresse" class="form-control form-control-lg" name="adresse" />
                    <label class="form-label" for="addresse">Adresse</label>
                </div>

                </div>
                <div class="col-md-6 mb-4 pb-2">

                <div class="form-outline">
                    <input type="text" id="town" class="form-control form-control-lg" name="ville" />
                    <label class="form-label" for="town">Ville</label>
                </div>

                <div class="form-outline">
                    <input type="text" class="form-control" id="cp" name="cp">
                    <label for="cp" class="form-label">Code Postal</label>
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

<?php require_once './inc/footer.inc.php'; ?>
