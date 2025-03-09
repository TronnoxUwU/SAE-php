<script src="../static/script/popup_valid.js"></script>

<?php


session_start();

require_once "../static/script/modele.php";

include 'navbar.php';

try {
    if (!isset($_SESSION["loggedin"]) || !$_SESSION["loggedin"]) {
        throw new Exception("Utilisateur non connecté.");
    }

    $user = getUtilisateur($_SESSION["mail"]);
    if (!$user) {
        throw new Exception("Aucun utilisateur trouvé.");
    }
    else {if (is_array($user[0])) {$user = $user[0];}}
    // else {var_dump($user);}
} catch (Exception $e) {
    header("Location: home.php");
}

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['name'] ?? null;
    $prenom = $_POST['prenom'] ?? null;
    $email = $_POST['email'] ?? null;
    $mdp = $_POST['password'] ?? null;
    $ville = $_POST['ville'] ?? "orleans";
    $departement = $_POST['departement'] ?? "Loiret";
    $region = $_POST['Region'] ?? "Centre-val-de-Loire";
    $tel = $_POST['telephone'] ?? "+33";
    $handicap = $_POST['handicap'] ?? false;

    if ($mdp_actuel && $email) {
        if (is_null($mdp_nouveau) || $mdp_nouveau === "") {
            try {
                //updateUtilisateur($email, $mdp_actuel, $nom, $prenom, $ville, $region, $poids, null);
                
                echo '<p></p>';
                echo '<script>showPopup("Données enregistrées avec succès !", true);</script>';
            } catch (Exception $e) {
                echo '<p></p>';
                echo '<script>showPopup("Erreur lors de la mise à jour des données.", false);</script>';
            }
        } else {
            if ($mdp_actuel === $mdp_nouveau) {
                echo '<p></p>';
                echo '<script>showPopup("Veuillez choisir un mot de passe différent.", false);</script>';
            } else {
                try {
                    
                    //updateUtilisateur($email, $mdp_actuel, $nom, $prenom, $telephone, $ville, $region, $mdp_nouveau);
                    $_SESSION['pswrd'] = $mdp_nouveau;
                    
                    echo '<p></p>';
                    echo '<script>showPopup("Données enregistrées avec succès !", true);</script>';
                } catch (Exception $e) {
                    echo '<p></p>';
                    echo '<script>showPopup("Erreur lors de la mise à jour des données.", false);</script>';
                }
            }
        }
    } else {
        echo '<p></p>';
        echo '<script>showPopup("Veuillez remplir tous les champs obligatoires.", false);</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../static/styles/settings.css">
    <link rel="stylesheet" href="../static/styles/popup_valid.css">
    <title>Paramètres</title>
</head>
<body>

    <main class="login-container">
        <form id="loginForm" method="POST">
            <h1>Modifier vos informations</h1>

            <div class="form-group">
                <label for="email">eMail *</label>
                <input type="email" id="username" name="email" readonly value="<?php echo htmlspecialchars($_SESSION["mail"]); ?>" required>
            </div>

            <div class="form-group">
                <label for="name">Nom</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($_SESSION["nom"]); ?>" required>
            </div>

            <div class="form-group">
                <label for="prenom">Prénom</label>
                <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($_SESSION["prenom"]); ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe actuel *</label>
                <input type="password" id="password" name="mdp" required>
            </div>
            
            <div class="form-group">
                <label for="NewPassword">Nouveau mot de passe</label>
                <input type="password" id="NewPassword" name="NewMdp">
            </div>

            <div class="form-group">
                <label for="telephone">Téléphone</label>
                <input type="text" id="telephone" name="telephone" value="<?php echo htmlspecialchars($user["telephone"]); ?>">
            </div>

            <div class="form-group">
                <label for="ville">Ville</label>
                <input type="text" id="ville" name="ville" value="<?php echo htmlspecialchars($user["ville"]); ?>">
            </div>

            <div class="form-group choix-regional">
                <label for="region-select">Département/Région</label>
                <select id="region-select" name="region-departement">
                    <option value="">Sélectionner un lieu</option>
                </select>
                <!-- Champs cachés pour stocker le département et la région -->
                <input type="hidden" id="departement" name="departement">
                <input type="hidden" id="region" name="region">
            </div>

            <div class="form-group">
                <label for="handicap">Avez vous un handicap physique ?</label>
                <input type="checkbox" id="handicap" name="handicap" <?php if ($user['handicap'] == true) echo "checked"?>>
            </div>

            <div class="form-group" id="btnform">
                <button type="submit">Enregistrer</button>
            </div>
        
        <script src="../static/script/update-ville-region.js"></script>

        </form>
    </main>

</body>
</html>
