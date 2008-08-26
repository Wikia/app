<?php

$wgExtensionCredits['other'][] = array(
	'name'           => 'WikimediaMessages',
	'author'         => 'Tim Starling',
	'svn-date'       => '$LastChangedDate: 2008-07-07 11:10:17 +0000 (Mon, 07 Jul 2008) $',
	'svn-revision'   => '$LastChangedRevision: 37244 $',
	'description'    => 'Wikimedia specific messages',
	'descriptionmsg' => 'wikimediamessages-desc',
);

$wgExtensionMessagesFiles['WikimediaMessages'] = dirname(__FILE__).'/WikimediaMessages.i18n.php';
$wgExtensionFunctions[] = 'wfSetupWikimediaMessages';

function wfSetupWikimediaMessages() {
	wfLoadExtensionMessages('WikimediaMessages');
}
