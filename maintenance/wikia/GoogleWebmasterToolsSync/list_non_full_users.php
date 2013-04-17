<?php
/**
 * User: artur
 * Date: 17.04.13
 * Time: 20:27
 */

// example: SERVER_ID=5915 php maintenance/wikia/GoogleWebmasterToolsSync/list_non_full_users.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php

$max_count = 495;

require_once(__DIR__ . '/../../commandLine.inc');
require_once($IP . '/lib/GoogleWebmasterTools/init.php');

$userRepository = new GWTUserRepository();
$users = $userRepository->allCountLt($max_count);

foreach ( $users as $i => $w ) {
	echo $w->getEmail() . " " . $w->getCount() . "\n";
}
