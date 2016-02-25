<?php

class ARecoveryEngineHooks {

	/**
	 * Register recovery related scripts on the top
	 *
	 * @param array $vars
	 * @param array $scripts
	 *
	 * @return bool
	 */
	public static function onWikiaSkinTopScripts( &$vars, &$scripts ) {


		$resourceLoader = new ResourceLoaderAdEngineSourcePointCSBootstrap();
		$resourceLoaderContext = new ResourceLoaderContext( new ResourceLoader(), new FauxRequest());
		$source = $resourceLoader->getScript($resourceLoaderContext);
		$source .= "\nspBootstrap('/api/v1/ARecoveryEngine/delivery', '/api/v1/ARecoveryEngine/message');";
		$scripts = '<script>' . $source . '</script>' . $scripts;

		return true;
	}
}
