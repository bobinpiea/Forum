# Forum


<?php
use App\Session;
?>

<header>
    <nav>
        <!-- Lien toujours visible -->
        <a href="index.php?ctrl=home&action=index">Accueil</a>

        <?php if(Session::getUser()) : ?>
            <!-- Visible uniquement pour un utilisateur connecté -->
            <a href="index.php?ctrl=security&action=logout">Se déconnecter</a>
            <span>Bienvenue <?= Session::getUser()->getNickName(); ?></span>
        <?php else: ?>
            <!-- Visible uniquement pour un visiteur non connecté -->
            <a href="index.php?ctrl=security&action=login">Connexion</a>
            <a href="index.php?ctrl=security&action=register">Inscription</a>
        <?php endif; ?>

        <?php if(Session::isAdmin()) : ?>
            <!-- Lien visible seulement pour un ADMIN -->
            <a href="index.php?ctrl=forum&action=addCategory">Ajouter une catégorie</a>
        <?php endif; ?>
    </nav>
</header>