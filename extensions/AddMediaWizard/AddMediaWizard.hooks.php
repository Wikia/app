<?php 
/**
 * Hooks for AddMediaWizard extension
 * 
 * @file
 * @ingroup Extensions
 */

class AddMediaWizardHooks {
	// Register TimedMediaHandler Hooks
	static function register(){
		global $wgHooks, $wgResourceModules;
		$wgHooks['EditPageBeforeEditToolbar'][] = 'AddMediaWizardHooks::addWikiEditorHookJS';
		
		
		$baseExtensionResource = array(
			'localBasePath' => dirname( __FILE__ ),
		 	'remoteExtPath' => 'AddMediaWizard',
		);
				
		$wgResourceModules+= array(
			'AddMediaWizardEditPage' => $baseExtensionResource + array(
				'scripts' => 'resources/AddMediaWizardEditPage.js',
				'messages' => array( 'addmediawizard-loading' )
			)
		);
	}
	static function addWikiEditorHookJS(){
		global $wgOut;
		// Add the AMWEditPage activator to the edit page in the "page" script bucket
		$wgOut->addModules( 'AddMediaWizardEditPage' );
		return true;
	}
}