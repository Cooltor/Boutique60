
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

echo '<table class=" table table-striped" border=\'2\'><tr>';

if(isset($_GET['action']) && $_GET['action'] == 'supprimer')
{
    if($pdo->query("DELETE FROM commande WHERE id_commande = '$_GET[id_commande]'")){
    
    header ('location:gestion_commandes.php');
    $content .= '<div class="alert alert-success" role="alert">
    Cette commande a bien été supprimé
    </div>';
    }
}

for($i = 0; $i < $res->columnCount(); $i++)
{
    $colonne = $res->getColumnMeta($i);
    echo "<th>".$colonne['name']."</th>";
}

echo "<th>Supprimer</th>";
echo "<th>Modifier</th>";
echo '</tr>';

while($ligne = $res->fetch(PDO::FETCH_ASSOC))
{
    echo '<tr>';
        foreach($ligne as $key=>$info) {
            
                echo "<td>$info</td>";
            
        }

    echo '<td><a href="?action=supprimer&id_commande='.$ligne['id_commande'].'">Supprimer<i class="fas fa-trash-alt"></i></a></td>';
    echo '<td><a href="?action=modifier&id_commande='.$ligne['id_commande'].'">Modifier<i class="fas fa-edit"></i></a></td>';
}

$vuTable = '</table>';



?>

<h1 class="text-center"> Listes de commandes passées</h1>

<?php echo $vuTable; 
    echo $content; ?>





<!-- PARTIE AFFICHAGE -->



<?php require_once '../inc/footer.inc.php'; ?>

