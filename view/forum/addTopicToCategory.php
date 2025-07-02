<?php
    // On récupère la catégorie dans laquelle on va ajouter le topic
    // Elle a été envoyée depuis le contrôleur dans la clé "category"
    $category = $result["data"]["category"];
?>

<h1>Créer un nouveau topic dans la catégorie <?= $category ?> </h1>

<form action="index.php?ctrl=forum&action=addTopicToCategory&id=<?= $category->getId() ?>" method="post">

    <label for="title">Titre du sujet :</label><br>
    <input type="text" id="title" name="title" required><br><br>


    <label for="user_id">ID de l’utilisateur :</label><br>
    <input type="number" id="user_id" name="user_id" required><br><br>
  

    
    <input type="submit" value="Créer le topic">
   
</form>