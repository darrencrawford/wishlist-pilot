<?php
    function checkAndProcessRequest() {
        require_once "wlmapiclass.php";

        $userIdKey = "UserID";
        $levelIdKey = "Level_Id";
        if (array_key_exists($userIdKey, $_REQUEST) && array_key_exists($levelIdKey, $_REQUEST)) {
            $user = $_REQUEST[$userIdKey];
            $level = $_REQUEST[$levelIdKey];

            $url = "http://" . $_SERVER["SERVER_NAME"];
            echo "Site URL : " . $url . "<br/>";
            require_once "credentials.php";
            global $wishListKey;
            $wishlistAPI = new wlmapiclass($url, $wishListKey);
            $wishlistAPI->return_format = 'php'; // <- value can also be xml or json
            $response = $wishlistAPI->post("/levels/$level/members", array("Users" => array($user)));
            $response = unserialize($response);
            echo "<pre>";
            print_r($response);
            echo "</pre>";
        }
    }

    checkAndProcessRequest();
?>
