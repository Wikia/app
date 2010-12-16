<?php
/**
 * Header Tabs extension
 *
 * @file
 * @ingroup Extensions
 *
 * @author Sergey Chernyshev
 */

$htScriptPath = $wgScriptPath . '/extensions/HeaderTabs';

$wgExtensionFunctions[] = 'htSetupExtension';
$wgExtensionCredits['parserhook'][] = array(
        'name' => 'Header Tabs',
        'description' => 'Adds tabs to the page separating top-level sections. Originally developed for [http://www.ardorado.com Ardorado.com]',
	'version' => '0.6.6',
        'author' => '[http://www.sergeychernyshev.com Sergey Chernyshev] (for [http://www.semanticcommunities.com Semantic Communities LLC.])',
        'url' => 'http://www.mediawiki.org/wiki/Extension:Header_Tabs'
);

$htYUIBase = 'http://yui.yahooapis.com/2.5.1/build/';
$htUseHistory = true;

function htSetupExtension() {
	global $wgHooks;
	global $wgParser;

	$wgHooks['BeforePageDisplay'][] = 'htAddHTMLHeader';
	$wgHooks['ParserAfterTidy'][] = 'htReplaceFirstLevelHeaders';
	$wgParser->setHook( 'headertabs', 'htTag' );

	return true;
}

function htTag( $input, $args, $parser ) {
	global $wgOut, $htScriptPath;

	$wgOut->addLink( array(
		'rel'   => 'stylesheet',
		'type'  => 'text/css',
		'media' => 'screen, projection',
		'href'  => $htScriptPath . '/skins/headertabs_hide_factbox.css'
	) );

	// this tag besides just enabling tabs, also designates end of tabs
	// TOC doesn't make sense where tabs are used
	return '<div id="nomoretabs"></div>';
}

function htReplaceFirstLevelHeaders( &$parser, &$text ) {
	global $htUseHistory, $htScriptPath, $wgVersion;

	$aboveandbelow = explode( '<div id="nomoretabs"></div>', $text, 2 );

        if ( count( $aboveandbelow ) <= 1 ) {
		return true; // <headertabs/> tag is not found
	}
	$below = $aboveandbelow[1];

	$aboveandtext = preg_split( '/(<a name=".*?"><\/a>)?<h1.*?class="mw-headline".*?<\/h1>/', $aboveandbelow[0], 2 );
	if ( count( $aboveandtext ) > 1 ) {
		$above = $aboveandtext[0];

		$tabs = array();

		$v = explode( '.', $wgVersion );
		if ( $v[0] > 1 || ( $v[0] == 1 && $v[1] >= 16 ) ) {
			$parts = preg_split( '/(<h1.*?class="mw-headline".*?<\/h1>)/', $aboveandbelow[0], - 1, PREG_SPLIT_DELIM_CAPTURE );
			array_shift( $parts ); // don't need above part anyway

			for ( $i = 0; $i < ( count( $parts ) / 2 ); $i++ )
			{
				preg_match( '/id="(.*?)"/', $parts[$i * 2], $matches );
				$tabid = $matches[1];

				preg_match( '/<span.*?class="mw-headline".*?>\s*(.*?)\s*<\/h1>/', $parts[$i * 2], $matches );
				$tabtitle = $matches[1];

				array_push( $tabs, array(
					'tabid' => $tabid,
					'title' => $tabtitle,
					'tabcontent' => $parts[$i * 2 + 1]
				) );
			}
		} else {
			$parts = preg_split( '/<a name="(.*?)"><\/a><h1>.*?<span class="mw-headline">\s*(.*?)\s*<\/span><\/h1>/', $aboveandbelow[0], - 1, PREG_SPLIT_DELIM_CAPTURE );
			array_shift( $parts ); // don't need above part anyway

			for ( $i = 0; $i < ( count( $parts ) / 3 ); $i++ ) {
				array_push( $tabs, array(
					'tabid' => $parts[$i * 3],
					'title' => $parts[$i * 3 + 1],
					'tabcontent' => $parts[$i * 3 + 2]
				) );
			}
		}

		$tabhtml  = '<div id="headertabs" class="yui-navset">';

		$tabhtml .= '<ul class="yui-nav">';
		$firsttab = true;
		foreach ( $tabs as $tab ) {
			$tabhtml .= '<li';
			if ( $firsttab ) {
				$tabhtml .= ' class="selected"';
				$firsttab = false;
			}
			$tabhtml .= '><a id="headertab_' . $tab['tabid'] . '" tabid="#' . $tab['tabid'] . '"><em>' . $tab['title'] . "</em></a></li>\n";
		}
		$tabhtml .= '</ul>';

		$tabhtml .= '<div class="yui-content">';
		$firsttab = true;
		foreach ( $tabs as $tab ) {
			if ( $firsttab ) {
				$style = '';
				$firsttab = false;
			} else {
				$style = ' style="display:none"';
			}
			$tabhtml .= '<div id="' . $tab['tabid'] . '"' . $style . '><p>' . $tab['tabcontent'] . '</p></div>';
		}
		$tabhtml .= '</div></div>';

		if ( $htUseHistory ) {
			$text = '<iframe id="yui-history-iframe" src="' . $htScriptPath . '/skins/blank.html" style="position:absolute; top:0; left:0; width:1px; height:1px; visibility:hidden;"></iframe><input id="yui-history-field" type="hidden">';
		} else {
			$text = '';
		}
		$text .= '<script>HeaderTabs.init(' . ( $htUseHistory ? 'true' : 'false' ) . ');</script>';
		$text .= $above . $tabhtml . $below;
	}

	return true;
}

