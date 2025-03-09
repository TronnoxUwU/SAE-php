<?php

include_once __DIR__.'/../../static/script/getKey.php';
require_once __DIR__.'/../../static/script/getImage.php';

class Restaurant{
    private int $osmId;
    private string $nomRestaurant;
    private string $description;
    private string $region;
    private string $departement;
    private string $ville;
    private float $longitude;
    private float $latitude;
    private string $siteWeb;
    private string $facebook;
    private string $telRestaurant;
    private float $nbEtoiles;
    private int $capacite;
    private bool $fumeur;
    private bool $drive;
    private bool $aEmporter;
    private bool $livraison;
    private bool $vegetarien;
    private string $horairesOuverture;
    private array $cuisines;
    private array $notes;


    public function __construct($osmId, $nomRestaurant, $description, $region, $departement, $ville, $longitude, $latitude, $siteWeb, $facebook, $telRestaurant, $nbEtoiles, $capacite, $fumeur, $drive, $aEmporter, $livraison, $vegetarien, $horairesOuverture, $cuisines, $Notes){
        $this->osmId = $osmId;
        $this->nomRestaurant = $nomRestaurant;
        $this->description = $description;
        $this->region = $region;
        $this->departement = $departement;
        $this->ville = $ville;
        $this->longitude = $longitude;
        $this->latitude = $latitude;
        $this->siteWeb = $siteWeb;
        $this->facebook = $facebook;
        $this->telRestaurant = $telRestaurant;
        $this->nbEtoiles = $nbEtoiles;
        $this->capacite = $capacite;
        $this->fumeur = $fumeur;
        $this->drive = $drive;
        $this->aEmporter = $aEmporter;
        $this->livraison = $livraison;
        $this->vegetarien = $vegetarien;
        $this->horairesOuverture = $horairesOuverture;
        $this->cuisines = $cuisines;
        $this->notes = $Notes;
    }

    public function getOsmId(){
        return $this->osmId;
    }

    public function getNomRestaurant(){
        return $this->nomRestaurant;
    }

    public function getNotes(){
        return $this->notes;
    }

    public function getDescription(){
        return $this->description;
    }

    public function getRegion(){
        return $this->region;
    }

    public function getDepartement(){
        return $this->departement;
    }

    public function getVille(){
        return $this->ville;
    }

    public function getLongitude(){
        return $this->longitude;
    }

    public function getLatitude(){
        return $this->latitude;
    }

    public function getSiteWeb(){
        return $this->siteWeb;
    }

    public function getFacebook(){
        return $this->facebook;
    }

    public function getTelRestaurant(){
        return $this->telRestaurant;
    }

    public function getNbEtoiles(){
        return $this->nbEtoiles;
    }

    public function getCapacite(){
        return $this->capacite;
    }

    public function getFumeur(){
        return $this->fumeur;
    }

    public function getDrive(){
        return $this->drive;
    }

    public function getAEmporter(){
        return $this->aEmporter;
    }

    public function getLivraison(){
        return $this->livraison;
    }

    public function getVegetarien(){
        return $this->vegetarien;
    }

    public function getHorairesOuverture(){
        return $this->horairesOuverture;
    }

    public function getCuisines(){
        return $this->cuisines;
    }

    public function setOsmId($osmId){
        $this->osmId = $osmId;
    }

    public function setNomRestaurant($nomRestaurant){
        $this->nomRestaurant = $nomRestaurant;
    }

    public function setDescription($description){
        $this->description = $description;
    }

    public function setRegion($region){
        $this->region = $region;
    }

    public function setDepartement($departement){
        $this->departement = $departement;
    }

    public function setVille($ville){
        $this->ville = $ville;
    }

    public function setLongitude($longitude){
        $this->longitude = $longitude;
    }

    public function setLatitude($latitude){
        $this->latitude = $latitude;
    }

    public function setSiteWeb($siteWeb){
        $this->siteWeb = $siteWeb;
    }

    public function setFacebook($facebook){
        $this->facebook = $facebook;
    }

    public function setTelRestaurant($telRestaurant){
        $this->telRestaurant = $telRestaurant;
    }

