<?php
if (!defined('MEDIAWIKI')) die();

class ResourceLoader {

	public static function loadVariableFromPHPFile( $_filename, $_variable ) {
		if ( !file_exists( $_filename ) ) {
			return null;
		} else {
			require( $_filename );
			return isset( $$_variable ) ? $$_variable : null;
		}
	}
}
