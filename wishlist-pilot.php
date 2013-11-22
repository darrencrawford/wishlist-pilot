<?php
/*
Plugin Name: WishList OAP Linker
Plugin URI: darrencrawford.com
Description: Send Wishlist Levels to Office Autopilot
Author: Mark Winstein and Andrei Glazunov
Commissioned by: Darren Crawford
Version: 0.1.5
Author URI: darrencrawford.com
*/


/* Add the Menu page */
add_action('admin_menu', 'wishlist_settings_menu');
function wishlist_settings_menu(){
    add_options_page('WishList OAP Linker', 'WishList OAP Linker', 'manage_options', 'wishlist', 'wishlist_options_page');
}

function wishlist_options_page(){
    $action = "options.php";//str_replace( '%7E', '~', $_SERVER['REQUEST_URI']);
    echo '<div><h2>WishList OAP Linker Settings</h2><form action="'.$action.'" method="post">';
    echo '<input type="hidden" name="form_submitted" value="Y">';
    settings_fields('wishlist_options');
    do_settings_sections('wishlist');
    echo '<br/><input name="Submit" type="submit" value="'. esc_attr('Save Changes') .'" /></form></div>';
    echo '<br/><br/>Plugin by: <a href="http://pilotplugins.com">http://pilotplugins.com</a>';
}


/* Fill the Menu page with content */
add_action('admin_init', 'wishlist_init');
function wishlist_init() {
    register_setting( 'wishlist_options', 'wishlist_options');
    add_settings_section('wishlist_section', '', 'wishlist_details_text', 'wishlist');
    add_settings_field('wishlist_apikey', 'WishList API Key', 'wishlist_apikey_display', 'wishlist', "wishlist_section");
    add_settings_field('autopilot_appid', 'Office Autopilot APP ID', 'autopilot_appid_display', 'wishlist', "wishlist_section");
    add_settings_field('autopilot_key', 'Office Autopilot Key', 'autopilot_key_display', 'wishlist', "wishlist_section");
    add_settings_field('wishlist_signuppage', 'Thankyou Page Numbers<br/> (Comma separated list)', 'wishlist_signuppage_display', 'wishlist', "wishlist_section");
    add_settings_field('autopilot_userfield', 'Name of UserID Storage Field in Office Autopilot', 'autopilot_userfield_display', 'wishlist', "wishlist_section");
    add_action("update_option_wishlist_options", "wishlist_options_updated");
}

function wishlist_options_updated($newValue) {
    $filePath = "../wp-content/plugins/wishlist-oap-linker/credentials.php";
    $options = get_option("wishlist_options");
    $apikey = $options["apikey"];
    file_put_contents($filePath, "<?php\nglobal \$wishListKey;\n\$wishListKey=\"$apikey\";\n?>");
    return $newValue;
}

function wishlist_apikey_display(){
    $options = get_option('wishlist_options');
    echo "<input id='wishlist_apikey' name='wishlist_options[apikey]' type='text' size='40' value='{$options['apikey']}' />";
}

function autopilot_appid_display(){
    $options = get_option('wishlist_options');
    echo "<input id='autopilot_appid' name='wishlist_options[pilotappid]' type='text' size='40' value='{$options['pilotappid']}' />";
}

function autopilot_key_display(){
    $options = get_option('wishlist_options');
    echo "<input id='autopilot_key' name='wishlist_options[pilotkey]' type='text' size='40' value='{$options['pilotkey']}' />";
}

function wishlist_signuppage_display(){
    $options = get_option('wishlist_options');
    echo "<input id='wishlist_apikey' name='wishlist_options[signuppage]' type='text' size='40' value='{$options['signuppage']}' />";
}

function autopilot_userfield_display(){
    $options = get_option('wishlist_options');
    echo "<input id='wishlist_apikey' name='wishlist_options[pilotuserfield]' type='text' size='40' value='{$options['pilotuserfield']}' />";
}

function wishlist_details_text(){
}


add_action('wp', 'process_page_load');
function process_page_load() {
    global $user_ID, $wp_query;

    if ($user_ID && $user_ID > 0 && property_exists($wp_query, "post")) {
        $postID = $wp_query->post->ID;
        $options = get_option('wishlist_options');
        $signupPageNumbers = $options["signuppage"];
        $signupPageNumbers = explode(",", $signupPageNumbers);
        $isSignupPage = false;
        foreach ($signupPageNumbers as $pageNumber) {
            if ($postID == trim($pageNumber)) {
                $isSignupPage = true;
            }
        }
        if ($isSignupPage) {
            require_once "autopilot.php";
            $response = wlmapi_get_member($user_ID);

            $member = $response["member"][0];
            global $current_user;
            get_currentuserinfo();
            $firstName = $current_user->user_firstname;
            $lastName = $current_user->user_lastname;
            $email = $current_user->user_email;
            $memberLevels = $member["Levels"];
            $levels = array();
            if (isset($memberLevels)) {
                foreach ($memberLevels as $level) {
                    array_push($levels, $level->Name);
                }
            }
            $appid = $options["pilotappid"];
            $key = $options["pilotkey"];
            $userIDField = $options["pilotuserfield"];

            addAutopilotContact($user_ID, $email, $firstName, $lastName, $levels, $userIDField, $appid, $key);
        }
    }
}

?>
