<?php
/**
 * OutboundScreen - redirects external links to special page
 *
 * @author Łukasz Garczewski (TOR) <tor@wikia-inc.com>
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia.com>
 *
 * @package MediaWiki
 * @subpackage SpecialPage
 */

$wgHooks['LinkerMakeExternalLink'][] = 'efOutboundScreen';
$wgAutoloadClasses['Outbound'] = dirname( __FILE__ ) . '/SpecialOutboundScreen_body.php';
$wgSpecialPages['Outbound'] = 'Outbound';
$wgExtensionMessagesFiles['Outbound'] = dirname(__FILE__) . '/OutboundScreen.i18n.php';

$wgOutboundScreenConfig = array(
	'redirectDelay' => 10,
	'anonsOnly' => false
);

function efOutboundScreen ( $url, $text, $link ) {
	global $wgUser, $wgOutboundScreenConfig;
	static $whiteList;

	$loggedIn = $wgUser->isLoggedIn();

	if(($wgOutboundScreenConfig['anonsOnly'] == false) || (($wgOutboundScreenConfig['anonsOnly'] == true) && !$loggedIn)) {
		if(!is_array($whiteList)) {
			$whiteList = array();
			$whiteListContent = wfMsgForContent('outbound-screen-whitelist');
			if(!empty($whiteListContent)) {
				$lines = explode("\n", $whiteListContent);
				foreach($lines as $line) {
					if(strpos($line, '* ') === 0 ) {
						$whiteList[] = trim($line, '* ');
					}
				}
			}
		}

		$isWhitelisted = false;
		foreach($whiteList as $whiteListedUrl) {
			$matches = null;
			preg_match('/'.$whiteListedUrl.'/i', $url, $matches);
			if(isset($matches[0])) {
				$isWhitelisted = true;
				break;
			}
		}

		if(!$isWhitelisted) {

			// strip URL fragment for later use
			$urlAndFragment = explode( '#', $url, 2 );
			$url = $urlAndFragment[0];
			$fragment = isset( $urlAndFragment[1] ) ? $urlAndFragment[1] : false;

			// make the actual link
			$special = Title::newFromText( 'Special:Outbound/' . $url );
			if($special instanceof Title) {
				$url = $special->getFullURL();
				// add URL fragment if needed
				$url .= $fragment ? '?f=' . $fragment : '';
			}
		}
	}

	return true;
}
