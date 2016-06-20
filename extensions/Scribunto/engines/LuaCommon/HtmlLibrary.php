<?php

class Scribunto_LuaHtmlLibrary extends Scribunto_LuaLibraryBase {
	function register() {
		$this->getEngine()->registerInterface( 'mw.html.lua', array(), array(
			// Prior to 1.26, the Parser sets its prefix as,
			// $this->mUniqPrefix = "\x7f'\"`UNIQ" . self::getRandomString()
			// random part should be hex chars, so we only need the first part here
			'uniqPrefix' => "\x7f'\"`UNIQ",
			'uniqSuffix' => Parser::MARKER_SUFFIX,
		) );
	}
}
