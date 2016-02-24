<?php
/**
 * Parser functions for Semantic Drilldown
 *
 * @file
 * @ingroup SD
 *
 * Two parser functions are defined: #drilldowninfo and #drilldownlink
 *
 * #drilldowninfo defines the drilldown information for one category - the
 * set of filters and so forth.
 *
 * #drilldownlink links to the page Special:BrowseData, with a query string
 * dictated by the parameters.
 *
 * {{#drilldownlink:category=|subcategory=|single|link text=|tooltip=|filter=}}
 *
 * @author Yaron Koren
 * @author mwjames
 */

class SDParserFunctions {

	static function registerFunctions( &$parser ) {
		$parser->setFunctionHook( 'drilldowninfo', array( 'SDParserFunctions', 'renderDrilldownInfo' ) );
		$parser->setFunctionHook( 'drilldownlink', array( 'SDParserFunctions', 'renderDrilldownLink' ) );
		return true;
	}

	static function renderDrilldownInfo( &$parser ) {
		$curTitle = $parser->getTitle();
		if ( $curTitle->getNamespace() != NS_CATEGORY ) {
			return '<div class="error">Error: #drilldowninfo can only be called in category pages.</div>';
		}

		$params = func_get_args();
		array_shift( $params );

		$filtersStr = $titleStr = $displayParametersStr = "";

		// Parameters
		foreach ( $params as $i => $param ) {
			$elements = explode( '=', $param, 2 );

			if ( count( $elements ) > 1 ) {
				$param_name = trim( $elements[0] );

				// parse (and sanitize) parameter values
				$value = trim( $parser->recursiveTagParse( $elements[1] ) );
			} else {
				// For now, don't do anything - this function
				// has no unnamed parameters.
				continue;
			}
			if ( $param_name == 'filters' ) {
				$filtersStr = $value;
			} elseif ( $param_name == 'title' ) {
				$titleStr = $value;
			} elseif ( $param_name == 'display parameters' ) {
				$displayParametersStr = $value;
			}
		}

		// Parse the "filters=" parameter.
		$filtersInfoArray = array();
		preg_match_all( '/([^()]*)\(([^)]*)\)/', $filtersStr, $matches );
		foreach( $matches[1] as $i => $filterName ) {
			$filterName = trim( $filterName, ", \t\n\r\0\x0B" );
			$filtersInfoArray[$filterName] = array();

			$filterSettingsStr = $matches[2][$i];
			$filterSettings = explode( ',', $filterSettingsStr );
			foreach( $filterSettings as $filterSettingStr ) {
				$filterSetting = explode( '=', $filterSettingStr, 2 );
				if ( count( $filterSetting ) != 2 ) {
					continue;
				}
				$key = trim( $filterSetting[0] );
				if ( $key != 'property' && $key != 'category' && $key != 'requires' ) {
					return "<div class=\"error\">Error: unknown setting, \"$key\".</div>";
					// Display an error message?
					continue;
				}

				$value = trim( $filterSetting[1] );
				// 'requires' holds a list, the other two
				// hold individual values.
				if ( $key == 'requires' ) {
					$values = explode( ',', $value );
					foreach ( $values as $realValue ) {
						$filtersInfoArray[$filterName][$key] = trim( $realValue );
					}
				} else {
					$filtersInfoArray[$filterName][$key] = $value;
				}
			}
		}

		$parserOutput = $parser->getOutput();

		$parserOutput->setProperty( 'SDFilters',  serialize( $filtersInfoArray ) );
		if ( $titleStr != '' ) {
			$parserOutput->setProperty( 'SDTitle', $titleStr );
		}
		if ( $displayParametersStr != '' ) {
			$parserOutput->setProperty( 'SDDisplayParams', $displayParametersStr );
		}

		$parserOutput->addModules( 'ext.semanticdrilldown.info' );

		$text = "<table class=\"drilldownInfo mw-collapsible mw-collapsed\">\n";
		$bd = Title::makeTitleSafe( NS_SPECIAL, 'BrowseData' );
		$bdURL = $bd->getLocalURL() . "/" . $curTitle->getPartialURL();
		$bdLink = Html::rawElement( 'a', array( 'href' => $bdURL ), "Semantic Drilldown" );
		$text .= "<tr><th colspan=\"2\">$bdLink</th></tr>\n";
		$text .= "<tr class=\"drilldownInfoHeader\"><td colspan=\"2\">Filters</td></tr>\n";
		foreach ( $filtersInfoArray as $filterName => $filterInfo ) {
			$text .= "<tr><td class=\"drilldownFilterName\">$filterName</td><td>\n";
			$i = 0;
			foreach ( $filterInfo as $key => $value ) {
				if ( $i++ > 0 ) { $text .= ", "; }
				$text .= $key . ' = ';
				if ( $key == 'property' ) {
					$propertyTitle = Title::makeTitleSafe( SMW_NS_PROPERTY, $value );
					$text .= Linker::link( $propertyTitle, $value );
				} elseif ( $key == 'category' ) {
					$categoryTitle = Title::makeTitleSafe( NS_CATEGORY, $value );
					$text .= Linker::link( $categoryTitle, $value );
				} elseif ( $key == 'requires' ) {
					$text .= '<strong>' . $value . '</strong>';
				} else {
					// Do what here?
					$text .= $value;
				}
			}
			$text .= "</td></tr>\n";
		}
		if ( $titleStr != '' ) {
			$text .= "<tr class=\"drilldownInfoHeader\"><td colspan=\"2\">Title</td></tr>\n";
			$text .= "<tr><td colspan=\"2\">$titleStr</td></tr>\n";
		}
		if ( $displayParametersStr != '' ) {
			$text .= "<tr class=\"drilldownInfoHeader\"><td colspan=\"2\">Display parameters</td></tr>\n";
			$text .= "<tr><td colspan=\"2\">$displayParametersStr</td></tr>\n";
		}
		$text .= "</table>\n";

		return $parser->insertStripItem( $text, $parser->mStripState );
	}


