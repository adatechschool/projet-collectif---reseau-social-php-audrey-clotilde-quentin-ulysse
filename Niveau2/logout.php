<?php include('modules.php') 
?>

<?php
unset($_SESSION['connected_id'])
?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>ReSoC - Inscription</title>
    <meta name="author" content="Julien Falconnet">
    <link rel="stylesheet" href="style.css" />
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
            <h2>Présentation</h2>
            <p>Bienvenu sur notre réseau social.</p>
        </aside>
        <main>
            <article>
                <h2>Déconnexion</h2>
                <p>Vous êtes bien déconnecté ! A bientôt !</p>
            </article>
        </main>
    </div>