
<?php
require_once '../static/script/modele.php';

function init_trier(){
    $_SESSION['nourriture'] = "";
    $_SESSION['tendance'] = "false";
    $_SESSION['livraison'] = "false";
    $_SESSION['aemporter'] = "false";
    $_SESSION['rating'] = "0";
}

function list_trier($nouriture,$tendance,$livraison,$rating,$aemporter,$recherche="",$ville=""){
    $listeRestaurant=[];

    if($nouriture =="" && $tendance=="false"&& $livraison=="false" && $aemporter=="false" && $recherche == "" && $ville =="" && $rating=="0"){
        return getrestauAll(); //ok
    }

    if($tendance == "true"){
        return getRestauTendance();
    }

    if($nouriture =="" && $tendance=="false"&& $livraison=="false" && $aemporter=="false" && $recherche != "" && $ville !="" && $rating=="0"){
        if (rechercheEstNouriture($recherche)){
            return getRestauParNouriturev2($recherche);
        }
    }

    if($nouriture !="" && $tendance=="false"&& $livraison=="false" && $aemporter=="false" && $recherche == "" && $ville =="" && $rating=="0"){
        if (substr_count($nouriture, ",") == 1){
            $nouriture = str_replace(",", $nouriture);
            return getRestauParNouriturev2($nouriture);

        } else{
            $LISTEN = explode(",", $nouriture);
            foreach ($LISTEN as $element){
                $listeRestaurant = array_merge($listeRestaurant,getRestauParNouriturev2($element));
            }
            return  $listeRestaurant;
        }
    }




    if($nouriture == "" && $tendance == "false"&& $livraison == "false" && $aemporter == "false" && $recherche != "" && $ville!="" && $rating=="0"){
        return getrestByName($recherche,$ville); //ok
    }




}





function getRestauAEmporter($name="",$ville="",$rating){
    global $connexion;
    if($name=="" && $ville==""){
        $requete = $connexion->prepare('SELECT r.*, AVG(NULLIF(n.Note, 0)) AS moy FROM RESTAURANT r LEFT JOIN NOTER n ON r.OsmID = n.OsmID LEFT JOIN COMMUNE c ON r.CodeCommune = c.CodeCommune LEFT JOIN DEPARTEMENT d ON c.CodeDepartement = d.CodeDepartement LEFT JOIN REGION reg ON d.CodeRegion = reg.CodeRegion where aemporter ='.$rating.'  GROUP BY r.OsmID;');
    } else{
        $requete = $connexion->prepare('SELECT r.*, AVG(NULLIF(n.Note, 0)) AS moy FROM RESTAURANT r LEFT JOIN NOTER n ON r.OsmID = n.OsmID LEFT JOIN COMMUNE c ON r.CodeCommune = c.CodeCommune LEFT JOIN DEPARTEMENT d ON c.CodeDepartement = d.CodeDepartement LEFT JOIN REGION reg ON d.CodeRegion = reg.CodeRegion where nomrestaurant LIKE '.$name.'% and nomcommune = '.$ville.'  GROUP BY r.OsmID;');
    }
    return traitement($requete);
}





function getRestaulivrer($name="",$ville=""){
    global $connexion;
    if($name=="" && $ville==""){
        $requete = $connexion->prepare("SELECT r.*, AVG(NULLIF(n.Note, 0)) AS moy FROM RESTAURANT r LEFT JOIN NOTER n ON r.OsmID = n.OsmID LEFT JOIN COMMUNE c ON r.CodeCommune = c.CodeCommune LEFT JOIN DEPARTEMENT d ON c.CodeDepartement = d.CodeDepartement LEFT JOIN REGION reg ON d.CodeRegion = reg.CodeRegion where livraison = true  GROUP BY r.OsmID;");
    } else{
        $requete = $connexion->prepare('SELECT r.*, AVG(NULLIF(n.Note, 0)) AS moy FROM RESTAURANT r LEFT JOIN NOTER n ON r.OsmID = n.OsmID LEFT JOIN COMMUNE c ON r.CodeCommune = c.CodeCommune LEFT JOIN DEPARTEMENT d ON c.CodeDepartement = d.CodeDepartement LEFT JOIN REGION reg ON d.CodeRegion = reg.CodeRegion where nomrestaurant LIKE '.$name.'% and nomcommune = '.$ville.'  GROUP BY r.OsmID;');
    }
    return traitement($requete);
}


