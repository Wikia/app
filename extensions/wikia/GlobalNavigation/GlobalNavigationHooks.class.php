<?php

class GlobalNavigationHooks {

	static public function onOutputPageParserOutput( OutputPage &$out, ParserOutput $parseroutput ) {
		global $wgEnableMWSuggest;


		// Global Navigation is always enabled on Venus, so we should disable MW suggest
		if ( F::app()->checkSkin( 'venus' ) ) {
			$wgEnableMWSuggest = false;
		}

		return true;
	}
}
