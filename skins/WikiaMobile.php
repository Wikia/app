<?php
/**
 * WikiaMobile is an experimental playground for new features, not a real skin
 * 
 * @author Jakub Olek <bukaj.kelo(at)gmail.com>
 * @authore Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
if( !defined( 'MEDIAWIKI' ) )
	die( -1 );

//force HMTL5 compliance
global $wgHtml5;
$wgHtml5 = true;

/**
 * Set filters for JSSnippets
 * Has to be that early as it has to be set
 * before ANY JSSnippet addToStack is called
 */
F::build("JSSnippets")->setFilters("wikiamobile");

class SkinWikiaMobile extends WikiaSkin {
	function __construct() {
		parent::__construct( 'WikiaMobileTemplate', 'wikiamobile' );
	}
}

class WikiaMobileTemplate extends WikiaQuickTemplate {
	function execute() {
		F::build( 'WikiaMobileService' )->setTemplateObject( $this );
		$response = $this->app->sendRequest( 'WikiaMobileService', 'index' );
		$response->sendHeaders();
		$response->render();
	}
}