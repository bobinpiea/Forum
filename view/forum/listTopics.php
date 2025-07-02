<?php
    // On récupère la catégorie actuelle 
    $category = $result["data"]['category'];

    // On récupère la liste des topics liés à cette catégorie (tableau d’objets Topic)
    $topics = $result["data"]['topics'];
?>

<!-- TITRE DE LA PAGE -->
<!-- Avec la methode  __toString(), on affiche automatiquement le nom de la catégorie -->
<h1>FORUM - Topics de la catégorie <?= $category ?></h1>

<!-- LIEN pour ajouter un nouveau topic dans cette catégorie -->
<p>
    <a href="index.php?ctrl=forum&action=addTopicToCategory&id=<?= $category->getId() ?>">
         Créer un nouveau topic dans cette catégorie
    </a>
</p>

<?php 
// On vérifie si la liste de topics n’est pas vide
if ($topics): 

    // On boucle sur chaque topic pour les afficher un par un
    foreach($topics as $topic): 
?>

    <p>
        <!-- LIEN vers la page qui affiche les messages de ce topic -->
        <!-- On envoie l’ID du topic dans l’URL avec ?id= -->
        <a href="index.php?ctrl=forum&action=listMessagesByTopic&id=<?= $topic->getId() ?>">
            <?= $topic ?> <!-- Affiche le titre du topic (grâce à __toString()) -->
        </a>

        <?php
            // On récupère la date de création (objet DateTime)
            $date = new DateTime($topic->getCreationDate());

            // Formatage de la date : ex. 28/06/2025 à 14h32
            $dateFormatted = $date->format("d/m/Y à H\hi");
        ?>

        <!-- AFFICHAGE du pseudo + date formatée -->
        <!-- On affiche le pseudo récupéré avec la jointure -->
        par <strong><?= $topic->getNickName() ?></strong>, le <?= $dateFormatted ?>

        <!-- LIEN pour supprimer le topic  -->
        <!-- On envoie l'ID du topic dans l'URL pour pouvoir le supprimer -->
        <!-- On ajoute une confirmation JavaScript pour éviter les clics accidentels -->
        <a href="index.php?ctrl=forum&action=deleteTopic&id=<?= $topic->getId() ?>"
           onclick="return confirm('Confirmer la suppression de ce topic ?')">
            Supprimer
        </a>
    </p>

<?php 
    // Fin de la boucle foreach
    endforeach; 

else: 
    // Si aucun topic dans la catégorie, on informe l’utilisateur
?>
    <p>Aucun topic dans cette catégorie pour le moment.</p>
<?php 
// Fin du if
endif; 
?>