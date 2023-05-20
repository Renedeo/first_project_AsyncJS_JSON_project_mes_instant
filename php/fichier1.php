<?php
include ('fonction.php');
$req1 = 'SELECT FontFamily_id, username
FROM `BD_CHAT`.`User`
WHERE Connected = 1
ORDER BY FontFamily_id';

// Famille

$rep1 = $pdo->query($req1);

while($ligne = $rep1->fetch(PDO::FETCH_NUM)){
    
    $req = 'SELECT font_family FROM `BD_CHAT`.`FontFamily` WHERE FontFamily_id = '.$ligne[0].';
';
    $rep = $pdo->query($req);
    
    $rep = $rep->fetchAll(PDO::FETCH_NUM);
    
    echo '<p><small>'.$ligne[1].'.<span class=family>['.$rep[0][0].']</span></small></p>';
}
?>