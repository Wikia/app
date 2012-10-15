<?php

class AutoLinker {

	/**
	 * Add extension's JS, CSS and load messages
	 *
	 * @param EditPageLayoutModule $module edit page module
	 * @return boolean always true
	 */
	public function onEditPageLayoutExecute($module) {
		$app = F::app();

		// add JS and CSS
		$app->wg->Out->addScriptFile($app->wg->ExtensionsPath . '/wikia/hacks/AutoLinker/js/AutoLinkerModule.js');

		// load messages
		F::build('JSMessages')->enqueuePackage('AutoLinker', JSMessages::EXTERNAL);

		return true;
	}
}
