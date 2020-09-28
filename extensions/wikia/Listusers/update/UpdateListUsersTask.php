<?php

use Wikia\Tasks\Tasks\BaseTask;

class UpdateListUsersTask extends BaseTask {
	const EVENTS_LOCAL_USERS = 'events_local_users';

	/** @var DatabaseBase $writeConnection */
	private $writeConnection;

	/** @var EditCountService $editCountService */
	private $editCountService;

	public function __construct( EditCountService $editCountService = null ) {
		$this->editCountService = $editCountService ?? new EditCountService();
	}

	public function updateEditInformation( array $editUpdateInfo ) {
		$editUpdate = ListUsersEditUpdate::newFromJson( $editUpdateInfo );
		$wikiId = $this->getWikiId();
		$userId = $editUpdate->getUserId();

		$editCount = $this->editCountService->getEditCount( $userId );

		$userGroups = $editUpdate->getUserGroups();
		$groupCount = count( $userGroups );

		$primaryKey = [ 'wiki_id', 'user_id' ];

		$rowToInsert = [
			'wiki_id' => $wikiId,
			'user_id' => $userId,
			'edits' => $editCount,
			'editdate' => wfTimestamp( TS_DB, $editUpdate->getLatestRevisionTimestamp() ),
			'last_revision' => $editUpdate->getLatestRevisionId(),
			'cnt_groups' => $groupCount,
			'single_group' => $groupCount ? $userGroups[$groupCount - 1] : '',
			'all_groups' => implode( ';', $userGroups ),
			'user_is_closed' => 0
		];

		$fieldsToUpdate = array_diff_key( $rowToInsert, array_flip( $primaryKey ) );

		$this->writeConnection()->upsert(
			static::EVENTS_LOCAL_USERS,
			[ $rowToInsert ],
			[ $primaryKey ],
			$fieldsToUpdate,
			__METHOD__
		);
		$this->updateUserGroupsTable( $wikiId, $userId, $userGroups );
	}

	public function updateUserGroups( array $updateInfo ) {
		$groupsUpdate = ListUsersUpdate::newFromJson( $updateInfo );

		$wikiId = $this->getWikiId();
		$userId = $groupsUpdate->getUserId();

		$userGroups = $groupsUpdate->getUserGroups();
		$groupCount = count( $userGroups );

		$updatedFields = [
			'cnt_groups' => $groupCount,
			'single_group' => $groupCount ? $userGroups[$groupCount - 1] : '',
			'all_groups' => implode( ';', $userGroups ),
		];

		$this->updateUserGroupsTable( $wikiId, $userId, $userGroups );

		// If a row already exists for this user and this wiki, a cheap UPDATE operation is sufficient
		$this->writeConnection()->update(
			static::EVENTS_LOCAL_USERS,
			$updatedFields,
			[ 'wiki_id' => $wikiId, 'user_id' => $userId ],
			__METHOD__
		);

		// No row exists yet for this user, so create one
		if ( !$this->writeConnection()->affectedRows() ) {
			$dbr = wfGetDB( DB_SLAVE );

			$editCount = $this->editCountService->getEditCount( $userId );

			$lastEdit = $dbr->selectRow(
				'revision',
				[ 'max(rev_id) AS revision_id', 'max(rev_timestamp) AS timestamp' ],
				[ 'rev_user' => $userId ],
				__METHOD__
			);

			$row = [
				'wiki_id' => $wikiId,
				'user_id' => $userId,
				'edits' => $editCount,
				'editdate' => $lastEdit ? wfTimestamp( TS_DB, $lastEdit->timestamp ) : '',
				'last_revision' => $lastEdit ? $lastEdit->revision_id : 0,
				'cnt_groups' => $groupCount,
				'single_group' => $groupCount ? $userGroups[$groupCount - 1] : '',
				'all_groups' => implode( ';', $userGroups ),
				'user_is_closed' => 0
			];

			$this->writeConnection()->insert( static::EVENTS_LOCAL_USERS, [ $row ], __METHOD__ );
		}
	}

	private function updateUserGroupsTable( int $wikiId, int $userId, array $groups ): void {
		$dbw = $this->writeConnection();
		$dbw->delete( 'local_user_groups', [ 'user_id' => $userId, 'wiki_id' => $wikiId ] );

		$groupRows = array_map( function ( $group ) use ( $wikiId, $userId ) {
			return [
				'user_id' => $userId,
				'wiki_id' => $wikiId,
				'group_name' => $group,
			];
		}, $groups );
		$dbw->insert( 'local_user_groups', $groupRows );
	}

	private function writeConnection(): DatabaseBase {
		if ( $this->writeConnection == null ) {
			global $wgSpecialsDB;
			$this->writeConnection = wfGetDB( DB_MASTER, [], $wgSpecialsDB );
		}

		return $this->writeConnection;
	}
}
