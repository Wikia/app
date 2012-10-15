<?php

class ApiUserDailyContribs extends ApiBase {

	public function execute() {
		$params = $this->extractRequestParams();
		$result = $this->getResult();

		$userName = $params['user'];
		$daysago = $params['daysago'];
		$basetimestamp = $params['basetimestamp'];
		$user = User::newFromName( $userName );

		if ( !$user ) {
			$this->dieUsage( 'Invalid username', 'bad_user' );
		}

		global $wgAuth, $wgUserDailyContributionsApiCheckAuthPlugin;

		if ( $wgUserDailyContributionsApiCheckAuthPlugin && !$wgAuth->userExists( $userName ) ) {
			$this->dieUsage( 'Specified user does not exist', 'bad_user' );
		}

		// Defaults to 'now' if not given
		$totime = wfTimestamp( TS_UNIX, $basetimestamp );

		$fromtime = $totime - ($daysago * 60 *60 *24);

		$result->addValue( $this->getModuleName() ,
			'id', $user->getId() );

		// Returns date of registration in YYYYMMDDHHMMSS format
		$result->addValue( $this->getModuleName(),
			'registration', $user->getRegistration() ? $user->getRegistration() : '0' );

		// Returns number of edits between daysago date and basetimestamp (or today)
		$result->addValue( $this->getModuleName(),
			'timeFrameEdits', getUserEditCountSince( $fromtime, $user, $totime ) );

		// Returns total number of edits
		$result->addValue( $this->getModuleName() ,
			'totalEdits', $user->getEditCount() == NULL ? 0 : $user->getEditCount() );
	}

	public function getAllowedParams() {
		return array(
			'user' => array(
				ApiBase::PARAM_TYPE => 'user',
			),
			'daysago' => array(
				ApiBase::PARAM_TYPE => 'integer',
				ApiBase::PARAM_MIN => 0,
			),
			'basetimestamp' => array(
				ApiBase::PARAM_TYPE => 'timestamp',
			),
		);
	}

	public function getParamDescription() {
		return array(
			'user' => 'Username to query',
			'daysago' => 'Number of edits since this many days ago',
			'basetimestamp' => array( 'Date from which daysago will be calculated (instead of "today").',
				'Count returned in timeFrameEdits will be editcount between this date and the date',
				'"daysago" from it.'
			),
		);
	}

	public function getDescription() {
		return 'Get the total number of user edits, time of registration, and edits in a given timeframe';
	}

	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
			array( 'code' => 'bad_user', 'info' => 'Invalid username' ),
			array( 'code' => 'bad_user', 'info' => 'Specified user does not exist' ),
		) );
	}

	public function getExamples() {
		return 'api.php?action=userdailycontribs&user=WikiSysop&daysago=5';
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiUserDailyContribs.php 105267 2011-12-06 01:02:39Z krinkle $';
	}

}