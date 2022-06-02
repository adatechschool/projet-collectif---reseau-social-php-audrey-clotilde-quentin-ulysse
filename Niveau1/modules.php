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

</nav>'

?>

<?php $mysqli = new mysqli("localhost", "root", "root", "socialnetwork"); ?>;

<?php
function navbar_link($link, $name)
{
    $output = "<a href=$link>$name</a>";
    return $output;
}
?>