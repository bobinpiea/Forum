<?php
    // On récupère les données envoyées par le contrôleur
// A relire pour mieux comprendre 
    $category = $result["data"]['category']; 
    $topics = $result["data"]['topics']; 
?>


<h1>FORUM - Liste des topics : <?= $category->getName() ?></h1>
       <!-- Lien vers le détail du topic -->
<a href="index.php?ctrl=forum&action=addTopic&id=<?= $category->getId() ?>">Créer un nouveau topic</a>
<?php foreach($topics as $topic) { ?>
  <p>
    <a href="index.php?ctrl=forum&action=detailTopic&id=<?= $topic->getId() ?>">
        <?= $topic->getTitle() ?>
    </a>
    par 
    <?php if ($topic->getUser()) : ?>
        <?= $topic->getUser()->getNickName() ?>
    <?php else : ?>
        <em>Anonyme</em>
    <?php endif; ?>
    le <?= $topic->getCreationDate() ?>
      <!--  Lien pour supprimer ce topic -->
    <a href="index.php?ctrl=forum&action=deleteTopic&id=<?= $topic->getId() ?>">Supprimer</a>
</p>
<?php } ?>
