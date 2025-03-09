<?php
include_once __DIR__.'/../static/script/getKey.php';
require_once __DIR__.'/../static/script/getImage.php';

$API = get_CSV_Key('MAPS');

var_dump(getGooglePlaceData(47.815659, 1.9403556, 'Campanille'));

?>