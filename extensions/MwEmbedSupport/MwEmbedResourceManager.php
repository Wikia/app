<?php
/**
 * MwEmbedResourceManager adds some convenience functions for loading mwEmbed 'modules'.
 *  Its shared between the mwEmbedStandAlone and the MwEmbed extension
 * 
 * @file
 * @ingroup Extensions
 */

class MwEmbedResourceManager {
	
	protected static $moduleSet = array();
	protected static $moduleConfig = array();
	
	/**
	 * Register mwEmbeed resource set based on the 
	 * 
	 * Adds modules to ResourceLoader
	 */
	public static function register( $mwEmbedResourcePath ) {
		global $IP, $wgExtensionMessagesFiles;
		$localResourcePath = $IP .'/' . $mwEmbedResourcePath;
		// Get the module name from the end of the path: 
		$modulePathParts = explode( '/', $mwEmbedResourcePath );
		$moduleName =  array_pop ( $modulePathParts );
		if( !is_dir( $localResourcePath ) ){
			throw new MWException( __METHOD__ . " not given readable path: "  . htmlspecialchars( $localResourcePath ) );
		}
		
		if( substr( $mwEmbedResourcePath, -1 ) == '/' ){
			throw new MWException(  __METHOD__ . " path has trailing slash: " . htmlspecialchars( $localResourcePath) );
		}
		
		// Add module messages if present: 
		if( is_file( $localResourcePath . '/' . $moduleName . '.i18n.php' ) ){
			$wgExtensionMessagesFiles[ 'MwEmbed.' . $moduleName ] = $localResourcePath . '/' . $moduleName . '.i18n.php';				
		}		
		
		// Check that resource file is present:
		$resourceListFilePath = $localResourcePath . '/' . $moduleName . '.php'; 
		if( !is_file( $resourceListFilePath ) ){
			throw new MWException( __METHOD__ . " mwEmbed Module is missing resource list: "  . htmlspecialchars( $resourceListFilePath ) );
		}
		// Get the mwEmbed module resource registration: 		
		$resourceList = include( $resourceListFilePath );
		
		// Look for special 'messages' => 'moduleFile' key and load all modules file messages:
		foreach( $resourceList as $name => $resources ){
			if( isset( $resources['messageFile'] ) && is_file( $localResourcePath . '/' .$resources['messageFile'] ) ){
				$resourceList[ $name ][ 'messages' ] = array();
				include( $localResourcePath . '/' .$resources['messageFile'] );
				foreach( $messages['en'] as $msgKey => $na ){		
					 $resourceList[ $name ][ 'messages' ][] = $msgKey;
				}
			}
		};
		
		// Check for module loader:
		if( is_file( $localResourcePath . '/' . $moduleName . '.loader.js' )){
			$resourceList[ $moduleName . '.loader' ] = array(
				'loaderScripts' => $moduleName . '.loader.js'
			);
		}
		
		// Check for module config ( @@TODO support per-module config )		
		$configPath =  $localResourcePath . '/' . $moduleName . '.config.php';  
		if( is_file( $configPath ) ){
			self::$moduleConfig = array_merge( self::$moduleConfig, include( $configPath ) );
		}
		
		// Add the resource list into the module set with its provided path 
		self::$moduleSet[ $mwEmbedResourcePath ] = $resourceList;		
	}
	
	public static function registerConfigVars( &$vars ){
		// Allow localSettings.php to override any module config by updating $wgMwEmbedModuleConfig var
		global $wgMwEmbedModuleConfig;
		foreach( self::$moduleConfig as $key => $value ){
			if( ! isset( $wgMwEmbedModuleConfig[ $key ] ) ){
				$wgMwEmbedModuleConfig[$key] = $value;
			}
		}
		$vars = array_merge( $vars, $wgMwEmbedModuleConfig ); 
		return $vars;
	}
	
	/**
	 * ResourceLoaderRegisterModules hook
	 * 
	 * Adds any mwEmbedResources to the ResourceLoader
	 */
	public static function registerModules( &$resourceLoader ) {
		global $IP, $wgEnableMwEmbedStandAlone, $wgScriptPath;
		// Register all the resources with the resource loader
		foreach( self::$moduleSet as $path => $modules ) {
			foreach ( $modules as $name => $resources ) {
				// Register the resource with MwEmbed extended class if in standAlone resource loader mode:
				if( $wgEnableMwEmbedStandAlone === true ){							
					$resourceLoader->register(					
						// Resource loader expects trailing slash: 
						$name, new MwEmbedResourceLoaderFileModule( $resources, "$IP/$path", $path)
					);
				} else {
					// Register with normal resource loader: 
					$resourceLoader->register(					
						// Resource loader expects trailing slash: 
						$name, new ResourceLoaderFileModule( $resources, "$IP/$path", $wgScriptPath .'/' . $path)
					);
				}
			}
		}
		// Continue module processing
		return true;
	}
}