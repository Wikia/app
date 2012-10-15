<?php
if (!defined('MEDIAWIKI')) die();
/**
 * Class file for the GoogleAdSense extension
 *
 * @file
 * @ingroup Extensions
 * @author Siebrand Mazeland
 * @license MIT
 */
class GoogleAdSense {
	static function GoogleAdSenseInSidebar( $skin, &$bar ) {
		global $wgGoogleAdSenseWidth, $wgGoogleAdSenseID,
			$wgGoogleAdSenseHeight, $wgGoogleAdSenseClient,
			$wgGoogleAdSenseSlot, $wgGoogleAdSenseSrc,
			$wgGoogleAdSenseAnonOnly, $wgUser;


		// Return $bar unchanged if not all values have been set.
		// FIXME: signal incorrect configuration nicely?
		if( $wgGoogleAdSenseClient == 'none' || $wgGoogleAdSenseSlot == 'none' || $wgGoogleAdSenseID == 'none' )
			return $bar;

		if( $wgUser->isLoggedIn() && $wgGoogleAdSenseAnonOnly ) {
			return $bar;
		}
		if( !$wgGoogleAdSenseSrc ) {
			return $bar;
		}

		$bar['googleadsense'] = "<script type=\"text/javascript\">
/* <![CDATA[ */
google_ad_client = \"$wgGoogleAdSenseClient\";
/* $wgGoogleAdSenseID */
google_ad_slot = \"$wgGoogleAdSenseSlot\";
google_ad_width = ".intval($wgGoogleAdSenseWidth).";
google_ad_height = ".intval($wgGoogleAdSenseHeight).";
/* ]]> */
</script>
<script type=\"text/javascript\"
src=\"$wgGoogleAdSenseSrc\">
</script>";

		return true;
	}

/* Not working yet. Need to find out why...
	static function injectCSS( $out ) {

		global $wgUser, $wgGoogleAdSenseAnonOnly, $wgGoogleAdSenseCssLocation;
		
		if( $wgUser->isLoggedIn() && $wgGoogleAdSenseAnonOnly ) {
			return true;
		}
		
		$out->addLink(
			array(
				'rel' => 'stylesheet',
				'type' => 'text/css',
				'href' => $wgGoogleAdSenseCssLocation . '/GoogleAdSense.css',
			)
		);
		return true;
	}
*/
}
