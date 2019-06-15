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

    $db->deletePost($id);
    header("Location: /");
    die();
}
