<?php
/**
 * Functions useful to extensions, which work regardless of the version of the MediaWiki core
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This file is part of MediaWiki, it is not a valid entry point.\n";
	exit( 1 );
}

if ( !defined( 'MW_SPECIALPAGE_VERSION' ) ) {
	/**
	 * Equivalent of wfCreateObject
	 */
	function extCreateObject( $name, $p ) {
		$p = array_values( $p );
		switch ( count( $p ) ) {
			case 0:
				return new $name;
			case 1:
				return new $name( $p[0] );
			case 2:
				return new $name( $p[0], $p[1] );
			case 3:
				return new $name( $p[0], $p[1], $p[2] );
			case 4:
				return new $name( $p[0], $p[1], $p[2], $p[3] );
			case 5:
				return new $name( $p[0], $p[1], $p[2], $p[3], $p[4] );
			case 6:
				return new $name( $p[0], $p[1], $p[2], $p[3], $p[4], $p[5] );
			default:
				wfDebugDieBacktrace( "Too many arguments to constructor in extCreateObject" );
		}
	}

	class SetupSpecialPage {
		function __construct( $file, $name, $params ) {
			$this->file = $file;
			$this->name = $name;
			$this->params = $params;
		}

		function setup() {
			global $IP;
			require_once( "$IP/includes/SpecialPage.php" );
			require_once( $this->file );
			if ( !is_array( $this->params ) ) {
				$this->params = array( $this->params );
			}
			$className = array_shift( $this->params );
			$obj = extCreateObject( $className, $this->params );
			SpecialPage::addPage( $obj );
		}
	}

	function extAddSpecialPage( $file, $name, $params ) {
		global $wgExtensionFunctions;
		$setup = new SetupSpecialPage( $file, $name, $params );
		$wgExtensionFunctions[] = array( &$setup, 'setup' );
	}
} else {
	/**
	 * Add a special page
	 *
	 * @param string $file Filename containing the derived class
	 * @param string $name Name of the special page
	 * @param mixed $params Name of the class, or array containing class name and constructor params
	 * @deprecated Use $wgSpecialPages and $wgAutoloadClasses
	 */
	function extAddSpecialPage( $file, $name, $params ) {
		global $wgSpecialPages, $wgAutoloadClasses;
		if ( !is_array( $params ) ) {
			$className = $params;
		} else {
			$className = $params[0];
		}
		$wgSpecialPages[$name] = $params;
		$wgAutoloadClasses[$className] = $file;
	}
}

