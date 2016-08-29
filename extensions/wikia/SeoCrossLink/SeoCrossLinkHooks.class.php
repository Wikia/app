<?php

/**
 * Class SeoCrossLinkHooks
 */
class SeoCrossLinkHooks {

	/**
	 * Insert crosslink module to the right rail
	 * @param array $modules
	 * @return bool
	 */
	public static function onGetRailModuleList( &$modules ) {
		if ( (new SeoCrossLinkHelper())->canShowModule() ) {
			$modules[1445] = $modules[1440];
			$modules[1440] = [ 'SeoCrossLink', 'index', null ];
			unset( $modules[1250] );
		}

		return true;
	}

}
