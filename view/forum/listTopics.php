<?php
    $category = $result["data"]['category']; 
    $topics = $result["data"]['topics']; 
?>

<h1>Liste des topics dans la catégorie : <?= $category->getName() ?></h1>

<?php foreach($topics as $topic) { ?>
    <p>
        <a href="index.php?ctrl=forum&action=detailTopic&id=<?= $topic->getId() ?>">
            <?= $topic->getTitle() ?>
        </a>
        par <?= $topic->getUser()->getNickName() ?>
        le <?= $topic->getCreationDate()?>
    </p>
<?php } ?>