<?php

/**
 * API module to delete contests.
 *
 * @since 0.1
 *
 * @file ApiDeleteContest.php
 * @ingroup Contest
 * @ingroup API
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ApiDeleteContest extends ApiBase {

	public function __construct( $main, $action ) {
		parent::__construct( $main, $action );
	}

	public function execute() {
		if ( !ContestSettings::get( 'contestDeletionEnabled' ) ) {
			$this->dieUsage( 'Contest deletion is disabled', 'contestdeletiondisabled' );
		}
		global $wgUser;

		if ( !$wgUser->isAllowed( 'contestadmin' ) || $wgUser->isBlocked() ) {
			$this->dieUsageMsg( array( 'badaccess-groups' ) );
		}

		$params = $this->extractRequestParams();

		$everythingOk = true;

		foreach ( $params['ids'] as $id ) {
			$contest = new Contest( array( 'id' => $id ) );
			$everythingOk = $contest->removeAllFromDB() && $everythingOk;
		}

		$this->getResult()->addValue(
			null,
			'success',
			$everythingOk
		);
	}

	public function needsToken() {
		return true;
	}

	public function getTokenSalt() {
		$params = $this->extractRequestParams();
		return 'deletecontest' . implode( '|', $params['ids'] );
	}

	public function mustBePosted() {
		return true;
	}

	public function getAllowedParams() {
		return array(
			'ids' => array(
				ApiBase::PARAM_TYPE => 'integer',
				ApiBase::PARAM_REQUIRED => true,
				ApiBase::PARAM_ISMULTI => true,
			),
			'token' => null,
		);
	}

	public function getParamDescription() {
		return array(
			'ids' => 'The IDs of the contests to delete',
			'token' => 'Edit token, salted with the contest id',
		);
	}

	public function getDescription() {
		return array(
			'API module for deleting contests.'
		);
	}

	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
			array( 'code' => 'contestdeletiondisabled', 'info' => 'Contest deletion is disabled' ),
		) );
	}

	public function getExamples() {
		return array(
			'api.php?action=deletecontest&ids=42',
			'api.php?action=deletecontest&ids=4|2',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiDeleteContest.php 100438 2011-10-21 19:05:15Z jeroendedauw $';
	}

}
