<?php

/**
 * API module to get a list of commets.
 *
 * @since 0.1
 *
 * @file ApiQueryContestComments.php
 * @ingroup Contest
 * @ingroup API
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ApiQueryContestComments extends ApiContestQuery {

	/**
	 * (non-PHPdoc)
	 * @see ApiContestQuery::getClassInfo()
	 * @return array
	 */
	protected function getClassInfo() {
		return array(
			'class' => 'ContestComment',
			'item' => 'comment',
			'set' => 'comments',
		);
	}

	public function __construct( $main, $action ) {
		parent::__construct( $main, $action, 'coco' );
	}

	/**
	 * Handle the API request.
	 * Checks for access rights and then let's the parent method do the actual work.
	 */
	public function execute() {
		global $wgUser;

		if ( !$wgUser->isAllowed( 'contestjudge' ) || $wgUser->isBlocked() ) {
			$this->dieUsageMsg( array( 'badaccess-groups' ) );
		}

		parent::execute();
	}

	/**
	 * (non-PHPdoc)
	 * @see includes/api/ApiBase#getDescription()
	 */
	public function getDescription() {
		return 'API module for querying contest comments';
	}

	/**
	 * (non-PHPdoc)
	 * @see includes/api/ApiBase#getExamples()
	 */
	public function getExamples() {
		return array (
			'api.php?action=query&list=contestcomments&cocoprops=id|user_id|contestant_id|text',
			'api.php?action=query&list=contestcomments&cocoprops=id|text&cocouser_id=42',
		);
	}

	/**
	 * (non-PHPdoc)
	 * @see includes/api/ApiBase#getVersion()
	 */
	public function getVersion() {
		return __CLASS__ . ': $Id: ApiQueryContestComments.php 99963 2011-10-16 18:54:51Z reedy $';
	}

}
