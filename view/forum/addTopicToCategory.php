<?php
    // On récupère la catégorie dans laquelle on va ajouter le topic
    // Elle a été envoyée depuis le contrôleur dans la clé "category"
    $category = $result["data"]["category"];
?>

<h1>Créer un nouveau topic dans la catégorie "<?= $category ?>"</h1>

<!-- FORMULAIRE HTML pour ajouter un topic -->
<!-- action : c’est l’URL de traitement du formulaire -->
<!-- on envoie aussi l’id de la catégorie dans l’URL (GET) -->
<form action="index.php?ctrl=forum&action=addTopicToCategory&id=<?= $category->getId() ?>" method="post">

    <!-- Champ pour le TITRE du topic -->
    <label for="title">Titre du sujet :</label><br>
    <input type="text" id="title" name="title" required><br><br>
    <!--
        - type="text" : champ texte
        - id="title" : identifiant unique du champ (lié au label)
        - name="title" : nom de la donnée envoyée (clé $_POST)
        - required : l’utilisateur est obligé de remplir ce champ
    -->

    <!-- Champ pour l’ID de l’utilisateur -->
    <!-- Ce champ est temporaire car tu ne fais pas encore les sessions -->
    <label for="user_id">ID de l’utilisateur :</label><br>
    <input type="number" id="user_id" name="user_id" required><br><br>
    <!--
        - type="number" : car l’ID est un nombre (ex. 1, 2, 3…)
        - Ce champ sera remplacé plus tard par la session utilisateur
    -->

    <!-- BOUTON pour valider le formulaire -->
    <input type="submit" value="Créer le topic">
    <!--
        - submit : quand on clique, le formulaire est envoyé au contrôleur
        - value : texte affiché sur le bouton
    -->

</form>