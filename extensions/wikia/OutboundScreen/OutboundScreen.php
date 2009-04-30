<?php

$wgHooks['LinkerMakeExternalLink'][] = 'efOutboundScreen';

function efOutboundScreen ( $url, $text, $link ) {
	$special = Title::newFromText( 'Special:Outbound/' . $url );

	if($special instanceof Title) {
		$url = $special->getFullURL();
	}

	return true;
}

$wgAutoloadClasses['Outbound'] = dirname( __FILE__ ) . '/SpecialOutboundScreen_body.php';
$wgSpecialPages['Outbound'] = 'Outbound';
$wgExtensionMessagesFiles['Outbound'] = dirname(__FILE__) . '/OutboundScreen.i18n.php';
