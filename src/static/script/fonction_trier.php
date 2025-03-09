
<?php
require_once '../static/script/modele.php';

function init_trier(){
    $_SESSION['nourriture'] = "";
    $_SESSION['tendance'] = "false";
    $_SESSION['livraison'] = "false";
    $_SESSION['aemporter'] = "false";
}

function list_trier($nouriture ="", $tendance="false",$livraison="false",$aemporter="false"){
    $listeRestaurant=[];
    if($nouriture =="" && $tendance=="false"&& $livraison=="false" && $aemporter=="false"){
        echo("no");
        return getrestauAll();
    }
    if( $tendance=="true"){
        $listeRestaurant = array_merge($listeRestaurant,getRestauAEmporter());
    }

    if($livraison=="true"){
        $listeRestaurant = array_merge($listeRestaurant,getRestaulivrer());
    }

    if ( $aemporter=="true"){
        $listeRestaurant = array_merge($listeRestaurant,getRestauAEmporter());
    }
    return $listeRestaurant;
}




function getRestauAEmporter(){
    global $connexion;
    $requete = $connexion->prepare("SELECT r.*, AVG(NULLIF(n.Note, 0)) AS moy FROM RESTAURANT r LEFT JOIN NOTER n ON r.OsmID = n.OsmID LEFT JOIN COMMUNE c ON r.CodeCommune = c.CodeCommune LEFT JOIN DEPARTEMENT d ON c.CodeDepartement = d.CodeDepartement LEFT JOIN REGION reg ON d.CodeRegion = reg.CodeRegion where aemporter = true  GROUP BY r.OsmID;");
    $requete->execute();
    $result = $requete->fetchAll(PDO::FETCH_ASSOC);
    $listeRestp = [];
    $i=0;
    foreach ($result as $element) {
        $cuisine = [];
        $requete2 = $connexion->prepare("select * from RESTAURANT natural join PREPARER where OsmID = ?");
        $requete2->execute([$element["osmid"]]);
        $resultat2 = $requete->fetchAll();

        foreach($resultat2 as $row2){
            array_push($cuisine,$row2["nomcuisine"]);
        }
        $nouveauResto = new Restaurant($element["osmid"],
                            $element["nomrestaurant"],
                            ($element["description"]==null) ? "" : $element["description"],
                            '$row["nomregion"]' ,
                            '$row["nomdepartement"]',
                            '$row["nomcommune"]',
                            $element["longitude"],
                            $element["latitude"],
                            ($element["siteweb"]==null) ? "" : $element["siteweb"],
                            ($element["facebook"]==null) ? "" : $element["facebook"],
                            ($element["telrestaurant"]==null) ? "" : $element["telrestaurant"],
                            floatval($element["moy"]),
                            ($element["capacite"]==null) ? 0 : $element["capacite"],
                            ($element["fumeur"]==null) ? 0 : $element["fumeur"],
                            ($element["drive"]==null) ? 0 : $element["drive"],
                            ($element["aemporter"]==null) ? 0 : $element["aemporter"],
                            ($element["livraison"]==null) ? 0 : $element["livraison"],
                            ($element["vegetarien"]==null) ? 0 : $element["vegetarien"],
                            ($element["horrairesouverture"]==null) ? "" : $element["horrairesouverture"],
                            $cuisine,
                            fetchNoteRestaurant($element["osmid"]));
        array_push($listeRestp,$nouveauResto);
    }
    return $listeRestp;
}




