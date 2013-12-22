<?php
/**
 * kernal
 * 
 */

// startup the system
require('bootstrap.php');

// get security functions
require(ABSPATH.'libs/functions-security.php');

// set language
require(ABSPATH.'libs/class-translation.php');
$translate = new Translator();

// smarty config
require(ABSPATH.'libs/smarty/Smarty.class.php');
$smarty = new Smarty;
$theme = 'vdomax';
$smarty->template_dir = ABSPATH.'content/themes/'.$theme.'/templates';
$smarty->compile_dir = ABSPATH.'content/themes/'.$theme.'/templates_c';

// get functions
require(ABSPATH.'libs/functions.php');

// get system settings
$getSystemSetting = $db->query("SELECT * FROM system_settings") or SQLError();
$systemSetting = $getSystemSetting->fetch_array(MYSQLI_ASSOC);

// assign system settings
define('SITE_TITLE', $systemSetting['SystemTitle']);
define('SITE_DESCRIPTION', $systemSetting['SystemDescription']);
define('SITE_DOMAIN', $systemSetting['SystemDomain']);
define('SITE_URL', $systemSetting['SystemURL']);

// Recaptcha key
define('RECAPTCHA_PUBLICKEY', $systemSetting['RECAPTCHA_PUBLICKEY']);
define('RECAPTCHA_PRIVATEKEY', $systemSetting['RECAPTCHA_PRIVATEKEY']);

// twitter app key
define('TW_APPID', $systemSetting['TW_APPID']);
define('TW_SECRET', $systemSetting['TW_SECRET']);
define('TW_CALLBACK', SITE_URL.'/oauth_twitter.php');

// facebook app key
define('FB_APPID', $systemSetting['FB_APPID']);
define('FB_SECRET', $systemSetting['FB_SECRET']);
define('FB_CALLBACK', SITE_URL.'/oauth_facebook.php');

// set date and time
$now = time();

// set spinner var
$spinner['small'] = SITE_URL."/content/themes/".$theme."/images/buttons/spinner.gif";
$spinner['larg']  = SITE_URL."/content/themes/".$theme."/images/buttons/spinner-larg.gif";

// assign kernal varibles
$smarty->assign('theme', $theme);
$smarty->assign('SITE_URL', SITE_URL);
$smarty->assign('SITE_DOMAIN', SITE_DOMAIN);
$smarty->assign('SITE_TITLE', SITE_TITLE);
$smarty->assign('translate', $translate);
$smarty->assign('RECAPTCHA_PUBLICKEY', RECAPTCHA_PUBLICKEY);
$smarty->assign('RECAPTCHA_PRIVATEKEY', RECAPTCHA_PRIVATEKEY);
$smarty->assign('spinner', $spinner);
$smarty->assign('systemSetting', $systemSetting);
$smarty->assign('serverHost', $_SERVER["HTTP_HOST"]);
$smarty->assign('year', date('Y'));

// system live
if($systemSetting['SystemLive'] == "N") {
    SystemError($translate->__('System Message'), $systemSetting['SystemMessage']);
}

// check if user exist
require(ABSPATH.'libs/class-user.php');
$user = new User;
$userExist = $user->getCookies();
if($userExist) {
    // get user info
    $userArray = $user->_userArray;
    // get user followings
    $userFollowings = $user->_userFollowings;
    // get user followers
    $userFollowers = $user->_userFollowers;
    // get user blocked users
    $userBlockedUsers = $user->_userBlockedUsers;
    // get user blocked posts
    $userBlockedPosts = $user->_userBlockedPosts;
    // assgin variables
    $smarty->assign('userArray', $userArray);
}

// assign variables
$smarty->assign('userExist', $userExist);

?>