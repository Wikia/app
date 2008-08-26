<?php

function efPhpbbData_handleToWiki(&$hook, $outputCache) {
	$result = $hook->previous_hook_result('BeforePageDisplay');
	if (!empty($result['result'])) {
		$outputCache = $result['result'];
	}
	
	if ( isset( $_REQUEST['toWiki'] ) ) {
	
		$domDoc = new DOMDocument();
		$domDoc->strictErrorChecking = false;
		$domDoc->resolveExternals = true;


		@$domDoc->loadHTML( $outputCache );
		$xpath = new DOMXPath( $domDoc );
		$colNodes = $xpath->query( '//div[@id="page-body"]' );
		if ( !$colNodes->length ) {
			//No page-body?  wierd...
			return false;
		} 
		
		$pageBodyNode = $colNodes->item(0);
		
		$div = $domDoc->createElement('div');
		$div = $pageBodyNode->insertBefore($div, $pageBodyNode->firstChild);
		$div->setAttribute('style', 'float: right; margin-top: 1em;');
		$wikiLink = $domDoc->createElement('a');
		$wikiLink = $div->appendChild($wikiLink);
		$wikiLink->setAttribute('href', htmlspecialchars($_REQUEST['toWiki']));
		$wikiLink->setAttribute('style', 'font-size: 175%;');
		$text = $domDoc->createTextNode('→ Return to Wiki');
		$text = $wikiLink->appendChild($text);

		return $domDoc->saveHTML();
	} else {
		return $outputCache;
	}
}
$phpbb_hook->register('BeforePageDisplay', 'efPhpbbData_handleToWiki');
	
function efPhpbbData_doTokenReplacement(&$hook, $outputCache) {
	$result = $hook->previous_hook_result('BeforePageDisplay');
	if (!empty($result['result'])) {
		$outputCache = $result['result'];
	}
	
	$validQueryKeys = array('f','t');
	$queryString = '';
	
	foreach ($_GET as $key => $value) {
		if (in_array($key, $validQueryKeys)) {
			if ($queryString == '')
				$queryString .= "?{$key}={$value}";
			else
				$queryString .= "&{$key}={$value}";
		}
	}
	
	$tokens = array(
		'{PAGE_URL_LOCAL_ESCAPED}' => urlencode( $_SERVER['PHP_SELF'] . $queryString ),
		urlencode('{PAGE_URL_LOCAL_ESCAPED}') => urlencode( $_SERVER['PHP_SELF'] . $queryString ),
		);
	
	foreach ($tokens as $key => $value) {
		$outputCache = str_replace($key,$value,$outputCache);
	}
	
	return $outputCache;
}
$phpbb_hook->register('BeforePageDisplay', 'efPhpbbData_doTokenReplacement');
