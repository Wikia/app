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

// For shared page code (such as Interstitial::getCss() and definition of INTERSTITIALS_SP).
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
function efOutboundScreen ( $url, $text, $link, $attribs, $linktype, $linker ) {
	global $wgCityId, $wgUser, $wgOutboundScreenConfig;
	static $whiteList;

	// skip logic when in FCK
	global $wgWysiwygParserEnabled;
	if(!empty($wgWysiwygParserEnabled)) {
		return true;
	}

	if ( strpos( $url, 'http://' ) !== 0 ) {
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
			$special = SpecialPage::getTitleFor( 'Outbound' );
			global $wgTitle;
			if( $special instanceof Title && $wgTitle instanceof Title ) {
				// RT #19167
				$href = $special->getFullURL('f='.urlencode($wgTitle->getPrefixedDBkey()).'&u=' . urlencode($url));
				$link = Xml::tags('a', array(
					'class' => 'external',
					'rel' => 'nofollow',
					'title' => $url,
					'href' => $href,
				), $text);

				return false;
			}
		}
	}

	return true;
}
