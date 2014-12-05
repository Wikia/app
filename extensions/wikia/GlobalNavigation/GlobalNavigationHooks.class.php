<?php

class GlobalNavigationHooks {

	static public function onOutputPageParserOutput( OutputPage &$out, ParserOutput $parseroutput ) {
		global $wgEnableMWSuggest;

		if ( F::app()->checkSkin( 'venus' ) ) {
			$wgEnableMWSuggest = false;
		}

		return true;
	}
}
