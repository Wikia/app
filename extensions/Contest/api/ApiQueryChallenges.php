<?php

/**
 * API module to get a list of contest challenges.
 *
 * @since 0.1
 *
 * @file ApiQueryChallenges.php
 * @ingroup Contest
 * @ingroup API
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ApiQueryChallenges extends ApiContestQuery {

	/**
	 * (non-PHPdoc)
	 * @see ApiContestQuery::getClassInfo()
	 * @return array
	 */
	protected function getClassInfo() {
		return array(
			'class' => 'ContestChallenge',
			'item' => 'challenge',
			'set' => 'challenges',
		);
	}

	public function __construct( $main, $action ) {
		parent::__construct( $main, $action, 'ch' );
	}

	/**
	 * Handle the API request.
	 * Checks for access rights and then let's the parent method do the actual work.
	 */
	public function execute() {
		global $wgUser;

		if ( !$wgUser->isAllowed( 'contestadmin' ) || $wgUser->isBlocked() ) {
			$this->dieUsageMsg( array( 'badaccess-groups' ) );
		}

		parent::execute();
	}

	/**
	 * (non-PHPdoc)
	 * @see includes/api/ApiBase#getDescription()
	 */
	public function getDescription() {
		return 'API module for querying contest challenges';
	}

	/**
	 * (non-PHPdoc)
	 * @see includes/api/ApiBase#getExamples()
	 */
	public function getExamples() {
		return array (
			'api.php?action=query&list=challenges&chprops=title|text',
			'api.php?action=query&list=challenges&chcontestid=42&chprops=id|contest_id|title',
		);
	}

	/**
	 * (non-PHPdoc)
	 * @see includes/api/ApiBase#getVersion()
	 */
	public function getVersion() {
		return __CLASS__ . ': $Id: ApiQueryChallenges.php 99963 2011-10-16 18:54:51Z reedy $';
	}

}
