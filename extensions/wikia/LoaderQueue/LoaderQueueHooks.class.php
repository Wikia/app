<?php

class LoaderQueueHooks extends WikiaController {

	/**
	 * @param array $vars JS variables to be added at the top of the page
	 * @return bool return true - it's a hook
	 */
	public function onWikiaSkinTopScripts(Array &$vars) {
		$vars['wgLoaderQueue'] = array();
		return true;
	}

	/**
	 * Add lazy queue handling in JavaScript
	 *
	 * @param $modules Array
	 * @return bool
	 */
	public static function onResourceLoaderGetStartupModules(&$modules) {
		$modules[] = 'ext.wikia.loaderQueue';
		return true;
	}
}
