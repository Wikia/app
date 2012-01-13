<?php
class LiteSemanticsHooks extends WikiaObject{

	public function onInternalParseBeforeLinks( $oParser, $sText, $mStripState ){

		/* Shazam - parser magic */

		return true;
	}
}
