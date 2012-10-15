<?php
/**
 * Version of the HeaderTabs class that uses jQuery and the ResourceLoader.
 *
 * @file
 * @ingroup Extensions
 *
 * @author Sergey Chernyshev
 * @author Yaron Koren
 * @author Olivier Finlay Beaton
 */

class HeaderTabs {
	public static function tag( $input, $args, $parser ) {
		// This tag, besides just enabling tabs, also designates
		// the end of tabs. Can be used even if automatiic namespaced
		return '<div id="nomoretabs"></div>';
	}

	public static function replaceFirstLevelHeaders( &$parser, &$text ) {
		global $htRenderSingleTab, $htAutomaticNamespaces, $htDefaultFirstTab, $htDisableDefaultToc, $htGenerateTabTocs, $htStyle, $htEditTabLink;
		global $htTabIndexes;

		//! @todo handle __NOTABTOC__, __TABTOC__, __FORCETABTOC__ here (2011-12-12, ofb)

		// Where do we stop rendering tabs, and what is below it?
		// if we don't have a stop point, then bail out
		$aboveandbelow = explode( '<div id="nomoretabs"></div>', $text, 2 );
		if ( count( $aboveandbelow ) <= 1 ) {
			if ( in_array( $parser->getTitle()->getNamespace(), $htAutomaticNamespaces ) === FALSE ) {
				return true; // <headertabs/> tag is not found
			} else {
				// assume end of article is nomoretabs
				$aboveandbelow[] = '';
			}
		}
		$below = $aboveandbelow[1];

		wfDebugLog('headertabs', __METHOD__.': detected header handling, checking');

		if ($below !== '') {
			wfDebugLog('headertabs', __METHOD__.': we have text below our tabs');
		}

		// grab the TOC
		$toc = '';
		$tocpattern = '%<table id="toc" class="toc"><tr><td><div id="toctitle"><h2>.+?</h2></div>'."\n+".'(<ul>'."\n+".'.+?</ul>)'."\n+".'</td></tr></table>'."\n+".'%ms';
		if ( preg_match($tocpattern, $aboveandbelow[0], $tocmatches, PREG_OFFSET_CAPTURE) === 1 ) {
			wfDebugLog('headertabs', __METHOD__.': found the toc: '.$tocmatches[0][1]);
			$toc = $tocmatches[0][0];
			// toc is first thing
			if ( $tocmatches[0][1] === 0 ) {
				wfDebugLog('headertabs', __METHOD__.': removed standard-pos TOC');
				$aboveandbelow[0] = substr_replace( $aboveandbelow[0], '', $tocmatches[0][1], strlen($tocmatches[0][0]) );
			}
		}
		// toc is tricky, if you allow the auto-gen-toc,
		//	 and it's not at the top, but you end up with tabs... it could be embedded in a tab
		//	 but if it is at the top, and you have auto-first-tab, but only a toc is there, you don't really have an auto-tab

		// how many headers parts do we have? if not enough, bail out
		// text -- with defaulttab off = 1 parts
		//--render singletab=on here
		// text -- with defaulttab on = 2 parts
		// 1 header -- with defaulttab off = 2 parts
		// above, 1 header -- with defaulttab off = 3 parts
		//--render singletab=off here
		// above, 1 header -- with defaulttab on = 4 parts
		// 2 header -- with defaulttab on/off = 4 parts
		// above, 2 header -- with defaulttab off = 5 parts
		// above, 2 header -- with defaulttab on = 6 parts

		$tabpatternsplit = '/(<h1.+?<span[^>]+class="mw-headline"[^>]+id="[^"]+"[^>]*>\s*.*?\s*<\/span>.*?<\/h1>)/';
		$tabpatternmatch = '/<h(1).+?<span[^>]+class="mw-headline"[^>]+id="([^"]+)"[^>]*>\s*(.*?)\s*<\/span>.*?<\/h1>/';
		$parts = preg_split( $tabpatternsplit, trim($aboveandbelow[0]), -1, PREG_SPLIT_DELIM_CAPTURE );
		$above = '';

		// auto tab and the first thing isn't a header (note we already removed the default toc, add it back later if needed)
		if ( $htDefaultFirstTab !== FALSE && $parts[0] !== '' ) {
			// add the default header
			$headline = '<h1><span class="mw-headline" id="'.str_replace(' ', '_', $htDefaultFirstTab).'">'.$htDefaultFirstTab.'</span></h1>';
			array_unshift( $parts, $headline );
			$above = ''; // explicit
		} else {
			$above = $parts[0];
			// discard first part blank part
			array_shift( $parts ); // don't need above part anyway
		}

		$partslimit = $htRenderSingleTab ? 2 : 4;

		wfDebugLog('headertabs', __METHOD__.': parts (limit '.$partslimit.'): '.count($parts));
		if ($above !== '') {
			wfDebugLog('headertabs', __METHOD__.': we have text above our tabs');
		}

		if ( count($parts) < $partslimit ) {
			return true;
		}

		wfDebugLog('headertabs', __METHOD__.': split count OK, continuing');

		// disable default TOC
		if ( $htDisableDefaultToc === TRUE ) {
			// if it was somewhere else, we need to remove it
			if ( count($tocmatches) > 0 && $tocmatches[0][1] !== 0 ) {
				wfDebugLog('headertabs', __METHOD__.': removed non-standard-pos TOC');
				// remove from above
				if ( $tocmatches[0][1] < strlen($above) ) {
					$above = substr_replace( $above, '', $tocmatches[0][1], strlen($tocmatches[0][0]) );
				} else {
					$tocmatches[0][1] -= strlen($above);
					// it's in a tab
					for ($i = 0; ($i < count ( $parts ) / 2 ); $i++ ) {
						if ( $tocmatches[0][1] < strlen($parts[($i * 2) + 1]) ) {
							$parts[($i * 2) + 1] = substr_replace( $parts[($i * 2) + 1], '', $tocmatches[0][1], strlen($tocmatches[0][0]) );
							break;
						}
						$tocmatches[0][1] -= strlen($parts[($i * 2) + 1]);
					}
				}
			}
		} elseif( count($tocmatches) > 0 && $tocmatches[0][1] === 0 ) {
			// add back a default-pos toc
			$above = $toc.$above;
		}

		// we have level 1 headers to parse, we'll want to render tabs
		$tabs = array();

		$s = 0;

		for ( $i = 0; $i < ( count( $parts ) / 2 ); $i++ ) {
			preg_match( $tabpatternmatch, $parts[$i * 2], $matches );

			// if this is a default tab, don't increment our section number
			if ($s !== 0 || $i !== 0 || $htDefaultFirstTab === FALSE || $matches[3] !== $htDefaultFirstTab) {
				++$s;
			}

			$tabsection = $s;
			$content = $parts[$i * 2 + 1];

			// Almost all special characters in tab IDs
			// cause a problem in the jQuery UI tabs()
			// function - in the URLs they already come out
			// as URL-encoded, which is good, but for some
			// reason it's as ".2F", etc., instead of
			// "%2F" - so replace all "." with "_", and
			// everything should be fine.
			$tabid = str_replace('.', '_', $matches[2]);

			$tabtitle = $matches[3];

			wfDebugLog('headertabs', __METHOD__.': found tab: '.$tabtitle);

			// toc and section counter
			$subpatternsplit = '/(<h[2-6].+?<span[^>]+class="mw-headline"[^>]+id="[^"]+"[^>]*>\s*.*?\s*<\/span>.*?<\/h[2-6]>)/';
			$subpatternmatch = '/<h([2-6]).+?<span[^>]+class="mw-headline"[^>]+id="([^"]+)"[^>]*>\s*(.*?)\s*<\/span>.*?<\/h[2-6]>/';
			$subparts = preg_split( $subpatternsplit, $content, -1, PREG_SPLIT_DELIM_CAPTURE );
			if ((count($subparts) % 2) !== 0) {
				// don't need anything above first header
				array_shift( $subparts );
			}
			for ( $p = 0; $p < ( count( $subparts ) / 2 ); $p++ ) {
				preg_match( $subpatternmatch, $subparts[$p * 2], $submatches );
				++$s;
			}

			//! @todo handle __TOC__, __FORCETOC__, __NOTOC__ here (2011-12-12, ofb)
			if ($htGenerateTabTocs === TRUE) {
				// really? that was it?
				// maybe a better way then clone... formatHeadings changes properties on the parser which we don't want to do
				// would be better to have a 'clean' parser so the tab was treated as a new page
				// maybe use LinkerOutput's generateTOC?

				//! @todo insert the toc after the first paragraph, maybe we can steal the location from formatHeadings despite the changed html? (2011-12-12, ofb)

				$tocparser = clone $parser;
				$tabtocraw = $tocparser->formatHeadings($content, '');
				if ( preg_match($tocpattern, $tabtocraw, $tabtocmatches) === 1 ) {
					wfDebugLog('headertabs', __METHOD__.': generated toc for tab');
					$tabtocraw = $tabtocmatches[0];
					$tabtoc = $tabtocraw;
					$itempattern = '/<li class="toclevel-[0-9]+"><a href="(#[^"]+)"><span class="tocnumber">[0-9]+<\/span> <span class="toctext">([^<]+)<\/span><\/a><\/li>/';
					if ( preg_match_all( $itempattern , $tabtocraw, $tabtocitemmatches, PREG_SET_ORDER ) > 0 ) {
						foreach( $tabtocitemmatches as $match ) {
							$newitem = $match[0];

							// 1.17 behavior
							if ( strpos( $match[2], '[edit] ' ) === 0 ) {
								$newitem = str_replace( $match[1], '#' . substr( $match[1], 12 ), $newitem );
								$newitem = str_replace( $match[2], substr( $match[2], 7 ), $newitem );
							// 1.18+ behavior
							} elseif ( trim( substr( $match[2], 0, strlen( $match[2] ) / 2 ) ) == trim( substr( $match[2], strlen( $match[2] ) / 2 ) ) ) {
								$newitem = str_replace( $match[1], '#' . trim( substr( $match[1], ( strlen( $match[1] ) / 2 ) + 1 ) ), $newitem );
								$newitem = str_replace( $match[2], trim( substr( $match[2], strlen( $match[2] ) / 2 ) ), $newitem );
							}
							$tabtoc = str_replace( $match[0], $newitem, $tabtoc );
						}
						$content = $tabtoc.$content;
					}
				}
			}

			array_push( $tabs, array(
				'tabid' => $tabid,
				'title' => $tabtitle,
				'tabcontent' => $content,
				'section' => $tabsection,
			) );
		}

		//! @todo see if we can't add the SMW factbox stuff back in (2011-12-12, ofb)

		wfDebugLog('headertabs', __METHOD__.': generated '.count($tabs).' tabs');

		$tabhtml = '<div id="headertabs"';
		if (!empty($htStyle) && $htStyle !== 'jquery') {
			$tabhtml .= ' class="'.$htStyle.'"';
		}
		$tabhtml .= '>';

		//! @todo handle __NOEDITTAB__ here (2011-12-12, ofb)
		if ( $htEditTabLink === TRUE ) {
			$tabhtml .= '<span class="editsection" id="edittab">[<a href="" title="'.wfMsg('headertabs-edittab-hint').'">'.wfMsg('headertabs-edittab').'</a>]</span>';
		}

		$tabhtml .= '<ul>';
		foreach ( $tabs as $i => $tab ) {
			$tabhtml .= '<li';
			if ( $i == 0 ) {
				$tabhtml .= ' class="selected" ';
			} else { // hide selector of all but first tab
				$tabhtml .= ' class="unselected"';
			}
			$tabhtml .= '><a href="#' . $tab['tabid'] . '">'.$tab['title'] . "</a></li>\n";
		}
		$tabhtml .= '</ul>';

		foreach ( $tabs as $i => $tab ) {
			$tabhtml .= '<div id="' . $tab['tabid'] . '" class="section-'.$tab['section'];
			
			if ( $i != 0 ) { // hide content of all but first tab
				$tabhtml .= ' unselected';
			}
			
			$tabhtml .= '"><p>' . $tab['tabcontent'] . '</p></div>';
		}
		$tabhtml .= '</div>';

		$text = $above . $tabhtml . $below;

		$parser->getOutput()->addHeadItem(HTML::inlineScript( 'document.styleSheets[0].insertRule?document.styleSheets[0].insertRule(".unselected {display:none;}", 0):document.styleSheets[0].addRule(".unselected", "display:none");' ), true );

		foreach ( $tabs as $i => $tab ) {
			$tabTitle = str_replace( ' ', '_', $tab['title'] );
			$htTabIndexes[$tabTitle] = $i;
		}
		
		return true;
	}

