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

$wgExtensionMessagesFiles['Campfire'] = dirname( __FILE__ ) . '/../extensions/wikia/Campfire/Campfire.i18n.php';

class SkinCampfire extends SkinTemplate {

	function __construct() {
		$this->skinname  = 'campfire';
		$this->stylename = 'campfire';
		$this->template  = 'CampfireTemplate';
		$this->themename = 'campfire';
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
