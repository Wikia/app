<?php

/**
 * JS Snippets main class
 *
 * @author macbre
 */
class JSSnippets {
	const resourceRegex = '/\.(css|scss|js)$/i';
	const urlRegex = '/^http[s]?:\/\//i';
	const cbRegex = '/\?cb=[0-9]+$/i';

	/**
	 * @brief Returns inline JS snippet
	 *
	 * @param mixed $dependencies a string containing an asset path or an AssetsManager package name
	 * or list of of them as an array, to be loaded (using $.getResources)
	 * @param array $loaders list of required JS loader functions ($.loadYUI, $.loadJQueryUI, ...)
	 * @param string $callback name of the JS function to be called when dependencies will be loaded
	 * @param array $options set of options to be passed to JS callback
	 * @return string JS snippet
	 * @throws WikiaException
	 *
	 * @description
	 * ( new JSSnippets )->addToStack(array(
	 *	'my_ext_js_package',
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

	static public function addToStack( $dependencies, $loaders = array(), $callback = null, $options = null ) {
		global $wgArticleAsJson, $wgForumMigration;
		$js = "";

		// HG-97: Don't include script tags when the article is requested as Json or it is forum migration dump
		if ( !empty( $wgArticleAsJson ) || !empty($wgForumMigration) ) {
			return $js;
		}
		
		wfProfileIn( __METHOD__ );
		
		$assetsManager = AssetsManager::getInstance();
		$skin = RequestContext::getMain()->getSkin();
		$isWikiaSkin = ( $skin instanceof WikiaSkin );

		$entry = array(
			'dependencies' => array(),
			'loaders' => '',
			'callback' => '',
		);

		//allow same format of first parameter as in WikiaResponse::addAsset and AssetsManager::getURL
		if ( !is_array( $dependencies ) ) {
			$dependencies = array( $dependencies );
		}

		// add static files
		foreach ( $dependencies as $dependency ) {
			$isURL = ( preg_match( self::urlRegex, $dependency ) > 0 || preg_match( self::cbRegex, $dependency ) > 0);
			$isResource = ( !$isURL && ( preg_match( self::resourceRegex, $dependency ) > 0 ) );//run after url check since is a subset

			if ( !( $isURL || $isResource ) ) {
				//an AssetsManager package name
				$type = null;
				$assets = $assetsManager->getURL( $dependency, $type );

				switch ( $type ) {
					case AssetsManager::TYPE_CSS:
					case AssetsManager::TYPE_SCSS:
						$type = 'css';
						break;
					case AssetsManager::TYPE_JS:
						$type = 'js';
						break;
					default:
						throw new WikiaException( 'unknown package type' );
				}

				foreach ( $assets as $dep ) {
					if ( !$isWikiaSkin || $assetsManager->checkAssetUrlForSkin( $dep, $skin ) ) {
						$d = new stdClass();
						$d->url = $dep;
						$d->type = $type;

						$entry['dependencies'][] = Xml::encodeJsVar( $d );
					}
				}
			} elseif ( !$isWikiaSkin || $assetsManager->checkAssetUrlForSkin( $dependency, $skin ) ) {
				$entry['dependencies'][] = Xml::encodeJsVar( $dependency );
			}
		}

		// add libraries loaders / dependency functions
		if ( !empty( $loaders ) ) {
			$entry['loaders'] = ',getLoaders:function(){return [' . implode( ',', $loaders ) . ']}';
		}

		if ( empty( $entry['dependencies'] ) && empty( $entry['loaders'] ) ) {
			wfProfileOut( __METHOD__ );
			return $js;
		}

		// add callback
		if (!is_null($callback)) {
			$optionsJSON = is_null($options) ? '' : (',options:' . json_encode($options));
			$entry['callback'] = ',callback:function(json){' . $callback .'(json)},id:' . Xml::encodeJsVar($callback) . $optionsJSON;
		}

		// generate JS snippet
		$js = Html::inlineScript('JSSnippetsStack.push({'.
			'dependencies:[' . implode(',', $entry['dependencies']) . ']' .
			$entry['loaders'] .
			$entry['callback'] .
		'})');

		wfProfileOut( __METHOD__ );
		return $js;
	}

	/**
	 * @brief Adds JS stack for dependencies in <head> section of the page
	 *
	 * @param array $vars list of JS variables in <head> section
	 * @return bool
	 */
	static public function onMakeGlobalVariablesScript(Array &$vars) {
		$vars['JSSnippetsStack'] = array();
		return true;
	}
}
