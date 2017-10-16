<?php

/**
 * LinkToMobileApp
 *
 * Simple extension, adds a LINK element that tells Android that an app exists that could open this content
 *
 * Requires the following settings in config or WikiFactory to work:
 * $wgWikiaMobileAppPackageId = 'com.wikia.singlewikia';
 * $wgWikiaMobileAppPackageIdLocalPart = 'muppet';
 * 
 * @author Łukasz Garczewski (TOR) <tor@wikia-inc.com>
 * @date 2014-11-03
 * @copyright Copyright © 2014 Łukasz Garczewski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
        echo "This is a MediaWiki extension named PerPageSEO.\n";
        exit( 1 );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['specialpage'][] = array(
        'name' => 'LinkToMobileApp',
        'version' => '1.0',
        'author' => "[http://www.wikia.com/wiki/User:TOR Łukasz 'TOR' Garczewski]",
		'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/LinkToMobileApp',
		'descriptionmsg' => 'linktomobileapp-desc'
);

//i18n
$wgExtensionMessagesFiles['LinkToMobileApp'] = __DIR__ . '/LinkToMobileApp.i18n.php';

$wgHooks['BeforePageDisplay'][] = 'efLinkToMobileApp';

function efLinkToMobileApp( $out ) {
	global $wgWikiaMobileAppPackageId, $wgWikiaMobileAppPackageIdLocalPart;

	if ( empty( $wgWikiaMobileAppPackageIdLocalPart ) ) {
		$app = $wgWikiaMobileAppPackageId;
	} else {
		$app = $wgWikiaMobileAppPackageId . '.' . $wgWikiaMobileAppPackageIdLocalPart;
	}

	$url = parse_url( $out->getTitle()->getFullUrl() );

	$href = 'android-app://' . $app . '/http/' . $url['host'] . $url['path'];

	$out->addLink(
		array( 
			'rel' => 'alternate',
			'href' => $href,
		)
	);

	return true;
}
