<?php

/**
 * This script generates the CSV file with the list of all per-wiki custom user groups
 *
 * @see PLATFORM-1300
 *
 * @author Macbre
 * @ingroup Maintenance
 */

putenv( 'SERVER_ID=1252' ); // run in the context of "starter" wiki, we want to get the default user groups from there

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );

/**
 * Maintenance script class
 */
class ListCustomUserGrousp extends Maintenance {

	// WF variable that stores the custom user groups with permissions
	// use WikiFactoryLoader::parsePermissionsSettings for parsing it
	const WF_GROUP_PERMISSION_LOCAL = 'wgGroupPermissionsLocal';

	private $csv;

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();
		$this->addOption( 'csv', 'File to store the user groups stats' );
		$this->mDescription = 'This script generates the CSV file with the list of all per-wiki custom user groups';
	}

	/**
	 * Get the list of the default groups
	 *
	 * Use starter wiki as a source
	 *
	 * @return array
	 */
	static private function getDefaultGroups() {
		global $wgGroupPermissions;
		return array_keys( $wgGroupPermissions );
	}

	/**
	 * Get the list of wikis that have given WF variable set along with its value
	 *
	 * @param string $varName WF variable name
	 * @return ResultWrapper
	 */
	private function getWikisWithVariableSet( $varName ) {
		$db_wf = WikiFactory::db( DB_SLAVE );

		return $db_wf->select(
			['city_variables', 'city_list'],
			['city_dbname AS dbname, cv_value AS value'],
			['cv_variable_id' => WikiFactory::getVarIdByName( $varName )],
			__METHOD__,
			[
				# 'LIMIT' => 20
			],
			[
				'city_list' => [ 'LEFT JOIN', 'city_variables.cv_city_id = city_list.city_id' ]
			]
		);
	}

	/**
	 * Get "local user group name" => "users in group count" pairs
	 *
	 * @param DatabaseBase $dbr wiki database to get stats for
	 * @param array $localGroups list of local groups to get stats for
	 * @return array
	 */
	private function getLocalUserGroupsStats( DatabaseBase $dbr, $localGroups ) {
		$res = $dbr->select(
			'user_groups',
			['ug_group', 'count(*) as cnt'],
			['ug_group' => $localGroups ],
			__METHOD__,
			['GROUP BY' => 'ug_group']
		);

		$groups = [];
		foreach ( $res as $row ) {
			$groups[ $row->ug_group ] = intval( $row->cnt );
		}

		return $groups;
	}

	/**
	 * Get the user groups statistics for a given wiki and store it in CSV file
	 *
	 * @param string $dbname
	 * @param array $permissionSettings parsed wgGroupPermissionsLocal variable value
	 * @throws DBError
	 */
	private function processWiki( $dbname, array $permissionSettings ) {
		$localGroups = [];

		// filter out global groups and format the rights
		foreach ( $permissionSettings as $groupName => $rights ) {
			// the current group is a local one
			if ( !in_array( $groupName, self::getDefaultGroups() ) ) {
				$localGroups[$groupName] = $rights;
			}
		}

		if ( empty( $localGroups ) ) {
			return;
		}

		$this->output( sprintf( "%s: local groups - %s\n", $dbname, implode( ', ', array_keys( $localGroups ) ) ) );

		// connect to a local wiki database and collect statistics
		$dbr = wfGetDB( DB_SLAVE, [], $dbname );

		$userGroupsStats = $this->getLocalUserGroupsStats( $dbr, array_keys( $localGroups ) );
		foreach ( $userGroupsStats as $groupName => $usersCount ) {
			$this->writeCsvRow( [
				$dbname,
				$groupName,
				$usersCount,
				implode( ',', array_keys( $localGroups[$groupName] ) ) # user group rights
			] );
		}
	}

	private function writeCsvRow( Array $row ) {
		if ( is_resource( $this->csv ) ) {
			fputcsv( $this->csv, $row );
		}
	}

	public function execute() {
		$this->output( sprintf( "Global user groups detected: %s\n\n", implode( ', ', self::getDefaultGroups() ) ) );

		if ( $this->getOption( 'csv' ) ) {
			$this->csv = fopen( $this->getOption( 'csv' ), 'w' );
			fputcsv( $this->csv, [
				'DB name',
				'Group name',
				'Group members',
				'Rights'
			] );
		}

		$res = $this->getWikisWithVariableSet( self::WF_GROUP_PERMISSION_LOCAL );
		foreach ( $res as $row ) {
			try {
				$this->processWiki( $row->dbname, WikiFactoryLoader::parsePermissionsSettings( unserialize( $row->value ) ) );
			}
			catch ( Exception $e ) {
				$this->output( $e->getMessage() . "\n" );
			}
		}

		if ( is_resource( $this->csv ) ) {
			fclose( $this->csv );
		}
	}
}

$maintClass = "ListCustomUserGrousp";
require_once( RUN_MAINTENANCE_IF_MAIN );
