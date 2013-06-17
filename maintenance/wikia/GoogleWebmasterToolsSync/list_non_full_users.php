<?php

// example: SERVER_ID=5915 php maintenance/wikia/GoogleWebmasterToolsSync/list_non_full_users.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php

$max_count = 495;

require_once( __DIR__."/common.php" );
GWTLogHelper::notice( __FILE__ . " script starts.");
try {
	$userRepository = new GWTUserRepository();
	$users = $userRepository->allCountLt($max_count);

	foreach ( $users as $i => $w ) {
		echo $w->getEmail() . " " . $w->getCount() . "\n";
	}

} catch ( Exception $ex ) {
	GWTLogHelper::error( __FILE__ . " script failed.", $ex);
}
