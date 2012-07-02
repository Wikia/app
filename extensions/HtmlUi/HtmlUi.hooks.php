<?php
/**
 * Hooks for HtmlUi extension
 * 
 * @file
 * @ingroup Extensions
 */

class HtmlUiHooks {
	
	/* Protected Static Members */
	
	protected static $modules = array(
		'ext.htmlUi' => array(
			'scripts' => 'ext.htmlUi.js',
			'styles' => 'ext.htmlUi.css',
			'group' => 'ext.htmlUi',
		),
	);
	
	/* Static Methods */
	
	/**
	 * ResourceLoaderRegisterModules hook.
	 * 
	 * Adds modules to ResourceLoader.
	 */
	public static function resourceLoaderRegisterModules( &$resourceLoader ) {
		global $wgExtensionAssetsPath;
		$localpath = dirname( __FILE__ ) . '/modules';
		$remotepath = "$wgExtensionAssetsPath/HtmlUi/modules";
		foreach ( self::$modules as $name => $resources ) {
			$resourceLoader->register(
				$name, new ResourceLoaderFileModule( $resources, $localpath, $remotepath )
			);
		}
		return true;
	}
}
