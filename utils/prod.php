

<?php

function getprod($source){


$json  = file_get_contents($source);
$obj   = json_decode($json,true);

if (empty($obj)){
    throw new Exception("no production ,1");
}
return $obj;


}
?>