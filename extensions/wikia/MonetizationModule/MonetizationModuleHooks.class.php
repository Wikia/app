<?php
/**
 * Monetization Hooks
 */
class MonetizationModuleHooks {

    /**
     * Register monetization-related scripts on top
     *
     * @param array $vars
     * @param array $scripts
     *
     * @return bool
     */
	public static function onWikiaSkinTopScripts( &$vars, &$scripts ) {
        wfProfileIn( __METHOD__ );

        // This hook is registered twice so we're going to check if the
        // script was called before we write it out again
        // TODO: figure out why this hook is registered twice
        $app = F::app();

        if ( $app->wg->MonetizationScriptsLoaded || !MonetizationModuleHelper::canShowModule() ) {
            wfProfileOut( __METHOD__ );
            return true;
        }

        foreach ( AssetsManager::getInstance()->getURL( [ 'monetization_module_top_script_js' ] ) as $script ) {
            $scripts .= '<script src="' . $script . '"></script>';
        }

        $app->wg->MonetizationScriptsLoaded = true;

        wfProfileOut( __METHOD__ );
        return true;
    }

}
