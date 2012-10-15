<?php

/**
 * API module to get a list of contestants.
 *
 * @since 0.1
 *
 * @file ApiQueryContestants.php
 * @ingroup Contest
 * @ingroup API
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ApiQueryContestants extends ApiContestQuery {

	/**
	 * (non-PHPdoc)
	 * @see ApiContestQuery::getClassInfo()
	 * @return array
	 */
	protected function getClassInfo() {
		return array(
			'class' => 'ContestContestant',
			'item' => 'contestant',
			'set' => 'contestants',
		);
	}

	public function __construct( $main, $action ) {
		parent::__construct( $main, $action, 'ct' );
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
		return 'API module for querying contestants';
	}

	/**
	 * (non-PHPdoc)
	 * @see includes/api/ApiBase#getExamples()
	 */
	public function getExamples() {
		return array (
			'api.php?action=query&list=contestants&ctprops=id|user_id|contest_id|rating',
			'api.php?action=query&list=contestants&ctprops=id|rating&ctcontest_id=42',
		);
	}

	/**
	 * (non-PHPdoc)
	 * @see includes/api/ApiBase#getVersion()
	 */
	public function getVersion() {
		return __CLASS__ . ': $Id: ApiQueryContestants.php 99963 2011-10-16 18:54:51Z reedy $';
	}

}
