<h1>Connexion</h1>

<!-- Formulaire de connexion -->
<!-- Les données seront envoyées en POST au contrôleur Security -->
<form action="index.php?ctrl=security&action=login" method="POST">

    <!-- Champ Email -->
    <label for="email">Email</label><br>
    <input type="email" name="email" id="email" required><br><br>

    <!-- Champ Mot de passe -->
    <label for="password">Mot de passe</label><br>
    <input type="password" name="password" id="password" required><br><br>

    <!-- Bouton de soumission/validation -->
    <input type="submit" name="submit" value="Se connecter">

</form>