function htAddHTMLHeader( &$wgOut ) {
	global $htScriptPath, $htYUIBase, $htUseHistory;

	if ( $htUseHistory ) {
		// TODO Rewrite it using latest History package so we can update $htYUIBase to latest version
		$wgOut->addScript( '<script type="text/javascript" src="'.$htScriptPath.'/skins/combined-history-min.js"></script>' );
	} else {
		$wgOut->addScript( '<script type="text/javascript" src="'.$htScriptPath.'/skins/combined-min.js"></script>' );
	}

	$wgOut->addLink( array(
		'rel'   => 'stylesheet',
		'type'  => 'text/css',
		'media' => 'screen, projection',
		'href'  => $htScriptPath . '/skins/combined-min.css'
	) );

	return true;
}

# Parser function to insert a link changing a tab:
$wgExtensionFunctions[] = 'headerTabsParserFunctions';
$wgHooks['LanguageGetMagic'][] = 'headerTabsLanguageGetMagic';

function headerTabsParserFunctions() {
    global $wgParser;
    $wgParser->setFunctionHook( 'switchtablink', 'renderSwitchTabLink' );
}

function headerTabsLanguageGetMagic( &$magicWords, $langCode = "en" ) {
	switch ( $langCode ) {
	default:
		$magicWords['switchtablink']	= array ( 0, 'switchtablink' );
	}
	return true;
}

function renderSwitchTabLink( &$parser, $tabName, $linkText, $anotherTarget = '' ) {
	$tabTitle = Title::newFromText( $tabName );
	$tabKey = $tabTitle->getDBkey();

	if ( $anotherTarget != '' ) {
		$targetTitle = Title::newFromText( $anotherTarget );
		$targetURL = $targetTitle->getFullURL();

		$output = '<a href="' . $targetURL . '#tab=' . $tabKey . '">' . $linkText . '</a>';
	} else {
		$output = '<a href="#tab=' . $tabKey . '" onclick="return HeaderTabs.switchTab(\'' . $tabKey . '\')">' . $linkText . '</a>';
	}

	return $parser->insertStripItem( $output, $parser->mStripState );
}
