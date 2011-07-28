<?php
/**
 * SkeleSkin is an experimental playground for new features, not a real skin
 * 
 * @author Jakub Olek <bukaj.kelo(at)gmail.com>
 * @authore Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
if( !defined( 'MEDIAWIKI' ) )
	die( -1 );

class SkinSkeleskin extends SkinTemplate {
	private $app;

	function __construct() {
		parent::__construct();
		$this->app = F::app();
	}

	function initPage( OutputPage $out ) {
		parent::initPage( $out );
		$this->skinname  = 'skeleskin';
		$this->stylename = 'skeleskin';
		$this->template  = 'SkeleSkinTemplate';
		$this->themename = 'skeleskin';
		
		$this->app->registerHook('SkinGetHeadScripts', 'SkinSkeleskin', 'onSkinGetHeadScripts');
		
		$out->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'skins/skeleskin/css/main.scss' ) );
	}

	public function onSkinGetHeadScripts( &$scripts ) {
		foreach ( AssetsManager::getInstance()->getGroupCommonURL( 'skeleskin_js' ) as $src ) {
			$scripts .= "\n<script src=\"{$src}\"></script>";
		}
		
		return true;
	}
	
}

class SkeleSkinTemplate extends QuickTemplate {
	function execute() {
		$response = F::app()->sendRequest( 'SkeleSkinService', 'index' );
		$response->sendHeaders();
		$response->render();
	}
}