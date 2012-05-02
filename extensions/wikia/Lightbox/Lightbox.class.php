<?php

class Lightbox {
	
	/**
	 * Add global JS variable indicating this extension is enabled
	 */
	static public function addJSVariable(&$vars) {
		$vars['wgEnableLightboxExt'] = true;
		return true;
	}

}