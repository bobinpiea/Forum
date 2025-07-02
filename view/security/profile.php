<?php $user = $result["data"]["user"]; ?>

<h1>Mon profil</h1>

<div>

    <div>
       
    </div>

    <div>
        <!-- Affichage du Pseudo -->
        <p><strong>Pseudo :</strong> <?= $user->getNickName() ?></p>

        <!-- Affichage du role -->
        <p><strong>Rôle :</strong> <?= $user->getRole() ?></p> 

        <!-- Date d'inscription  -->
        <p><strong>Inscrit depuis le :</strong> 
            <?= date("d/m/Y", strtotime($user->getCreationDate())) ?>
        </p>

        <!-- Afficher le nbr de message posté -->
        <p><strong>Nombre de messages postés :</strong> à venir</p>

        <!-- le nbr de reponses-->
        <p><strong>Nombre de réponses postées :</strong> à venir</p>

    </div>

</div>

<div>
    <a href="index.php?ctrl=security&action=editProfile">Modifier mon profil</a>
</div>