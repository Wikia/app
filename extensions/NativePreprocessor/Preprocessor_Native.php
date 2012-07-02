<?php

if ( class_exists( 'MediaWikiPreprocessor' ) ) {
	global $wgParserConf;
	$wgParserConf['preprocessorClass'] = 'Preprocessor_Native';
}

class Preprocessor_Native implements Preprocessor {
	var $parser;
	
	function __construct( $parser ) {
		$this->parser = $parser;
	}
	
	
	function preprocessToObj( $text, $flags = 0 ) {
		$ntobj = $this->preprocessToObjInternal( $text, $flags );
		
		return array( 'text' => $text, 'nodes' => $ntobj );
	}
	
	function preprocessToObjInternal( $text, $flags = 0 ) {
		$nativePP = new MediaWikiPreprocessor();
		$ntobj = $nativePP->preprocessToObj( $text, $flags, $this->parser->getStripList() );
		
		return $ntobj;
	}
	
	/**
	 * Completely inefficient function to transform into the xml serialization.
	 */
	function preprocessToXml( $text, $flags = 0 ) {
		$ser = $this->preprocessToObjInternal( $text, $flags );

		return $this->unserializeNode( substr( $ser, 0, 16 ), substr( $ser, 16 ), $text );
	}
	
	const NODE_LEN = 16;
	function unserializeNode( $node, $children, &$text ) {
		if ( $node == '' ) throw new MWException( 'Empty node' );
		
		$flags = ord( $node[1] ) - 48;
		$childrenLen = hexdec( substr( $node, 2, 6 ) );
		$textLen = hexdec( substr( $node, 8, 8 ) );
		$result = htmlspecialchars( substr( $text, 0,  $textLen ) );
		if ( strlen( $text ) < $textLen ) throw new MWException( 'Bad length in node of type ' . $node[0] . ". Expected $textLen bytes, but only " . strlen( $text ) . " available."  );
		$text = substr( $text, $textLen );
		if ( strpos( '<et|p', $node[0] ) !== false )
			$result = ''; // Not present in Preprocessor_DOM
		
		while ( $childrenLen > 0 ) {
			$result .= $this->unserializeNode( substr( $children, 0, 16 ), substr( $children, 16 ), $text );
			$n = self::NODE_LEN + hexdec( substr( $children, 2, 6 ) );
			$children = substr( $children, $n );
			$childrenLen -= $n;
		}
		switch ( $node[0] ) {
			case '/':
				return "<root>$result</root>";
			case 'L':
				return $result;
			case 'I':
				return "<ignore>$result</ignore>";
			case '-':
				return "<comment>$result</comment>";
			case '<':
				return "<ext>$result</ext>";
			case 'N':
				if ($flags)
					return "<name index=\"$flags\" />";
				else
					return "<name>$result</name>";
			case 'a':
				return "<attr>$result</attr>";
			case 'e':
				return $result;
			case '.':
				return "<inner>$result</inner>";
			case '>':
				return "<close>$result</close>";
			case 'i':
			case 'j':
			case 'k':
			case 'l':
			case 'm':
			case 'n':
				return "<h level=\"" . ( ord( $node[0] ) - ord( 'h' ) ) . "\" i=\"" . ( ord( $node[1] ) - ord( '0' ) ) . "\">$result</h>";
			case 't':
				$lineStart = $flags ? " lineStart=\"1\"" : "";
				return "<template$lineStart>$result</template>";
			case 'p':
				$lineStart = $flags ? " lineStart=\"1\"" : "";
				return "<tplarg$lineStart>$result</tplarg>";
			case 'T':
				return "<title>$result</title>";
			case '|':
				return "<part>$result</part>";
			case 'v':
				return "<value>$result</value>";
			case '}':
				return '';
			default:
				throw new Exception( "Unknown node of type '" . $node[0] . "'");
		}
	}
	
	function newFrame() {
		throw new Exception( __METHOD__ . 'unimplemented' );
	}
	
	function newCustomFrame( $args ) {
		throw new Exception( __METHOD__ . 'unimplemented' );
	}
	
	function newPartNodeArray( $values ) {
		throw new Exception( __METHOD__ . 'unimplemented' );
	}
}
