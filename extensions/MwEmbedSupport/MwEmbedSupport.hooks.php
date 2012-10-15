<?php

/**
 * Hooks for MwEmbedSupport extension
 *
 * @file
 * @ingroup Extensions
 */

class MwEmbedSupportHooks {
	// Register MwEmbedSupport Hooks
	static function register(){
		global $wgHooks;
		// Register the core MwEmbed Support Module:
		MwEmbedResourceManager::register( 'extensions/MwEmbedSupport/MwEmbedModules/MwEmbedSupport' );
		
		// Register the MwEmbed 'mediaWiki' Module:
		MwEmbedResourceManager::register( 'extensions/MwEmbedSupport/MwEmbedModules/MediaWikiSupport' );

		// Add mwEmbed Support modules that are not part of startup
		$wgHooks['BeforePageDisplay'][] = 'MwEmbedSupportHooks::UpdatePageModules';
		
		// Add Global MwEmbed Registration hook
		$wgHooks['ResourceLoaderRegisterModules'][] = 'MwEmbedResourceManager::registerModules';
		
		// Add MwEmbed module configuration
		$wgHooks['ResourceLoaderGetConfigVars'][] =  'MwEmbedResourceManager::registerConfigVars';
		
		// Add the startup modules hook	
		$wgHooks['ResourceLoaderGetStartupModules'][] = 'MwEmbedSupportHooks::addStartupModules';
		return true;
	}
	
	/**
	 * Update the page modules to include mwEmbed style
	 * 
	 * TODO look into loading this on-demand instead of all pages. 
	 */
	static function updatePageModules( &$out ){
		$out->addModules( 'mw.MwEmbedSupport.style' );
		return true;		
	}
	
	// Add MwEmbedSupport modules to Startup:
	static function addStartupModules( &$modules ){
		array_push($modules, 'jquery.triggerQueueCallback', 'jquery.loadingSpinner', 'jquery.mwEmbedUtil', 'mw.MwEmbedSupport' );		
		return true;
	}
}