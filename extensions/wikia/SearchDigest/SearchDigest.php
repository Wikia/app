<?php

 /**
  * SearchDigest
  *
  * A short description of the SearchDigest extension
  *
  * @author Lucas Garczewski <tor@wikia-inc.com>
  * @date 2011-08-03
  * @copyright Copyright (C) 2011 Wikia Inc.
  * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
  * @package MediaWiki
  */

// Extension credits
$wgExtensionCredits['other'][] = array(
	'name' => 'SearchDigest',
	'author' => array( '[http://community.wikia.com/wiki/User:TOR Lucas \'TOR\' Garczewski]', '[http://community.wikia.com/wiki/User:Grunny Daniel Grunwell (Grunny)]' ),
	'descriptionmsg' => 'searchdigest-desc',
);

$dir = dirname(__FILE__);

// autoloaded classes
$wgAutoloadClasses['SpecialSearchDigest'] = "$dir/SearchDigest.class.php";

// i18n
$wgExtensionMessagesFiles['SearchDigest'] = $dir.'/SearchDigest.i18n.php';

// register special page
$wgSpecialPages['SearchDigest'] = 'SpecialSearchDigest';

$wgHooks['SpecialSearchNogomatch'][] = 'efSearchDigestRecordMiss';

/**
 * @param Title $title
 * @return bool
 */
function efSearchDigestRecordMiss( $title ) {
	global $wgEnableScribeReport, $wgCityId;

	if ( empty( $wgEnableScribeReport ) ) {
		return true;
	}

	if ( !is_object( $title ) ) {
		return true;
	}

	$params = array(
		"sd_wiki" => $wgCityId,
		"sd_query" => $title->getText(),
	);

	// use scribe
	try {
		$message = array(
			'method' => 'searchmiss',
			'params' => $params
		);
		$data = json_encode( $message );
		WScribeClient::singleton('trigger')->send($data);
	}
	catch( TException $e ) {
		Wikia::log( __METHOD__, 'scribeClient exception', $e->getMessage() );
	}

	return true;
}
