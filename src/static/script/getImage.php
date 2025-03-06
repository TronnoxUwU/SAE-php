<?php 

set_time_limit(0);

include_once '../static/script/getKey.php';


function getPlaceId(float $lat, float $lng, string $name, int $rad = 20){ 
    $API = get_CSV_Key("MAPS");
    $placeId = "";
    $url = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?key=$API&location=$lat,$lng&radius=$rad";
    
    // Boucle pour gérer la pagination avec next_page_token
    do {
        // Effectuer la requête initiale ou suivante selon la pagination
        $response = file_get_contents($url);
        $data = json_decode($response, true);
        $feur = boolval(isset($data["next_page_token"]));
        // var_dump($feur);
        // var_dump(boolval(isset($data["results"])));
        // var_dump(sizeof($data["results"]));

        try {
            // Parcours des résultats de la page actuelle
            foreach ($data["results"] as $resto) {
                // echo ($resto["name"]);
                if ($resto["name"] == $name) {
                    $placeId = $resto["place_id"];
                    break 2; // On trouve le résultat, on sort des deux boucles
                }
            }
            
            // Si un next_page_token est présent, on l'ajoute à l'URL pour récupérer la page suivante
            if ($feur) {
                // var_dump($data["next_page_token"]);
                $url = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?key=$API&location=$lat,$lng&radius=$rad&pagetoken=" . $data["next_page_token"];
                // Attendre un peu avant de faire la prochaine requête (le next_page_token devient valide après quelques secondes)
                  sleep(2); // Attente de 2 secondes
                //  echo("********* ");
                //  sleep(1); // Attente de 2 secondes
                //  echo("********* ");
                 
            } else {
                // Si pas de next_page_token, sortir de la boucle
                // echo ("burger");
                break;
            }
        } catch (Exception $e) {
            // En cas d'exception, continuer avec la boucle
        }
        // echo("sex");
    } while ($placeId==""); // La boucle continue tant que le placeId n'a pas été trouvé
    // echo (" place ->"); var_dump($placeId);
    return $placeId;
}



function getImagesResto($bdd, $osmid){
        try {
            $reqResto = $bdd->prepare("SELECT horizontal, vertical FROM RESTAURANT WHERE osmid = ?");
            $reqResto->execute(array($osmid));
    
            $info = $reqResto->fetch();
            
            if(!$info){
                return [
                    'vertical' => [],
                    'horizontal' => [],
                ];
            }
            return $info;
        } catch (\Throwable $th) {
            return [
                'vertical' => [],
                'horizontal' => [],
            ];
        }


    }


function getImageByPlaceId(PDO $bdd, string $osmid, string $placeId):array{

    $API = get_CSV_Key("MAPS");

    $lesimages = getImagesResto($bdd, $osmid);
    if(!empty($lesimages["vertical"]) && !empty($lesimages["horizontal"])  ){
        

        return $lesimages;
    }else{
        

        $url_img = "https://maps.googleapis.com/maps/api/place/details/json?place_id=$placeId&fields=name,photos&key=$API";

        $response_img = file_get_contents($url_img);
        $data_img = json_decode($response_img, true);
        
        // if (!$data_img || $data_img['status'] !== "OK") {
        //     die(json_encode(["error" => "Aucun résultat trouvé ou erreur API.", "status" => $data_img['status'] ?? "Unknown"]));
        // }
        
        $photos = [];
        if (!empty($data_img['result']['photos'])) {
            foreach ($data_img['result']['photos'] as $photo) {
                $photoRef = $photo['photo_reference'];
                $photoUrl = "https://maps.googleapis.com/maps/api/place/photo?maxwidth=800&photoreference=$photoRef&key=$API";
                $photos[] = $photoUrl;
            }
        }
        if(empty($photo)){
            return[];
        }
        // header('Content-Type: application/json');
        $lesimages = categorizeImagesByOrientation($photos);
      
        if(!empty($lesimages["vertical"]) && !empty($lesimages["horizontal"])  ){
            
            // echo ("insert image dans la bd");

            // addImageRestaurantById($bdd, $osmid, $lesimages["horizontal"][0], $lesimages["vertical"][0]);
        }
        return  [
            'vertical' => $lesimages["vertical"][0],
            'horizontal' => $lesimages["horizontal"][0],
        ];
    }

}

function getImageByPlaceIdLight(string $placeId):array{

    $API = get_CSV_Key("MAPS");
    $url_img = "https://maps.googleapis.com/maps/api/place/details/json?place_id=$placeId&fields=name,photos&key=$API";

    $response_img = file_get_contents($url_img);
    $data_img = json_decode($response_img, true);
    
    // if (!$data_img || $data_img['status'] !== "OK") {
    //     die(json_encode(["error" => "Aucun résultat trouvé ou erreur API.", "status" => $data_img['status'] ?? "Unknown"]));
    // }
    
    $photos = [];
    if (!empty($data_img['result']['photos'])) {
        foreach ($data_img['result']['photos'] as $photo) {
            $photoRef = $photo['photo_reference'];
            $photoUrl = "https://maps.googleapis.com/maps/api/place/photo?maxwidth=800&photoreference=$photoRef&key=$API";
            $photos[] = $photoUrl;
        }
    }
    if(empty($photo)){
        return[];
    }
    // header('Content-Type: application/json');
    $lesimages = categorizeImagesByOrientation($photos);
    
    return  [
        'vertical' => $lesimages["vertical"],
        'horizontal' => $lesimages["horizontal"],
    ];

}


function categorizeImagesByOrientation($imageUrls) {
    $categorizedImages = [
        'vertical' => [],
        'horizontal' => [],
    ];

    foreach ($imageUrls as $imageUrl) {
        // Télécharger l'image depuis l'URL
        $imageData = file_get_contents($imageUrl);

        if ($imageData === false) {
            continue; // Passer à l'image suivante si erreur
        }
        // Obtenir les dimensions de l'image
        $imageSize = getimagesizefromstring($imageData);

        if ($imageSize === false) {
            continue; // Passer à l'image suivante si erreur
        }

        $width = $imageSize[0];
        $height = $imageSize[1];

        // Classer l'image en fonction de l'orientation
        if ($width > $height) {
            $categorizedImages['horizontal'][] = $imageUrl;
        } else {
            $categorizedImages['vertical'][] = $imageUrl;
        }
    }

    return $categorizedImages;
}