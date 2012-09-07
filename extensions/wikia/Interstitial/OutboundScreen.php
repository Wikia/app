<?php
/**
 * OutboundScreen - redirects external links to special page
 *
 * Do not be alarmed if this file is included even on
 * wikis where the extension is disabled.
 * In order for cached pages (with their links rewritten to go through
 * Special:Outbound) to work even after disabling this extension,
 * the special page will always be present even if the link-rewriting
 * is disabled.
 *
 * @author Łukasz Garczewski (TOR) <tor@wikia-inc.com>
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia.com>
 * @author Sean Colombo <sean@wikia-inc.com>
 *
 * @package MediaWiki
 * @subpackage SpecialPage
 */

$wgAutoloadClasses['Outbound'] = dirname( __FILE__ ) . '/SpecialOutboundScreen_body.php';
$wgSpecialPages['Outbound'] = 'Outbound';
$wgExtensionMessagesFiles['Outbound'] = dirname(__FILE__) . '/OutboundScreen.i18n.php';

// Extension will always be present. Only rewrite links when enabled.
if (!empty($wgEnableOutboundScreenExt)) {
	$wgHooks['LinkerMakeExternalLink'][] = 'efOutboundScreen';
}

// For shared page code (such as definition of INTERSTITIALS_SP).
include_once dirname(__FILE__) . '/Interstitial.php';
include_once dirname(__FILE__) . '/SpecialInterstitial_body.php';

$wgOutboundScreenConfig = array(
	'redirectDelay' => !empty($wgOutboundScreenRedirectDelay) ? intval($wgOutboundScreenRedirectDelay) : 10,
	'anonsOnly' => true,
	'adLayoutMode' => !empty($wgOutboundScreenAdLayout) ? $wgOutboundScreenAdLayout : 'classic'
);

/**
 * This function makes all of the outbound links in the page re-written to go through Special:Outbound.
 */
function efOutboundScreen ( $url, $text, &$link, $attribs, $linktype ) {
	global $wgCityId, $wgUser, $wgOutboundScreenConfig, $wgTitle;
	static $whiteList;

	// skip logic when in FCK
	global $wgRTEParserEnabled;
	if(!empty($wgRTEParserEnabled)) {
		return true;
	}

	if ( strpos( $url, 'http://' ) !== 0 ) {
		return true;
	}

	// setup functions can call MakeExternalLink before wgTitle is set RT#144229
	if (empty($wgTitle)){
		return true;
	}

	// if there are no other ads on this page, do not show exitstitial
	$response = F::app()->sendRequest('Ad', 'config');
	$adSlots = $response->getVal('conf');
	if (empty($adSlots) || !sizeof($adSlots)) {
		return true;
	}

	$loggedIn = $wgUser->isLoggedIn();

	if(($wgOutboundScreenConfig['anonsOnly'] == false) || (($wgOutboundScreenConfig['anonsOnly'] == true) && !$loggedIn)) {
		if(!is_array($whiteList)) {
			$whiteList = array();
			$whiteListContent = wfMsgExt('outbound-screen-whitelist', array( 'language' => 'en' ));
			if(!empty($whiteListContent)) {
				$lines = explode("\n", $whiteListContent);
				foreach($lines as $line) {
					if(strpos($line, '* ') === 0 ) {
						$whiteList[] = trim($line, '* ');
					}
				}
			}
			$wikiDomains = WikiFactory::getDomains($wgCityId);
			if ($wikiDomains !== false) {
				$whiteList = array_merge($wikiDomains, $whiteList);
			}
		}

		// Devboxes run on different domains than just what is in WikiFactory.
		global $wgDevelEnvironment;
		if($wgDevelEnvironment){
			array_unshift($whiteList, empty($_SERVER['SERVER_NAME']) ? "":$_SERVER['SERVER_NAME'] );
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
			$link = '<a href="' . $url . '" rel="nofollow" class="external exitstitial">' . $text . '</a>';

			return false;
		}
	}

	return true;
}