    public function setNbEtoiles($nbEtoiles){
        $this->nbEtoiles = $nbEtoiles;
    }

    public function setCapacite($capacite){
        $this->capacite = $capacite;
    }

    public function setFumeur($fumeur){
        $this->fumeur = $fumeur;
    }

    public function setDrive($drive){
        $this->drive = $drive;
    }

    public function setAEmporter($aEmporter){
        $this->aEmporter = $aEmporter;
    }

    public function setLivraison($livraison){
        $this->livraison = $livraison;
    }

    public function setVegetarien($vegetarien){
        $this->vegetarien = $vegetarien;
    }

    public function setHorairesOuverture($horairesOuverture){
        $this->horairesOuverture = $horairesOuverture;
    }

    public function setCuisines($cuisines){
        $this->cuisines = $cuisines;
    }

    public function addCuisine($cuisine){
        $this->cuisines[] = $cuisine;
    }

    public function removeCuisine($cuisine){
        $key = array_search($cuisine, $this->cuisines);
        if($key !== false){
            unset($this->cuisines[$key]);
        }
    }

    public function addNote($note){
        $this->notes[] = $note;
    }

    public function localiser(){
        # A remplacer par un appelle de fonction qui renvoie la localisation du restaurant
        return $this->ville.', '.$this->departement.', '.$this->region;
    }

    public function getNbCommentaire(){
        # A remplacer par un appelle de fonction qui renvoie le nombre de commentaire du restaurant
        return sizeof($this->notes);
    }

    public function getPremierCommentaire(){
        # A remplacer par un appelle de fonction qui renvoie le premier commentaire du restaurant
        echo "<p>".$this->notes[0]->getMailAuteur().' a donné une note de '.$this->notes[0]->getNote().'☆ : '.'</p>';
        echo  "<p>".$this->notes[0]->getCommentaire()."</p>";
    }

    public function getCommentaires(){
        # A remplacer par un appelle de fonction qui renvoie les commentaires du restaurant
        foreach($this->notes as $note){
            echo "<div class='commentaire'>";
                echo "<div class=auteur>";
                    echo "<h4>".$note->getPrenomAuteur().' '.$note->getNomAuteur().'</h4>';
                    echo "<p>(Il y a ".$note->getDateDiff().')</p>';
                echo "</div>";
                echo "<p>".$note->getCommentaire()."</p>";
            echo "</div>";
        }
    }

    public function getCommentaireParAuteur($mail){
        foreach($this->notes as $note){
            if($note->getMailAuteur() == $mail){
                return $note;
            }
        }
        return null;
    }

    public function addCommentaire($note){
        $this->notes[] = $note;
    }

    
    public function getImagePrincipal() {
        # Donne l'image principale du restaurant
        $cacheFile = '../data/cache/' . md5($this->getNomRestaurant()) . '.json';
        $imagePath = "../data/cache/img/" . md5($this->getNomRestaurant()) . "_0.jpg";
    
        if (file_exists($imagePath)) {
            return $imagePath;
        }
    
        // Vérification du cache pour récupérer les références des images
        if (file_exists($cacheFile)) {
            $cacheData = json_decode(file_get_contents($cacheFile), true);
            // error_log("TTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTT");
            // var_dump($cacheData["google_data"]);
            $cacheData = $cacheData["google_data"];
            // error_log($cacheData['photos'][0]);
            if (!empty($cacheData['photos'])) {
                $photoRefs = $cacheData['photos'];
                // error_log($photoRefs);
                $API = get_CSV_Key("MAPS");
    
                downloadFirstImage($this->getNomRestaurant(), $photoRefs, $API);
    
                return file_exists($imagePath) ? $imagePath : '../static/images/noequestrians.png';
            }
        }
        else {
            getGooglePlaceData($this->getLatitude(), $this->getLongitude(), $this->getNomRestaurant());
            if(file_exists($cacheFile)){
                $cacheData = json_decode(file_get_contents($cacheFile), true);
                if (!empty($cacheData['photos'])) {
                    $photoRefs = $cacheData['photos'];
                    $API = get_CSV_Key("MAPS");
        
                    downloadFirstImage($this->getNomRestaurant(), $photoRefs, $API);
                    var_dump($imagePath);
                    return file_exists($imagePath) ? $imagePath : '../static/images/noequestrians.png';
                }
            }
        }
    
        return '../static/images/noequestrians.png';
    }
    
