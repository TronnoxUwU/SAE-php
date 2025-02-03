<?php
function get_CSV_Key($key) {
    $fichier = __DIR__."/../../data/keys.csv";
    if (!file_exists($fichier)) {
        return "Fichier non trouve";
    }
    
    if (($file = fopen($fichier, "r")) !== FALSE) {
        while (($data = fgetcsv($file)) !== FALSE) {
            if (count($data) >= 2 && $data[0] === $key) {
                fclose($file);
                return $data[1];
            }
        }
        fclose($file);
    }
    
    return "Cle fausse ou inexistante";
}

?>