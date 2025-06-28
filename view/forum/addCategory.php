<?php
//  AddCategory
// Ce fichier permet d'afficher le formulaire pour ajouter une catégorie 
?>

<h1> FORUM : Ajouter une nouvelle catégorie</h1>

    <!-- 
        FORMULAIRE HTML qui envoie les données vers le contrôleur ForumController
        Il va exécuter la méthode insertCategory() :
            - ctrl=forum , pour le ForumController
            - action=insertCategory, pour choisir la bonne méthode
    -->
        <form action="index.php?ctrl=forum&action=insertCategory" method="post">

            <!-- Champ de texte pour le nom de la catégorie -->
                 <!-- 
                    Label = le texte affiché à côté du champ 
                    for="name" = lié au champ qui a id="name"
                -->
                <label for="name">Nom de la catégorie :</label>
                 <!-- 
                    Ci-dessous:
                    - type="text" = l'utilisateur peut taper du texte
                    - name="name" = la donnée sera récupérée en PHP avec $_POST['name']
                    - id="name" = sert à relier le champ au label
                    - required = empêche d’envoyer le formulaire vide
                -->
                <input type="text" name="name" id="name" required>

            <!-- Bouton pour valider le formulaire -->
                <input type="submit" value="Ajouter la catégorie">

        </form>