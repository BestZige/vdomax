<?php
/**
 * home
 * 
 */

// fetch kernal
require('/home/new2/kernal.php');

// check access level
AccessLevel('restricted');

// page header
PageHeader($translate->__("Home"));
$live = $db->query(sprintf("UPDATE users SET Live = '2' WHERE UserID = %s", $userArray[UserID])) or SQLError();
// get profile
$username = $userArray[UserName];
$getProfile = $db->query(sprintf("SELECT * FROM users WHERE UserName = %s", SafeSQL($username) )) or SQLError();
if($getProfile->num_rows == 0) {
	SystemError($translate->__("This content is currently unavailable"), $translate->__("The page you requested cannot be displayed right now. It may be temporarily unavailable, the link you clicked on may have expired, or you may not have permission to view this page."));
}
$profile = $getProfile->fetch_array(MYSQLI_ASSOC);
// check username case
if(strtolower($username) == strtolower($profile['UserName']) && $username != $profile['UserName']) {
	header('Location: '.SITE_URL.'/'.$profile['UserName']);
}

// check if user follow him
if($userExist && $profile['UserID'] != $userArray['UserID']) {
    if(count($userFollowings) > 0) {
        $profile['FollowingHim'] = (in_array($profile['UserID'], $userFollowings))? true: false;
    }else {
        $profile['FollowingHim'] = false;
    }
}

// get featured wall photos
$getWallPhotos = $db->query(sprintf("SELECT * FROM posts_photos_sources WHERE AlbumID = %s ORDER BY ID DESC LIMIT 5", Secure($profile['UserWallPhotos'], 'int') )) or SQLError();
while($wallPhoto = $getWallPhotos->fetch_array(MYSQLI_ASSOC)) {
    $profile['wallPhotos'][] = $wallPhoto;
}

// get followings
$getFollowings = $db->query(sprintf("SELECT user.UserID, user.UserName, user.UserFirstName, user.UserLastName, user.UserAvatarPathSmall FROM users_followings follow INNER JOIN users user ON follow.FollowingID = user.UserID WHERE follow.UserID = %s AND user.Live = '1' LIMIT 21", SafeSQL($profile['UserID'], 'int'))) or SQLError();
if($getFollowings->num_rows > 0 ){
    $profile['hasFollowings'] = true;
    while($following = $getFollowings->fetch_array(MYSQLI_ASSOC)) {
        $profile['followings'][] = $following;
    }
}else {
    $profile['hasFollowings'] = false;
}

// get today birthdays
$getBirthdays = $db->query(sprintf("SELECT * FROM users WHERE UserBirthMonth = %s AND UserBirthDay = %s", Secure(date(m), 'int'), Secure(date(d), 'int') )) or SQLError();
if($getBirthdays->num_rows > 0 ){
    $todayBirthday = true;
    while($birthday = $getBirthdays->fetch_array(MYSQLI_ASSOC)) {
        $birthday['UserURL'] = SITE_URL."/".$birthday['UserName'];
        $birthdays[] = $birthday;
    }
}else {
    $todayBirthday = false;
}
$smarty->assign('todayBirthday', $todayBirthday);
$smarty->assign('birthdays', $birthdays);
$smarty->assign('profile', $profile);
print_r($userArray);

// page footer
PageFooter("payment");

?>
