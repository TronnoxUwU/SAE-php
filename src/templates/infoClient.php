<script src="../static/script/popup_valid.js"></script>

<?php 

require_once "../static/script/modele.php";
session_start();

// Gestion de la confirmation du paiement
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmerPaiement'])) {
    $idAct = utilisateurExistant($_SESSION["user"], $_SESSION["pswrd"]);
    $message = enregistrerCotisation($idAct);
    echo "<p></p>";
    echo '<script>showPopup("Paiement validé !", true);</script>';
    // Redirection pour rafraîchir la page et afficher le nouvel état
    //echo "<script>window.location.href = window.location.href;</script>";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informations du compte</title>
    <link rel="stylesheet" href="../static/styles/admin.css">
    <link rel="stylesheet" href="../static/styles/clientel.css">
    <link rel="stylesheet" href="../static/styles/popup_valid.css">
    
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <?php include "./navbar_admin.php"; ?>
        </aside>
        <main>
            <div class="titreAdmin"><h1>Informations du compte</h1></div>
            
            <section class="section">
                <div class="table-container">
                    <h2>Paiement de l'abonnement</h2>
                    <?php
                        $idCli = utilisateurExistant($_SESSION["user"], $_SESSION["pswrd"]);
                        //var_dump($idCli);
                        $etatAbonnement = getEtatAbonnement($idCli);
                        //var_dump($etatAbonnement);
                        if ($etatAbonnement['payé']) {
                            echo "<p>Abonnement de l'année en cours : Payé 🟢</p>";
                        } else {
                            echo "<p>Abonnement de l'année en cours : Non payé 🔴</p>";
                            echo '<button onclick="ouvrirPopup()">Payer l\'abonnement</button>';
                        }
                    ?>
                </div>
            </section>

            <section class="section">
                <div class="table-container">
                    <h2>Prochains cours</h2>
                    <?php
                    $id = utilisateurExistant($_SESSION["user"], $_SESSION["pswrd"]);
                    // var_dump($id);
                    $cours = getProchainCours($id);
                    // var_dump(getReserve($id));

                    if (empty($cours)) {
                        echo "<p>Aucun cours inscrit.</p>";
                    } else {
                        foreach ($cours as $row) {
                            echo "<a href='#' class='course-link'>"; // Lien vide pour l'instant
                            echo "<div class='course-item'>";
                            echo "<h3>" . htmlspecialchars($row['intitule']) . "</h3>";
                            echo "<p>Date : " . htmlspecialchars($row['date']) . "</p>";
                            echo "<p>Heure : " . htmlspecialchars($row['heureDebut']) . "</p>";
                            echo "<p>Moniteur : " . htmlspecialchars($row['moniteur']) . "</p>";
                            echo "<p>Niveau : " . htmlspecialchars($row['niveau']) . "</p>";
                            echo "</div>";
                            echo "</a>";
                        }
                        
                    }
                    ?>
                </div>
            </section>



            <!-- Popup -->
            <div class="popup-overlay" id="popup-overlay" onclick="fermerPopup()"></div>
            <div class="popup" id="popup">
                <h3 style="color:black;">Confirmer le paiement</h3>
                <p style="color:black;">Confirmez-vous le paiement de l'abonnement annuel ?</p>
                <form method="POST" action="">
                    <input type="hidden" name="idCli" value="<?php echo $idCli; ?>">
                    <button type="submit" name="confirmerPaiement">Confirmer</button>
                </form>
                <button onclick="fermerPopup()">Annuler</button>
            </div>
        </main>
    </div>

    <script>
        function ouvrirPopup() {
            document.getElementById('popup-overlay').style.display = 'block';
            document.getElementById('popup').style.display = 'block';
        }

        function fermerPopup() {
            document.getElementById('popup-overlay').style.display = 'none';
            document.getElementById('popup').style.display = 'none';
        }
    </script>
</body>
</html>


