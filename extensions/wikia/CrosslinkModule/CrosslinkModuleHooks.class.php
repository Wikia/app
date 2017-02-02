<?php

/**
 * Class CrosslinkModuleHooks
 */
class CrosslinkModuleHooks {

	/**
	 * Insert crosslink module to the right rail
	 * @param array $modules
	 * @return bool
	 */
	public static function onGetRailModuleList( &$modules ) {
		if ( ( new CrosslinkModuleHelper() )->canShowModule() ) {
			$modules[1445] = $modules[1440];
			$modules[1440] = [ 'CrosslinkModule', 'index', null ];

			// remove Recent Wiki Activity module
			unset( $modules[1250] );
		}

		return true;
	}

}
