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


class SkinCampfire extends SkinTemplate {

	function __construct() {
		$this->skinname  = 'campfire';
		$this->stylename = 'campfire';
		$this->template  = 'CampfireTemplate';
		$this->themename = 'campfire';

		global $IP, $wgAutoloadClasses, $wgExtensionMessagesFiles;
		$dir = dirname( __FILE__ );

		$wgExtensionMessagesFiles['Campfire'] = $IP . '/extensions/wikia/Campfire/Campfire.i18n.php';

		$wgAutoloadClasses['CampfireModule'] = $dir . '/campfire/modules/CampfireModule.class.php';
		$wgAutoloadClasses['CampfireBodyModule'] = $dir . '/campfire/modules/CampfireBodyModule.class.php';
		$wgAutoloadClasses['CampfireHeaderModule'] = $dir . '/campfire/modules/CampfireHeaderModule.class.php';
		$wgAutoloadClasses['CampfireCategoriesModule'] = $dir . '/campfire/modules/CampfireCategoriesModule.class.php';
		$wgAutoloadClasses['CampfireFooterModule'] = $dir . '/campfire/modules/CampfireFooterModule.class.php';
	}

	function setupSkinUserCss( OutputPage $out ) {}
}

class CampfireTemplate extends QuickTemplate {

	function execute() {
		Module::setSkinTemplateObj($this);


		$entryModuleName = Wikia::getVar( 'CampfireEntryModuleName', 'Campfire' );

		$response = F::app()->sendRequest( $entryModuleName, 'index', null, false );

		$response->sendHeaders();
		$response->render();
	}

}