	static function renderDrilldownLink( &$parser ) {
		$params = func_get_args();
		array_shift( $params );

		$specialPage = SpecialPageFactory::getPage( 'BrowseData' );

		// Set defaults.
		$inQueryArr = array();
		$inLinkStr = $category = $classStr = $inTooltip = '';

		// Parameters
		foreach ( $params as $i => $param ) {
			$elements = explode( '=', $param, 2 );

			// set param_name and value
			if ( count( $elements ) > 1 ) {
				$param_name = trim( $elements[0] );

				// parse (and sanitize) parameter values
				$value = trim( $parser->recursiveTagParse( $elements[1] ) );
			} else {
				$param_name = null;

				// parse (and sanitize) parameter values
				$value = trim( $parser->recursiveTagParse( $param ) );
			}

			if ( $param_name == 'category' || $param_name == 'cat' ) {
				$category = $value;
			} elseif ( $param_name == 'subcategory' || $param_name == 'subcat' ) {
				parse_str( '_subcat=' . $value , $arr);
				$inQueryArr = array_merge( $inQueryArr, $arr );
			} elseif ( $param_name == 'link text' ) {
				$inLinkStr = $value;
			} elseif ( $param_name == 'tooltip' ) {
				$inTooltip = Sanitizer::decodeCharReferences( $value );
			} elseif ( $param_name == null && $value == 'single' ) {
				parse_str( '_single' , $arr);
				$inQueryArr = array_merge( $inQueryArr, $arr );
			} elseif ( $param_name == 'filters' ) {
				$inQueryStr = str_replace( '&amp;', '%26', $value );
				parse_str( $inQueryStr, $arr );
				$inQueryArr = array_merge( $inQueryArr, $arr );
			}
		}

		if ( method_exists( $specialPage, 'getPageTitle' ) ) {
			// MW 1.23+
			$title = $specialPage->getPageTitle();
		} else {
			$title = $specialPage->getTitle();
		}
		$link_url = $title->getLocalURL() . "/{$category}";
		$link_url = str_replace( ' ', '_', $link_url );
		if ( ! empty( $inQueryArr ) ) {
			$link_url .= ( strstr( $link_url, '?' ) ) ? '&' : '?';
			$link_url .= str_replace( '+', '%20', http_build_query( $inQueryArr, '', '&' ) );
		}

		$inLinkStr = ( empty($inLinkStr) ? $category : $inLinkStr ) ;
		$link = Html::rawElement( 'a', array( 'href' => $link_url, 'class' => $classStr, 'title' => $inTooltip ), $inLinkStr );

		// hack to remove newline from beginning of output, thanks to
		// http://jimbojw.com/wiki/index.php?title=Raw_HTML_Output_from_a_MediaWiki_Parser_Function
		return $parser->insertStripItem( $link , $parser->mStripState );
	}

}
