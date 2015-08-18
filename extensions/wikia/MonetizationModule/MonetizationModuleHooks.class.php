<?php
/**
 * Monetization Hooks
 */
class MonetizationModuleHooks {

	/**
	 * Register monetization-related scripts on the top of the page
	 * @param array $jsAssetGroups
	 * @return true
	 */
	public static function onOasisSkinAssetGroupsBlocking( &$jsAssetGroups ) {
		$app = F::app();
		$script = 'monetization_module_top_script_js';
		if ( !WikiaPageType::isCorporatePage() && $app->wg->User->isAnon() && $app->checkSkin( 'oasis' )
			&& !in_array( $script, $jsAssetGroups ) ) {
			$jsAssetGroups[] = $script;
		}

		return true;
	}

}
