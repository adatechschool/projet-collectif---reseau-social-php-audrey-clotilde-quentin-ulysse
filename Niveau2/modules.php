<?php
$navbar = '
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
    </ul>

</nav>';

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
        $outcome = $outcome . "<a href =''>#" . $tag . "</a> ";
    }
    return $outcome;
}

function create_post($post)
{
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
                <small>♥ ".$post['like_number']."</small>" .
                display_tags_in_post($post['taglist']) .
            "</footer>
        </article>"
    );
}

//DEBUG
$debug_article = ['created' => '22/03/2022', 'author_name' => 'Quentin', 'content' => 'Ceci est le contenu de mon article', 'like_number' => 8, 'taglist' => 'debug,test']

?>

