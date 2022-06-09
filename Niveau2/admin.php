<!doctype html>

<?php
include('modules.php');
?>

<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>ReSoC - Administration</title>
    <meta name="author" content="Julien Falconnet">
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <header>
        <!-- <img src="resoc.jpg" alt="Logo de notre réseau social" />
        <?php
        echo $navbar
        ?> -->
    </header>

    <?php
    /**
     * Etape 1: Ouvrir une connexion avec la base de donnée.
     */

    //ouvrir une connecxion à la BDD


    //verification
    if ($mysqli->connect_errno) {
        echo ("Échec de la connexion : " . $mysqli->connect_error);
        exit();
    }
    ?>
    <div id="wrapper" class='admin'>
        <aside>
            <h2>Mots-clés</h2>
            <?php
            /*
                 * Etape 2 : trouver tous les mots clés
                 */
            $laQuestionEnSql = "SELECT * FROM `tags` LIMIT 50"; #requête vers la BDD
            $lesInformations = $mysqli->query($laQuestionEnSql); #enregistre résultat requête
            // Vérification
            if (!$lesInformations) {
                echo ("Échec de la requete : " . $mysqli->error);
                exit();
            }

            /*
                 * Etape 3 : @todo : Afficher les mots clés en s'inspirant de ce qui a été fait dans news.php
                   Attention à ne pas oublier de modifier tag_id=321 avec l'id du mot dans le lien
                 */
            while ($tag = $lesInformations->fetch_assoc()) {
                // echo "<pre>" . print_r($tag, 1) . "</pre>";
            ?>
                <article>
                    <h3><?php echo $tag['label'] ?></h3>
                    <p><?php echo $tag['id'] ?></p>
                    <nav>
                        <a href="tags.php?<?php echo $tag['label'] ?>">Messages</a>
                    </nav>
                </article>
            <?php } ?>
        </aside>
        <main>
            <h2>Utilisatrices</h2>
            <?php
            /*
                 * Etape 4 : trouver tous les mots clés
                 * PS: on note que la connexion $mysqli à la base a été faite, pas besoin de la refaire.
                 */
            $laQuestionEnSql = "SELECT * FROM `users` LIMIT 50";
            $lesInformations = $mysqli->query($laQuestionEnSql);
            // Vérification
            if (!$lesInformations) {
                echo ("Échec de la requete : " . $mysqli->error);
                exit();
            }

            /*
                 * Etape 5 : @todo : Afficher les utilisatrices en s'inspirant de ce qui a été fait dans news.php
                 * Attention à en pas oublier de modifier dans le lien les "user_id=123" avec l'id de l'utilisatrice
                 */
            while ($tag = $lesInformations->fetch_assoc()) {
                // echo "<pre>" . print_r($tag, 1) . "</pre>";
            ?>
                <article>
                    <h3><?php echo $tag['alias'] ?></h3>
                    <p><?php echo $tag['id'] ?></p>
                    <nav>
                        <a href="wall.php?<?php $tag['id'] ?>">Mur</a>
                        | <a href="feed.php?<?php $tag['id'] ?>">Flux</a>
                        | <a href="settings.php?<?php $tag['id'] ?>">Paramètres</a>
                        | <a href="followers.php?<?php $tag['id'] ?>">Suiveurs</a>
                        | <a href="subscriptions.php?<?php $tag['id'] ?>">Abonnements</a>
                    </nav>
                </article>
            <?php } ?>
        </main>
    </div>
</body>

</html>