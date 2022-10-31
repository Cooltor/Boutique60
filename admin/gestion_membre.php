
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

$res = $pdo->query("SELECT * FROM membre");

echo '<table class=" table table-striped" border=\'2\'><tr>';

if(isset($_GET['action']) && $_GET['action'] == 'supprimer')
{
    if($pdo->query("DELETE FROM membre WHERE id_membre = '$_GET[id_membre]' AND statut = 0")){
    
    header ('location:gestion_membre.php');
    $content .= '<div class="alert alert-success" role="alert">
    Le membre a bien été supprimé
    </div>';
    } else {
        header ('location:gestion_membre.php');
        $content .= '<div class="alert alert-danger" role="alert">
        L\'admin ne peut pas être supprimé
        </div>';
    }
}


for($i = 0; $i < $res->columnCount(); $i++)
{
    $colonne = $res->getColumnMeta($i);
    echo "<th>".$colonne['name']."</th>";
}


echo "<th>Supprimer</th>";
echo '</tr>';

while($ligne = $res->fetch(PDO::FETCH_ASSOC))
{
    echo '<tr>';
        foreach($ligne as $key=>$info) {
            
                echo "<td>$info</td>";
            
        }

    echo '<td><a href="?action=supprimer&id_membre='.$ligne['id_membre'].'">Supprimer<i class="fas fa-trash-alt"></i></a></td>';

}

$vuTable = '</table>';






?>


<?php echo $vuTable; 
    echo $content; ?>





<!-- PARTIE AFFICHAGE -->



<?php require_once '../inc/footer.inc.php'; ?>