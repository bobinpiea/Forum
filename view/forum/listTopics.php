<?php
    // On récupère les données envoyées par le contrôleur
// A relirepour mieux comprendre 
    $category = $result["data"]['category']; 
    $topics = $result["data"]['topics']; 
?>


<h1>FORUM - Liste des topics : <?= $category->getName() ?></h1>


<a href="index.php?ctrl=forum&action=addTopicSimple&id=<?= $category->getId() ?>">Ajouter un nouveau topic</a>


<?php foreach($topics as $topic) { ?>
    <p>
   
        <a href="index.php?ctrl=forum&action=detailTopic&id=<?= $topic->getId() ?>">
            <?= $topic->getTitle() ?>
        </a>
       
        par <?= $topic->getUser()->getNickName() ?>
        le <?= $topic->getCreationDate() ?>
    </p>
<?php } ?>


<?php
    $category = $result["data"]["category"];
?>


<form action="index.php?ctrl=forum&action=addTopicToCategory&id=<?= $category->getId() ?>" method="post">
    <label for="title"> Nouveau Topic:</label>
    <input type="text" name="title" id="title" required>

    <button type="submit">Valider</button>
</form>