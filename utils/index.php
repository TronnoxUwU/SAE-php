<h1> bon fichier</h1>


<?php
require_once 'data/prod.php';


echo'<a href="./index.php" > tout la liste </a>';
echo'<a href="./templates/fentre_trier.php/?who=Apple">.Apple </a>';



$obj = getprod('data/product.json');


if(!empty($_REQUEST['filter'])){
  $obj = array_filter(
    $obj,
    fn($branche) => $branche['brand'] == $_REQUEST['filter']
  );
}



echo "<br>";
echo "<table>";
echo "<caption> liste produit </caption>";

echo "<thead>";
echo "<tr>";
echo "<th scope=\"col\">ID</th>";
echo "<th scope=\"col\">title</th>";
echo "<th scope=\"col\">brand </th>";
echo "<th scope=\"col\">price</th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";



foreach (  $obj as $liste ) {
  echo "<tr>";
  print_r ('<th scope=\"row\"><a href="./detail.php/?id_produit='.$liste["id"].'">.'.$liste["id"].' </a></th>');
  print_r ('<td>'.$liste["title"].'</td>');
  print_r ('<td>'.$liste["brand"].'</td>');
  print_r ('<td>'.$liste["price"].'</td>');
  echo "</tr>";
}
echo "</table>";
?>
