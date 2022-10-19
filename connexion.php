<!-- PARTIE TRAITEMENT -->




<?php
// Verifier que le pseudo et le mdp correspondent à un membre de la BDD avec password_verify
// Si c'est le cas, on connecte le membre
require_once './inc/init.php';
$err = '';


if($_POST){
    $pseudo = $_POST['pseudo'];
    $mdp = $_POST['mdp'];

    $resultat = $pdo->prepare("SELECT * FROM membre WHERE pseudo = :pseudo");
    $resultat->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
    $resultat->execute();

    if($resultat->rowCount() > 0){
        $membre = $resultat->fetch(PDO::FETCH_ASSOC);
        if(password_verify($mdp, $membre['mdp'])){
            $_SESSION['membre'] = $membre;
            header('location:profil.php');
        }
        else{
            $err .= '<div class="alert alert-danger">Erreur sur le pseudo ou le mot de passe</div>';
        }
    }
    else{
        $err .= '<div class="alert alert-danger">Erreur sur le pseudo ou le mot de passe</div>';
    }
}


$content .= $err;



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
            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Connexion</h3>
            <form>

            <div class="row">
                <div class="col-md-6 mb-4">

                <div class="form-outline">
                    <input type="text" id="pseudo" class="form-control form-control-lg" name="pseudo"/>
                    <label class="form-label" for="pseudo">Pseudo</label>
                </div>

                </div>
                <div class="col-md-6 mb-4">

                <div class="form-outline">
                    <input type="password" id="mdp" class="form-control form-control-lg" name="mdp" />
                    <label class="form-label" for="mdp">Mot de passe</label>
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