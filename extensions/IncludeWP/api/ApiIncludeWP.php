<?php

/**
 * API module to change wikitext into plain text by removing stuff.
 *
 * @since 0.1
 *
 * @file ApiIncludeWP.php
 * @ingroup IncludeWP
 *
 * @licence GNU GPL v3 or later
 *
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ApiIncludeWP extends ApiBase {
	
	
	public function __construct( $main, $action ) {
		parent::__construct( $main, $action );
	}
	
	public function execute() {
		global $egPushLoginUser, $egPushLoginPass, $egPushLoginUsers, $egPushLoginPasswords;
		
		$params = $this->extractRequestParams();
		
		if ( !isset( $params['text'] ) ) {
			$this->dieUsageMsg( array( 'missingparam', 'text' ) );
		}
		
		if ( !isset( $params['pagename'] ) ) {
			$this->dieUsageMsg( array( 'missingparam', 'pagename' ) );
		}		
		
		$plaintext = $params['text'];
		
		// Remove comments.
		$plaintext = preg_replace( '/\\<!--([^(--\\>)]*)--\\>/', '', $plaintext );
		
		// Remove ref tags.
		$plaintext = preg_replace( '/<ref[^>]*\>(.*?)<\/ref>/si', '', $plaintext );
		
		// Replace both internal and external wiki links with their plain text.
		$plaintext = preg_replace( '/\[http(?:s)?:\/\/\S*\s([^\]]*)]/', '$1', $plaintext );
		$plaintext = preg_replace( '/http(?:s)?:\/\/\S*/', '$1', $plaintext );
		$plaintext = preg_replace( '/\[\[(?!(Category|Image|File|[^\s]{2,5}:))[^\|\]]*\|([^\]]*)\]\]/', '$2', $plaintext );
		$plaintext = preg_replace( '/\[\[((?!(Category|Image|File|[^\s]{2,5}:))[^\]]*)\]\]/', '$1', $plaintext ); 		
		
		// Remove categories and files (images).
		$plaintext =  preg_replace( '/\[\[(Category|File|Image|):[^\]]+\]\]/', '', $plaintext );
		
		// Remove inter language links.
		$plaintext =  preg_replace( '/\[\[[^\s]{2,5}:[^\s][^\]]+\]\]/', '', $plaintext );	
		
		for( $i = 3 ; $i > 0; $i-- ) {
			$plaintext = preg_replace( "/\{\{(?:[^\}\{]*)?\}\}/", '', $plaintext );
		}
		
		// Render the wikitext
		$parser = new Parser();
		$options = new ParserOptions();
		$options->setEditSection( false );
		$plaintext = $parser->parse( trim( $plaintext ), Title::newFromText( $params['pagename'] ), $options )->getText();
		
		// Remove excess whitespace
		$plaintext = preg_replace( '/\s\s+/', ' ', $plaintext );
		$plaintext = str_replace( "<p><br />\n</p>", '', $plaintext );
		
		$this->getResult()->addValue(
			null,
			null,
			$plaintext
		);
	}
	
	public function getAllowedParams() {
		return array(
			'text' => array(
				ApiBase::PARAM_TYPE => 'string',
				//ApiBase::PARAM_REQUIRED => true,
			),
			'pagename' => array(
				ApiBase::PARAM_TYPE => 'string',
				//ApiBase::PARAM_REQUIRED => true,
			),			
		);
	}
	
	public function getParamDescription() {
		return array(
			'text' => 'The wikitext',
			'pagename' => 'Name of the page'
		);
	}
	
	public function getDescription() {
		return array(
			'Turns wikitext into plain text by removing stuff.'
		);
	}
		
	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
			array( 'missingparam', 'text' ),
			array( 'missingparam', 'pagename' ),
		) );
	}

	public function getExamples() {
		return array(
			'api.php?action=includewp&text=Some [[wikitext]] be here&pagename=Foobar',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiIncludeWP.php 81538 2011-02-04 20:54:51Z jeroendedauw $';
	}	
	
}
