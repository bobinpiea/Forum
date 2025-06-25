<?php
  
?>

<h1>Créer un nouveau topic</h1>

<form action="index.php?ctrl=forum&action=addTopic&id=<?= $idCategory ?>" method="post">
    
    <label for="title">Titre du topic :</label><br>
    <input type="text" id="title" name="title" required><br><br>

    <label for="message">Message d’introduction :</label><br>
    <textarea id="message" name="message" required></textarea>

    <input type="submit" value="Créer le topic">

</form>

