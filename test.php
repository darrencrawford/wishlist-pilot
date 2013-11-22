<?php
    require_once "wlmapiclass.php";
    require_once "credentials.php";
    global $wishListKey;
    $url = "http://" . $_SERVER["SERVER_NAME"];
    $wishlistAPI = new wlmapiclass($url, $wishListKey);
    $wishlistAPI->return_format = 'php'; // <- value can also be xml or json
    $response = $wishlistAPI->get("/levels");
    $response = unserialize($response);

    echo "<pre>";
    print_r($response);
    echo "</pre>";
?>
