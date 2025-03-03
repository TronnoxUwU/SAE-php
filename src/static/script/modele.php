<?php
$dsn = "mysql:dbname="."DBrichard".";host="."servinfo-maria";
$connexion = new PDO($dsn, "richard", "richard");

function getMeilleurRestaurant($codeRegion, $codeDepartement, $codeCommune){
    global $connexion;

    $requete = "select OsmID, avg(Note) as moy from RESTAURANT natural join NOTER where codeRegion = ? and codeDepartement = ? and codeCommune = ? group by OsmID order by moy";
    // todo
}

function chargementFichier($chemin){
    global $connexion;

    $content = file_get_contents($chemin);
    $restaurants = json_decode($content, true);

    foreach ($restaurants as $restaurant) {
        try {
            $requete = $connexion->prepare("insert into REGION(CodeRegion,NomRegion) values(?,?)");
            $requete->execute([$restaurant["code_region"],$restaurant["region"]]);
        } catch (\Throwable $th) {
            //throw $th;
        }
        try {
            $requete = $connexion->prepare("insert into DEPARTEMENT(CodeDepartement,CodeRegion,NomDepartement) values(?,?,?)");
            $requete->execute([$restaurant["code_departement"],$restaurant["code_region"],$restaurant["departement"]]);
        } catch (\Throwable $th) {
            //throw $th;
        }
        try {
            $requete = $connexion->prepare("insert into COMMUNE(CodeCommune,CodeDepartement,CodeRegion,NomCommune) values(?,?,?,?)");
            $requete->execute([$restaurant["code_commune"],$restaurant["code_departement"],$restaurant["code_region"],$restaurant["commune"]]);
        } catch (\Throwable $th) {
            //throw $th;
        }

        //,Longitude,Latitude,CodeCommune,CodeDepartement,CodeRegion,NomRestaurant,SiteWeb,Facebook,TelRestaurant,NbEtoileMichelin,Drive,Capacite,AEmporter,Livraison,Vegetarien,HorrairesOuverture
        $requete = $connexion->prepare("insert into RESTAURANT(OsmID,Longitude,Latitude,CodeCommune,CodeDepartement,CodeRegion,NomRestaurant,SiteWeb,Facebook,TelRestaurant,NbEtoileMichelin,Capacite,Fumeur,AEmporter,Livraison,Vegetarien,Drive,HorrairesOuverture) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        echo "<p>";
        var_dump([substr($restaurant["osm_id"],5),$restaurant["geo_point_2d"]["lon"],$restaurant["geo_point_2d"]["lat"],$restaurant["code_commune"],
        $restaurant["code_departement"],$restaurant["code_region"],$restaurant["name"],$restaurant["smoking"]=="yes",
        $restaurant["website"],$restaurant["facebook"],$restaurant["phone"],$restaurant["stars"],
        $restaurant["drive_through"]=="yes",$restaurant["capacity"],$restaurant["takeaway"]=="yes",$restaurant["delivery"]=="yes",
        $restaurant["vegetarian"]=="yes",$restaurant["opening_hours"]]);
        echo "</p>";
        $requete->execute([substr($restaurant["osm_id"],5),$restaurant["geo_point_2d"]["lon"],$restaurant["geo_point_2d"]["lat"],$restaurant["code_commune"],
                           $restaurant["code_departement"],$restaurant["code_region"],$restaurant["name"],$restaurant["website"],$restaurant["facebook"],$restaurant["phone"],
                           $restaurant["stars"],$restaurant["capacity"],($restaurant["smoking"]=="yes") ? 1 : 0,($restaurant["takeaway"]=="yes") ? 1 : 0,
                           ($restaurant["delivery"]=="yes") ? 1 : 0,($restaurant["vegetarian"]=="yes") ? 1 : 0,($restaurant["drive_through"]=="yes") ? 1 : 0,$restaurant["opening_hours"]
                        ]);

        foreach ($restaurant["cuisine"] as $nom) {
            try {
                $requete = $connexion->prepare("insert into CUISINE(NomCuisine) values(?)");
                $requete->execute([$nom]);
            } catch (\Throwable $th) {
                //throw $th;
            }
            $requete = $connexion->prepare("insert into PREPARER(NomCuisine, OsmID) values(?,?)");
            $requete->execute([$nom,substr($restaurant["osm_id"],5)]);
        }
    }
    return $restaurants;
}
chargementFichier(__DIR__."./../../data/restaurants_orleans.json");
