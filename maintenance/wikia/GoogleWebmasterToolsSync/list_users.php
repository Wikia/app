<?php

// example: SERVER_ID=5915 php maintenance/wikia/GoogleWebmasterToolsSync/list_users.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php

require_once( __DIR__."/common.php" );
GWTLogHelper::notice( __FILE__ . " script starts.");
try {
	$userRepository = new GWTUserRepository();

	$users = $userRepository->all();
	foreach( $users as $i => $u ) {
		echo "[ id = " . $u->getId() . " ]  " . $u->getEmail() . " " . $u->getCount() . "\n";
	}

} catch ( Exception $ex ) {
	GWTLogHelper::error( __FILE__ . " script failed.", $ex);
}
