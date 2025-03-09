<?php



$host = 'aws-0-eu-west-3.pooler.supabase.com';
$dbname = 'postgres';
$user = 'postgres.vicnhizlpnnchlerpqtr';
$password = 'SAEMLF2025.';
$port = '5432'; // Par défaut, 5432

// Création de la connexion avec PDO
$dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password";
$connexion = new PDO($dsn);


function getMeilleurRestaurant($codeRegion, $codeDepartement, $codeCommune){
    global $connexion;

    $sortie = [];

    $localisation = lesNomsRegions($codeRegion, $codeDepartement, $codeCommune);

    $requete = $connexion->prepare("SELECT r.*, AVG(NULLIF(n.Note, 0)) AS moy FROM RESTAURANT r LEFT JOIN NOTER n ON r.OsmID = n.OsmID LEFT JOIN COMMUNE c ON r.CodeCommune = c.CodeCommune LEFT JOIN DEPARTEMENT d ON c.CodeDepartement = d.CodeDepartement LEFT JOIN REGION reg ON d.CodeRegion = reg.CodeRegion  WHERE c.codeRegion = ? and c.codeDepartement = ? and c.codeCommune = ? GROUP BY r.OsmID ORDER BY moy, r.OsmID;");
    $requete->execute([$codeRegion, $codeDepartement, $codeCommune]);
    $resultat = $requete->fetchAll();

    foreach($resultat as $row){
        if (count($sortie)<10) {

            $cuisine = [];
            $requete2 = $connexion->prepare("select * from RESTAURANT natural join PREPARER where OsmID = ?");
            $requete2->execute([$row["osmid"]]);
            $resultat2 = $requete->fetchAll();

            foreach($resultat2 as $row2){
                array_push($cuisine,$row2["nomcuisine"]);
            }

            $restaurant = new Restaurant($row["osmid"],
                                         $row["nomrestaurant"],
                                         ($row["description"]==null) ? "" : $row["description"],
                                         $localisation[0] ,
                                         $localisation[1],
                                         $localisation[2],
                                         $row["longitude"],
                                         $row["latitude"],
                                         ($row["siteweb"]==null) ? "" : $row["siteweb"],
                                         ($row["facebook"]==null) ? "" : $row["facebook"],
                                         ($row["telrestaurant"]==null) ? "" : $row["telrestaurant"],
                                         floatval($row["moy"]),
                                         ($row["capacite"]==null) ? 0 : $row["capacite"],
                                         ($row["fumeur"]==null) ? 0 : $row["fumeur"],
                                         ($row["drive"]==null) ? 0 : $row["drive"],
                                         ($row["aemporter"]==null) ? 0 : $row["aemporter"],
                                         ($row["livraison"]==null) ? 0 : $row["livraison"],
                                         ($row["vegetarien"]==null) ? 0 : $row["vegetarien"],
                                         ($row["horrairesouverture"]==null) ? "" : $row["horrairesouverture"],
                                         $cuisine,
                                         fetchNoteRestaurant($row["osmid"]));

            array_push($sortie, $restaurant);
        }
    }
    return $sortie;
}

