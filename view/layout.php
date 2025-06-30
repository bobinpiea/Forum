<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?= $meta_description ?>">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <script src="https://cdn.tiny.cloud/1/zg3mwraazn1b2ezih16je1tc6z7gwp5yd4pod06ae5uai8pa/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />
        <link rel="stylesheet" href="<?= PUBLIC_DIR ?>css/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        <title>FORUM</title>
    </head>
    <body>
        <div id="wrapper"> 
            <div id="mainpage">
                <!-- c'est ici que les messages (erreur ou succès) s'affichent-->
                <h3 class="message" style="color: red"><?= App\Session::getFlash("error") ?></h3>
                <h3 class="message" style="color: green"><?= App\Session::getFlash("success") ?></h3>
                    <!-- HEADER -->
                <header>
                    <nav>
                        <!-- 2 : le logo -->
                        <div id="logo">
                            <a href="http://localhost:8888/pierre_BOBIN/Forum/index.php">
                                <img src="public/img/logo.webp" alt="Logo Talk'em">
                            </a>
                        </div>
                        <!-- Le menu de gauche -->
                        <div id="nav-left">
                            <a href="http://localhost:8888/pierre_BOBIN/Forum/index.php">Accueil</a>
                            <a href="index.php?ctrl=forum&action=listTopicsByCategory&id=55">Cash Game</a>
                            <a href="index.php?ctrl=forum&action=listTopicsByCategory&id=56">MTT</a>
                            <a href="index.php?ctrl=forum&action=listTopicsByCategory&id=57">Spin & Expresso</a>
                            <?php if(App\Session::isAdmin()){ ?>
                                <a href="index.php?ctrl=home&action=users">Voir la liste des gens</a>
                            <?php } ?>
                        </div>
                        <!-- Le menu de droite --> 
                        <div id="nav-right">
                            <?php if(App\Session::getUser()){ ?>
                                <a href="index.php?ctrl=security&action=profile">
                                    <span class="fas fa-user"></span>&nbsp;<?= App\Session::getUser() ?>
                                </a>
                                <a href="index.php?ctrl=security&action=logout">Déconnexion</a>
                            <?php } else { ?> 
                           
                                <a href="index.php?ctrl=forum&action=index">Liste des catégories</a>
                                <a href="index.php?ctrl=forum&action=listTopics">Liste des topics</a> 
                                    <!-- 5 : connexion et inscription -->
                                <a class="bouton-connexion" href="index.php?ctrl=security&action=login">Connexion</a>
                                <a class="bouton-inscription" href="index.php?ctrl=security&action=register">Inscription</a>
                            <?php } ?>
                        </div>
                    </nav>
                </header>
                
                
                <main id="forum">
                    <?= $page ?>
                </main>
            </div>


         <footer>
    <!-- SECTION 1 DU FOOTER -->
    <section class="footer1">
        <!-- Colonne 1 : Présentation -->
        <div class="presentation">
            <img class="logo" src="public/img/logo.webp" alt="Logo Talk'em">
            <p class="center">Leçons de poker, vidéos et discussions stratégiques Talk’em — là où les gagnants se retrouvent</p>
            <div class="reseaux">
                <a href="https://www.facebook.com/" target="_blank" rel="noopener noreferrer"><i class="fab fa-facebook-f"></i></a>
                <a href="https://twitter.com/" target="_blank" rel="noopener noreferrer"><i class="fab fa-x-twitter"></i></a>
                <a href="https://www.tiktok.com/" target="_blank" rel="noopener noreferrer"><i class="fab fa-tiktok"></i></a>
                <a href="https://www.youtube.com/" target="_blank" rel="noopener noreferrer"><i class="fab fa-youtube"></i></a>
                <a href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer"><i class="fab fa-instagram"></i></a>
            </div>
        </div>

        <!-- Colonne 2 : Rooms de poker -->
        <div>
            <p>POKER ROOMS</p>

            <div class="room">
                <img src="public/img/unibet.webp" alt="unibet logo">
                <a href="https://www.unibet.fr/pari-sportif-poker" target="_blank" rel="noopener noreferrer">Unibet Poker</a>
            </div>

            <div class="room">
                <img src="public/img/winamax.webp" alt="winamax logo">
                <a href="https://www.winamax.fr/" target="_blank" rel="noopener noreferrer">Winamax</a>
            </div>

            <div class="room">
                <img src="public/img/PokerStars.webp" alt="pokerstar logo">
                <a href="https://www.pokerstars.com/fr/?&no_redirect=1" target="_blank" rel="noopener noreferrer">PokerStars</a>
            </div>
        </div>

        <!-- Colonne 3 : Jobs et partenaires -->
        <div>
            <p>Jobs & Partenaires</p>
            <a href="#" target="_blank" rel="noopener noreferrer">Devenir coach</a>
            <a href="#" target="_blank" rel="noopener noreferrer">Devenir club partenaire</a>
            <a href="#" target="_blank" rel="noopener noreferrer">Devenir stagiaire</a>       
        </div>

        <!-- Colonne 4 : À propos -->
        <div>
            <p>À propos de nous</p>
            <a href="#" target="_blank" rel="noopener noreferrer">Conditions générales</a>
            <a href="#" target="_blank" rel="noopener noreferrer">Mentions légales</a>
            <a href="#" target="_blank" rel="noopener noreferrer">Questions fréquentes</a>
            <a href="#" target="_blank" rel="noopener noreferrer">Notre blog</a>
            <a href="https://www.facebook.com/" target="_blank" rel="noopener noreferrer">Groupe privé Facebook</a>
        </div>
    </section>

    <!-- SECTION 2 DU FOOTER -->
    <section class="footer2">
        <p>CGU - Club Poker</p> 
        <p>&copy; Talk’em 2005-2025</p>
    </section>

    <!-- SECTION 3 DU FOOTER -->
    <section class="footer3">
        <p> 
            Les jeux d'argent sont interdits aux mineurs. Il est strictement interdit aux mineurs de jouer de l'argent. 
            Les joueurs qui choisissent de jouer de l'argent le font de leur gré et à leurs risques en sachant que dans 
            tous jeux de hasard, il y a des risques de perdre de l'argent. Talk’em travaille uniquement avec des 
            opérateurs agréés par l'ARJEL. 
        </p>
    </section>
</footer>
           
        </div>
        <script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous">
        </script>
        <script>
            $(document).ready(function(){
                $(".message").each(function(){
                    if($(this).text().length > 0){
                        $(this).slideDown(500, function(){
                            $(this).delay(3000).slideUp(500)
                        })
                    }
                })
                $(".delete-btn").on("click", function(){
                    return confirm("Etes-vous sûr de vouloir supprimer?")
                })
                tinymce.init({
                    selector: '.post',
                    menubar: false,
                    plugins: [
                        'advlist autolink lists link image charmap print preview anchor',
                        'searchreplace visualblocks code fullscreen',
                        'insertdatetime media table paste code help wordcount'
                    ],
                    toolbar: 'undo redo | formatselect | ' +
                    'bold italic backcolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat | help',
                    content_css: '//www.tiny.cloud/css/codepen.min.css'
                });
            })
        </script>
        <script src="<?= PUBLIC_DIR ?>/js/script.js"></script>
    </body>
</html> 