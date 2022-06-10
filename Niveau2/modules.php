<?php
session_start();
//echo "<pre>" . print_r($_SESSION, 1) . "</pre>";
$urlId = $_SESSION['connected_id'];

$navbar = '
    <img src="resoc.jpg" alt="Logo de notre réseau social"/>
 <nav id="menu">
    <a href="news.php">Actualités</a>
    <a href="wall.php?user_id=' . $urlId . '">Mur</a>
    <a href="feed.php?user_id=' . $urlId . '">Flux</a>
    <a href="tags.php?tag_id=1">Mots-clés</a>
</nav>
<nav id="user">
    <a href="#">Profil</a>
    <ul>
        <li><a href="settings.php?user_id=' . $urlId . '">Paramètres</a></li>
        <li><a href="followers.php?user_id=' . $urlId . '">Mes suiveurs</a></li>
        <li><a href="subscriptions.php?user_id=' . $urlId . '">Mes abonnements</a></li>
        <li><a href="logout.php?">Déconnexion</a></li>
    </ul>
</nav>';

if (!$_SESSION['connected_id']) {
        $navbar = '
        <img src="resoc.jpg" alt="Logo de notre réseau social"/>
 <nav id="menu">
    <a href="news.php">Actualités</a>
    <a href="wall.php?user_id=' . $urlId . '">Mur</a>
    <a href="feed.php?user_id=' . $urlId . '">Flux</a>
    <a href="tags.php?tag_id=1">Mots-clés</a>
</nav>
        <nav id="user">
            <a href="login.php">Connexion</a>
        </nav>
        ';
    };

$mysqli = new mysqli("localhost", "root", "root", "socialnetwork");

function navbar_link($link, $name)
{
    $output = "<a href=$link>$name</a>";
    return $output;
}

function display_tags_in_post($taglist)
{
    $tags = explode(",", $taglist);
    $outcome = "";
    foreach ($tags as $tag){
        $requeteTagId = " SELECT id FROM tags WHERE label = '$tag' ";
        global $mysqli;
        $tagIdList = $mysqli->query($requeteTagId);
        if (!$tagIdList) {
            echo "Impossible d'ajouter le message: " . $mysqli->error;
        }
        $tagIdFetch = $tagIdList->fetch_assoc();
        //echo "<pre>" . print_r($tagIdFetch, 1) . "</pre>";
        $id = $tagIdFetch['id'];
        $outcome = $outcome . "<a href ='tags.php?tag_id=" . $id . "'>#" . $tag . "</a> ";
    }
    return $outcome;
}

function create_post($post)
{
    if (isset($post['taglist'])) {
    echo(
        "<article>
            <h3>
                <time datetime=".$post['created'].">".$post['created']."</time>
            </h3>
            <address>".$post['author_name']."
            </address>
            <div>
                <p>".$post['content']."</p>
            </div>
            <footer>
                <small>♥ ".$post['like_number']."</small>"
                . display_tags_in_post($post['taglist'])
            . "</footer>
        </article>"
    ); } else {
    
    echo(
        "<article>
            <h3>
                <time datetime=".$post['created'].">".$post['created']."</time>
            </h3>
            <address>".$post['author_name']."
            </address>
            <div>
                <p>".$post['content']."</p>
            </div>
            <footer>
                <small>♥ ".$post['like_number']."</small>"
            . "</footer>
        </article>"
    );};

}

?>
