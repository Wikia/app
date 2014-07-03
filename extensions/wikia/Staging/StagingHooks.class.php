<?php

class StagingHooks {
	/**
	* Register global JS variables bottom
	*
	* @param array $vars
	*
	* @return bool
	*/
	static public function onMakeGlobalVariablesScript( &$vars ) {
		Wikia::addAssetsToOutput( 'extensions/wikia/Staging/js/Staging.js' );
		$vars['wgStagingEnvironment'] = true;

		return true;
	}
}
