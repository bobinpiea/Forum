<?php
    $idCategory = $_GET['id'];
?>

<h1>Créer un nouveau topic</h1>

<!-- Formulaire d'ajout de topic -->
<form action="index.php?ctrl=forum&action=addTopicSimple&id=<?= $idCategory ?>" method="post">
    
    <label for="title">Titre du topic :</label>
    <input type="text" name="title" id="title" required>

    <br><br>

    <input type="submit" value="Créer le topic">

</form>

