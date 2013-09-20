<?php

class LoaderQueueHooks  {

	/**
	 * @param array $vars JS variables to be added at the top of the page
	 * @return bool return true - it's a hook
	 */
	static public function onWikiaSkinTopScripts(Array &$vars) {
		$vars['wgLoaderQueue'] = array();
		F::app()->wg->Out->addModules('ext.wikia.loaderQueue');
		return true;
	}
}
