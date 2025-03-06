<?php
require_once './src/static/script/modele.php';


echo"yeah";
//set_time_limit(5000);
//chargementFichier("./src/data/restaurants_orleans.json");
//set_time_limit(30);

//utilisateurExistant("", "")
//ajouteNote("aaaa",2170973,2,"");

//insertClient("Test", "Test", "+33 6 04 50 50 50", "aaaa", 24, 45, 45234, "UwU", true);
echo "<p>";
echo utilisateurExistant("aaaa", "UwU") ? "Il existe" : "Il existe pas";
echo "</p>";
//ajoutePrefCuisine("aaaa", "burger");
echo "<p>";
var_dump(getPrefCuisine("aaaa"));
echo "</p>";

echo "<p>";
var_dump(getRegion("Orléans"));
echo "</p>";

echo "<p>";
var_dump(getBestResto());
echo "</p>";