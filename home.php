<?php

include_once(__DIR__ . "/database.php");
$db = new Database();
$posts = $db->posts();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Posts - All</title>
    <link rel="stylesheet" href="./node_modules/@fortawesome/fontawesome-free//css/all.min.css">
    <link rel="stylesheet" type="text/css" href="./node_modules/bulma/css/bulma.css">
    <link rel="stylesheet" type="text/css" href="./node_modules/bulma-extensions/bulma-divider/dist/css/bulma-divider.min.css">
    <link rel="stylesheet" type="text/css" href="./static/css/base.css">
</head>
<body>
    <nav class="navbar" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>

    <div id="navbarBasicExample" class="navbar-menu">
        <div class="navbar-start">
            <a class="navbar-item" href="/">
                Posts
            </a>

            <a class="navbar-item" href="/add">
                Add
            </a>
        </div>
    </div>
    </nav>
    <section class="section">
    <div class="container content">

<?php
if (isset($posts)) {
    foreach ($posts as $post) { ?>
<br>
<div class="card">
    <header class="card-header">
        <p class="card-header-title">
            <?php print $post["title"]; ?>
        </p>
    </header>
    <div class="card-content">
        <div class="content">
            <?php print $post["body"]; ?>
            <br>
            Author: <?php print $post["author"]; ?>
            <div class="is-pulled-right">
                <a class="button is-success" href="<?php print "/update?id=" . $post["id"]; ?>">
                    <span class="icon is-medium">
                        <i class="fas fa-edit"></i>
                    </span>
                    <span>Edit</span>
                </a>
                &nbsp;
                <a class="button is-danger" href="<?php print "/delete?id=" . $post["id"]; ?>">
                    <span class="icon is-medium">
                        <i class="fas fa-trash-alt"></i>
                    </span>
                    <span>Delete</span>
                </a>
            </div>
        </div>
    </div>
</div>
<br>
<?php
    }
}
?>

    </div>
    </section>

    <footer class="footer">
        <div class="content has-text-centered">
            <p>
                <strong>Posts</strong> by <a href="https://github.com/shutdown57">Majid Mohamadi Parvar</a>. The source code is licensed
                <a href="http://opensource.org/licenses/mit-license.php">MIT</a>. The website content
                is licensed <a href="http://creativecommons.org/licenses/by-nc-sa/4.0/">CC BY NC SA 4.0</a>.
            </p>
        </div>
    </footer>
    <script type="text/javascript" src="./node_modules/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="./static/js/base.js"></script>

</body>
</html>
