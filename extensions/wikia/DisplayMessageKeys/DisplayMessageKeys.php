<?php

$wgHooks['NormalizeMessageKey'][] = 'efShowMessageKeys';

function efShowMessageKeys( &$key, &$useDB, &$langCode, &$transform ) {
	global $wgLang;

	if ( $langCode == "messages" || $wgLang->getCode() == "messages" ) {
		$key = 'a-msg-here:' . $key;
	}

	return true;
}
