<?php 

set_time_limit(0);

include_once '../static/script/getKey.php';







// VERSION A JOUR DE MAPS 



function getGooglePlaceData(float $lat, float $lng, string $name, int $rad = 20) {

// CETTE FONCTION REMPLACE L'ANCIENNE A CAUSE DU CHANGEMENT DE FACTURATION DE GOOGLE API
// Cette fonction à presque entièrement été faite par chatGPT en se basant sur les anciennes versions que moi et julian avons réalisés

    $cacheFile = __DIR__ . '/../../data/cache/' . md5($name) . '.json';

    $API = get_CSV_Key("MAPS");
    $url = "https://places.googleapis.com/v1/places:searchNearby";


    $payload = [
        // "includedTypes" => ["restaurant"],
        "maxResultCount" => 10,
        "locationRestriction" => [
            "circle" => [
                "center" => [
                    "latitude" => $lat,
                    "longitude" => $lng
                ],
                "radius" => $rad
            ]
        ]
    ];
    
    // inclure que les champs nécessaires (voir la doc parce que ça peut couter cher (cette SAE m'a déjà couté 15€ :sob:))
    $headers = [
        "Content-Type: application/json",
        "X-Goog-Api-Key: $API",
        "X-Goog-FieldMask: places.displayName,places.formattedAddress,places.location,places.id,places.photos"
    ];
    

    $options = [
        'http' => [
            'method'  => 'POST',
            'header'  => implode("\r\n", $headers),
            'content' => json_encode($payload),
            'ignore_errors' => true
        ]
    ];
    $context = stream_context_create($options);
    
    // Appel à l'API
    $response = @file_get_contents($url, false, $context);
    if ($response === false) {
        error_log("Erreur lors de l'appel à l'API Nearby Search");
        return null;
    }
    
    $data = json_decode($response, true);
    if (!isset($data["places"]) || !is_array($data["places"])) {
        error_log("Réponse inattendue de l'API: " . $response);
        return null;
    }
    
    $bestMatch = null;
    $bestScore = PHP_INT_MAX;
    
    // Parcourt les lieux retournés pour déterminer le meilleur match

    foreach ($data["places"] as $place) {
        if (!isset($place["location"]["latitude"], $place["location"]["longitude"], $place["displayName"]["text"])) {
            continue;
        }
        
        // Calcul d'une distance approximative (distance de Manhattan)
        $distance = abs($lat - $place["location"]["latitude"]) + abs($lng - $place["location"]["longitude"]);
        
        // Calcul de la similarité du nom
        $placeName = strtolower($place["displayName"]["text"]);
        $nameSimilarity = levenshtein($placeName, strtolower($name));
        
        // Score combiné : distance pondérée + similarité du nom
        $score = ($distance * 1000) + $nameSimilarity;
        
        if ($score < $bestScore) {
            $bestScore = $score;
            $bestMatch = $place;
        }
    }
    

    if ($bestMatch !== null) {

        $photoRefs = [];
        if (isset($bestMatch["photos"]) && is_array($bestMatch["photos"])) {
            foreach ($bestMatch["photos"] as $photo) {
                if (isset($photo["name"])) {
                    $parts = explode("/photos/", $photo["name"]);
                    $ref = (count($parts) > 1) ? $parts[1] : $photo["name"];
                    $photoRefs[] = $ref;
                }
            }
        }
        
        // enregistrer dans le cache
        $cacheData = [
            "google_data" => [
                "place_id"  => $bestMatch["id"] ?? null,
                "name"      => $bestMatch["displayName"]["text"] ?? null,
                "address"   => $bestMatch["formattedAddress"] ?? null,
                "latitude"  => $bestMatch["location"]["latitude"],
                "longitude" => $bestMatch["location"]["longitude"],
                "photos"    => $photoRefs  // stocke uniquement les références photo
            ]
        ];
        
        file_put_contents($cacheFile, json_encode($cacheData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
    
    return $bestMatch;
}

function downloadFirstImage(string $name, array $photoRefs, string $API) {
    if (empty($photoRefs)) {
        return false; // Aucune photo disponible
    }

    $photoUrl = "https://maps.googleapis.com/maps/api/place/photo?maxwidth=800&photoreference={$photoRefs[0]}&key={$API}";
    
    $filePath = __DIR__ . "/../../data/cache/img/" . md5($name) . "_0.jpg";

    return saveImageFromUrl($photoUrl, $filePath);
}

function downloadOtherImages(string $name, array $photoRefs, string $API) {
    if (count($photoRefs) < 2) {
        return false; // Pas d'autres images disponibles
    }

    $success = true;


    for ($i = 1; $i < count($photoRefs); $i++) {
        $photoUrl = "https://maps.googleapis.com/maps/api/place/photo?maxwidth=800&photoreference={$photoRefs[$i]}&key={$API}";
        $filePath = __DIR__ . "/../../data/cache/img/" . md5($name) . "_{$i}.jpg";
        
        if (!saveImageFromUrl($photoUrl, $filePath)) {
            $success = false;
        }
    }

    return $success;
}

function saveImageFromUrl(string $url, string $filePath) {
    // Télécharger l'image et l'enregistrer

    // $imageData = @file_get_contents($url);
    // if ($imageData === false) {
    //     return false;
    // }
    $saveDir = '../data/cache/img/' ;
    if (!file_exists($filePath)) {
        error_log($url);
        $imageData = @file_get_contents($url);
        if ($imageData) {
            if (!is_dir($saveDir)) {
                mkdir($saveDir, 0777, true);
            }
            file_put_contents($filePath, $imageData);
            return true;
        }
    }
    
    // return file_put_contents($filePath, $imageData) !== false;
    return false;
}





// NE PAS UTILISER CES FONCTIONS NON PLUS !!!!



// NE PAS UTILISER LES ANCIENNES VERSIONS !!!!!

function getPlaceId_old(float $lat, float $lng, string $name, int $rad = 50){ 
    $API = get_CSV_Key("MAPS");
    $placeId = "";
    $url = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?key=$API&location=$lat,$lng&radius=$rad";
    
    do {
        $response = file_get_contents($url);
        $data = json_decode($response, true);
        $feur = boolval(isset($data["next_page_token"]));
        // var_dump($feur);
        // var_dump(boolval(isset($data["results"])));
        // var_dump(sizeof($data["results"]));

        try {
            foreach ($data["results"] as $resto) {
                // echo ($resto["name"]);
                if ($resto["name"] == $name) {
                    $placeId = $resto["place_id"];
                    break 2;
                }
            }
            
            if ($feur) {
                // var_dump($data["next_page_token"]);
                $url = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?key=$API&location=$lat,$lng&radius=$rad&pagetoken=" . $data["next_page_token"];
                // Attendre un peu avant de faire la prochaine requête (le next_page_token devient valide après quelques secondes)
                  sleep(2);
                //  echo("********* ");
                //  sleep(1);
                //  echo("********* ");
                 
            } else {
                // echo ("burger");
                break;
            }
        } catch (Exception $e) {
        }
        // echo("feur");
    } while ($placeId=="");
    // echo (" place ->"); var_dump($placeId);
    return $placeId;
}

function getPlaceId(float $lat, float $lng, string $name, int $rad = 20) { 
    $API = get_CSV_Key("MAPS");
    $placeId = "";
    $url = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?key=$API&location=$lat,$lng&radius=$rad";
    
    $bestMatch = null;
    $bestScore = PHP_INT_MAX;

    do {
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        foreach ($data["results"] as $resto) {
            $distance = abs($lat - $resto["geometry"]["location"]["lat"]) + abs($lng - $resto["geometry"]["location"]["lng"]);
            $nameSimilarity = levenshtein(strtolower($resto["name"]), strtolower($name));
            

            $score = ($distance * 1000) + $nameSimilarity; 

            if ($score < $bestScore) {
                $bestScore = $score;
                $bestMatch = $resto["place_id"];
            }
        }

        if (isset($data["next_page_token"])) {
            $url = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?key=$API&location=$lat,$lng&radius=$rad&pagetoken=" . $data["next_page_token"];
            sleep(1.5);
        } else {
            break;
        }
    } while ($bestMatch === null);

    return $bestMatch;
}

function getGooglePlaceData_old(float $lat, float $lng, string $name, int $rad = 20) { 
    $API = get_CSV_Key("MAPS");
    $url = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?key=$API&location=$lat,$lng&radius=$rad";
    
    $bestMatch = null;
    $bestScore = PHP_INT_MAX;

    do {
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        foreach ($data["results"] as $resto) {
            $distance = abs($lat - $resto["geometry"]["location"]["lat"]) + abs($lng - $resto["geometry"]["location"]["lng"]);
            $nameSimilarity = levenshtein(strtolower($resto["name"]), strtolower($name));
            

            $score = ($distance * 1000) + $nameSimilarity; 

            if ($score < $bestScore) {
                $bestScore = $score;
                $bestMatch = $resto;
            }
        }

        if (isset($data["next_page_token"]) && $bestMatch === null) {
            $url = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?key=$API&location=$lat,$lng&radius=$rad&pagetoken=" . $data["next_page_token"];
            sleep(1.5);
        } else {
            break;
        }
    } while ($bestMatch === null);

    return $bestMatch;
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