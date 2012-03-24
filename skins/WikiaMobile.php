<?php
/**
 * WikiaMobile is an experimental playground for new features, not a real skin
 * 
 * @author Jakub Olek <bukaj.kelo(at)gmail.com>
 * @authore Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
if( !defined( 'MEDIAWIKI' ) )
	die( -1 );
	
/**
 * Set filters for JSSnippets
 * Has to be that early as it has to be set
 * before ANY JSSnippet addToStack is called
 */
F::build("JSSnippets")->setFilters("wikiamobile");
		
class SkinWikiaMobile extends SkinTemplate {
	private $app;

	function __construct() {
		parent::__construct();
		
		$this->skinname  = 'wikiamobile';
		$this->stylename = 'wikiamobile';
		$this->template  = 'WikiaMobileTemplate';
		$this->themename = 'wikiamobile';
		$this->app = F::app();
	}
}

class WikiaMobileTemplate extends QuickTemplate {
	private $app;
	
	function __construct(){
		parent::__construct();
		$this->app = F::app();
		
	}
	
	function execute() {
		Module::setSkinTemplateObj($this);

		$this->app->sendRequest( 'WikiaMobileService', 'setTemplateObject', array( 'templateObject' => $this ) );
		
		$response = $this->app->sendRequest( 'WikiaMobileService', 'index' );
		$response->sendHeaders();
		$response->render();
	}
}