function getRestaulivrer(){
    global $connexion;
    $requete = $connexion->prepare("SELECT r.*, AVG(NULLIF(n.Note, 0)) AS moy FROM RESTAURANT r LEFT JOIN NOTER n ON r.OsmID = n.OsmID LEFT JOIN COMMUNE c ON r.CodeCommune = c.CodeCommune LEFT JOIN DEPARTEMENT d ON c.CodeDepartement = d.CodeDepartement LEFT JOIN REGION reg ON d.CodeRegion = reg.CodeRegion where livraison = true  GROUP BY r.OsmID;");
    $requete->execute();
    $result = $requete->fetchAll(PDO::FETCH_ASSOC);
    $listeRestp = [];
    $i=0;
    foreach ($result as $element) {
        $cuisine = [];
        $requete2 = $connexion->prepare("select * from RESTAURANT natural join PREPARER where OsmID = ?");
        $requete2->execute([$element["osmid"]]);
        $resultat2 = $requete->fetchAll();

        foreach($resultat2 as $row2){
            array_push($cuisine,$row2["nomcuisine"]);
        }
        $nouveauResto = new Restaurant($element["osmid"],
                            $element["nomrestaurant"],
                            ($element["description"]==null) ? "" : $element["description"],
                            '$row["nomregion"]' ,
                            '$row["nomdepartement"]',
                            '$row["nomcommune"]',
                            $element["longitude"],
                            $element["latitude"],
                            ($element["siteweb"]==null) ? "" : $element["siteweb"],
                            ($element["facebook"]==null) ? "" : $element["facebook"],
                            ($element["telrestaurant"]==null) ? "" : $element["telrestaurant"],
                            floatval($element["moy"]),
                            ($element["capacite"]==null) ? 0 : $element["capacite"],
                            ($element["fumeur"]==null) ? 0 : $element["fumeur"],
                            ($element["drive"]==null) ? 0 : $element["drive"],
                            ($element["aemporter"]==null) ? 0 : $element["aemporter"],
                            ($element["livraison"]==null) ? 0 : $element["livraison"],
                            ($element["vegetarien"]==null) ? 0 : $element["vegetarien"],
                            ($element["horrairesouverture"]==null) ? "" : $element["horrairesouverture"],
                            $cuisine,
                            fetchNoteRestaurant($element["osmid"]));
        array_push($listeRestp,$nouveauResto);
    }
    return $listeRestp;
}



function getRestauTendance(){
    global $connexion;
    $requete = $connexion->prepare("SELECT r.*, AVG(NULLIF(n.Note, 0)) AS moy FROM RESTAURANT r LEFT JOIN NOTER n ON r.OsmID = n.OsmID LEFT JOIN COMMUNE c ON r.CodeCommune = c.CodeCommune LEFT JOIN DEPARTEMENT d ON c.CodeDepartement = d.CodeDepartement LEFT JOIN REGION reg ON d.CodeRegion = reg.CodeRegion where livraison = true  GROUP BY r.OsmID;");
    $requete->execute();
    $result = $requete->fetchAll(PDO::FETCH_ASSOC);
    $listeRestp = [];
    $i=0;
    foreach ($result as $element) {
        $cuisine = [];
        $requete2 = $connexion->prepare("select * from RESTAURANT natural join PREPARER where OsmID = ?");
        $requete2->execute([$element["osmid"]]);
        $resultat2 = $requete->fetchAll();

        foreach($resultat2 as $row2){
            array_push($cuisine,$row2["nomcuisine"]);
        }
        $nouveauResto = new Restaurant($element["osmid"],
                            $element["nomrestaurant"],
                            ($element["description"]==null) ? "" : $element["description"],
                            '$row["nomregion"]' ,
                            '$row["nomdepartement"]',
                            '$row["nomcommune"]',
                            $element["longitude"],
                            $element["latitude"],
                            ($element["siteweb"]==null) ? "" : $element["siteweb"],
                            ($element["facebook"]==null) ? "" : $element["facebook"],
                            ($element["telrestaurant"]==null) ? "" : $element["telrestaurant"],
                            floatval($element["moy"]),
                            ($element["capacite"]==null) ? 0 : $element["capacite"],
                            ($element["fumeur"]==null) ? 0 : $element["fumeur"],
                            ($element["drive"]==null) ? 0 : $element["drive"],
                            ($element["aemporter"]==null) ? 0 : $element["aemporter"],
                            ($element["livraison"]==null) ? 0 : $element["livraison"],
                            ($element["vegetarien"]==null) ? 0 : $element["vegetarien"],
                            ($element["horrairesouverture"]==null) ? "" : $element["horrairesouverture"],
                            $cuisine,
                            fetchNoteRestaurant($element["osmid"]));
        array_push($listeRestp,$nouveauResto);
    }
    return $listeRestp;
}


?>
