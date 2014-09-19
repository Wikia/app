<?php

class Scribunto_LuaHtmlLibrary extends Scribunto_LuaLibraryBase {
	function register() {
		$this->getEngine()->registerInterface( 'mw.html.lua', array() );
	}
}
