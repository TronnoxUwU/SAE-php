<main class="login-container">
    <form id="registerForm" method="POST">
        <h1>Inscription</h1>

        <div class="form-group">
            <label for="name">Nom *</label>
            <input type="text" id="name" name="name" placeholder="nom" required>
        </div>

        <div class="form-group">
            <label for="prenom">Prénom *</label>
            <input type="text" id="prenom" name="prenom" placeholder="prenom" required>
        </div>

        <div class="form-group">
            <label for="email">eMail *</label>
            <input type="email" id="email" name="email" placeholder="test@mail.com" required>
        </div>

        <div class="form-group">
            <label for="password">Mot de passe *</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="form-group">
            <label for="telephone">Téléphone</label>
            <input type="text" id="telephone" name="telephone" placeholder="téléphone : 06 07 08 09 10">
        </div>

        <div class="form-group">
            <label for="ville">ville</label>
            <input type="text" id="ville" name="ville" placeholder=Orléans>
        </div>

        <div class="form-group">
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
            <input type="checkbox" id="handicap" name="handicap" >
        </div>


        <div class="form-group" id="btnform">
            <button name="partie-insc" type="submit">S'inscrire</button>
        </div>

         
        <script src="../static/script/update-ville-region.js"></script>

    </form>
</main>