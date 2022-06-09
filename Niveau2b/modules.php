<?php
    session_start();
    echo "<pre>" . print_r($_SESSION, 1) . "</pre>";
    $urlId= $_SESSION['connected_id'];
?>

<header>
    <img src="resoc.jpg" alt="Logo de notre réseau social"/>
        <nav id="menu">
            <a href="news.php?user_id=<?php echo $urlId ?>">Actualités</a>
            <a href="wall.php?user_id=<?php echo $urlId ?>">Mur</a>
            <a href="feed.php?user_id=<?php echo $urlId ?>">Flux</a>
            <a href="tags.php?tag_id=1">Mots-clés</a>
        </nav>
        <nav id="user">
            <a href="#">Profil</a>
            <ul>
                <li><a href="settings.php?user_id=5">Paramètres</a></li>
                <li><a href="followers.php?user_id=5">Mes suiveurs</a></li>
                <li><a href="subscriptions.php?user_id=5">Mes abonnements</a></li>
            </ul>

        </nav>
</header>


<?php   

    $mysqli = new mysqli("localhost", "root", "root", "socialnetwork");

    function navbar_link($link, $name){
        $output = "<a href=$link>$name</a>";
        return $output;
    };

    

?>