function getRestaurantPopulaire($codeRegion, $codeDepartement, $codeCommune){
    global $connexion;

    $sortie = [];

    $localisation = lesNomsRegions($codeRegion, $codeDepartement, $codeCommune);

    $requete = $connexion->prepare("SELECT r.*, AVG(NULLIF(n.Note, 0)) AS moy, COUNT(n.Note) AS place FROM RESTAURANT r LEFT JOIN NOTER n ON r.OsmID = n.OsmID LEFT JOIN COMMUNE c ON r.CodeCommune = c.CodeCommune LEFT JOIN DEPARTEMENT d ON c.CodeDepartement = d.CodeDepartement LEFT JOIN REGION reg ON d.CodeRegion = reg.CodeRegion  WHERE c.codeRegion = ? and c.codeDepartement = ? and c.codeCommune = ? GROUP BY r.OsmID ORDER BY place,moy, r.OsmID;");
    $requete->execute([$codeRegion, $codeDepartement, $codeCommune]);
    $resultat = $requete->fetchAll();

    foreach($resultat as $row){
        if (count($sortie)<10) {

            $cuisine = [];
            $requete2 = $connexion->prepare("select * from RESTAURANT natural join PREPARER where OsmID = ?");
            $requete2->execute([$row["osmid"]]);
            $resultat2 = $requete->fetchAll();

            foreach($resultat2 as $row2){
                array_push($cuisine,$row2["nomcuisine"]);
            }

            $restaurant = new Restaurant($row["osmid"],
                                         $row["nomrestaurant"],
                                         ($row["description"]==null) ? "" : $row["description"],
                                         $localisation[0] ,
                                         $localisation[1],
                                         $localisation[2],
                                         $row["longitude"],
                                         $row["latitude"],
                                         ($row["siteweb"]==null) ? "" : $row["siteweb"],
                                         ($row["facebook"]==null) ? "" : $row["facebook"],
                                         ($row["telrestaurant"]==null) ? "" : $row["telrestaurant"],
                                         floatval($row["moy"]),
                                         ($row["capacite"]==null) ? 0 : $row["capacite"],
                                         ($row["fumeur"]==null) ? 0 : $row["fumeur"],
                                         ($row["drive"]==null) ? 0 : $row["drive"],
                                         ($row["aemporter"]==null) ? 0 : $row["aemporter"],
                                         ($row["livraison"]==null) ? 0 : $row["livraison"],
                                         ($row["vegetarien"]==null) ? 0 : $row["vegetarien"],
                                         ($row["horrairesouverture"]==null) ? "" : $row["horrairesouverture"],
                                         $cuisine,
                                         fetchNoteRestaurant($row["osmid"]));

            array_push($sortie, $restaurant);
        }
    }
    return $sortie;
}




