<?php

class WallRailHelper {

	/**
	 * @brief Hooks into GetRailModuleList
	 *
	 * @return boolean true
	 */
	public static function onGetRailModuleList( &$modules ) {
		$app = F::App();
		wfProfileIn( __METHOD__ );

		$namespace = $app->wg->Title->getNamespace();

		if ( !BodyController::isEditPage()
			&& $namespace === NS_USER_WALL
			&& !$app->wg->Title->isSubpage()
		) {
			// we want only chat, achivements and following pages
			$remove = [ 1250, 1450, 1300, 1150 ];
			foreach ( $remove as $rightRailEl ) {
				if ( !empty( $modules[$rightRailEl] ) ) {
					unset( $modules[$rightRailEl] );
				}
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

}
