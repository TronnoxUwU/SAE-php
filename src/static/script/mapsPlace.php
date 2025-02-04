<?php
// header('Content-Type: application/json');

include_once __DIR__."/../static/script/getKey.php";

// $lat = "47.90114979996115";
// $lng = "1.9052942";
// $name = "Cha+";


// if (isset($_GET['latitude']) && isset($_GET['longitude']) && isset($_GET['nom'])) {

function getRestoImage($lat, $lng, $name){

    try {
        $apiKey = get_CSV_Key("MAPS"); // API
        $rad = "10";
        $placeId = "";

        
        // $lat = trim($_GET['latitude']);
        // $lng = trim($_GET['longitude']);
        // $name = trim($_GET['nom']);

        // 
        // récupération id resto
        // 
        $url = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?key=$apiKey&location=$lat,$lng&radius=$rad";
        // var_dump($url);
        $response = file_get_contents($url);
        $data = json_decode($response, true);
        try{
            foreach($data["results"] as $resto){
                if ($resto["name"]==$name){
                    $placeId = $resto["place_id"];
                    break;
                }
            }
        } catch( Exception $e ){
            // Juste parce que le foreach resto fait chier
        }
        // var_dump($placeId);


        // 
        // récupération photos resto
        // 
        $url_img = "https://maps.googleapis.com/maps/api/place/details/json?place_id=$placeId&fields=name,photos&key=$apiKey";

        $response_img = file_get_contents($url_img);
        $data_img = json_decode($response_img, true);

        if (!$data_img || $data_img['status'] !== "OK") {
            // die(json_encode(["error" => "Aucun résultat trouvé ou erreur API.", "status" => $data_img['status'] ?? "Unknown"]));
            return [];
        }

        $photos = [];
        if (!empty($data_img['result']['photos'])) {
            foreach ($data_img['result']['photos'] as $photo) {
                $photoRef = $photo['photo_reference'];
                $photoUrl = "https://maps.googleapis.com/maps/api/place/photo?maxwidth=800&photoreference=$photoRef&key=$apiKey";
                $photos[] = $photoUrl;
            }
        }

        // header('Content-Type: application/json');
        // echo json_encode(["name" => $data_img['result']["name"], "photos" => $photos], JSON_PRETTY_PRINT);

        // echo json_encode(["photos" => $photos], JSON_PRETTY_PRINT);
        return ["photos" => $photos];

    } catch(Exception $e) {
        // echo json_encode(["photos" => []], JSON_PRETTY_PRINT);
        return ["photos" => []];
    }
}
?>





<?php

// CODE "OBSELETE" (ancienne requetes)



// $apiKey = "AIzaSyBTyD0V18SbGWwRq7sMZ7e4XyGD4DIUxa4";
// $lat = "47.90114979996115";
// $lng = "1.9052942";
// $rad = "10";
// $name = "Cha+";

// $url = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?key=$apiKey&location=$lat,$lng&radius=$rad";
// $response = file_get_contents($url);
// $data = json_decode($response, true);
// foreach($data as $resto){
//     foreach($resto as $val) {
//         if ($val["name"]==$name){
//             var_dump($val["place_id"]);
//             break;
//         }
//     }
// }
?>

<?php
// $apiKey = "AIzaSyBTyD0V18SbGWwRq7sMZ7e4XyGD4DIUxa4"; // Remplace avec ta clé API
// $lat = "47.90114979996115";
// $lng = "1.9052942";
// $rad = "10";
// $name = "Cha+";

// // URL de l'API Nearby Search
// $url = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?key=$apiKey&location=$lat,$lng&radius=$rad";

// // Récupération des résultats JSON
// $response = file_get_contents($url);
// $data = json_decode($response, true);

// if (!$data || $data['status'] !== "OK") {
//     die(json_encode(["error" => "Aucun résultat trouvé ou erreur API.", "status" => $data['status'] ?? "Unknown"]));
// }

// // Recherche du restaurant par son nom
// $found = null;
// foreach ($data['results'] as $resto) {
//     if (strcasecmp($resto["name"], $name) == 0) { // Comparaison insensible à la casse
//         $found = $resto;
//         break;
//     }
// }

// if (!$found) {
//     die(json_encode(["error" => "Restaurant non trouvé"]));
// }

// // Extraction des photos si disponibles
// $photos = [];
// if (!empty($found['photos'])) {
//     foreach ($found['photos'] as $photo) {
//         $photoRef = $photo['photo_reference'];
//         $photoUrl = "https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photoreference=$photoRef&key=$apiKey";
//         $photos[] = $photoUrl;
//     }
// }

// // Retourne les images au format JSON
// header('Content-Type: application/json');
// echo json_encode(["name" => $found["name"], "photos" => $photos], JSON_PRETTY_PRINT);
?>