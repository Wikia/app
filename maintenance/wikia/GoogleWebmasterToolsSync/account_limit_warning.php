<?php
// example: SERVER_ID=5915 php maintenance/wikia/GoogleWebmasterToolsSync/list_users.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php

$freeSlotsWarning = 100;
$warningEmails = array("jacek@wikia-inc.com");

require_once(__DIR__ . '/../../commandLine.inc');
require_once($IP . '/lib/GoogleWebmasterTools/setup.php');

$gwt = new GWTService(null, null, null);
$users = $gwt->getAvailableUsers();

$limitPerAccout = $gwt->getMaxSitesPerAccount();


$freeSlots = 0;

foreach ( $users as $user ) { /* @var $user GWTUser */

	$freeSlots += $limitPerAccout - $user->getCount();
}


echo "\nFREE SLOTS: $freeSlots\n";

if ( $freeSlots < $freeSlotsWarning ) {

	foreach ( $warningEmails as $warningEmail ) {
		UserMailer::send(
			new MailAddress( $warningEmail ),
			new MailAddress( 'GoogleWebmasterToolsService@wikia-inc.com', 'GoogleWebmasterToolsService' ),
			'GA Webmaster Tools Accounts - '.$freeSlots.' slots left',
			'There is only '.$freeSlots.' slots left. Please add new accounts to our database.',
			null,
			'text/html; charset=ISO-8859-1'
		);
	}
}