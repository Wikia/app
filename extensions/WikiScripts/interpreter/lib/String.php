<?php

class WSStringLibrary extends WSLibraryModuleBase {
	public function getFunctions() {
		return array(
			'lowercase' => array( 'lowercase', 1 ),
			'uppercase' => array( 'uppercase', 1 ),
			'uppercase_first' => array( 'uppercaseFirst', 1 ),
			'url_encode' => array( 'urlEncode', 1 ),
			'anchor_encode' => array( 'anchorEncode', 1 ),
			'grammar' => array( 'grammar', 2 ),
			'plural' => array( 'plural', 2 ),
			'length' => array( 'length', 1 ),
			'sub' => array( 'sub', 3 ),
			'replace' => array( 'replace', 3 ),
			'split' => array( 'split', 2 ),
			'join' => array( 'join', 2 ),
			'join_list' => array( 'join_list', 2 ),
		);
	}

	public function lowercase( $args, $context, $line ) {
		global $wgContLang;
		return new WSData( WSData::DString, $wgContLang->lc( $args[0]->toString() ) );
	}

	public function uppercase( $args, $context, $line ) {
		global $wgContLang;
		return new WSData( WSData::DString, $wgContLang->uc( $args[0]->toString() ) );
	}

	public function uppercaseFirst( $args, $context, $line ) {
		global $wgContLang;
		return new WSData( WSData::DString, $wgContLang->ucfirst( $args[0]->toString() ) );
	}

	public function urlEncode( $args, $context, $line ) {
		return new WSData( WSData::DString, wfUrlencode( $args[0]->toString() ) );
	}

	public function anchorEncode( $args, $context, $line ) {
		$s = urlencode( $args[0]->toString() );
		$s = strtr( $s, array( '%' => '.', '+' => '_' ) );
		$s = str_replace( '.3A', ':', $s );

		return new WSData( WSData::DString, $s );
	}
	
	public function grammar( $args, $context, $line ) {
		list( $case, $word ) = $args;
		$res = $context->mParser->getFunctionLang()->convertGrammar(
			$case->toString(), $word->toString() );
		return new WSData( WSData::DString, $res );
	}

	public function plural( $args, $context, $line ) {
		$num = $args[0]->toInt();
		for( $i = 1; $i < count( $args ); $i++ )
			$forms[] = $args[$i]->toString();
		$res = $context->mParser->getFunctionLang()->convertPlural( $num, $forms );
		return new WSData( WSData::DString, $res );
	}

	public function length( $args, $context, $line ) {
		return new WSData( WSData::DInt, mb_strlen( $args[0]->toString() ) );
	}

	public function sub( $args, $context, $line ) {
		$s = $args[0]->toString();
		$start = $args[1]->toInt();
		$length = $args[2]->toInt();
		return new WSData( WSData::DString, mb_substr( $s, $start, $length ) );
	}
	
	public function replace( $args, $context, $line ) {
		$s = $args[0]->toString();
		$old = $args[1]->toString();
		$new = $args[2]->toString();
		return new WSData( WSData::DString, str_replace( $old, $new, $s ) );
	}

	public function split( $args, $context, $line ) {
		$list = explode( $args[1]->toString(), $args[0]->toString() );
		return WSData::newFromPHPVar( $list );
	}

	public function join( $args, $context, $line ) {
		$bits = array();
		for( $i = 1; $i < count( $args ); $i++ ) {
			$bits[] = $args[$i]->toString();
		}

		return new WSData( WSData::DString, implode( $args[0]->toString(), $bits ) );
	}

	public function join_list( $args, $context, $line ) {
		$bits = array();
		foreach( $args[0]->toList() as $bit ) {
			$prefix = isset( $args[2] ) ? $args[2]->toString() : '';
			$postfix = isset( $args[3] ) ? $args[3]->toString() : '';
			$bits[] = $prefix . $bit->toString() . $postfix;
		}

		return new WSData( WSData::DString, implode( $args[1]->toString(), $bits ) );
	}
}