    public function getImages() {
        # Donne les autres images du restaurant
        $imagePaths = [];
        $cacheDir = "../data/cache/img/";
        $baseName = md5($this->getNomRestaurant());
        $cacheFile = '../data/cache/' . md5($this->getNomRestaurant()) . '.json';
    
        // Vérification des images déjà téléchargées
        for ($i = 1; $i < 9; $i++) {
            $imagePath = "{$cacheDir}{$baseName}_{$i}.jpg";
            if (file_exists($imagePath)) {
                $imagePaths[] = $imagePath;
            }
        }
    
        if (!empty($imagePaths)) {
            return $imagePaths;
        }
    
        // Vérification du cache pour récupérer les références des images
        if (file_exists($cacheFile)) {
            $cacheData = json_decode(file_get_contents($cacheFile), true);
            $cacheData = $cacheData['google_data'];
            if (!empty($cacheData['photos'])) {
                $photoRefs = $cacheData['photos'];
                $API = get_CSV_Key("MAPS");
    
                downloadOtherImages($this->getNomRestaurant(), $photoRefs, $API);
    
                // Vérification après téléchargement
                for ($i = 1; $i < min(9, count($photoRefs)); $i++) {
                    $imagePath = "{$cacheDir}{$baseName}_{$i}.jpg";
                    if (file_exists($imagePath)) {
                        $imagePaths[] = $imagePath;
                    }
                }
            }
        }
    
        return !empty($imagePaths) ? $imagePaths : array_fill(0, 8, '../static/images/noequestrians.png');
    }
    
    public function getCachedAddress() {
        # Récupère l'adresse depuis le cache ou utilise getVille()
        $cacheFile = '../data/cache/' . md5($this->getNomRestaurant()) . ".json";
    
        if (file_exists($cacheFile)) {
            $cacheData = json_decode(file_get_contents($cacheFile), true);
            if (!empty($cacheData['google_data']['address'])) {
                return $cacheData['google_data']['address'];
            }
        }
    
        return $this->getVille();
    }
    

    

    public function renderSmall(){
        echo '<a href="pageRestaurant.php?id='.$this->getOsmId().'" class="fiche-resto">';
        echo '<article>';
        # A remplacer par un appelle de fonction qui renvoie l'image du restaurant
        echo '<img src="'.$this->getImagePrincipal().'" class="fiche-resto-image" loading="lazy">';
        #
        echo '<div>';
        echo '<span>';
        echo '<h3>'.$this->getNomRestaurant().'</h3>';
        echo '<h3>'.$this->getNbEtoiles().'☆</h3>';
        echo '</span>';
        if($this->getDescription() != ""){
            echo '<p>'.$this->getDescription().'</p>';
        } else {
            $desc = '<p> Restaurant de ';
            foreach($this->getCuisines() as $cuisine){
                $desc .= $cuisine.', ';
            }
            $desc = substr($desc, 0, -2);
            $desc .= '</p>';
            echo $desc;
        }
        echo '</div>';
        echo '</article>';
        echo '</a>';
    }

    public function renderFull(){
        echo '<a href="pageRestaurant.php?id='.$this->getOsmId().'" class="grande-fiche-resto">';
        echo '<article>';
        # A remplacer par un appelle de fonction qui renvoie l'image du restaurant
        echo '<img src="'.$this->getImagePrincipal().'" class="lazy grande-fiche-resto-image" loading="lazy">';
        #
        echo '<div>';
        echo '<span>';
        echo '<h3>'.$this->getNomRestaurant().'</h3>';
        echo '<h3>'.$this->getNbEtoiles().'☆</h3>';
        echo '</span>';
        if($this->getDescription() != ""){
            echo '<p>'.$this->getDescription().'</p>';
        } else {
            $desc = '<p> Restaurant de ';
            foreach($this->getCuisines() as $cuisine){
                $desc .= $cuisine.', ';
            }
            $desc = substr($desc, 0, -2);
            $desc .= '</p>';
            echo $desc;
        }
        echo '<span>';
        echo '<p>'.$this->getCachedAddress().'</p>';
        echo '<text>'.$this->getNbCommentaire().' 🗨️</text>';
        echo '</span>';
        echo '<span>';
        echo '<text class="commentaire">'.$this->getPremierCommentaire().'</text>';
        echo '</span>';
        echo '</div>';
        echo '</article>';
        echo '</a>';

    }

