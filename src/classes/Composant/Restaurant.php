<?php
include_once __DIR__."/../../static/script/mapsPlace.php";

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

    public function getOsMId(){
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

    public function setOsMId($osmId){
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

    public function getImage(){

        $image = getRestoImage($this->getLatitude(), $this->getLongitude(), $this->getNomRestaurant())["photos"][0];
        // var_dump($image);
        if (!isset($image) || $image===""){
            $image='../static/images/noequestrians.png';
        }
        return $image.'" alt="Balade en forêt';
    }

    public function renderSmall(){
        echo '<a href="" class="fiche-resto">';
        echo '<article>';
        # A remplacer par un appelle de fonction qui renvoie l'image du restaurant
        echo '<img src="'.$this->getImage().'" class="fiche-resto-image">';
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
        echo '<a href="" class="grande-fiche-resto">';
        echo '<article>';
        # A remplacer par un appelle de fonction qui renvoie l'image du restaurant
        echo '<img src="'.$this->getImage().'" class="grande-fiche-resto-image">';
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
}