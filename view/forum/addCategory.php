<?php
// AddCategory
// Ce fichier permet d'afficher le formulaire pour ajouter une catégorie 
?>

<h1> FORUM : Ajouter une nouvelle catégorie</h1>

        <form action="index.php?ctrl=forum&action=insertCategory" method="post">

            <!--
                -->
                <label for="name">Nom de la catégorie :</label>
               
                <input type="text" name="name" id="name" required>

            <!-- Bouton pour valider le formulaire -->
                <input type="submit" value="Ajouter la catégorie">

        </form>