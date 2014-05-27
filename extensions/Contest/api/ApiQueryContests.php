<?php

/**
 * API module to get a list of contests.
 *
 * @since 0.1
 *
 * @file ApiQueryContests.php
 * @ingroup Contest
 * @ingroup API
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ApiQueryContests extends ApiContestQuery {

	/**
	 * (non-PHPdoc)
	 * @see ApiContestQuery::getClassInfo()
	 * @return array
	 */
	protected function getClassInfo() {
		return array(
			'class' => 'Contest',
			'item' => 'contest',
			'set' => 'contests',
		);
	}

	public function __construct( $main, $action ) {
		parent::__construct( $main, $action, 'co' );
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
		return 'API module for querying contests';
	}

	/**
	 * (non-PHPdoc)
	 * @see includes/api/ApiBase#getExamples()
	 */
	public function getExamples() {
		return array (
			'api.php?action=query&list=contests&coprops=id|name',
			'api.php?action=query&list=contests&costatus=1',
		);
	}

	/**
	 * (non-PHPdoc)
	 * @see includes/api/ApiBase#getVersion()
	 */
	public function getVersion() {
		return __CLASS__ . ': $Id: ApiQueryContests.php 99963 2011-10-16 18:54:51Z reedy $';
	}

}
