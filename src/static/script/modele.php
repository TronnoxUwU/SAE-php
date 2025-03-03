<?php
require_once '../../classes/Composant/Restaurant.php';

$dsn = "mysql:dbname="."DBrichard".";host="."servinfo-maria";
$connexion = new PDO($dsn, "richard", "richard");

// $dsn = "mysql:dbname="."sae_mlp".";host="."127.0.0.1";
// try{
//     $connexion = new PDO($dsn, "root", "clermont");
// }
// catch(PDOException $e){
//     printf("Error connecting to database: %s", $e->getMessage());
//     exit();
// }

function getMeilleurRestaurant($codeRegion, $codeDepartement, $codeCommune){
    global $connexion;

    $sortie = [];

    $requete = $connexion->prepare("select OsmID,Longitude,Latitude,CodeCommune,NomCommune,CodeDepartement,NomDepartement,CodeRegion,NomRegion,NomRestaurant,SiteWeb,Facebook,TelRestaurant,NbEtoileMichelin,Capacite,Fumeur,AEmporter,Livraison,Vegetarien,Drive,HorrairesOuverture,Description, avg(Note) as moy from RESTAURANT natural left join NOTER natural join COMMUNE natural join DEPARTEMENT natural join REGION where codeRegion = ? and codeDepartement = ? and codeCommune = ? group by OsmID order by moy");
    $requete->execute([$codeRegion, $codeDepartement, $codeCommune]);
    $resultat = $requete->fetchAll();

    foreach($resultat as $row){
        if (count($sortie)<10) {

            var_dump($row);

            $cuisine = [];
            $requete2 = $connexion->prepare("select * from RESTAURANT natural join PREPARER where OsmID = ?");
            $requete2->execute([$row["OsmID"]]);
            $resultat2 = $requete->fetchAll();

            foreach($resultat2 as $row2){
                array_push($cuisine,$row2["NomCuisine"]);
            }

            $restaurant = new Restaurant($row["OsmID"],
                                         $row["NomRestaurant"],
                                         ($row["Description"]==null) ? "" : $row["Description"],
                                         $row["NomRegion"] ,
                                         $row["NomDepartement"],
                                         $row["NomCommune"],
                                         $row["Longitude"],
                                         $row["Latitude"],
                                         $row["SiteWeb"],
                                         ($row["Facebook"]==null) ? "" : $row["Facebook"],
                                         $row["TelRestaurant"],
                                         1.2,
                                         $row["Capacite"],
                                         $row["Fumeur"],
                                         $row["Drive"],
                                         $row["AEmporter"],
                                         $row["Livraison"],
                                         $row["Vegetarien"],
                                         $row["HorrairesOuverture"],
                                         $cuisine);

            array_push($sortie, $restaurant);
        }
    }
    return $sortie;
}


var_dump(getMeilleurRestaurant(24, 45, 45234));

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
}
      
// $pdo = new PDO('sqlite:'.$db_path);
// $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
// $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

function utilisateurExistant($mail, $mdp) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :mail");
    $stmt->execute(array('mail' => $mail));
    $result = $stmt->fetchAll();
    if ($result != null){
        return true;
    }
    return false;
}

function getUtilisateur($mail) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :mail");
    $stmt->execute(array('mail' => $mail));
    $result = $stmt->fetchAll();
    if ($result){
        return $result;
    }
    return $restaurants;
}

// chargementFichier(__DIR__."./../../data/restaurants_orleans.json");

 
function insertClient($nom, $prenom, $tel, $email, $cp, $ville, $mdp, $handicap) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO users (name, prenom, telephone, email, codepostal, ville, mdp) Values (?,?,?,?,?,?,?)");
    $stmt->execute([$nom, $prenom, $tel, $email,$cp, $ville, $mdp]);
}

function ajoutePrefCuisine($email, $cuisine){
    
}

function getPrefCuisine($email){
    return array("Chinoise","Americaine");
}

function getRegion($ville) {
    // Exemple de simulation de données
    $data = [
        "Moret" => [[null, "Pensylvanie"], ["Loir-et-Cher", "Centre-Val de Loire"]],
        "Orleans" => [["Loiret", "Centre-Val de Loire"]],
        "Nates" => [["Loire-Atlantique", "Pays de la Loire"]],
        "Lille" => [["Nord", "Hauts-de-France"]]
    ];

    return $data[$ville] ?? [];
}

function getBestResto(){
    $resto = new Restaurant(
        1, "test BEST RESTO", "", "Centre-Val-De-Loire", "Loiret", "Orléans",
        "1.9052942", "47.902964", "https://test.com", "@testbest",
        "06 06 06 06 69", 3.4, 42, true, false, true, true, false,
        "12:00-14:00,19:00-22:00", ["Française", "Italienne"]
    );

    return array_fill(0, 10, $resto);
}
function getPopResto(){
    $resto = new Restaurant(
        1, "test POPULAR", "", "Centre-Val-De-Loire", "Loiret", "Orléans",
        "1.9052942", "47.902964", "https://test.com", "@testPOP",
        "06 06 06 69 06", 3.4, 42, true, false, true, true, false,
        "12:00-14:00,19:00-22:00", ["Chinoise"]
    );

    return array_fill(0, 10, $resto);
}
