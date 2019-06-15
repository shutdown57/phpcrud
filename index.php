<?php

$url = explode("?", ltrim($_SERVER["REQUEST_URI"], 2))[0];

switch ($url) {
case "/":
    require_once(__DIR__ . "/home.php");
    break;
case "/posts":
    echo "Posts";
    break;
case "/add":
    require_once(__DIR__ . "/insertPost.php");
    break;
case "/update":
    require_once(__DIR__ . "/updatePost.php");
    break;
case "/delete":
    require_once(__DIR__ . "/deletePost.php");
    break;
default:
    echo "Not found";
    break;
}
