<?php
/*
 * Campfire is a Wikia skin for the Amazon Kindle e-book reader
 *
 * still in beta/testing/flux
 *
 * @author Lucas 'TOR' Garczewski <tor@wikia-inc.com>
 */

if( !defined( 'MEDIAWIKI' ) )
	die( -1 );

class SkinCampfire extends WikiaSkin {

	function __construct() {
		parent::__construct( 'CampfireTemplate', 'campfire' );

		//non-strict checks of css/js/scss assets/packages
		$this->strictAssetUrlCheck = false;

		global $IP, $wgAutoloadClasses, $wgExtensionMessagesFiles;
		$dir = dirname( __FILE__ );

		$wgExtensionMessagesFiles['Campfire'] = $IP . '/extensions/wikia/Campfire/Campfire.i18n.php';

		$wgAutoloadClasses['CampfireController'] = $dir . '/campfire/modules/CampfireController.class.php';
		$wgAutoloadClasses['CampfireBodyController'] = $dir . '/campfire/modules/CampfireBodyController.class.php';
		$wgAutoloadClasses['CampfireHeaderController'] = $dir . '/campfire/modules/CampfireHeaderController.class.php';
		$wgAutoloadClasses['CampfireCategoriesController'] = $dir . '/campfire/modules/CampfireCategoriesController.class.php';
		$wgAutoloadClasses['CampfireFooterController'] = $dir . '/campfire/modules/CampfireFooterController.class.php';
	}

	function setupSkinUserCss( OutputPage $out ) {}
}

class CampfireTemplate extends WikiaBaseTemplate {
	function execute() {
		F::app()->setSkinTemplateObj($this);
		$response = $this->app->sendRequest( Wikia::getVar( 'CampfireEntryControllerName', 'Campfire' ), 'index', null, false );
		$response->sendHeaders();
		$response->render();
	}
}