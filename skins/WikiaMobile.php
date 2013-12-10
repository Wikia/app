<?php
/**
 * WikiaMobile is a real skin, not an experimental playground for new features
 * 
 * @author Jakub Olek <bukaj.kelo(at)gmail.com>
 * @authore Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
if( !defined( 'MEDIAWIKI' ) )
	die( -1 );

//force HMTL5 compliance
global $wgHtml5;
$wgHtml5 = true;

class SkinWikiaMobile extends WikiaSkin {
	function __construct() {
		parent::__construct( 'WikiaMobileTemplate', 'wikiamobile' );
	}

	/*
	 * This is due Wikiamobile needs a lot less global variables
	 * having separate getTopScripts allows for less injecting itself into  WikiaSkin
	 */
	function getTopScripts( $globalVariables = [] ){
		$vars = [];
		$scripts = '';

		$globalVariables['Wikia'] = new StdClass();

		//this is run to grab all global variables
		wfRunHooks( 'WikiaSkinTopScripts', [ &$vars, &$scripts, $this ] );
		//send list of supported videos so we can treat not supported ones differently
		$globalVariables['supportedVideos'] = $this->wg->WikiaMobileSupportedVideos;


		//global variables
		//from Output class
		//and from ResourceLoaderStartUpModule
		$res = new ResourceVariablesGetter();
		$vars = array_intersect_key(
			$this->wg->Out->getJSVars() + $res->get() + $vars,
			array_flip( $this->wg->WikiaMobileIncludeJSGlobals )
		);

		return WikiaSkin::makeInlineVariablesScript( $vars + $globalVariables ) . $scripts;
	}
}

class WikiaMobileTemplate extends WikiaSkinTemplate {
	function execute() {
		$this->app->setSkinTemplateObj( $this );
		$response = $this->app->sendRequest( 'WikiaMobileService', 'index' );
		$response->sendHeaders();
		$response->render();
	}
}
