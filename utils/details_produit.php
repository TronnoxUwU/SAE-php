
<h1> bon fichier</h1>

<?php
// From Superglobals vars
$request = $_GET['id_produit'] ?? null;
?>

<?php
require_once 'data/prod.php';
echo'<a href="/" > tout la liste </a>';

echo'<a href="/detail.php/?id_produit='.$request.'">.'.$request.' </a>';
$obj = getprod("data/product.json");
//print_r($obj);

if ($request > 0){
    $request = $request-1;
}

foreach($obj[$request] as $key => $info)
{
    if( $key === "thumbnail" or $key === "images"){
        if($key === "thumbnail"){
            echo "<br>";
            echo "thumbnail";
            echo "<br>";
            echo'<img src='.$info.' >';
            echo "<br>";
        }

        if($key === "images"){
            echo "<br>";
            echo "presentation des images";
            echo "<br>";
            foreach($info as $key => $image){
                echo'<img src='.$image.' >';
                }
        }

    }

    else{
        echo "<br>";
        print_r($key );
        print_r(":");
        print_r(" ");
        print_r($info);
        echo "<br>";

    }

}


?>

