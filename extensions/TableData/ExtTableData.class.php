<?php
/**
 * ExtTableData class for extension TableData.
 *
 * @file
 * @ingroup Extensions
 */

class ExtTableData {
	
	public function tag( &$parser, $frame, $content, $attributes ) {
		
		/** Fetch ourself a data parser for the content, be sure to error out and make this something extensible **/
		if ( !isset($attributes['format']) ) {
			return self::error( 'formatnotdefined' );
		}
		
		$dataParser = self::getDataParser( $attributes['format'] );
		
		if ( !$dataParser ) {
			return self::error( 'invalidformat', $attributes['format'] );
		}
		
		// @todo Consider supporting the extracting of data from another page
		$data = $dataParser->parse( trim($content), $attributes );
		if ( is_array($data) && isset($data["error"]) ) {
			return self::error($data["error"]);
		}
		
		/** Build our WikiText here. We support header/row/footer attributes defining templates to use for formatting **/
		$wt = '';
		if ( isset($attributes["header"]) ) {
			// The tag has defined a template to use to format the header
			$tpl = Title::newFromText( $attributes["header"], NS_TEMPLATE );
			if ( !is_object($tpl) ) {
				return self::error( 'invalidtemplatetitle', "header", $attributes["header"] );
			}
			$tplText = $tpl->getPrefixedText();
			$wt .= self::makeTemplateLine( $tplText, null, $data["headers"] );
			$wt .= "\n";
		} else {
			$wt .= "{|\n|-\n";
			foreach ( $data["headers"] as $header ) {
				$wt .= "!| " . wfEscapeWikiText( $header ) . "\n";
			}
		}
		if ( isset($attributes["row"]) ) {
			// The tag has defined a template to use to format rows
			$tpl = Title::newFromText( $attributes["row"], NS_TEMPLATE );
			if ( !is_object($tpl) ) {
				return self::error( 'invalidtemplatetitle', "row", $attributes["row"] );
			}
			$tplText = $tpl->getPrefixedText();
			foreach ( $data["rows"] as $i => $row ) {
				$wt .= self::makeTemplateLine( $tplText, $i, $data["headers"], $row );
				$wt .= "\n";
			}
		} else {
			foreach ( $data["rows"] as $row ) {
				$wt .= "|-\n";
				foreach ( $row as $header => $cell ) {
					$wt .= "|| " . wfEscapeWikiText( $cell ) . "\n";
				}
			}
		}
		if ( isset($attributes["footer"]) ) {
			// The tag has defined a template to use to format the footer
			$tpl = Title::newFromText( $attributes["footer"], NS_TEMPLATE );
			if ( !is_object($tpl) ) {
				return self::error( 'invalidtemplatetitle', "footer", $attributes["footer"] );
			}
			$tplText = $tpl->getPrefixedText();
			$wt .= self::makeTemplateLine( $tplText, null, $data["headers"] );
		} else {
			$wt .= "|}";
		}
		
		// Be sure to recursiveTagParse our WikiText
		return trim($parser->recursiveTagParse( $wt, $frame ));
	}
	
	static $dataParsers = array();
	protected static function getDataParser( $format ) {
		if ( !array_key_exists( $format, self::$dataParsers ) ) {
			self::$dataParsers[$format] = self::doGetDataParser( $format );
		}
		return self::$dataParsers[$format];
	}
	protected static function doGetDataParser( $format ) {
		// @todo Add hook that other extensions can use to add their own data parsers
		switch($format) {
		case "csv": return new ExtTableDataParser_csv( $format );
		case "separated": return new ExtTableDataParser_separated( $format );
		}
		return false;
	}
	
	protected static function makeTemplateLine( $tplText, $i, $headers, $params=null ) {
		$wt = "{{{$tplText}";
		if ( isset($i) ) {
			$wt .= "|#=" . ($i+1);
		}
		foreach ( $headers as $h => $header ) {
			$wt .= "|#" . ($h+1) . "#=" . wfEscapeWikiText( $header );
		}
		if ( isset($params) ) {
			foreach ( $params as $param => $value ) {
				$wt .= "|" . wfEscapeWikiText( $param ) . "=" . wfEscapeWikiText( $value );
			}
		}
		$wt .= "}}\n";
		return $wt;
	}
	
	protected static function error( /*...*/ ) {
		$args = func_get_args();
		if ( is_array($args[0]) ) {
			$args = $args[0];
		}
		$args[0] = "datatable-error-{$args[0]}";
		return Html::rawElement( 'p', null,
			Html::rawElement( 'strong', array( 'class' => 'error' ), call_user_func_array( "wfMsgForContent", $args ) ) );
	}
	
	
}
