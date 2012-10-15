<?php

/**
 * API module to get the ratings of a single page.
 * This includes the current total votes, the current avarage
 * and optionally the value of the current users vote.
 *
 * @since 0.1
 *
 * @file ApiQueryRatings.php
 * @ingroup Ratings
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ApiQueryRatings extends ApiQueryBase {
	public function __construct( $main, $action ) {
		parent :: __construct( $main, $action, 'qr' );
	}

	/**
	 * Retrieve the specil words from the database.
	 */
	public function execute() {
		// Get the requests parameters.
		$params = $this->extractRequestParams();
		
		// In MW 1.17 and above ApiBase::PARAM_REQUIRED can be used, this is for b/c with 1.16.
		foreach ( array( 'page' ) as $requiredParam ) {
			if ( !isset( $params[$requiredParam] ) ) {
				$this->dieUsageMsg( array( 'missingparam', $requiredParam ) );
			}
		}
		
		$page = Title::newFromText( $params['page'] );
		
		if ( !$page->exists() ) {
			$this->dieUsageMsg( array( 'notanarticle' ) );
		}
		
		$this->addTables( array( 'votes', 'vote_props' ) );
		
		$this->addJoinConds( array(
			'vote_props' => array( 'LEFT JOIN', array( 'vote_prop_id=prop_id' ) ),
		) );
		
		$this->addFields( array(
			'vote_id',
			'vote_value',
			'vote_time',
			'prop_name'
		) );
		
		$this->addWhere( array(
			'vote_page_id' => $page->getArticleID(),
			'vote_user_text' => isset( $params['user'] ) ? $params['user'] : $GLOBALS['wgUser']->getName()
		) );
		
		if ( !is_null( $params['continue'] ) ) {
			$dbr = wfGetDB( DB_SLAVE );
			$this->addWhere( 'vote_id >= ' . $dbr->addQuotes( $params['continue'] ) );			
		}
		
		$this->addOption( 'LIMIT', $params['limit'] + 1 );
		$this->addOption( 'ORDER BY', 'vote_id ASC' );		
		
		$ratings = $this->select( __METHOD__ );
		$count = 0;
		$limitTags = isset( $params['tags'] );
		
		while ( $rating = $ratings->fetchObject() ) {
			if ( ++$count > $params['limit'] ) {
				// We've reached the one extra which shows that
				// there are additional pages to be had. Stop here...
				$this->setContinueEnumParameter( 'continue', $rating->vote_id );
				break;
			}
			
			if ( !$limitTags || in_array( $rating->prop_name, $params['tags'] ) ) {
				$this->getResult()->addValue(
					'userratings',
					$rating->prop_name,
					(int)$rating->vote_value
				);				
			}
		}
	}
	
	/**
	 * (non-PHPdoc)
	 * @see includes/api/ApiBase#getAllowedParams()
	 */
	public function getAllowedParams() {
		return array (
			'page' => array(
				ApiBase::PARAM_TYPE => 'string',
				//ApiBase::PARAM_REQUIRED => true,
			),
			'user' => array(
				ApiBase::PARAM_TYPE => 'string',
			),
			'limit' => array(
				ApiBase :: PARAM_DFLT => 500,
				ApiBase :: PARAM_TYPE => 'limit',
				ApiBase :: PARAM_MIN => 1,
				ApiBase :: PARAM_MAX => ApiBase :: LIMIT_BIG1,
				ApiBase :: PARAM_MAX2 => ApiBase :: LIMIT_BIG2
			),			
			'continue' => null,
			'tags' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_ISMULTI => true,
			),			
		);
	}

	/**
	 * (non-PHPdoc)
	 * @see includes/api/ApiBase#getParamDescription()
	 */
	public function getParamDescription() {
		return array (
			'page' => 'The page to get rating values for',
			'user' => 'The name of the user to get rating values for',
			'continue' => 'Offset number from where to continue the query',
			'limit'   => 'Max amount of words to return',
			'tags' => 'Can be used to limit the tags for which values are returned'
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
			array( 'missingparam', 'page' ), 
			array( 'missingparam', 'user' )
		) );
	}	
	
	/**
	 * (non-PHPdoc)
	 * @see includes/api/ApiBase#getExamples()
	 */
	public function getExamples() {
		return array (
			'api.php?action=query&list=ratings&qrpage=Main_page&qruser=0:0:0:0:0:0:0:1',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiQueryRatings.php 85996 2011-04-13 22:40:26Z jeroendedauw $';
	}	
	
}
