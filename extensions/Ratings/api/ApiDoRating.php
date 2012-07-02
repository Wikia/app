<?php

/**
 * API module to rate properties of pages.
 *
 * @since 0.1
 *
 * @file ApiDoRating.php
 * @ingroup Ratings
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ApiDoRating extends ApiBase {
	
	public function __construct( $main, $action ) {
		parent::__construct( $main, $action );
	}
	
	public function execute() {
		$params = $this->extractRequestParams();
		
		global $wgUser;

		if ( !$wgUser->isAllowed( 'rate' ) || $wgUser->isBlocked() 
			/*|| !array_key_exists( 'token', $params ) || !$wgUser->matchEditToken( $params['token'] )*/ ) {
			$this->dieUsageMsg( array( 'badaccess-groups' ) );
		}
		
		// In MW 1.17 and above ApiBase::PARAM_REQUIRED can be used, this is for b/c with 1.16.
		foreach ( array( 'tag', 'pagename', 'value' ) as $requiredParam ) {
			if ( !isset( $params[$requiredParam] ) ) {
				$this->dieUsageMsg( array( 'missingparam', $requiredParam ) );
			}
		}
		
		$page = Title::newFromText( $params['pagename'] );
		
		if ( !$page->exists() ) {
			$this->dieUsageMsg( array( 'notanarticle' ) );
		}
		
		$userText = $wgUser->getName();

		$tagId = $this->getTagId( $params['tag'] );
		$voteId = $this->userAlreadyVoted( $page, $tagId, $userText );

		if ( $voteId === false ) {
			$result = $this->insertRating( $page, $tagId, $params['value'], $userText );
		}
		else {
			$result = $this->updateRating( $voteId, $params['value'] );
		}
		
		if ( $result && $GLOBALS['egRatingsInvalidateOnVote'] ) {
			$page->invalidateCache();
		}
		
		$this->getResult()->addValue(
			'result',
			'success',
			$result
		);
	}
	
	/**
	 * Get the ID for the current tag. 
	 * Makes sure the tag exists by creating it if it doesn't yet.
	 * 
	 * @since 0.1
	 * 
	 * @param string $tagName
	 * 
	 * @return integer
	 */
	protected function getTagId( $tagName ) {
		$dbr = wfGetDB( DB_SLAVE );
		
		$prop = $dbr->selectRow(
			'vote_props',
			array( 'prop_id' ),
			array(
				'prop_name' => $tagName
			)
		);

		if ( $prop ) {
			return $prop->prop_id;
		}
		else {
			$this->createTag( $tagName );
			return $this->getTagId( $tagName );
		}
	}
	
	/**
	 * Insers a new tag.
	 * 
	 * @since 0.1
	 * 
	 * @param string $tagName
	 */
	protected function createTag( $tagName ) {
		$dbw = wfGetDB( DB_MASTER );
		
		$dbw->insert(
			'vote_props',
			array( 'prop_name' => $tagName )
		);
	}
	
	/**
	 * Returns the id of the users vote for the property on this page or
	 * false when there is no such vote yet.
	 * 
	 * @since 0.1
	 * 
	 * @param Title $page
	 * @param integer $tagId
	 * @param string $userText
	 * 
	 * @return false or intger
	 */
	protected function userAlreadyVoted( Title $page, $tagId, $userText ) {
		$dbr = wfGetDB( DB_SLAVE );
		
		$vote = $dbr->selectRow(
			'votes',
			array( 'vote_id' ),
			array(
				'vote_user_text' => $userText,
				'vote_page_id' => $page->getArticleID(),
				'vote_prop_id' => $tagId
			)
		);
		
		return $vote ? $vote->vote_id : false;
	}
	
	/**
	 * Insers a new vote.
	 * 
	 * @since 0.1
	 * 
	 * @param Title $page
	 * @param integer $tagId
	 * @param integer $value
	 * @param string $userText
	 * 
	 * @return boolean
	 */
	protected function insertRating( Title $page, $tagId, $value, $userText ) {
		$dbw = wfGetDB( DB_MASTER );
		
		return $dbw->insert(
			'votes',
			array(
				'vote_user_text' => $userText,
				'vote_page_id' => $page->getArticleID(),
				'vote_prop_id' => $tagId,
				'vote_value' => $value,
				'vote_time' => $dbw->timestamp()
			)
		);
	}
	
	/**
	 * Updates an existing vote with a new value. 
	 * 
	 * @since 0.1
	 * 
	 * @param integer $voteId
	 * @param integer $value
	 * 
	 * @return boolean
	 */
	protected function updateRating( $voteId, $value ) {
		$dbw = wfGetDB( DB_MASTER );
		
		return $dbw->update(
			'votes',
			array(
				'vote_value' => $value,
				'vote_time' => $dbw->timestamp()
			),
			array(
				'vote_id' => $voteId,
			)
		);		
	}	
	
	public function getAllowedParams() {
		return array(
			'tag' => array(
				ApiBase::PARAM_TYPE => 'string',
				//ApiBase::PARAM_REQUIRED => true,
			),
			'pagename' => array(
				ApiBase::PARAM_TYPE => 'string',
				//ApiBase::PARAM_REQUIRED => true,
			),
			'value' => array(
				ApiBase::PARAM_TYPE => 'integer',
				//ApiBase::PARAM_REQUIRED => true,
			),
			'revid' => array(
				ApiBase::PARAM_TYPE => 'integer'
			),			
			'token' => null,			
		);
	}
	
	public function getParamDescription() {
		return array(
			'tag' => 'The tag that is rated',
			'pagename' => 'Name of the page',
			'value' => 'The value of the rating'
		);
	}
	
	public function getDescription() {
		return array(
			'Allows rating a single tag for a single page.'
		);
	}
	
	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
			array( 'badaccess-groups' ),
			array( 'missingparam', 'tag' ),
			array( 'missingparam', 'pagename' ),
			array( 'missingparam', 'value' ),
		) );
	}

	public function getExamples() {
		return array(
			'api.php?action=dorating&pagename=User:Jeroen_De_Dauw&tag=awesomeness&value=9001&token=ABC012',
		);
	}
	
	public function needsToken() {
		return true;
	}	

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiDoRating.php 85996 2011-04-13 22:40:26Z jeroendedauw $';
	}	
	
}
