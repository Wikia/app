<?php
if (!defined('MEDIAWIKI')) die();
/**
 * WikiaModern Skin
 *
 * @author Consumer Team
 */

require_once('includes/SkinTemplate.php');

class SkinWikiaModern extends WikiaSkin {
	function __construct() {
		global $wgOut;
		parent::__construct( 'WikiaModernTemplate', 'wikiamodern' );

		$wgOut->addModuleStyles( 'skins.wikiamodern' );

		//non-strict checks of css/js/scss assets/packages
		$this->strictAssetUrlCheck = false;
	}
}


class WikiaModernTemplate extends WikiaSkinTemplate {
	function execute() {
		F::app()->setSkinTemplateObj($this);
		$response = $this->app->sendRequest( 'WikiaModern', 'index' );
		$response->sendHeaders();
		$response->render();
	}
}
?>
