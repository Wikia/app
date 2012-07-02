<?php
/**
 * Quantcast tracking extension -- adds Quantcast tracking JS code to all pages
 *
 * @file
 * @ingroup Extensions
 * @version 0.1
 * @date 12 December 2010
 * @author Jack Phoenix <jack@shoutwiki.com> (forgive me)
 * @license http://en.wikipedia.org/wiki/Public_domain Public domain
 * @link http://www.mediawiki.org/wiki/Extension:Quantcast Documentation
 * @see http://bugzilla.shoutwiki.com/show_bug.cgi?id=108
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This is not a valid entry point to MediaWiki.' );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['other'][] = array(
	'name' => 'Quantcast Tracking',
	'version' => '0.1',
	'author' => 'Jack Phoenix',
	'description' => 'Adds [http://www.quantcast.com/ Quantcast] tracking code to pages',
	'url' => 'https://www.mediawiki.org/wiki/Extension:Quantcast',
);

// Groups that are excluded from Quantcast statistics
$wgQuantcastTrackingExcludedGroups = array( 'staff' );

// Hook it up!
$wgHooks['SkinAfterBottomScripts'][] = 'wfAddQuantcastTrackingCode';

/**
 * Add tracking JS to all pages for all users that are not members of excluded
 * groups (the group listed in $wgQuantcastTrackingExcludedGroups).
 *
 * @param $skin Object: Skin object
 * @param $text String: bottomScripts text
 * @return Boolean: true
 */
function wfAddQuantcastTrackingCode( $skin, &$text ) {
	global $wgUser, $wgQuantcastTrackingExcludedGroups;

	$groups = $wgUser->getEffectiveGroups();
	if ( !in_array( $wgQuantcastTrackingExcludedGroups, $groups ) ) {
		$message = trim( wfMsgForContent( 'quantcast-tracking-number' ) );
		// We have a custom tracking code, use it!
		if( !wfEmptyMsg( 'quantcast-tracking-number', $message ) ) {
			$trackingCode = $message;
		} else { // use ShoutWiki's default code
			$trackingCode = wfMsgForContent( 'shoutwiki-quantcast-tracking-number' );
		}
		$safeCode = htmlspecialchars( $trackingCode, ENT_QUOTES );
		$text .= "\t\t" . '<!-- Start Quantcast tag -->
		<script type="text/javascript">/*<![CDATA[*/
		_qoptions = {
			qacct: "' . $safeCode . '"
		};
		/*]]>*/</script>
		<script type="text/javascript" src="http://edge.quantserve.com/quant.js"></script>
		<noscript>
		<img src="http://pixel.quantserve.com/pixel/' . $safeCode . '.gif" style="display: none;" border="0" height="1" width="1" alt="Quantcast" />
		</noscript>
		<!-- End Quantcast tag -->' . "\n\n";
	}

	return true;
}