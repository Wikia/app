<?php
/**
 * @package MediaWiki
 * @subpackage CustomFooter
 *
 * @author Maciej Błaszkowski <marooned@wikia.com>
 */

if(!defined('MEDIAWIKI')) {
	exit( 1 );
}

$wgHooks['SpecialFooterAfterWikia'][] = 'SpecialFooterHook';

function SpecialFooterHook() {
	$message = wfMsg('custom-footer');
	if (!wfEmptyMsg('custom-footer', $message) && trim($message) != '-') {
		global $wgOut;
		$message = $wgOut->parse($message);
		echo "<div class=\"custom-footer\">$message</div>";
	}
	return true;
}