<?php
/**
 * Parser functions for tab widget.
 */

class ETParserFunctions {
	static function registerFunctions( &$parser ) {
		$parser->setFunctionHook( 'tab', array( 'ETParserFunctions', 'renderTabWidget' ), SFH_OBJECT_ARGS );
		$parser->setHook( "embedwiki", array( 'ETParserFunctions', 'embedWiki' ) );

		return true;
	}

//	static $inlineParser = false;
	static public function embedWiki( $input, $argv ) {
//		if(!ETParserFunctions::$inlineParser) {
//			global $wgParserConf;
//			ETParserFunctions::$inlineParser = wfCreateObject( $wgParserConf['class'], array( $wgParserConf ) );
//		}
		global $wgParser;

	   	if ( ( $wgParser->getTitle() instanceof Title ) && ( $wgParser->getOptions() instanceof ParserOptions ) ) {
			$result = $wgParser->recursiveTagParse( $input );
		} else {
			global $wgTitle;
			$popt = new ParserOptions();
			$popt->setEditSection( false );
			$pout = $wgParser->parse( $input . '__NOTOC__', $wgTitle, $popt );
			// / NOTE: as of MW 1.14SVN, there is apparently no better way to hide the TOC
			SMWOutputs::requireFromParserOutput( $pout );
			$result = $pout->getText();
		}
	    return $result;
	}

	static $tabWidgetId = 0;
	static function renderTabWidget ( $parser, $frame, $args ) {
		global $smwgExtTabScriptPath, $wgTitle, $wgOut;
		if ( self::$tabWidgetId == 0 ) {
			$wgOut->addLink( array(
					'rel'   => 'stylesheet',
					'type'  => 'text/css',
					'media' => 'screen, projection',
					'href'  => $smwgExtTabScriptPath . '/scripts/extjs/resources/css/ext-all.css'
				) );
			$wgOut->addLink( array(
					'rel'   => 'stylesheet',
					'type'  => 'text/css',
					'media' => 'screen, projection',
					'href'  => $smwgExtTabScriptPath . '/skins/style.css'
				) );

			$wgOut->addScript( '<script type="text/javascript" src="' . $smwgExtTabScriptPath . '/scripts/extjs/adapter/ext/ext-base.js"></script>' );
			$wgOut->addScript( '<script type="text/javascript" src="' . $smwgExtTabScriptPath . '/scripts/extjs/ext-all.js"></script>' );
			$wgOut->addScript( '<script type="text/javascript" src="' . $smwgExtTabScriptPath . '/scripts/tabwidgets.js"></script>' );
		}

		$tabs = array();
		$htmls = array();
		$widget_options = array();
		$widget_name = '';

		$id = self::$tabWidgetId ++;

		for ( $i = count( $args ); $i > 0; --$i ) {
			$t = trim( $frame->expand( array_shift( $args ) ) );
			if ( !$t ) continue;
			$arr = explode( '=', $t, 2 );
			$t = trim( $arr[1] );
			if ( strtolower( trim( $arr[0] ) ) == 'options' ) {
				foreach ( explode( ';', $t ) as $opt ) {
					$nv = explode( ':', $opt );
					$widget_options[strtolower( trim( $nv[0] ) )] = trim( $nv[1] );
				}
				continue;
			}
			if ( strtolower( trim( $arr[0] ) ) == 'name' ) {
				$widget_name = $t;
				continue;
			}

			$var = explode( '.', $arr[0], 2 );
			if ( strtolower( trim( $var[1] ) ) == 'body' ) {
				if ( preg_match( '/^\[\[([^\[\]\|]+)(\|([^\[\]]+))?\]\]$/', $t, $matches ) ) {
					if ( count( $matches ) == 4 ) $t = $matches[3]; else $t = $matches[1];
					$tabs[$var[0]] = array( 'title' => $t, 'type' => 'internal', 'html' => $matches[1] );
				} else {
					$val = explode( "\n", $t, 2 );
					$t = trim( $val[0] );
					$html = $val[1];
					$html = $parser->preprocessToDom( $html, $frame->isTemplate() ? Parser::PTD_FOR_INCLUSION : 0 );
					$html_id = 'tabs' . $id . '_' . $i;
					$htmls[$html_id] = trim( $frame->expand( $html ) );
					$tabs[$var[0]] = array(
						'title' => $t, 'type' => 'html', 'html' => $html_id );
				}
			} elseif ( strtolower( trim( $var[1] ) ) == 'option' ) {
				$options = array();
				foreach ( explode( ';', $t ) as $opt ) {
					$nv = explode( ':', $opt );
					$options[strtolower( trim( $nv[0] ) )] = trim( $nv[1] );
				}
				$tabs[$var[0]]['option'] = $options;
			}
		}
		$tabItems = array();
		global $smwgIQRunningNumber;
		foreach ( $tabs as $t ) {
			$txt = 'title: "' . str_replace( '"', '\"', $t['title'] ) . '",';
			if ( $t['type'] == 'html' ) {
				$txt .= 'contentEl:"' . $t['html'] . '"';
			} elseif ( $t['type'] == 'internal' ) {
				$txt .= 'autoLoad: {url: "", params: "action=ajax&rs=smwf_et_Access&&rsargs[]=internalLoad&rsargs[]=' . ( $smwgIQRunningNumber++ ) . ',' . $t['html'] . '"}';
			}

			$tabItems[] = $txt;
		}
		$wgOut->addScript( '<script type="text/javascript">
			ExtTab.tabWidgets.push({
				id:"tabs' . $id . '",' .
				( isset( $widget_options['height'] ) ? ( 'height:' . intval( $widget_options['height'] ) . ',' ):'' ) .
				( isset( $widget_options['width'] ) ? ( 'width:' . intval( $widget_options['width'] ) . ',' ):'' ) .
				'items:[{' . implode( '},{', $tabItems ) . '}]
			});
			</script>' );
		$str = '<div id="tabs' . $id . '">';
		foreach ( $htmls as $hid => $html ) {
			$str .= '<div id="' . $hid . '" class="x-hide-display">' . $html . '</div>';
		}
		$str .= '</div>';
		return array( $str, 'noparse' => true, 'isHTML' => false );
	}
}
