<?php
class LqtParserFunctions {
	static function useLiquidThreads( &$parser, $param = '1' ) {
		$offParams = array( 'no', 'off', 'disable' );
		// Figure out if they want to turn it off or on.
		$param = trim( strtolower( $param ) );
		
		if ( in_array( $param, $offParams ) || !$param ) {
			$param = 0;
		} else {
			$param = 1;
		}
		
		$parser->mOutput->setProperty( 'use-liquid-threads', $param );
	}
	
	static function lqtPageLimit( &$parser, $param = null ) {
		if ( $param && $param > 0 ) {
			$parser->mOutput->setProperty( 'lqt-page-limit', $param );
		}
	}
}
