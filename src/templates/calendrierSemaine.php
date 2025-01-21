
<?php

require_once "../static/script/modele.php";

$date = new DateTime($_GET['date'] ?? "now");
$premierJourSemaine = $date->format('d') - $date->format('N') + 1;
$premierJourSemaineD = $date->modify('-'.($date->format('N')).'day');

$j= $premierJourSemaineD->format("Y-m-d");
$dernierJourSemaineD = $premierJourSemaineD->modify("+7 day");

$exemplecours = getCours($j,$dernierJourSemaineD->format("Y-m-d"));

$annee = $date->format('o');

$mois = $date->format('m');
$nbJourDansMoisDernier = $date->modify("last day of previous month")->format('t');


echo '<table border="1">';
echo '<tr class="trsem">';
echo '<th class="thsem"></th>';
foreach ($exemplecours as $key => $value) {
    $jour = $premierJourSemaine;
    if($premierJourSemaine<=0){
        $jour=$nbJourDansMoisDernier+$premierJourSemaine;
        $mois = $date->modify('-1 month')->format('m');
        $annee = $date->format('o');
    } elseif ($premierJourSemaine==1) {
        $mois = $date->format('m');
        $annee = $date->format('o');
    }
    $date->modify('+1 month');
    echo "<th class='thsem'><h2>$key</h2><p>$jour/$mois/$annee</p></th>";
    $premierJourSemaine++;
}
echo '</tr>';

for ($i= 8;$i<20;$i++){
    echo '<tr class="trsem">';
    printf("<th class='thsem'>%s - %s h</th>", $i, ($i+1)%24);
    foreach ($exemplecours as $jour=>$cours) {
        $pascours = true;
        foreach ($cours as $value) {
            if ($i>=$value['debut'] && ($i<$value['fin'] || $i==$value['debut'])){
                $pascours = false;
                if ($i==$value['debut']) {
                    printf("<td rowspan=%s class='tdsem'><a href='/src/templates/seance.php?id=%s'><div class='cours'><h3>%s</h3></div></a></td>",$value['fin']-$value['debut'],$value['id'],$value['intitulé']);
                }
            }
        }
        if($pascours) {
            echo "<td class='tdsem'></td>";
        }
    }
    echo '</tr>';
}
echo '</table>';
?>
