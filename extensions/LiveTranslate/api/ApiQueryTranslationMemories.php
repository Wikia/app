<?php

/**
 * API module to get a list of translation memories.
 *
 * @since 1.2
 *
 * @file ApiQueryLiveTranslate.php
 * @ingroup LiveTranslate
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ApiQueryTranslationMemories extends ApiQueryBase {
	
	public function __construct( $main, $action ) {
		parent :: __construct( $main, $action, 'qtm' );
	}

	/**
	 * Retrieve the specil words from the database.
	 */
	public function execute() {
		// Get the requests parameters.
		$params = $this->extractRequestParams();
		
		$this->addTables( 'live_translate_memories' );
		
		if ( !in_array( 'id', $params ) ) {
			$this->addFields( 'memory_id' );
		}
		
		foreach ( $params['props'] as &$prop ) {
			$prop = "memory_$prop";
		}
		
		$this->addFields( $params['props'] );
		
		if ( count( $params['ids'] ) > 0 ) {
			$this->addWhere( array(
				'memory_id' => $params['ids']
			) );
		}

		if ( !is_null( $params['continue'] ) ) {
			$dbr = wfGetDB( DB_SLAVE );
			$this->addWhere( 'memory_id >= ' . $dbr->addQuotes( $params['continue'] ) );			
		}
		
		$this->addOption( 'LIMIT', $params['limit'] + 1 );
		$this->addOption( 'ORDER BY', 'memory_id ASC' );		
		
		$memories = $this->select( __METHOD__ );
		$resultMemories = array();
		$count = 0;
		
		while ( $memory = $memories->fetchObject() ) {
			if ( ++$count > $params['limit'] ) {
				// We've reached the one extra which shows that
				// there are additional pages to be had. Stop here...
				$this->setContinueEnumParameter( 'continue', $memory->memory_id );
				break;
			}

			$resultMemories[$memory->memory_id] = (array)$memory;
		}
		
		$this->getResult()->setIndexedTagName( $resultMemories, 'memory' );
		
		$this->getResult()->addValue(
			null,
			'memories',
			$resultMemories
		);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see includes/api/ApiBase#getAllowedParams()
	 */
	public function getAllowedParams() {
		return array (
			'props' => array(
				ApiBase::PARAM_DFLT => 'id|type|location|local|lang_count|tu_count|version_hash',
				ApiBase::PARAM_ISMULTI => true,
				ApiBase::PARAM_TYPE => array(
					'id',
					'type',
					'location',
					'local',
					'lang_count',
					'tu_count',
					'version_hash',
				),
			),
			'ids' => array(
				ApiBase::PARAM_DFLT => '',
				ApiBase::PARAM_ISMULTI => true,
				ApiBase::PARAM_TYPE => 'integer',
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
			'props' => 'Translation memory properties to query',
			'ids' => 'Limit the results to translation memories with an ID in this list',
			'continue' => 'Offset number from where to continue the query',
			'limit'   => 'Max amount of words to return',
		);
	}

	/**
	 * (non-PHPdoc)
	 * @see includes/api/ApiBase#getDescription()
	 */
	public function getDescription() {
		return 'This module returns all matching translation memories';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see includes/api/ApiBase#getPossibleErrors()
	 */
	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
		) );
	}	
	
	/**
	 * (non-PHPdoc)
	 * @see includes/api/ApiBase#getExamples()
	 */
	public function getExamples() {
		return array (
			'api.php?action=query&list=translationmemories',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiQueryTranslationMemories.php 94035 2011-08-07 03:09:52Z jeroendedauw $';
	}	
	
}
