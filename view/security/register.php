
<!-- Formulaire d'inscription -->

<h1>Créer un compte</h1>

<!-- Formulaire d'inscription -->
<form action="index.php?ctrl=security&action=register" method="POST">

    <!-- Champ pour le pseudo (nickName) -->
    <label for="nickName">Pseudo :</label><br>
    <input type="text" name="nickName" id="nickName" required><br>

    <!-- Champ pour l'email -->
    <label for="email">Adresse email :</label><br>
    <input type="email" name="email" id="email" required><br>

    <!-- Champ pour le mot de passe -->
    <label for="pass1">Mot de passe :</label><br>
    <input type="password" name="pass1" id="pass1" required><br>

    <!-- Champ pour confirmer le mot de passe -->
    <label for="pass2">Veuillez confirmer le mot de passe :</label><br>
    <input type="password" name="pass2" id="pass2" required><br>

    <!-- Bouton pour envoyer le formulaire -->
    <input type="submit" name="submit" value="S'inscrire">

</form>