function getRestauParEtoile($name="",$ville=""){
    global $connexion;
    if($name=="" && $ville==""){
    $requete = $connexion->prepare("SELECT r.*, AVG(NULLIF(n.Note, 0)) AS moy FROM RESTAURANT r LEFT JOIN NOTER n ON r.OsmID = n.OsmID LEFT JOIN COMMUNE c ON r.CodeCommune = c.CodeCommune LEFT JOIN DEPARTEMENT d ON c.CodeDepartement = d.CodeDepartement LEFT JOIN REGION reg ON d.CodeRegion = reg.CodeRegion where livraison = true  GROUP BY r.OsmID;");
    }else{
        $requete = $connexion->prepare('SELECT r.*, AVG(NULLIF(n.Note, 0)) AS moy FROM RESTAURANT r LEFT JOIN NOTER n ON r.OsmID = n.OsmID LEFT JOIN COMMUNE c ON r.CodeCommune = c.CodeCommune LEFT JOIN DEPARTEMENT d ON c.CodeDepartement = d.CodeDepartement LEFT JOIN REGION reg ON d.CodeRegion = reg.CodeRegion where nomrestaurant LIKE '.$name.'% and nomcommune = '.$ville.'  GROUP BY r.OsmID;');
    }
    return traitement($requete);
}


function getRestauParNouriture($name="",$ville="",$nourriture){
    global $connexion;
    if($name=="" && $ville==""){
        $requete = $connexion->prepare('SELECT r.*, AVG(NULLIF(n.Note, 0)) AS moy FROM RESTAURANT r LEFT JOIN NOTER n ON r.OsmID = n.OsmID LEFT JOIN COMMUNE c ON r.CodeCommune = c.CodeCommune LEFT JOIN DEPARTEMENT d ON c.CodeDepartement = d.CodeDepartement LEFT JOIN REGION reg ON d.CodeRegion = reg.CodeRegion where nomcuisine='.$nourriture.'  GROUP BY r.OsmID;');
    }else{
        $requete = $connexion->prepare('SELECT r.*, AVG(NULLIF(n.Note, 0)) AS moy FROM RESTAURANT r LEFT JOIN NOTER n ON r.OsmID = n.OsmID LEFT JOIN COMMUNE c ON r.CodeCommune = c.CodeCommune LEFT JOIN DEPARTEMENT d ON c.CodeDepartement = d.CodeDepartement LEFT JOIN REGION reg ON d.CodeRegion = reg.CodeRegion where nomrestaurant LIKE '.$name.'% and nomcommune = '.$ville.' and '.$nourriture.' GROUP BY r.OsmID;');
    }
    return traitement($requete);
}






//taper nourriture ok
// trier par nouriture uniquement ok
// $tendance == "true" ok






function getRestauParNouriturev2($ville=""){
    global $connexion;
    if ($ville ==""){
        return [];
    } 
    $requete = $connexion->prepare('SELECT r.*, AVG(NULLIF(n.Note, 0)) AS moy FROM RESTAURANT r LEFT JOIN NOTER n ON r.OsmID = n.OsmID LEFT JOIN COMMUNE c ON r.CodeCommune = c.CodeCommune LEFT JOIN DEPARTEMENT d ON c.CodeDepartement = d.CodeDepartement LEFT JOIN REGION reg ON d.CodeRegion = reg.CodeRegion where nomcuisine='.$ville.'  GROUP BY r.OsmID;');
    return traitement($requete);
}


function rechercheEstNouriture($recherche){
    $listeNouriture = getNomCuisine();
    if (in_array($recherche, $listeNouriture)){
        return true;
    }
    return false;
}

function getRestauTendance(){
    return getRestaurantPopulaire(24, 45, 45234);
}




function traitement($requete){
    global $connexion;
    $requete->execute();
        $result = $requete->fetchAll(PDO::FETCH_ASSOC);
        $listeRestp = [];
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
        return $listeRestp;}
?>



