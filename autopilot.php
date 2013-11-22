<?php

function addAutopilotContact($userID, $email, $firstName, $lastName, $levels, $userIDField, $appid, $key)
{
    $staticTag = "WishList";
    $tags = "*/*$staticTag*/*" . join("*/*", $levels) . "*/*";

    $data = <<<STRING
<contact>
<Group_Tag name="Contact Information">
<field name="First Name">$firstName</field>
<field name="Last Name">$lastName</field>
<field name="E-Mail">$email</field>
<field name="$userIDField">$userID</field>
</Group_Tag>
<Group_Tag name="Sequences and Tags">
<field name="Contact Tags">$tags</field>
</Group_Tag>
</contact>
STRING;

    $data = urlencode(urlencode($data));

    $reqType = "add";
    $postargs = "appid=" . $appid . "&key=" . $key . "&return_id=1&reqType=" . $reqType . "&data=" . $data;
    $request = "http://api.moon-ray.com/cdata.php";

    $session = curl_init($request);
    curl_setopt($session, CURLOPT_POST, true);
    curl_setopt($session, CURLOPT_POSTFIELDS, $postargs);
    curl_setopt($session, CURLOPT_HEADER, false);
    curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($session);
    curl_close($session);

    return $response;
}

?>
