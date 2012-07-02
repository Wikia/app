<?php

class ParserPlaygroundHooks {
	public static function editPageShowEditFormInitial( &$toolbar ) {
		global $wgOut;
		$wgOut->addModules( 'ext.parserPlayground' );
		return true;
	}
}
