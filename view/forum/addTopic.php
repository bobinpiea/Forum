<?php
    $categoryId = $result["data"]["category_id"];
?>

<h1>Créer un nouveau topic dans la catégorie <?= $categoryId ?></h1>

<form action="index.php?ctrl=forum&action=addTopicToCategory&id=<?= $categoryId ?>" method="post">
    <label for="title">Titre du topic :</label><br>
    <input type="text" id="title" name="title" required><br>

      <!-- CHAMP USER_ID  -->
    <!-- 
    <label for="user_id">Votre ID utilisateur :</label><br>
    <input type="number" id="user_id" name="user_id" value="1" required><br>
    -->

    <input type="submit" value="Créer le topic">
</form>