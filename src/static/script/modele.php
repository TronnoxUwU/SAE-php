<?php
$dsn = "mysql:dbname="."sae_mlp".";host="."127.0.0.1";
try{
    $connexion = new PDO($dsn, "root", "clermont");
}
catch(PDOException $e){
    printf("Error connecting to database: %s", $e->getMessage());
    exit();
}


function getMoniteur(){
    global $connexion;
    $sql = "SELECT * FROM PERSONNE NATURAL JOIN ENCADRANT where idPers = idEnc order by nomPers";
    if (!$connexion->query($sql)){
        echo "Error: %s\n";
    }
    else{
        $result = $connexion->query($sql);
        echo "<table border='1'>";
        echo "<tr><th>Nom</th><th>Prénom</th></tr>";
        foreach($result as $row){
            echo "<tr>";
            echo "<td>".$row['nomPers']."</td>";
            echo "<td>".$row['prenomPers']."</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
}

function getAdherent(){
    global $connexion;
    $sql = "SELECT * FROM PERSONNE NATURAL JOIN CLIENT where idPers = idCli order by nomPers";
    if (!$connexion->query($sql)){
        echo "Error: %s\n";
    }
    else{
        $result = $connexion->query($sql);
        echo "<table border='1'>";
        echo "<tr><th>Nom</th><th>Prénom</th><th>Tel</th><th>Mail</th><th>Taille</th><th>Poids</th></tr>";
        foreach($result as $row){
            echo "<tr>";
            echo "<td>".$row['nomPers']."</td>";
            echo "<td>".$row['prenomPers']."</td>";
            echo "<td>".$row['tel']."</td>";
            echo "<td>".$row['mail']."</td>";
            echo "<td>".$row['taille']."</td>";
            echo "<td>".$row['poids']."</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
}

function getPoneys(){
    global $connexion;
    $sql = "SELECT * FROM PONEY order by nomRace";
    if (!$connexion->query($sql)){
        echo "Error: %s\n";
    }
    else{
        $result = $connexion->query($sql);
        echo "<table border='1'>";
        echo "<tr><th>Race</th><th>Nom</th><th>Poids maximal</th><th>Taille Mininimale</th></tr>";
        foreach($result as $row){
            echo "<tr>";
            echo "<td>".$row['nomRace']."</td>";
            echo "<td>".$row['nomPoney']."</td>";
            echo "<td>".$row['poidsMax']."</td>";
            echo "<td>".$row['tailleMin']."</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
}

function insertPersonne($nom, $prenom, $tel, $mail, $taille, $poids,$mdp){
    global $connexion;
    $sql = "SELECT max(idPers) as maxid FROM PERSONNE";
    $result = $connexion->query($sql);
    //var_dump($result) ;
    $row = $result->fetch();
    $id = $row['maxid'] + 1;

    $hash=hash('sha256',$mdp);
    $stmt = $connexion->prepare("INSERT INTO PERSONNE (nomPers,prenomPers,poids,taille,tel,mail,mdp) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nom, $prenom, $poids, $taille, $tel, $mail, $hash]);

    return $id;
}

function insertMoniteur($nom, $prenom, $tel, $mail, $taille, $poids, $nbHeureMax,$mdp){
    global $connexion;
    $id = insertPersonne($nom, $prenom, $tel, $mail, $taille, $poids,$mdp);
    //echo "---->".$id;
    $stmt = $connexion->prepare("INSERT INTO ENCADRANT (idEnc,nbHeuresMax) VALUES (?, ?)");
    $stmt->execute([$id, $nbHeureMax]);
}

function insertAdherent($nom, $prenom, $tel, $mail, $taille, $poids, $dateInscription, $mdp){
    global $connexion;
    //echo $nom.$prenom.$tel.$mail.$taille.$poids.$dateInscription;
    $id = insertPersonne($nom, $prenom, $tel, $mail, $taille, $poids,$mdp);
    $stmt = $connexion->prepare("INSERT INTO CLIENT (idCli,dateInscription) VALUES (?, ?)");
    $stmt->execute([$id, $dateInscription]);
    assignerNiveau($id, 1, $dateInscription);
}

function insertPoney($nomPoney, $nomRace, $poidsMax, $tailleMin){
    global $connexion;
    $stmt = $connexion->prepare("INSERT INTO PONEY (nomPoney,nomRace,poidsMax,tailleMin) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nomPoney, $nomRace, $poidsMax, $tailleMin]);
}

function creerCours($nbPersonne, $nomCours, $niveau){
    global $connexion;
    $sql = "SELECT max(idCours) as maxid FROM COURS";
    $result = $connexion->query($sql);
    $row = $result->fetch();
    $id = $row['maxid'] + 1;
    $stmt = $connexion->prepare("INSERT INTO COURS (idCours,nbPersonneMax,nomCours,niveau) VALUES (?, ?, ?, ?)");
    $stmt->execute([$id, $nbPersonne, $nomCours, $niveau]);
}

function creerSceance($encadrant, $heureDebut, $duree, $jma, $idCours, $intitule){
    global $connexion;
    $sql = "SELECT max(idSeance) as maxid FROM SEANCE";
    $result = $connexion->query($sql);
    $row = $result->fetch();
    $id = $row['maxid'] + 1;
    $stmt = $connexion->prepare("INSERT INTO SEANCE (idSeance,encadrantSeance,heureDebut,duree,jma,idCours,intitule) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$id, $encadrant, $heureDebut, $duree, $jma, $idCours, $intitule]);
}

function reserveCreneau($idCli,$idSceance){
    global $connexion;

    $stmt = $connexion->prepare("INSERT INTO RESERVER (idSeance,idCli) VALUES (?, ?)");
    $stmt->execute([$idSceance,$idCli]);
}

function assignerNiveau($idCli, $niveau, $dateObtention){
    //echo"    ----->";var_dump($idCli);
    //echo"    ----->";var_dump($niveau);
    //echo"    ----->";var_dump($dateObtention);
    global $connexion;
    $stmt = $connexion->prepare("INSERT INTO obtenir_lvl (idPers,niveau,jma) VALUES (?, ?, ?)");
    $stmt->execute([$idCli, $niveau, $dateObtention]);
}

function cotiser($idCli, $anneeCotisation, $montant){
    global $connexion;
    $stmt = $connexion->prepare("INSERT INTO COTISATION_CLIENT (idCli,anneeCotisation,prix) VALUES (?, ?, ?)");
    $stmt->execute([$idCli, $anneeCotisation, $montant]);
}

function assignerPoney($idPoney, $idSceance){
    global $connexion;
    $stmt = $connexion->prepare("INSERT INTO PONEY_RESERVE (idPoney,idSeance) VALUES (?, ?)");
    $stmt->execute([$idPoney, $idSceance]);
}

function utilisateurExistant($mail,$mdp){
    global $connexion;
    $hash=hash('sha256',$mdp);
    $sql = "SELECT * FROM PERSONNE where mail=? and mdp=?";
    $stmt = $connexion->prepare($sql);
    $stmt->execute([$mail,$hash]);
    $result = $stmt->fetch();
    if($result){
        return $result['idPers'];
    }
    else{
        return -1;
    }
}


function isUtilisateurExistant($mail,$mdp){
    global $connexion;
    $hash=hash('sha256',$mdp);
    $sql = "SELECT * FROM PERSONNE where mail=? and mdp=?";
    $stmt = $connexion->prepare($sql);
    $stmt->execute([$mail,$hash]);
    $result = $stmt->fetch();
    if($result){
        return true;
    }
    else{
        return false;
    }
}

function isMoniteur($mail, $mdp){
    global $connexion;
    $hash=hash('sha256',$mdp);
    $sql = "SELECT * FROM PERSONNE NATURAL JOIN ENCADRANT where mail=? and mdp=? and idPers=idEnc";
    $stmt = $connexion->prepare($sql);
    $stmt->execute([$mail,$hash]);
    $result = $stmt->fetch();
    if($result){
        return true;
    }
    else{
        return false;
    }
}

function isAdherent($mail, $mdp){
    global $connexion;
    $hash=hash('sha256',$mdp);
    $sql = "SELECT * FROM PERSONNE NATURAL JOIN CLIENT where mail=? and mdp=? and idPers=idCli";
    $stmt = $connexion->prepare($sql);
    $stmt->execute([$mail,$hash]);
    $result = $stmt->fetch();
    if($result){
        return true;
    }
    else{
        return false;
    }
}

function isAdmin($mail, $mdp){
    global $connexion;
    $hash=hash('sha256',$mdp);
    $sql = "SELECT * FROM PERSONNE NATURAL JOIN ADMIN where mail=? and mdp=? and idPers=idAdm";
    $stmt = $connexion->prepare($sql);
    $stmt->execute([$mail,$hash]);
    $result = $stmt->fetch();
    if($result){
        return true;
    }
    else{
        return false;
    }
}

function getUtilisateur($email, $mdp) {
    global $connexion;
    $stmt = $connexion->prepare("SELECT * FROM PERSONNE WHERE mail = :email AND mdp = :mdp");
    $stmt->execute([
        ':email' => $email,
        ':mdp' => hash('sha256', $mdp)
    ]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function updateUtilisateur($email, $mdp, $nom, $prenom, $telephone, $taille, $poids, $NEWmdp = null) {
    try {
        global $connexion;
        $query = "UPDATE personne SET nomPers = :name, prenomPers = :prenom, tel = :telephone, taille = :taille, poids = :poids";
        if ($NEWmdp) {
            $query .= ", mdp = :new_mdp";
        }
        $query .= " WHERE mail = :email AND mdp = :mdp";

        $stmt = $connexion->prepare($query);
        $stmt->bindParam(':name', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':telephone', $telephone);
        $stmt->bindParam(':taille', $taille);
        $stmt->bindParam(':poids', $poids);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':mdp', hash('sha256', $mdp));
        if ($NEWmdp) {
            $stmt->bindParam(':new_mdp', hash('sha256', $NEWmdp));
        }
        $stmt->execute();
        $stmt->fetch();
    } catch (Exception $e) {
        throw new Exception("Erreur lors de la mise à jour de l'utilisateur : " . $e->getMessage());
    }
}

function getLvl($mail){
    global $connexion;
    $sql = "SELECT max(niveau) FROM OBTENIR_LVL NATURAL JOIN PERSONNE where mail=?";
    $stmt = $connexion->prepare($sql);
    $stmt->execute([$mail]);
    $result = $stmt->fetch();
    return $result[0];
}

function getEtatAbonnement($idCli) {
    global $connexion;
    $annee = date("Y");
    $sql = "SELECT COUNT(*) as count FROM COTISATION_CLIENT WHERE idCli = ? AND anneeCotisation = ?";
    $stmt = $connexion->prepare($sql);
    $stmt->execute([$idCli, $annee]);
    $result = $stmt->fetch();

    return ['payé' => $result['count'] > 0];
}

function enregistrerCotisation($idCli) {
    global $connexion;
    $annee = date("Y");
    $montant = 100;

    //echo $idCli.$annee;

    try {
        // cotisation existe déjà
        $sqlCheck = "SELECT COUNT(*) as count FROM COTISATION_CLIENT WHERE idCli = ? AND anneeCotisation = ?";
        $stmtCheck = $connexion->prepare($sqlCheck);
        $stmtCheck->execute([$idCli, $annee]);
        $resultCheck = $stmtCheck->fetch();

        if ($resultCheck['count'] > 0) {
            return "La cotisation pour l'année $annee est déjà enregistrée.";
        }

        // Ajout cotisation
        $sqlInsert = "INSERT INTO COTISATION_CLIENT (idCli, anneeCotisation, prix) VALUES (?, ?, ?)";
        $stmtInsert = $connexion->prepare($sqlInsert);
        $stmtInsert->execute([$idCli, $annee, $montant]);

        return "Cotisation de $montant € enregistrée avec succès pour l'utilisateur $idCli pour l'année $annee.";
    } catch (PDOException $e) {
        return "Erreur lors de l'enregistrement de la cotisation : " . $e->getMessage();
    }
}

// function getReserve($idClient){
//     global $connexion;
//     $sql = "SELECT * FROM RESERVER NATURAL JOIN SEANCE NATURAL JOIN COURS NATURAL JOIN ENCADRANT WHERE idCli = ? AND jma >= CURDATE()";
//     $stmt = $connexion->prepare($sql);
//     $stmt->execute([$idClient]);
//     return $stmt->fetchAll(PDO::FETCH_ASSOC);
// }

function getProchainCours($idClient) {
    global $connexion;
    $sql = "SELECT s.intitule, s.jma AS date, s.heureDebut, c.niveau, p.nomPers AS moniteur
            FROM SEANCE s
            JOIN COURS c ON s.idCours = c.idCours
            JOIN ENCADRANT e ON s.encadrantSeance = e.idEnc
            JOIN PERSONNE p ON e.idEnc = p.idPers
            JOIN RESERVER r ON s.idSeance = r.idSeance
            WHERE r.idCli = ?
            AND s.jma >= CURDATE()
            ORDER BY s.jma, s.heureDebut";
    
    $stmt = $connexion->prepare($sql);
    $stmt->execute([$idClient]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getInfoSeance($id){
    global $connexion;
    $sql = "SELECT nbPersonneMax,nomCours,nomPers,prenomPers,intitule FROM COURS NATURAL JOIN SEANCE NATURAL JOIN PERSONNE where idSeance=?";
    $stmt = $connexion->prepare($sql);
    $stmt->execute([$id]);
    $resBrut = $stmt->fetch();
    return $resBrut;
}

function getParticipants($id){
    global $connexion;
    $sql = "SELECT DISTINCT nomPers,prenomPers FROM COURS NATURAL JOIN RESERVER INNER JOIN PERSONNE ON RESERVER.idCli=PERSONNE.idPers  where idSeance=?";
    $stmt = $connexion->prepare($sql);
    $stmt->execute([$id]);
    $resBrut = $stmt->fetchAll();
    $resPropre = [];

    foreach ($resBrut as $rows) {
        array_push($resPropre,['nom'=>$rows['nomPers'],'prenom'=>$rows['prenomPers']]);
    }
    return $resPropre;
}

function getCours($dateDebut,$dateFin){
    global $connexion;
    $sql = "SELECT idSeance,intitule,heureDebut,duree,jma FROM SEANCE WHERE jma > STR_TO_DATE(?,'%Y-%m-%d') AND jma < STR_TO_DATE(?,'%Y-%m-%d') ORDER BY jma";
    $stmt = $connexion->prepare($sql);
    $stmt->execute([$dateDebut,$dateFin]);
    $resBrut = $stmt->fetchAll();
    $resPropre = ['Lundi'=>[],
                    'Mardi'=>[],
                    'Mercredi'=>[],
                    'Jeudi'=>[],
                    'Vendredi'=>[],
                    'Samedi'=>[],
                    'Dimanche'=>[]];
    

    foreach ($resBrut as $rows) {
        $jour = new DateTime($rows['jma']);
        array_push($resPropre[array_keys($resPropre)[$jour->format('N')-1]],['id'=>$rows["idSeance"],
                                                                             'debut'=>$rows["heureDebut"],
                                                                             'fin'=>$rows["heureDebut"]+$rows["duree"],
                                                                             'intitulé'=>$rows["intitule"]]);
    }
    return $resPropre;
}

