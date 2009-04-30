<?php

$wgHooks['LinkerMakeExternalLink'][] = 'efOutboundScreen';

function efOutboundScreen ( $url, $text, $link ) {

	$special = Title::newFromText( 'Special:Outbound/' . $url );

	$url = $special->getFullURL();

	return true;
}

$wgAutoloadClasses['Outbound'] = dirname( __FILE__ ) . '/SpecialOutboundScreen_body.php';
$wgSpecialPages['Outbound'] = 'Outbound';
