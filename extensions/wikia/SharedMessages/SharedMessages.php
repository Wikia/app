<?php
if(!defined('MEDIAWIKI')) {
	die();
}

$wgExtensionFunctions[] = 'wfSharedMessages';

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'SharedMessages',
	'description' => 'Allows drawing "shared*" messages from the shared DB',
	'author' => 'Inez Korczyński'
);

function wfSharedMessages() {
	global $wgHooks;
	$wgHooks['MessagesPreLoad'][] = 'wfGetSharedMessage';
}

function wfGetSharedMessage($messageTitle, &$message){
	$text = '';
	if(preg_match('/^shared-(.*)/i', $messageTitle, $messageParts)) {
		global $wgContLang, $wgLang;
		$sharedMessageName = $wgContLang->ucfirst($messageParts[1]);

		# a hack
		# central wikia is in English, but if requesting a shared message
		# from a wiki where English is not a default language
		# we must append its language code
		if( !strpos( $sharedMessageName, '/' )
				&& $wgLang->getCode() == $wgContLang->getCode()
				&& $wgLang->getCode() != 'en' ) {
			$title = Title::makeTitle(NS_MEDIAWIKI, $sharedMessageName . '/' . $wgLang->getCode());
			$text = getSharedMessageText($title);
		}

		if( empty( $text ) ) {
			$title = Title::makeTitle(NS_MEDIAWIKI, $sharedMessageName);
			$text = getSharedMessageText($title);
		}
 	}
 	if( !empty( $text ) ) {
 		$message = $text;
 	}
	return true;
}

function getSharedMessageText(&$title) {
	global $wgExternalSharedDB, $wgDBname, $wgMemc;
	if ( empty($wgExternalSharedDB) ) {
		return null;
	}
	
	$memkey = wfForeignMemcKey($wgExternalSharedDB, __METHOD__, $title->getNamespace(), $title->getDBkey());
	$cached = ( $wgDBname == $wgExternalSharedDB ) ? '' : $wgMemc->get($memkey); 

	$result = null;
	if ( empty($cached) ) {
		$db = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );

		$row = $db->selectRow(
			array( 'page', 'revision', 'text' ),
			array( '*' ),
			array(
				'page_namespace' => $title->getNamespace(),
				'page_title' => $title->getDBkey(),
				'page_latest = rev_id',
				'old_id = rev_text_id'
			),
			__METHOD__
		);

		if ($row) {
			$result = Revision::getRevisionText($row);
			$wgMemc->set($memkey, $result, 60*60);
		} 
	} else {
		$result = $cached;
	}
	
	return $result;
}
