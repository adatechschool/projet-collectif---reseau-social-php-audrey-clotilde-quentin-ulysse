<?php
    session_start();
    echo "<pre>" . print_r($_SESSION, 1) . "</pre>";
?>

<?php
    $navbarfix = '
        <nav id="menu">
            <a href="news.php">Actualités</a>
            <a href="wall.php?user_id=5">Mur</a>
            <a href="feed.php?user_id=5">Flux</a>
            <a href="tags.php?tag_id=1">Mots-clés</a>
        </nav>
        <nav id="user">
            <a href="#">Profil</a>
            <ul>
                <li><a href="settings.php?user_id=5">Paramètres</a></li>
                <li><a href="followers.php?user_id=5">Mes suiveurs</a></li>
                <li><a href="subscriptions.php?user_id=5">Mes abonnements</a></li>
                <li><a href="logout.php?">Déconnexion</a></li>
            </ul>

        </nav>
        ';

    if (!$_SESSION['connected_id']) {
        $navbarfix = '
        <nav id="menu">
            <a href="news.php">Actualités</a>
            <a href="wall.php?user_id=5">Mur</a>
            <a href="feed.php?user_id=5">Flux</a>
            <a href="tags.php?tag_id=1">Mots-clés</a>
        </nav>
        <nav id="user">
            <a href="login.php">Connexion</a>

        </nav>
        ';
    };

    $navbar = $navbarfix;    

    $mysqli = new mysqli("localhost", "root", "root", "socialnetwork");

    function navbar_link($link, $name){
        $output = "<a href=$link>$name</a>";
        return $output;
    };

    

?>