function chargementFichier($chemin){
    global $connexion;

    echo "test";

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

        foreach ($restaurant["cuisine"] ?? [] as $nom) {
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
      

//chargementFichier("./src/data/restaurants_orleans.json");

//var_dump(getMeilleurRestaurant(24, 45, 45234));

// $pdo = new PDO('sqlite:'.$db_path);
// $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
// $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

function utilisateurExistant($mail, $mdp) {
    global $connexion;
    $hash=hash('sha256',$mdp);
    $requete = $connexion->prepare("SELECT * FROM PERSONNE WHERE EMailPersonne = :mail AND MotDePasse = :mdp");
    $requete->execute(['mail' => $mail,
                       'mdp' => $hash]);
    $result = $requete->fetch();
    if ($result != null){
        return true;
    }
    return false;
}
//utilisateurExistant("", "");


function getUtilisateur($mail) {
    global $connexion;
    $stmt = $connexion->prepare("SELECT * FROM PERSONNE WHERE EMailPersonne = :mail");
    $stmt->execute(array('mail' => $mail));
    $result = $stmt->fetchAll();
    return $result;
}

// chargementFichier(__DIR__."./../../data/restaurants_orleans.json");

 
function insertClient($nom, $prenom, $tel, $email, $codeRegion, $codeDepartement, $codeCommune, $mdp, $handicap) {
    global $connexion;
    $hash=hash('sha256',$mdp);
    $requete = $connexion->prepare("INSERT INTO PERSONNE (EMailPersonne, PrenomPersonne, NomPersonne, TelPersonne, MotDePasse, Role, codeRegion, codeDepartement, codeCommune, Handicap) Values (?,?,?,?,?,?,?,?,?,?)");
    $requete->execute([$email, $prenom, $nom, $tel, $hash, "Client", $codeRegion, $codeDepartement, $codeCommune, $handicap]);
}


function ajoutePrefCuisine($email, $cuisine){
    global $connexion;
    $requete = $connexion->prepare("INSERT INTO PREFERER (EMailPersonne, nomCuisine) VALUES (?,?)");
    $requete->execute([$email, $cuisine]);
}

function ajouteNote($email, $osmid, $note, $commentaire){
    global $connexion;
    $requete = $connexion->prepare("INSERT INTO NOTER (EMailPersonne, OsmID, Note, Commentaire, Date) VALUES (?,?,?,?,?)");
    $requete->execute([$email, $osmid,$note,$commentaire,date('Y-m-d H:i:s')]);
}

function modifNote($email, $osmid, $note, $commentaire){
    global $connexion;
    $requete = $connexion->prepare("UPDATE NOTER SET Note=?, Commentaire=? WHERE EMailPersonne=? and OsmID=?");
    $requete->execute([$note,$commentaire,$email, $osmid]);
}

function getCommentaire($mail) {
    global $connexion;
    $stmt = $connexion->prepare("SELECT * FROM NOTER WHERE EMailPersonne = :mail");
    $stmt->execute(array('mail' => $mail));
    $result = $stmt->fetchAll();
    return $result;
}

function fetchNoteRestaurant($osmid){
    global $connexion;
    $resultat = [];
    $requete = $connexion->prepare("SELECT * FROM NOTER NATURAL JOIN PERSONNE WHERE OsmID = ? ");
    $requete->execute([$osmid]);
    $result = $requete->fetchAll();

    foreach($result as $row){
        array_push($resultat,new Note($row['emailpersonne'],
                                                      $row['note'],
                                                      $row['commentaire'],
                                                      $row['date'],
                                                      $row['nompersonne'],
                                                      $row['prenompersonne']
                                                    ));
    }

    return $resultat;
}


function getPrefCuisine($email){
    global $connexion;
    $requete = $connexion->prepare("SELECT nomCuisine FROM PREFERER WHERE EMailPersonne = ? ");
    $requete->execute([$email]);
    $result = $requete->fetchAll();
    return $result;
}

function getRegion($ville) {
    // Exemple de simulation de données
    global $connexion;
    $resultat = [];
    $requete = $connexion->prepare("SELECT * FROM COMMUNE NATURAL JOIN DEPARTEMENT NATURAL JOIN REGION WHERE NomCommune = ? ");
    $requete->execute([$ville]);
    $result = $requete->fetchAll();

    foreach($result as $row){
        array_push($resultat,[$row["nomdepartement"],$row["nomregion"]]);
    }

    return $resultat;
}

function getBestResto(){
    // $resto = new Restaurant(
    //     1, "test BEST RESTO", "", "Centre-Val-De-Loire", "Loiret", "Orléans",
    //     "1.9052942", "47.902964", "https://test.com", "@testbest",
    //     "06 06 06 06 69", 3.4, 42, true, false, true, true, false,
    //     "12:00-14:00,19:00-22:00", ["Française", "Italienne"]
    // );

    return getMeilleurRestaurant(24, 45, 45234);
}

function getPopResto(){
    // $resto = new Restaurant(
    //     1, "test POPULAR", "", "Centre-Val-De-Loire", "Loiret", "Orléans",
    //     "1.9052942", "47.902964", "https://test.com", "@testPOP",
    //     "06 06 06 69 06", 3.4, 42, true, false, true, true, false,
    //     "12:00-14:00,19:00-22:00", ["Chinoise"]
    // );

    return getRestaurantPopulaire(24, 45, 45234);
}

function getRestoById($osmid){
    global $connexion;
    $requete = $connexion->prepare("SELECT r.*, AVG(NULLIF(n.Note, 0)) AS moy FROM RESTAURANT r LEFT JOIN NOTER n ON r.OsmID = n.OsmID LEFT JOIN COMMUNE c ON r.CodeCommune = c.CodeCommune LEFT JOIN DEPARTEMENT d ON c.CodeDepartement = d.CodeDepartement LEFT JOIN REGION reg ON d.CodeRegion = reg.CodeRegion  WHERE r.OsmID = ? GROUP BY r.OsmID;");
    $requete->execute([$osmid]);
    $result = $requete->fetch();

    $cuisine = [];
    $requete2 = $connexion->prepare("select * from RESTAURANT natural join PREPARER where OsmID = ?");
    $requete2->execute([$result["osmid"]]);
    $resultat2 = $requete->fetchAll();

    foreach($resultat2 as $row2){
        array_push($cuisine,$row2["nomcuisine"]);
    }

    return new Restaurant($result["osmid"],
                          $result["nomrestaurant"],
                          ($result["description"]==null) ? "" : $result["description"],
                          '$row["nomregion"]' ,
                          '$row["nomdepartement"]',
                          '$row["nomcommune"]',
                          $result["longitude"],
                          $result["latitude"],
                          ($result["siteweb"]==null) ? "" : $result["siteweb"],
                          ($result["facebook"]==null) ? "" : $result["facebook"],
                          ($result["telrestaurant"]==null) ? "" : $result["telrestaurant"],
                          floatval($result["moy"]),
                          ($result["capacite"]==null) ? 0 : $result["capacite"],
                          ($result["fumeur"]==null) ? 0 : $result["fumeur"],
                          ($result["drive"]==null) ? 0 : $result["drive"],
                          ($result["aemporter"]==null) ? 0 : $result["aemporter"],
                          ($result["livraison"]==null) ? 0 : $result["livraison"],
                          ($result["vegetarien"]==null) ? 0 : $result["vegetarien"],
                          ($result["horrairesouverture"]==null) ? "" : $result["horrairesouverture"],
                          $cuisine,
                          fetchNoteRestaurant($result["osmid"]));

}

function estFavoris($mail, $osmid){
    global $connexion;
    $requete = $connexion->prepare("SELECT * FROM FAVORI WHERE EmailPersonne = ? and OsmID = ?");
    $requete->execute([$mail, $osmid]);
    $result = $requete->fetch();

    return $result!=null;
}

function lesNomsRegions($codeRegion, $codeDepartement, $codeCommune){
    global $connexion;
    $requete = $connexion->prepare("SELECT * FROM REGION NATURAL JOIN DEPARTEMENT NATURAL JOIN COMMUNE WHERE codeRegion = ? and codeDepartement = ? and codeCommune = ?");
    $requete->execute([$codeRegion, $codeDepartement, $codeCommune]);
    $result = $requete->fetch();

    return [$result['nomregion'],$result['nomdepartement'],$result['nomcommune']];
}

function ajouter_supprimerFavoris($mail, $osmid){
    global $connexion;
    try{
        $requete = $connexion->prepare("INSERT INTO FAVORI (EmailPersonne, OsmID) Values (?,?)");
        $requete->execute([$mail, $osmid]);
    } catch (\Throwable $th) {
        $requete = $connexion->prepare("DELETE FROM FAVORI WHERE EmailPersonne = ? and OsmID = ?");
        $requete->execute([$mail, $osmid]);
    }
}

function fetchCuisine(){
    global $connexion;
    $requete = $connexion->prepare("SELECT * FROM CUISINE");
    $requete->execute();
    $result = $requete->fetchAll();

    return $result;
}
















function getrestoAll(){
    global $connexion;
    $requete = $connexion->prepare("SELECT r.*, AVG(NULLIF(n.Note, 0)) AS moy FROM RESTAURANT r LEFT JOIN NOTER n ON r.OsmID = n.OsmID LEFT JOIN COMMUNE c ON r.CodeCommune = c.CodeCommune LEFT JOIN DEPARTEMENT d ON c.CodeDepartement = d.CodeDepartement LEFT JOIN REGION reg ON d.CodeRegion = reg.CodeRegion  GROUP BY r.OsmID;");
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









function getNomCuisine(){
    global $connexion;
    $ListeNomCuisine = [];
    $requete = $connexion->prepare("select nomcuisine from CUISINE ");
    $requete->execute();
    $resultat = $requete->fetchAll();

    foreach($resultat as $row){
        array_push($ListeNomCuisine, $row );
    }
    return $ListeNomCuisine;
}


function getimputeNomCuisine(){
    try {
    global $connexion;

        $requete = $connexion->prepare("select nomcuisine from CUISINE ");
        $requete->execute();
        $resultat = $requete->fetchAll();

        foreach($resultat as $row){
            echo '<input class="styled" type="submit" id='.$row['nomcuisine'].' name="nourriture" value="'.$row['nomcuisine'].'"'.$row['nomcuisine'].' />';
        }
    } catch (PDOException $e) {
        echo 'Exception reçue : ',  $e->getMessage(), "\n";
        for($i=0;$i<5;$i++){
            echo '<input class="styled" type="button" id="X" name="X" value="food" X />';
        }
    }

}

function getPOSTNomCuisine(){
    try {
        global $connexion;
        $ListeNomCuisineActif = [];
        $requete = $connexion->prepare("select nomcuisine from CUISINE ");
        $requete->execute();
        $resultat = $requete->fetchAll();

        print_r($_POST);
        foreach($_POST as $key => $value){
            
            if (in_array($value,$resultat)) {
                array_push($ListeNomCuisineActif, $value );
                echo($value);
            }
            

            
        }
        return $ListeNomCuisineActif;
    } catch (PDOException $e) {
        echo 'Exception reçue : ',  $e->getMessage(), "\n";
         return $ListeNomCuisineActif;
    }
}


