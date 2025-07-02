<?php
    // On récupère les données envoyées depuis le contrôleur ForumController (via return[])
    // Le tableau $result contient un sous-tableau appelé 'data', et dans ce sous-tableau, il y a un élément 'categories'
    // Cet élément contient en réalité une liste (un tableau) d'objets Category (grâce à CategoryManager)
    // On stocke donc tout ça dans une variable plus simple : $categories
    $categories = $result["data"]['categories']; 
?>


<h1>FORUM - LISTES DES CATEGORIES</h1>


<p><a href="index.php?ctrl=forum&action=addCategory">Créer une nouvelle catégorie</a></p>

<?php
// On parcourt chaque catégorie (chaque objet Category) dans la liste $categories
foreach($categories as $category ){ ?>

    <p> 
        <!-- Lien vers les topics de la catégorie -->
        <a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>">
            <?= $category->getName() ?>
        </a> 
        
        <!-- Lien pour supprimer la catégorie avec confirmation -->
        <a 
            href="index.php?ctrl=forum&action=deleteCategory&id=<?= $category->getId() ?>"
            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ? Cette action est irréversible.')"
        >
            Supprimer
        </a>
    </p>

<?php } ?>