    public function renderMax($logged){

        if ($logged != true){
            $logged = false;
        }

        echo '<article id="restaurant">';
            echo '<img src="'.$this->getImagePrincipal().'" class="lazy resto-image">';
            echo '<div class="resto-info">';
                echo '<span class="resto-header">';
                    echo '<a href="'.$this->getSiteWeb().'" class="resto-link">';
                    echo '<h1>'.$this->getNomRestaurant().' 🔗</h1>';
                    echo '</a>';
                    if ($logged){
                        if (!estFavoris($_SESSION['mail'], $this->getOsmId()))
                            {echo '<button id="fav-button" class="unfav">Ajouter à vos favoris ♡</button>';}
                        else {echo '<button id="fav-button" class="faved">Retirer de vos favoris ♥</button>';}
                    }
                    
                echo '</span>';
                
                if (!empty($this->getDescription())) {
                    echo '<p class="resto-desc">'.$this->getDescription().'</p>';
                } else {
                    echo '<p class="resto-desc">Restaurant de ';
                    foreach ($this->getCuisines() as $cuisine) {
                        echo $cuisine.', ';
                    }
                    echo '</p>';
                }

                echo '<p>📍 '.$this->getCachedAddress().'</p>';
                echo '<p>📞 Tel : '.$this->getTelRestaurant().'</p>';
                echo '<p>🕒 '.$this->getHorairesOuverture().'</p>';
                echo '<p>👥 Capacité : '.$this->getCapacite().' personnes</p>';

                echo '<span class="rating">';
                    echo '<strong>'.$this->getNbEtoiles().' ☆</strong>';
                    echo '<p> sur '.$this->getNbCommentaire().' avis</p>';
                echo '</span>';
            echo '</div>';

        echo '</article>';

        // $API = get_CSV_Key("MAPS");

        echo '<article class="restaurant-details">';
            echo '<div class="resto-media">';
                echo '<span class="photos">';
                foreach ($this->getImages() as $img) {
                    echo '<img src="'.$img.'" class="lazy resto-thumbnail" loading="lazy">';
                }
                echo '</span>';
                
                echo '<span class="commentaires">';
                        echo '<h3>Commentaires '.$this->getNbCommentaire().' 🗨️</h3>';
                        # Ici ya le form pour les commentaires et la note
                        echo '<form method="POST" action="pageRestaurant.php?id='.$this->getOsmId().'">';
                            echo '<select name="rating">';
                                echo '<option value="1">⭐✦✦✦✦</option>';
                                echo '<option value="2">⭐⭐✦✦✦</option>';
                                echo '<option value="3">⭐⭐⭐✦✦</option>';
                                echo '<option value="4">⭐⭐⭐⭐✦</option>';
                                echo '<option value="5">⭐⭐⭐⭐⭐</option>';
                            echo '</select>';
                            echo '<input type="text" name="commentaire" placeholder="Commentaire">';
                            echo '<button type="submit">Envoyer</button>';
                        echo '</form>';
                        #
                        echo '<div class="les_commentaires">';
                            $this->getCommentaires();
                        echo '</div>';
                    echo '</span>';
            echo '</div>';

            ?> 
                <iframe width="400" height="400" style="border: 1px;"
                    allowfullscreen
                    src="https://www.google.com/maps?q=<?php echo $this->latitude; ?>,<?php echo $this->longitude; ?>&output=embed">
                </iframe>
        <?php   
        echo '</article>';

    }
}