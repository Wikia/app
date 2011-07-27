<?php
if( !defined( 'MEDIAWIKI' ) )
	die( -1 );


class SkinSkeleskin extends SkinTemplate {

	function __construct() {
		parent::__construct();
	}

	function initPage( OutputPage $out ) {
		parent::initPage( $out );
		$this->skinname  = 'skeleskin';
		$this->stylename = 'skeleskin';
		$this->template  = 'SkeleSkinTemplate';
		$this->themename = 'skeleskin';
		
		// register templates
		global $wgWikiaTemplateDir;
		$dir = dirname( __FILE__ ) . '/';
		$wgWikiaTemplateDir['SharedTemplates'] = $dir.'skeleskin';
		
		foreach ( AssetsManager::getInstance()->getGroupCommonURL( 'skeleskin_css' ) as $src ) {
			$out->addStyle( $src );
		}

		
	}


	
	public function onSkinGetHeadScripts(&$scripts) {
		
		foreach ( AssetsManager::getInstance()->getGroupCommonURL( 'skeleskin_js' ) as $src ) {
			$scripts .= "\n<script src=\"{$src}\"></script>";
		}
		
		return true;
	}
	
}

class SkeleSkinTemplate extends QuickTemplate {

	function execute() {
		global $wgOut;
		
		$response = F::app()->sendRequest( 'SkeleSkinService', 'index' );

		$response->sendHeaders();
		$response->render();
	}

}