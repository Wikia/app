<?php

class JSSnippets {

	private $app;

	function __construct() {
		$this->app = F::build('App');
	}

	/**
	 * @brief Returns inline JS snippet
	 *
	 * @param array $dependencies list of JS/CSS/SASS files to be loaded (using $.getResources)
	 * @param array $loaders list of required JS loader functions ($.loadYUI, $.loadJQueryUI, ...)
	 * @param string $callback name of the JS function to be called when dependencies will be loaded
	 * @param array $options set of options to be passed to JS callback
	 * @return string JS snippet
	 *
	 * @description
	 * F::build('JSSnippets')->addToStack(array(
	 *  '/extensions/wikia/Feature/js/Feature.js',
	 *  '/extensions/wikia/Feature/css/Feature.css',
	 *  '/skins/common/jquery/jquery.foo.js'
	 * ),
	 * array(
	 *  '$.loadYUI',
	 *  '$.loadJQueryUI'
	 * ), 'Feature.init');
	 *
	 */
	public function addToStack($dependencies, $loaders = array(), $callback = null, $options = null) {
		wfProfileIn(__METHOD__);

		$entry = array(
			'dependencies' => array(),
			'loaders' => '',
			'callback' => '',
		);

		// add static files
		foreach($dependencies as $dependency) {
			$entry['dependencies'][] = Xml::encodeJsVar($dependency);
		}

		// add libraries loaders / dependency functions
		if (!empty($loaders)) {
			$entry['loaders'] = ',getLoaders:function(){return [' . implode(',', $loaders) . ']}';
		}

		// add callback
		if (!is_null($callback)) {
			$optionsJSON = is_null($options) ? '' : (',options:' . Wikia::json_encode($options));
			$entry['callback'] = ',callback:function(json){' . $callback .'(json)},id:' . Xml::encodeJsVar($callback) . $optionsJSON;
		}

		// generate JS snippet
		$js = Html::inlineScript('JSSnippetsStack.push({'.
			'dependencies:[' . implode(',', $entry['dependencies']) . ']' .
			$entry['loaders'] .
			$entry['callback'] .
			'})');

		wfProfileOut(__METHOD__);
		return $js;
	}

	/**
	 * @brief Adds JS stack for dependencies in <head> section of the page
	 *
	 * @param array $vars list of JS variables in <head> section
	 */
	public function onMakeGlobalVariablesScript($vars) {
		$vars['JSSnippetsStack'] = array();
		return true;
	}

	/**
	 * @brief Loads JSSnippets main JS if there's any item on the stack
	 *
	 * @param Skin $skin MW skin instance
	 * @param string $text content of bottom scripts
	 */
	public function onSkinAfterBottomScripts($skin, &$text) {
		$jsFile = "{$this->app->wg->extensionsPath}/wikia/JSSnippets/js/JSSnippets.js?{$this->app->wg->styleVersion}";
		$text .= Html::inlineScript("if (JSSnippetsStack.length) $.getScript('{$jsFile}');");
		return true;
	}
}