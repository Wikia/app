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
	'anonsOnly' => true
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
			// make the actual link
			$special = Title::newFromText( 'Special:Outbound' );
			if($special instanceof Title) {
				$url = $special->getFullURL() . '?u=' . urlencode($url);
			}
		}
	}

	return true;
}