	public static function addConfigVarsToJS( &$vars ) {
		global $htUseHistory, $htEditTabLink;

		$vars['htUseHistory'] = $htUseHistory;
		$vars['htEditTabLink'] = $htEditTabLink;

		return true;
	}

	/**
	 * @param $out OutputPage
	 * @return bool
	 */
	public static function addHTMLHeader( &$out ) {
		global $htScriptPath,$htStyle;

		//! @todo we might be able to only load our js and styles if we are rendering tabs, speeding up pages that don't use it? but what about cached pages? (2011-12-12, ofb)

		$out->addModules( 'ext.headertabs' );

		// Add the CSS file for the specified style.
		if ( !empty( $htStyle ) && $htStyle !== 'jquery' ) {
			$styleFile = $htScriptPath . '/skins-jquery/ext.headertabs.' . $htStyle . '.css';
			$out->addExtensionStyle( $styleFile );
		}

		return true;
	}

	public static function renderSwitchTabLink( &$parser, $tabName, $linkText, $anotherTarget = '' ) {
		// The cache unfortunately needs to be disabled for the
		// Javascript for such links to work.
		$parser->disableCache();

		$tabTitle = Title::newFromText( $tabName );
		$tabKey = $tabTitle->getDBkey();
		$sanitizedLinkText = $parser->recursiveTagParse( $linkText );

		if ( $anotherTarget != '' ) {
			$targetTitle = Title::newFromText( $anotherTarget );
			$targetURL = $targetTitle->getFullURL();

			$output = '<a href="' . $targetURL . '#tab=' . $tabKey . '">' . $sanitizedLinkText . '</a>';
		} else {
			$output = '<a href="#tab='.$tabKey.'" class="tabLink">'.$sanitizedLinkText.'</a>';
		}

		return $parser->insertStripItem( $output, $parser->mStripState );
	}

	static function setGlobalJSVariables( &$vars ) {
		global $htTabIndexes;
		$vars['htTabIndexes'] = $htTabIndexes;
		return true;
	}
}
