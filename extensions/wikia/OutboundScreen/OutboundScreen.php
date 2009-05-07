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

function efOutboundScreen ( $url, $text, $link ) {
	static $whiteList;

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
		$special = Title::newFromText( 'Special:Outbound/' . $url );
		if($special instanceof Title) {
			$url = $special->getFullURL();
		}
	}

	return true;
}
