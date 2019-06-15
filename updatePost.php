<?php

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (empty($_GET["id"]) || !isset($_GET["id"])) {
        header("Location: /");
        die();
    }
    require_once(__DIR__ . "/database.php");
    $id = (int) $_GET["id"];
    $db = new Database();
    $data = $db->post($id);
    if (!isset($data)) {
        header("Location: /");
        die();
    }
} else if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require_once(__DIR__ . "/database.php");
    $db = new Database();
    $data = $db->toArray($_POST["email"], $_POST["title"], $_POST["content"], $_POST["id"]);
    if ($data) {
        $db->updatePost($data);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Posts - Insert</title>
    <link rel="stylesheet" href="./node_modules/@fortawesome/fontawesome-free//css/all.min.css">
    <link rel="stylesheet" type="text/css" href="./node_modules/bulma/css/bulma.css">
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
        <form id="update-form" method="POST" action="<?php print htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="columns">
                <div class="column">
                    <div class="field">
                        <label class="label">Email</label>
                        <div class="control">
                        <input name="email" class="input" type="email" value="<?php print $data["author"]; ?>" placeholder="Email">
                        </div>
                        <p id="email-help" class="help"></p>
                    </div>
                    <div class="field">
                        <label class="label">Title</label>
                        <div class="control">
                        <input name="title" class="input" type="text" value="<?php print $data["title"]; ?>" placeholder="Title">
                        </div>
                        <p id="title-help" class="help"></p>
                    </div>
                </div>
                <div class="column">
                    <div class="field">
                        <label class="label">Content</label>
                        <div class="control">
                        <textarea name="content" class="textarea" placeholder="Textarea"><?php print $data["body"]; ?></textarea>
                        </div>
                    </div>
                </div>
                <input name="id" class="input" type="hidden" value="<?php print $data["id"]; ?>" placeholder="Email">
            </div>
            <div>
                <button id="btn-update" class="button is-primary" type="submit">Add</button>
            </div>
        </form>
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
    <script type="text/javascript" src="./static/js/update.js"></script>
</body>
</html>
