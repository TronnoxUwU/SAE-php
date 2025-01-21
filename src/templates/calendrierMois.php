
<?php
$Days = 1;
    
//var_dump($_GET['date'] ?? "now");
$date = new DateTime($_GET['date'] ?? "now");

$mois = ["Janvier","Fevrier","Mars","Avril","Mai","Juin","Juillet","Aout","Septembre","Octobre","Novembre","Decembre"];

$nbJourDansMois = $date->format('t');
$lemois = $mois[intval($date->format('m'))-1];
$lemoischiffre = $date->format('m');
$annee = $date->format('o');
$jourDebutMois = $date->modify("first day of this month")->format('N');
$jourDernierMoisPrecedent= $date->modify("last day of previous month")->format('N');


echo '<table border="1">';
echo '<tr>';
echo "<th class='thmois' colspan=7><p>$lemois</p></th>";
echo '</tr>';
echo '<tr>';
echo '<th class="thmois">L</th>';
echo '<th class="thmois">M</th>';
echo '<th class="thmois">M</th>';
echo '<th class="thmois">J</th>';
echo '<th class="thmois">V</th>';
echo '<th class="thmois">S</th>';
echo '<th class="thmois">D</th>';
echo '</tr>';

for ($i=0; $i < 6 ; $i++) {
    echo '<tr>';
    for($j=1; $j < 8;$j++) {
        if($j+$i*7 >= $jourDebutMois ){
            if ($Days > $nbJourDansMois){
                $Days = 1;
                //var_dump($lemoischiffre);
                $lemoischiffre = $date->modify("+2 month")->format('m');
                $lemoischiffre = $date->modify("-1 month")->format('m');
                //var_dump($lemoischiffre);
            }
            echo "<td><a class='jourMois' href='/src/templates/planning.php?date=$annee-$lemoischiffre-$Days'>$Days</a></td>";
            $Days++;
        }else{
            echo "<td>  ̇Ù</td>";
        }
    }
    echo '</tr>';
}

echo '</table>';