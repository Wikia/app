<?php

/**
 * Class SeoCrossLinkHooks
 */
class SeoCrossLinkHooks {

	/**
	 * Insert cross link module to the right rail
	 * @param array $modules
	 * @return bool
	 */
	static public function onGetRailModuleList( &$modules ) {

		$helper = new SeoCrossLinkHelper();
		if ( $helper->canShowModule() ) {
			$modules[1250] = [ 'SeoCrossLink', 'index', null ];
		}

		return true;
	}

}
