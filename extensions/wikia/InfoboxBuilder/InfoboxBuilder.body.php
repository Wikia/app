<?php

class Scribunto_InfoboxBuilder extends Scribunto_LuaLibraryBase {
	function register() {
		$this->getEngine()->registerInterface( __DIR__ . "/lua/InfoboxBuilder.lua", array(), array() );
	}
}