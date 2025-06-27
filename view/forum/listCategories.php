<?php
    // A revoir ça
    $categories = $result["data"]['categories']; 
?>

<h1> FORUM - Liste des catégories</h1>
<!-- Lien pour  une nouvelle catégorie -->
<a href="index.php?ctrl=forum&action=addCategory">Créer une nouvelle catégorie</a>

<?php
    // On parcourt chaque catégorie pour l'afficher
    foreach($categories as $category ){ ?>
        <p>
            <!-- Lien vers la liste des topics de cette catégorie -->
            <a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>">
                <?= $category->getName() ?>
            </a>

            <!-- Lien pour supprimer la catégorie -->
            <a style="color: red;" href="index.php?ctrl=forum&action=deleteCategory&id=<?= $category->getId() ?>">
                Supprimer
            </a>
        </p>
<?php } ?>
