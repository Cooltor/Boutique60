
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

//echo '<table class=" table table-striped" border=\'2\'><tr>';

//if(isset($_GET['action']) && $_GET['action'] == 'supprimer')
//{
//    if($pdo->query("DELETE FROM commande WHERE id_commande = '$_GET[id_commande]'")){
 //   
//    header ('location:gestion_commandes.php');
//    $content .= '<div class="alert alert-success" role="alert">
//    Cette commande a bien été supprimé
//    </div>';
//    }
//}



//for($i = 0; $i < $res->columnCount(); $i++)
//{
//    $colonne = $res->getColumnMeta($i);
//    echo "<th>".$colonne['name']."</th>";
//}

//echo "<th>Supprimer</th>";

//echo '</tr>';

//while($ligne = $res->fetch(PDO::FETCH_ASSOC))
//{
//    echo '<tr>';
//        foreach($ligne as $key=>$info) {
//            
//                echo "<td>$info</td>";
//            
 //       }

//    echo '<td><a href="?action=supprimer&id_commande='.$ligne['id_commande'].'">Supprimer<i class="fas fa-trash-alt"></i></a></td>';

//}

//$vuTable = '</table>';


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

