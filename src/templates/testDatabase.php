<!doctype html>
<html>
<head>
    <title>Test Database</title>
    <meta charset="utf-8">
    <style>
        /* Style de la popup */
        .popup {
            display: none; /* Cacher la popup par défaut */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Fond semi-transparent */
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .popup-content {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            width: 350px;
            text-align: center;
        }
        .popup input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .popup button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .popup button.close {
            background-color: #f44336;
        }
    </style>
</head>
<body>

    <h1>Page avec Popup et saisie d'un nombre d'heures</h1>
    <p>Appuyez sur le bouton ci-dessous pour afficher la popup et saisir un nombre d'heures.</p>

    <!-- Bouton pour ouvrir la popup -->
    <button id="openPopup">Ouvrir la popup</button>

    <!-- La Popup -->
    <div class="popup" id="popup">
        <div class="popup-content">
            <h2>Entrez le nombre d'heures</h2>
            <form action="POST">
                <!-- Formulaire de saisie -->
                <input type="number" id="hours" placeholder="Nombre d'heures" min="0" step="1" required>
                <input type="text" id="name" placeholder="Nom" required>
                <input type="text" id="prenom" placeholder="Prénom" required>
                <input type="mail" id="mail" placeholder="mail" required>
                <input type="tel" id="tel" placeholder="Téléphone" required>
                <button id="submitBtn">Soumettre</button>
                <button class="close" id="closeBtn">Fermer</button>
            </form>

        </div>
    </div>

    <script>
        // Sélectionner les éléments
        const openPopupBtn = document.getElementById('openPopup');
        const popup = document.getElementById('popup');
        const closeBtn = document.getElementById('closeBtn');
        const submitBtn = document.getElementById('submitBtn');
        const hoursInput = document.getElementById('hours');
        const nameInput = document.getElementById('name');
        const prenomInput = document.getElementById('prenom');
        const mailInput = document.getElementById('mail');
        const telInput = document.getElementById('tel');

        // Ouvrir la popup
        openPopupBtn.addEventListener('click', function() {
            popup.style.display = 'flex';
        });

        // Fermer la popup
        closeBtn.addEventListener('click', function() {
            popup.style.display = 'none';
        });

        // Soumettre le nombre d'heures
        submitBtn.addEventListener('click', function() {
            const hoursValue = hoursInput.value;

            // Vérification de la saisie
            if (hoursValue&&nameInput.value&&prenomInput.value&&mailInput.value&&telInput.value) {
                alert("Nombre d'heures : " + hoursValue + "\nNom : " + nameInput.value + "\nPrénom : " + prenomInput.value + "\nMail : " + mailInput.value + "\nTéléphone : " + telInput.value);
                popup.style.display = 'none'; // Fermer la popup après soumission
            } else {
                alert("Il faut remplir tous les champs !");
            }
        });

        // Fermer la popup si l'utilisateur clique en dehors de la boîte de dialogue
        window.addEventListener('click', function(event) {
            if (event.target === popup) {
                popup.style.display = 'none';
            }
        });
    </script>
    <h1>Test Database</h1>
    <?php
    $dsn = "mysql:dbname="."DBchaloine".";host="."servinfo-maria";
    try{
        $connexio = new PDO($dsn, "chaloine", "chaloine");
    }
    catch(PDOException $e){
        printf("Error connecting to database: %s", $e->getMessage());
        exit();
    }

    $sql = "SELECT * FROM PERSONNE";
    if (!$connexio->query($sql)){
        echo "Error: %s\n";
    }
    else{
        $result = $connexio->query($sql);
        echo "<table border='1'>";
        echo "<tr><th>Id</th><th>Nom</th><th>Prénom</th></tr>";
        foreach($result as $row){
            echo "<tr>";
            echo "<td>".$row['idPers']."</td>";
            echo "<td>".$row['nomPers']."</td>";
            echo "<td>".$row['prenomPers']."</td>";
            echo "</tr>";
        }
        echo "</table>";
    }


    $stmt = $connexio->prepare("INSERT INTO PERSONNE (nomPers, prenomPers) VALUES (?, ?)");
    $stmt->execute(["Doe", "John"]);
    ?>
</body>
</html>