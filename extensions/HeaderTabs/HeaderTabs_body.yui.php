<?php
/**
 * Version of the Header Tabs class that uses the YUI Javascript library,
 * meant to be used with MediaWiki < 1.17.
 *
 * @file
 * @ingroup Extensions
 *
 * @author Sergey Chernyshev
 */

class HeaderTabs {

	public static function tag( $input, $args, $parser ) {
		global $wgOut, $htScriptPath;

		$wgOut->addLink( array(
			'rel'	 => 'stylesheet',
			'type'	=> 'text/css',
			'media' => 'screen, projection',
			'href'	=> $htScriptPath . '/skins-yui/headertabs_hide_factbox.css'
		) );

		// This tag, besides just enabling tabs, also designates the
		// end of tabs.
		// TOC doesn't make sense where tabs are used
		return '<div id="nomoretabs"></div>';
	}

	public static function replaceFirstLevelHeaders( &$parser, &$text ) {
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

			if ( version_compare( $wgVersion, '1.16', '>=' ) ) {
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

			$tabhtml	= '<div id="headertabs" class="yui-navset">';

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
			foreach ( $tabs as $tab ) {
				$tabhtml .= '<div id="' . $tab['tabid'] . '"><p>' . $tab['tabcontent'] . '</p></div>';
			}
			$tabhtml .= '</div></div>';

			if ( $htUseHistory ) {
				$text = '<iframe id="yui-history-iframe" src="' . $htScriptPath . '/skins-yui/blank.html" style="position:absolute; top:0; left:0; width:1px; height:1px; visibility:hidden;"></iframe><input id="yui-history-field" type="hidden">';
			} else {
				$text = '';
			}
			$text .= '<script>HeaderTabs.init(' . ( $htUseHistory ? 'true' : 'false' ) . ');</script>';
			$text .= $above . $tabhtml . $below;
		}

		return true;
	}

	/**
	 * @param $out OutputPage
	 * @return bool
	 */
	public static function addHTMLHeader( &$out ) {
		global $htScriptPath, $htUseHistory;

		if ( $htUseHistory ) {
			$out->addScript( '<script type="text/javascript" src="'.$htScriptPath.'/skins-yui/combined-history-min.js"></script>' );
		} else {
			$out->addScript( '<script type="text/javascript" src="'.$htScriptPath.'/skins-yui/combined-min.js"></script>' );
		}

		$out->addLink( array(
			'rel'	 => 'stylesheet',
			'type'	=> 'text/css',
			'media' => 'screen, projection',
			'href'	=> $htScriptPath . '/skins-yui/combined-min.css'
		) );

		return true;
	}

	public static function renderSwitchTabLink( &$parser, $tabName, $linkText, $anotherTarget = '' ) {
		$tabTitle = Title::newFromText( $tabName );
		$tabKey = $tabTitle->getDBkey();
		$sanitizedLinkText = $parser->recursiveTagParse( $linkText );

		if ( $anotherTarget != '' ) {
			$targetTitle = Title::newFromText( $anotherTarget );
			$targetURL = $targetTitle->getFullURL();

			$output = '<a href="' . $targetURL . '#tab=' . $tabKey . '">' . $sanitizedLinkText . '</a>';
		} else {
			$output = '<a href="#tab=' . $tabKey . '" onclick="return HeaderTabs.switchTab(\'' . $tabKey . '\')">' . $sanitizedLinkText . '</a>';
		}

		return $parser->insertStripItem( $output, $parser->mStripState );
	}

}
