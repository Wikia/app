<?php

/**
 * API module to get special words for a language stored by the Live Translate extension.
 *
 * @since 0.2
 *
 * @file ApiQueryLiveTranslate.php
 * @ingroup LiveTranslate
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ApiQueryLiveTranslate extends ApiQueryBase {
	public function __construct( $main, $action ) {
		parent :: __construct( $main, $action, 'lt' );
	}

	/**
	 * Retrieve the specil words from the database.
	 */
	public function execute() {
		// Get the requests parameters.
		$params = $this->extractRequestParams();
		
		if ( !isset( $params['language'] ) ) {
			$this->dieUsageMsg( array( 'missingparam', 'language' ) );
		}			
		
		$this->addTables( 'live_translate' );
		
		$this->addFields( array(
			'word_id',
			'word_translation'
		) );
		
		$this->addWhere( array(
			'word_language' => $params['language']
		) );

		if ( !is_null( $params['continue'] ) ) {
			$dbr = wfGetDB( DB_SLAVE );
			$this->addWhere( 'word_id >= ' . $dbr->addQuotes( $params['continue'] ) );			
		}
		
		$this->addOption( 'LIMIT', $params['limit'] + 1 );
		$this->addOption( 'ORDER BY', 'word_id ASC' );		
		
		$words = $this->select( __METHOD__ );
		$specialWords = array();
		$count = 0;
		
		while ( $word = $words->fetchObject() ) {
			if ( ++$count > $params['limit'] ) {
				// We've reached the one extra which shows that
				// there are additional pages to be had. Stop here...
				$this->setContinueEnumParameter( 'continue', $word->word_id );
				break;
			}

			$specialWords[] = $word->word_translation;
		}
		
		$toggeledSpecials = array();
		
		foreach ( $specialWords as $word ) {
			$toggledWord = LiveTranslateFunctions::getToggledCase( $word );
			
			if ( $toggledWord ) {
				$toggeledSpecials[] = $toggledWord;
			}
		}
		
		foreach ( array_unique( array_merge( $specialWords, $toggeledSpecials ) ) as $word ) {
			$this->getResult()->addValue(
				'words',
				null,
				$word
			);			
		}
	}
	
	/**
	 * (non-PHPdoc)
	 * @see includes/api/ApiBase#getAllowedParams()
	 */
	public function getAllowedParams() {
		return array (
			'language' => array(
				ApiBase::PARAM_TYPE => 'string',
				//ApiBase::PARAM_REQUIRED => true,
			),
			'limit' => array(
				ApiBase :: PARAM_DFLT => 500,
				ApiBase :: PARAM_TYPE => 'limit',
				ApiBase :: PARAM_MIN => 1,
				ApiBase :: PARAM_MAX => ApiBase :: LIMIT_BIG1,
				ApiBase :: PARAM_MAX2 => ApiBase :: LIMIT_BIG2
			),			
			'continue' => null,
		);
	}

	/**
	 * (non-PHPdoc)
	 * @see includes/api/ApiBase#getParamDescription()
	 */
	public function getParamDescription() {
		return array (
			'language' => 'The language for which to return special words',
			'continue' => 'Offset number from where to continue the query',
			'limit'   => 'Max amount of words to return',
		);
	}

	/**
	 * (non-PHPdoc)
	 * @see includes/api/ApiBase#getDescription()
	 */
	public function getDescription() {
		return 'This module returns all special words defined in the wikis Live Translate Dictionary for a given language';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see includes/api/ApiBase#getPossibleErrors()
	 */
	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
			array( 'missingparam', 'language' ),
		) );
	}	
	
	/**
	 * (non-PHPdoc)
	 * @see includes/api/ApiBase#getExamples()
	 */
	public function getExamples() {
		return array (
			'api.php?action=query&list=livetranslate&ltlanguage',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiQueryLiveTranslate.php 93667 2011-08-01 22:47:40Z jeroendedauw $';
	}	
	
}
