<?php include('modules.php');
    if (!isset($_SESSION['connected_id'])) {
    echo $_SESSION['connected_id'];
    header("Location: login.php");
    exit();
} ?>

<!doctype html>

<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>ReSoC - Mes abonnements</title> 
        <meta name="author" content="Julien Falconnet">
        <link rel="stylesheet" href="style.css"/>
    </head>
    <body>
    <header>
        <img src="resoc.jpg" alt="Logo de notre réseau social" />
        <?php 
            echo $navbar
        ?>
    </header>
        <div id="wrapper">
            <aside>
                <img src="user.jpg" alt="Portrait de l'utilisatrice"/>
                <section>
                    <h3>Présentation</h3>
                    <p>Sur cette page vous trouverez la liste des personnes dont
                        l'utilisatrice
                        n° <?php echo intval($_GET['user_id']) ?>
                        suit les messages
                    </p>

                </section>
            </aside>
            <main class='contacts'>
                <?php
                // Etape 1: récupérer l'id de l'utilisateur
                $userId = intval($_GET['user_id']);
                // Etape 2: se connecter à la base de donnée
                $mysqli = new mysqli("localhost", "root", "root", "socialnetwork");
                // Etape 3: récupérer le nom de l'utilisateur
                $laQuestionEnSql = "
                    SELECT users.* 
                    FROM followers 
                    LEFT JOIN users ON users.id=followers.followed_user_id 
                    WHERE followers.following_user_id='$userId'
                    GROUP BY users.id
                    ";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                // Etape 4: à vous de jouer
                //@todo: faire la boucle while de parcours des abonnés et mettre les bonnes valeurs ci dessous 
                while ($userName = $lesInformations->fetch_assoc())
                {
                    //echo "<pre>" . print_r($userName, 1) . "</pre>";
                ?>
                <article>
                    <img src="user.jpg" alt="blason"/>
                    <a href="wall.php?user_id=<?php echo $userName['id']?>"><?php echo $userName['alias']?></a>
                    <p>id:<?php echo $userName['id']?></p>                    
                </article>
                <?php } ?>                    
            </main>
        </div>
    </body>
</html>
