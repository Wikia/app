<?php
/**
 * Lite Semantics hooks
 *
 * @author Jakub Kurcek <jakub at wikia-inc.com>
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */

class LiteSemanticsHooks extends WikiaObject{
	private $avoidActions = null;

	function __construct(){
		parent::__construct();

		$this->avoidActions = array( 'edit', 'submit' );
	}

	private function canRun(){
		return ( !in_array( $this->wg->Request->getVal( 'action', 'view' ), $this->avoidActions ) );
	}

	public function onInternalParseBeforeLinks( &$parser, &$text ){
		if ( $this->canRun() ) {
			$semanticsDocument = (new LiteSemanticsParser)->parse( $text, $parser->getTitle() );
	
			//give a chance to extensions to alter the data to be stored
			if ( F::app()->runHook( 'LiteSemanticsBeforeProcessDocument', array( &$semanticsDocument ) ) !== false ) {
				//TODO: store in DB/cache goes here
	
				$text = $semanticsDocument->process();
			}
		}

		return true;
	}

	public function onSanitizerTagsLists( &$includeTags, &$excludeTags ){
		if ( $this->canRun() ) {
			$includeTags[] = 'data';
			$includeTags[] = 'prop';
		}

		return true;
	}

	public function onSanitizerAttributesSetup( &$whitelist ){
		if ( $this->canRun() ) {
			if( !array_key_exists( 'data', $whitelist ) ) {
				$whitelist['data'] = array();
			}
	
			$whitelist['data'][] = 'template';
			$whitelist['data'][] = 'id';
	
			if( !array_key_exists( 'prop', $whitelist ) ) {
				$whitelist['prop'] = array();
			}
	
			$whitelist['prop'][] = 'type';
		}

		return true;
	}

	public function onArticleDeleteComplete( &$article, User &$user, $reason, $id ){
		//TODO: clear cache/DB
		return true;
	}

	public function onArticleSaveComplete( &$article, &$user, $text, $summary,
		 $minoredit, $watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId, &$redirect ){
		//TODO: clear cache/DB
		return true;
	}

	//places demo
	public function onLiteSemanticsRenderData( $title, $data, &$output ){
		if ( !empty( $this->wg->EnablePlacesExt ) ) {
			$lat = $data->getProperty( 'lat' );
			$lon = $data->getProperty( 'lon' );
	
			if ( !empty( $lat ) && !empty( $lon ) ) {
				$output = $this->wg->Parser->recursiveTagParse( "<place lat=\"{$lat}\" lon=\"{$lon}\" width=\"300\" zoom=\"16\" />" );
			}
		}

		return true;
	}
}
