<?php
# Alert the user that this is not a valid entry point to MediaWiki if they try to access the special pages file directly.
if (!defined('MEDIAWIKI')) {
        echo <<<EOT
To install my extension install sendmail redirection and put the following line in LocalSettings.php:
require_once( "\$IP/extensions/SendmailToWiki/SendmailToWiki.php" );
EOT;
        exit( 1 );
}
 
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'SendmailToWiki',
	'author' => 'Jure Kajzer - freakolowsky <jure.kajzer@abakus.si>',
	'url' => 'http://www.mediawiki.org/wiki/Extension:SendmailToWiki',
	'description' => 'Posting to wiki with sendmail redirection into a php script',
	'descriptionmsg' => 'sendmailtowiki-desc',
	'version' => '0.1.0',
);
 
$dir = dirname(__FILE__) . '/';
 
$wgAutoloadClasses['SendmailToWiki'] = $dir . 'SendmailToWiki_body.php';
$wgExtensionMessagesFiles['SendmailToWiki'] = $dir . 'SendmailToWiki.i18n.php';
$wgSpecialPages['SendmailToWiki'] = 'SendmailToWiki';

$wgHooks['GetPreferences'][] = 'sendmailtowikiPrefHook';
$wgHooks['userCan'][] = 'sendmailtowikiUserCanHook';

//replace with custom prefix in LocalSettings.php
$sendmailtowikiPrefix = 'wikipost';
 
function sendmailtowikiPinValidate( $value, $alldata ) {
	global $wgMessageCache;
	if ($value != '' && strlen($value) != 5)
		return $wgMessageCache->get('sendmailtowiki-err-pinlength');
	return true;
}
	
function sendmailtowikiPrefHook( $user, &$preferences ) {
 	global $wgUser, $sendmailtowikiPrefix;
	$preferences['sendmailtowiki_inemail'] = array(
		'type' => 'info',
		'label-message' => 'sendmailtowiki-inemail',
		'section' => 'personal/sendmailtowiki',
		'default' => $sendmailtowikiPrefix.'+'.$wgUser->getId().'.<PIN>@'.preg_replace("/^(.*\.)?([^.]*\..*)$/", "$2", $_SERVER['HTTP_HOST']),
	);
 
	$preferences['sendmailtowiki_inpin'] = array(
		'type' => 'int',
		'label-message' => 'sendmailtowiki-inpin',
		'section' => 'personal/sendmailtowiki',
		'validation-callback' => 'sendmailtowikiPinValidate',
		'help-message' => 'prefs-help-sendmailtowiki_pin',
	);
 
	return true;
}

function sendmailtowikiUserCanHook(&$title, &$user, $action, &$result) {
	if ($user->isLoggedIn()) return true;
	if ($title->getNamespace() == NS_SPECIAL && $title->mTextform == 'SendmailToWiki') {
		$result = true;
		return false;
	}
	
	return true;
}

