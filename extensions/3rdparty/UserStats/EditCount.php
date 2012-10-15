<?php
$wgHooks['ArticleSave'][] = 'incEditCount';

function incEditCount() {
    global $wgUser, $IP;
    require_once ("$IP/extensions/UserStats/UserStatsClass.php");
    $stats = new UserStatsTrack(1,$wgUser->mId, $wgUser->mName);
    $stats->incEditCount();
    return true;
}

?>