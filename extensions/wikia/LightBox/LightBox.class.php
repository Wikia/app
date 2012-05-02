<?php

class LightBox {
	
	/**
	 * Add global JS variable indicating this extension is enabled
	 */
	static public function addJSVariable(&$vars) {
		$vars['wgEnableLightBoxExt'] = true;
		return true;
	}

}