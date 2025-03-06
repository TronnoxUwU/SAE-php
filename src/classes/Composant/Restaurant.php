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

    public function __construct($osmId, $nomRestaurant, $description, $region, $departement, $ville, $longitude, $latitude, $siteWeb, $facebook, $telRestaurant, $nbEtoiles, $capacite, $fumeur, $drive, $aEmporter, $livraison, $vegetarien, $horairesOuverture, $cuisines){
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
    }

    public function getOsmId(){
        return $this->osmId;
    }

    public function getNomRestaurant(){
        return $this->nomRestaurant;
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

    public function localiser(){
        # A remplacer par un appelle de fonction qui renvoie la localisation du restaurant
        return $this->ville.', '.$this->departement.', '.$this->region;
    }

    public function getNbCommentaire(){
        # A remplacer par un appelle de fonction qui renvoie le nombre de commentaire du restaurant
        return 0;
    }

    public function getPremierCommentaire(){
        # A remplacer par un appelle de fonction qui renvoie le premier commentaire du restaurant
        return 'Pas de commentaire pour le moment, ceci est un long commentaire pour tester la mise en page de la fiche restaurant';
    }

    public function getImagePrincipal(){
        # A remplacer par un appelle de fonction qui renvoie l'image principale du restaurant

        $cacheFile = '../data/cache/' . md5($this->getNomRestaurant()) . '.json';

        if (file_exists($cacheFile)) {
            $images = json_decode(file_get_contents($cacheFile), true);
            
            foreach ($images as $image) {
                if (str_ends_with($image, '_main.jpg')) {
                    return $image;
                }
            }
        }

        $img = $this->getImagesGoogle();

        if ($img==[]){return '../static/images/noequestrians.png" alt="Balade en forêt';}

        $img = $img[0];

        $localImages = [];
        $localImages[] = $this->downloadAndSaveImage($img, $this->getOsmId(), "main");

        file_put_contents($cacheFile, json_encode($localImages), FILE_APPEND);
        return $localImages[0];

        return '../static/images/noequestrians.png" alt="Balade en forêt';
    }

    public function downloadAndSaveImage($imageUrl, $restaurantName, $index) {
        $saveDir = '../data/cache/img/';
        $savePath = $saveDir . md5($restaurantName) . "_$index.jpg";
    
        // Vérifie si le fichier existe déjà pour éviter de le retélécharger
        if (!file_exists($savePath)) {
            $imageData = @file_get_contents($imageUrl);
            if ($imageData) {
                // Créer le dossier s'il n'existe pas
                if (!is_dir($saveDir)) {
                    mkdir($saveDir, 0777, true);
                }
                file_put_contents($savePath, $imageData);
            }
        }
    
        return $savePath;
    }
    

    public function getImages(){

        $cacheFile = '../data/cache/' . md5($this->getOsmId()) . '.json';

        // if (file_exists($cacheFile)) {
        //     return json_decode(file_get_contents($cacheFile), true);
        // }
        if (file_exists($cacheFile)) {
            $images = json_decode(file_get_contents($cacheFile), true);
            $c_images = [];
            foreach ($images as $image) {
                if (!str_ends_with($image, '_main.jpg')) {
                    array_push($c_images, $image);
                }
            }
            return $c_images;
        }


        $img = $this->getImagesGoogle();
        $img = array_slice($img, 1);

        if ($img==[]){
            return ['../static/images/noequestrians.png" alt="Balade en forêt', '../static/images/noequestrians.png" alt="Balade en forêt','../static/images/noequestrians.png" alt="Balade en forêt','../static/images/noequestrians.png" alt="Balade en forêt','../static/images/noequestrians.png" alt="Balade en forêt','../static/images/noequestrians.png" alt="Balade en forêt','../static/images/noequestrians.png" alt="Balade en forêt','../static/images/noequestrians.png" alt="Balade en forêt'];
        }

        $localImages = [];
        foreach ($img as $index => $imgUrl) {
            $localImages[] = $this->downloadAndSaveImage($imgUrl, $this->getNomRestaurant(), $index);
        }

        file_put_contents($cacheFile, json_encode($localImages), FILE_APPEND);
        return $localImages;
    }

    public function getImagesGoogle(){
        
        $lat = $this->getLatitude();
        // var_dump($lat);
        $long = $this->getLongitude();
        // var_dump($long);
        $name = $this->getNomRestaurant();
        // var_dump($name);

        $Pid = getPlaceId($lat, $long, $name);
        // var_dump($Pid);
        $images = getImageByPlaceIdLight($Pid);

        $res = array();
        if (array_key_exists('horizontal', $images) && array_key_exists('vertical', $images)){
            $res = array_merge($res, $images['horizontal']);
            $res = array_merge($res, $images['vertical']);
        }
        else{
            return array();
        }
        
        // var_dump($res);
        return $res;
    }

    public function renderSmall(){
        echo '<a href="pageRestaurant.php?id="'.$this->getOsmId().'" class="fiche-resto">';
        echo '<article>';
        # A remplacer par un appelle de fonction qui renvoie l'image du restaurant
        echo '<img src="'.$this->getImagePrincipal().'" class="fiche-resto-image">';
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
        echo '<a href="pageRestaurant.php?id="'.$this->getOsmId().'" class="grande-fiche-resto">';
        echo '<article>';
        # A remplacer par un appelle de fonction qui renvoie l'image du restaurant
        echo '<img src="'.$this->getImagePrincipal().'" class="lazy grande-fiche-resto-image">';
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
        echo '<p>'.$this->localiser().'</p>';
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
                    if ($logged){echo '<button id="fav-button">Ajouter à vos favoris ♡</button>';}
                    
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

                echo '<p>📍 '.$this->localiser().'</p>';
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
                    echo '<img src="'.$img.'" class="lazy resto-thumbnail">';
                }
                echo '</span>';
                
                echo '<span class="commentaires">';
                    echo '<h3>Commentaires ('.$this->getNbCommentaire().') 🗨️</h3>';
                    echo '<p>'.$this->getPremierCommentaire().'</p>';
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