<?php

/**
 * Example of the page that uses extensions hooks for
 * making nice error page.
 *
 * @author VasilievVV
 * @license GNU GPL 2 or later
 */

//$wgExceptionHooks['DBConnectionErrorRaw'][] = array( 'NiceErrorPage', 'dbConnectionOP' );
$wgExceptionHooks['DBConnectionErrorRaw'][] = array( 'NiceErrorPage', 'dbConnection' );
$wgExceptionHooks['DBQueryErrorRaw'][] = array( 'NiceErrorPage', 'dbQueryError' );

$wgNiceErrorPagePath = "{$wgServer}{$wgScriptPath}/extensions/examples/ErrorPage";

class NiceErrorPage {
	static function dbConnection( $error ) {
		if ( trim( $error->error ) == '' ) {
			$error->error = $error->db->getProperty('mServer');
		}
		return self::preprocessPage( 'dbconn', array( 'dberror' => $error->error ) );
	}
	
	static function dbQueryError( $error ) {
		$args = array(
			'sql' => $error->getSQL(),
			'function' => $error->fname,
			'errno' => $error->errno,
			'error' => $error->error,
		);
		return self::preprocessPage( 'dberr', $args );
	}

	static function preprocessPage( $name, $args = array() ) {
		$page = file_get_contents( dirname( __FILE__ ) . "/{$name}.html" );
		$args = array_merge( self::commonArgs(), $args );
		foreach( $args as $aname => $aval ) {
			$page = preg_replace( '/{{' . $aname . '}}/i', $aval, $page );
		}
		return $page;
	}

	static function commonArgs() {
		global $wgNiceErrorPagePath, $wgLogo, $wgSitename, $wgServer, $wgScriptPath;
		$a = array(
			'basepath' => $wgNiceErrorPagePath,
			'logo' => $wgLogo,
			'now' => wfTimestamp( TS_RFC2822 ),
			'sitename' => $wgSitename,
			'skins' => "{$wgServer}{$wgScriptPath}/skins",
		);
		return $a;
	}

	static function __call( $method, $args ) {
		$name = str_replace( 'OP', '', $method );
		return $this->$name( $args[0] );
	}
}