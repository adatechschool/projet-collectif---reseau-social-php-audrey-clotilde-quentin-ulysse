<!doctype html>

<?php
include('modules.php');

#ICI ON ECRIT LES VARIABLES DE LA PAGE
$userId = intval($_GET['user_id']);

#ICI ON ECRIT LES STRINGS DES REQUÊTES
$requeteAbonnement = "INSERT INTO followers "
                    . "(id, followed_user_id, following_user_id) " //ajouter dans la table les colonnes permalink et post_id et leur faire correspondre le lien du post (URL) et id du post ou supprimer ces colonnes et leurs valeurs dans le code. 
                    . "VALUES (NULL, "
                    . $userId .", "
                    . $_SESSION['connected_id']
                    . ")";

#ICI ON EXECUTE LES REQUÊTES EN ECRITURE
$enCoursAbonnement = isset($_POST['subscribe']);
if ($enCoursAbonnement){
    $ok_subscribe = $mysqli->query($requeteAbonnement);    
}
?>

<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>ReSoC - Mur</title>
    <meta name="author" content="Julien Falconnet">
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <header>
        <!-- <img src="resoc.jpg" alt="Logo de notre réseau social" /> -->
        <!-- <?php
        echo $navbar
        ?> -->
    </header>
    <div id="wrapper">
        <?php

        /**
         * Etape 3: récupérer tous les messages de l'utilisatrice
         */
        
        $requeteMessages = "
                    SELECT posts.content, posts.created, users.alias as author_name, 
                    COUNT(likes.id) as like_number, GROUP_CONCAT(DISTINCT tags.label) AS taglist 
                    FROM posts
                    JOIN users ON  users.id=posts.user_id
                    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
                    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
                    LEFT JOIN likes      ON likes.post_id  = posts.id 
                    WHERE posts.user_id='$userId' 
                    GROUP BY posts.id
                    ORDER BY posts.created DESC  
                    ";

        /**
         * Etape 1: Le mur concerne un utilisateur en particulier
         * La première étape est donc de trouver quel est l'id de l'utilisateur
         * Celui ci est indiqué en parametre GET de la page sous la forme user_id=...
         * Documentation : https://www.php.net/manual/fr/reserved.variables.get.php
         * ... mais en résumé c'est une manière de passer des informations à la page en ajoutant des choses dans l'url
         */

        $userIsWallOwner = ($_SESSION['connected_id'] == $userId);
        $connectedID = $_SESSION['connected_id'];
        ?>
        <?php
        /**
         * Etape 2: se connecter à la base de donnée
         */
        $mysqli = new mysqli("localhost", "root", "root", "socialnetwork");
        ?>

        <aside>
            <?php
            /**
             * Etape 3: récupérer le nom de l'utilisateur
             */
            $requeteInfosWallOwner = "SELECT * FROM users WHERE id= '$userId' ";
            $wallOwnerInfos = $mysqli->query($requeteInfosWallOwner);
            $user = $wallOwnerInfos->fetch_assoc();
            //@todo: afficher le résultat de la ligne ci dessous, remplacer XXX par l'alias et effacer la ligne ci-dessous
            // echo "<pre>" . print_r($user, 1) . "</pre>";

            ?>
            <img src="user.jpg" alt="Portrait de l'utilisatrice" />
            <section>
                <h3>Présentation</h3>
                <p>Sur cette page vous trouverez tous les message de l'utilisatrice : <?php echo $user['alias']; ?>
                    (n°<?php echo $userId ?>)
                </p>
                <?php
                $requeteCheckAbonnes = "
                SELECT * 
                FROM followers 
                WHERE followers.following_user_id='$connectedID' AND followers.followed_user_id='$userId'";


                if (!$userIsWallOwner) {
                    if ($connectedID) {
                        $isConnected = $mysqli->query($requeteCheckAbonnes);
                        $connexionLink = $isConnected->fetch_assoc(); #le résultat de la requête est comme une promesse donc il faut un fetch_assoc() pour récupérer une donnée utilisable.
                        echo "<pre>" . print_r($connexionLink, 1) . "</pre>";
                        if (!$connexionLink) {
                ?>
                            <form method="post">
                                <dl>
                                    <input type="submit" value="Je m'abonne !" name="subscribe">
                                    <?php
                                        if ($enCoursAbonnement && !$ok_subscribe){
                                            echo "Déso, l'abonnement a échoué" . $mysqli->error;
                                        }
                                    ?> 
                                </dl>
                            </form>
                        <?php
                        } else {
                        ?>
                            <form action="wall.php?user_id=<?php echo $_SESSION['connected_id'] ?>" method="post">
                                <dl>
                                    <input type="button" value="Me désabonner :(">
                                </dl>
                            </form>
                <?php
                        }
                    }
                }
                ?>
            </section>
        </aside>
        <main>
            <?php

            $enCoursDeTraitement = isset($_POST['message']);
            if ($enCoursDeTraitement) {

                $postContent = $_POST['message'];

                $postContent = $mysqli->real_escape_string($postContent);

                $lInstructionSql = "INSERT INTO posts "
                    . "(id, user_id, content, created) " //ajouter dans la table les colonnes permalink et post_id et leur faire correspondre le lien du post (URL) et id du post ou supprimer ces colonnes et leurs valeurs dans le code. 
                    . "VALUES (NULL, "
                    . $_SESSION['connected_id'] . ", "
                    . "'" . $postContent . "', "
                    . "NOW());";
                //echo $lInstructionSql;
                // Etape 5 : execution
                $ok = $mysqli->query($lInstructionSql);
                if (!$ok) {
                    echo "Impossible d'ajouter le message: " . $mysqli->error;
                } else {
                    echo "Message posté";
                }
            }

            $lesInformations = $mysqli->query($requeteMessages);
            if (!$lesInformations) {
                echo ("Échec de la requete : " . $mysqli->error);
            }


            if ($userIsWallOwner) {
            ?>
                <form action="wall.php?user_id=<?php echo $_SESSION['connected_id'] ?>" method="post">
                    <dl>
                        <dt><label for='message'>Message</label></dt>
                        <dd><textarea name='message'></textarea></dd>
                    </dl>
                    <input type='submit'>
                </form>

            <?php
            }
            /**
             * Etape 4: @todo Parcourir les messsages et remplir correctement le HTML avec les bonnes valeurs php
             */
            while ($post = $lesInformations->fetch_assoc()) {

                // echo "<pre>" . print_r($post, 1) . "</pre>";
            ?>
                <article>
                    <h3>
                        <time datetime=<?php echo $post['created'] ?>><?php echo $post['created'] ?></time>
                    </h3>
                    <address><?php echo $post['author_name'] ?>
                    </address>
                    <div>
                        <p>
                            <?php echo $post['content'] ?>
                        </p>
                    </div>
                    <footer>
                        <small> <?php echo $post['like_number'] ?> </small>
                        <a href=<?php echo $post['taglist'] ?>><?php echo $post['taglist'] ?></a>
                        <a href=""></a>,
                    </footer>
                </article>
            <?php } ?>


        </main>
    </div>
</body>

</html>