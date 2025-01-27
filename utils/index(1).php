<?php
session_start();

if ($_SESSION["Panier"] === null){
  $_SESSION["Panier"] = array();
 }

require_once 'data/prod.php';
$obj = getprod('data/product.json');

if(!empty($_REQUEST['filter'])){
  $obj = array_filter(
    $obj,
    fn($branche) => $branche['brand'] == $_REQUEST['filter']
  );
}

?>





<!doctype html>
<html lang="fr">
  <head>
    <meta charset="utf-8" />

    <title>liste de produit</title>
    <link rel="stylesheet" href="../../css/index_tableau.css" />
    <link rel="stylesheet" href="../../css/nav.css" />
    <link rel="stylesheet" href="../../css/index_section.css" />
  </head>

  <body>

    <header>
        <nav>
            <section class = "choix">
                <ul>
                    <li><a href="/index.php">home</a></li>
                    <li><a href="/templates/cart.php">panier</a></li>
                    <li><a href="./templates/fentre_trier.php/?who=Apple">Apple </a></li>
                </ul>
            </section>
            <section class = "recherche">
            <form>
                <input type="search" name="R" placeholder="Rechercher" />
                <input type="submit" value="Lancer !" />
            </form>
        </section>
        </nav>
    </header>


    <main>

    <section class="gauche">
     <p>image 1</p>
    </section>

    <section class="millieux">
      <h1>liste produit</h1>
      <br>
      <table>
        <caption> liste produit </caption>
        <thead>
        <tr>
          <th scope=\"col\">ID</th>
          <th scope=\"col\">title</th>
          <th scope=\"col\">brand </th>
          <th scope=\"col\">price</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach (  $obj as $liste ): ?>
        <tr>
          <th scope=\"row\"> <a href="./detail.php/?id_produit=<?=$liste["id"]?>"> <?= $liste["id"]?> </a></th>
          <td><?=$liste["title"]?></td> 
          <td><?=$liste["brand"]?></td>
          <td><?=$liste["price"]?></td>
        </tr>
        <?php endforeach ?>
      </table>
    </section>
    
    <section class="droite">
    <p>image 2</p>
    </section>

    </main>

    <footer>
        <nav>
            <section>
                    <ul>
                        <li><a href="/index.php">home</a></li>
                        <li><a href="/templates/panier.php">panier</a></li>
                    </ul>
                </section>

            <section>
                    <p>confidentialiter</p>
            </section>
        </nav>
    </footer>
  </body>
</html>


