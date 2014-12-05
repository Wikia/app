<?php
if (!defined('MEDIAWIKI')) die();
/**
 * Venus Skin
 *
 * @author Consumer Team
 */

class SkinVenus extends WikiaSkin {
	function __construct() {
		global $wgOut;
		parent::__construct( 'VenusTemplate', 'venus' );

		$wgOut->addModuleStyles( 'skins.venus' );

		$this->strictAssetUrlCheck = true;
		$this->pushRLModulesToBottom = true;
	}

	function setupSkinUserCss( OutputPage $out ) {}
}


class VenusTemplate extends WikiaSkinTemplate {
	function execute() {
		F::app()->setSkinTemplateObj($this);
		$response = $this->app->sendRequest( 'Venus', 'index' );
		$response->sendHeaders();
		$response->render();
	}
}
