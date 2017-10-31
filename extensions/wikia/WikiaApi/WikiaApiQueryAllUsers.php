<?php

/**
 * A query action to return meta information about the wiki site.
 *
 * @addtogroup API
 */

class WikiaApiQueryAllUsers extends ApiQueryBase {

	private $params = [];

	private $mCityId, $mDB;

	public function __construct( $query, $moduleName ) {
		parent::__construct( $query, $moduleName, 'au' );
	}

	protected function getDB() {
		if ( empty( $this->mDB ) ) {
			global $wgExternalSharedDB;
			$this->mDB = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );
		}

		return $this->mDB;
	}

	public function execute() {
		global $wgCityId;

		$this->params = $this->extractRequestParams();
		$this->mCityId = (int) $wgCityId;

		$prop = $this->params['prop'];
		if ( !is_null( $prop ) ) {
			$prop = array_flip( $prop );
		}

		$this->fld_registration 	= isset( $prop['registration'] );

		$db = $this->getDB();

		$limit = $this->params['limit'];
		$this->addTables( '`user`', 'u1' );

		if ( !is_null( $this->params['from'] ) ) {
			$this->addWhere( 'u1.user_name >= ' . $db->addQuotes( $this->keyToTitle( $this->params['from'] ) ) );
		}

		if ( !is_null( $this->params['prefix'] ) ) {
			$this->addWhere( 'u1.user_name' . $db->buildLike( $this->keyToTitle( $this->params['prefix'] ), $db->anyString() ) );
		}

		$this->addOption( 'LIMIT', $limit + 1 );

		$this->addFields  ( 'u1.user_name, u1.user_id' );
		$this->addFieldsIf( 'u1.user_registration', $this->fld_registration );

		$this->addOption  ( 'ORDER BY', 'u1.user_name' );

		$res = $this->select( __METHOD__ );

		$count = 0;
		$lastUserData = false;
		$lastUser = false;
		$result = $this->getResult();

		while ( true ) {

			$row = $db->fetchObject( $res );
			$count++;

			if ( !$row || $lastUser !== $row->user_name ) {
				// Save the last pass's user data
				if ( is_array( $lastUserData ) ) {
					$fit = $result->addValue( array( 'query', $this->getModuleName() ), null, $lastUserData );
					if ( !$fit ) {
						$this->setContinueEnumParameter( 'from', $this->keyToTitle( $lastUserData['name'] ) );
						break;
					}
				}

				// No more rows left
				if ( !$row ) {
					break;
				}

				if ( $count > $limit ) {
					// We've reached the one extra which shows that there are additional pages to be had. Stop here...
					$this->setContinueEnumParameter( 'from', $this->keyToTitle( $row->user_name ) );
					break;
				}

				// Record new user's data
				$lastUser = $row->user_name;
				$lastUserData = array( 'name' => $lastUser, 'id' => $row->user_id );

				if ( $this->fld_registration ) {
					$lastUserData['registration'] = wfTimestamp( TS_ISO_8601, $row->user_registration );
				}
			}

		}

		$db->freeResult( $res );

		$result->setIndexedTagName_internal( array( 'query', $this->getModuleName() ), 'u' );
	}

	protected function getAllowedParams() {
		return [
			'from' => null,
			'to' => null,
			'prefix' => null,
			'dir' => [
				ApiBase::PARAM_DFLT => 'ascending',
				ApiBase::PARAM_TYPE => [
					'ascending',
					'descending',
				],
			],
			'prop' => [
				ApiBase::PARAM_ISMULTI => true,
				ApiBase::PARAM_TYPE => [
					'registration',
				],
			],
			'limit' => [
				ApiBase::PARAM_DFLT => 10,
				ApiBase::PARAM_TYPE => 'limit',
				ApiBase::PARAM_MIN => 1,
				ApiBase::PARAM_MAX => ApiBase::LIMIT_BIG1,
				ApiBase::PARAM_MAX2 => ApiBase::LIMIT_BIG2,
			],
		];
	}

	protected function getParamDescription() {
		return [
			'from' => 'The user name to start enumerating from',
			'to' => 'The user name to stop enumerating at',
			'prefix' => 'Search for all users that begin with this value',
			'dir' => 'Direction to sort in',
			'group' => 'Limit users to given group name(s)',
			'prop' => [
				'What pieces of information to include.',
				' registration   - Adds the timestamp of when the user registered if available (may be blank)',
			],
			'limit' => 'How many total user names to return',
		];
	}

	public function getCacheMode( $params ) {
		return 'anon-public-user-private';
	}

	public function getDescription() {
		return 'Enumerate all registered users';
	}

	public function getExamples() {
		return array(
			'api.php?action=query&list=allusers&aufrom=Y',
		);
	}

	public function getHelpUrls() {
		return 'https://www.mediawiki.org/wiki/API:Allusers';
	}

	public function getVersion() {
		return __CLASS__ . ': $Id$';
	}
}
