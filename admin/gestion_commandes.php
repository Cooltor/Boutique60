
<!-- PARTIE TRAITEMENT -->

<?php require_once '../inc/header.inc.php'; ?>

<?php
if(!userConnected())
{
    header('location:connexion.php');
}


if(!userIsAdmin()){
    header('location:../connexion.php');
    exit();
}

$res = $pdo->query("SELECT * FROM commande");


if(isset($_POST['statut_cmd'])){

    $pdo->query("UPDATE commande SET etat = '$_POST[etat]' WHERE id_commande = '$_POST[id_commande]'");
}

$allOrder = $pdo->query('SELECT * FROM commande ORDER BY id_commande DESC');

$content .= '<table class="table table-striped" border="2"><tr>';

for($i = 0; $i < $allOrder->columnCount(); $i++)
{
    $colonne = $allOrder->getColumnMeta($i);
    $content .= "<th>".$colonne['name']."</th>";
}

while ($oneOrder = $allOrder-> fetch(PDO::FETCH_ASSOC)) {

    $content.= '<tr>';

    foreach ($oneOrder as $key => $value) {

    
    if ($key == 'etat') {
        $content .= '<form action="" method="POST">';
        $content .= "<input type=\"hidden\" name=\"id_commande\" value=\"$oneOrder[id_commande]\">";
        $content .= "<td class=\"align-middle\">";
        $content .= "<select name=\"etat\" id=\"etat\">";
        $content .= "<option value=\"$value\">$value</option>";
        $content .= "<option value=\"envoyé\">Envoyé</option>";
        $content .= "<option value=\"livré\">Livré</option>"; 
        $content .= "</select>";
        $content .= "<input type=\"submit\" value=\"Modifier\" name=\"statut_cmd\" class=\"btn btn-outline-primary btn sm-ms-2\" >";
        $content .= "</form>";


    }else{
        $content .= "<td class=\"align-middle\">$value</td>";
    }
}
}
?>

<h1 class="text-center"> Listes de commandes passées</h1>

<?php //echo $vuTable; 
    echo $content; ?>





<!-- PARTIE AFFICHAGE -->



<?php require_once '../inc/footer.inc.php'; ?>

