<?php

/**
 * Constructs SQL query segments for certain constraints affecting revisions
 */
class DplRevisionQuerySegmentBuilder {
	/** @var DatabaseBase $databaseConnection */
	private $databaseConnection;

	/** @var DplTableSet $dplTableSet */
	private $dplTableSet;

	public function __construct( DatabaseBase $databaseConnection ) {
		$this->databaseConnection = $databaseConnection;
	}

	/**
	 * Specify the {@see DplTableSet} instance that will hold the tables and aliases
	 * added by the query segments build by this instance.
	 *
	 * @param DplTableSet $dplTableSet
	 * @return DplRevisionQuerySegmentBuilder
	 */
	public function tableSet( DplTableSet $dplTableSet ): DplRevisionQuerySegmentBuilder {
		$this->dplTableSet = $dplTableSet;
		return $this;
	}

	/**
	 * Construct an SQL query segment that will match only revisions created by the given user
	 * @param array $userArray An array with either an user_text entry or an user_id entry
	 * @return string the SQL query segment
	 */
	public function buildCreatedByQuerySegment( array $userArray ): string {
		if ( empty( $userArray ) ) {
			return '';
		}

		$this->dplTableSet->addTableAlias( 'revision', 'creation_rev' );

		if ( isset( $userArray['user_text'] ) ) {
			$userText = $this->databaseConnection->addQuotes( $userArray['user_text'] );
			$sqlQuerySegment = "AND creation_rev.rev_user_text = $userText";
		} else {
			$userId = $this->databaseConnection->addQuotes( $userArray['user_id'] );
			$sqlQuerySegment = "AND creation_rev.rev_user = $userId";
		}

		$sqlQuerySegment .= ' AND creation_rev.rev_page = page_id';
		$sqlQuerySegment .= ' AND creation_rev.rev_parent_id = 0';

		return " $sqlQuerySegment";
	}

	/**
	 * Construct an SQL query segment that will match only revisions NOT created by the given user
	 * @param array $userArray An array with either an user_text entry or an user_id entry
	 * @return string the SQL query segment
	 */
	public function buildNotCreatedByQuerySegment( array $userArray ): string {
		if ( empty( $userArray ) ) {
			return '';
		}

		$this->dplTableSet->addTableAlias( 'revision', 'no_creation_rev' );

		if ( isset( $userArray['user_text'] ) ) {
			$userText = $this->databaseConnection->addQuotes( $userArray['user_text'] );
			$sqlQuerySegment = "AND no_creation_rev.rev_user_text != $userText";
		} else {
			$userId = $this->databaseConnection->addQuotes( $userArray['user_id'] );
			$sqlQuerySegment = "AND no_creation_rev.rev_user != $userId";
		}

		$sqlQuerySegment .= ' AND no_creation_rev.rev_page = page_id';
		$sqlQuerySegment .= ' AND no_creation_rev.rev_parent_id = 0';

		return " $sqlQuerySegment";
	}

	/**
	 * Construct an SQL query segment that will match only revisions modified by the given user
	 * @param array $userArray An array with either an user_text entry or an user_id entry
	 * @return string the SQL query segment
	 */
	public function buildModifiedByQuerySegment( array $userArray ): string {
		if ( empty( $userArray ) ) {
			return '';
		}

		$this->dplTableSet->addTableAlias( 'revision', 'change_rev' );

		if ( isset( $userArray['user_text'] ) ) {
			$userText = $this->databaseConnection->addQuotes( $userArray['user_text'] );
			$sqlQuerySegment = "AND change_rev.rev_user_text = $userText";
		} else {
			$userId = $this->databaseConnection->addQuotes( $userArray['user_id'] );
			$sqlQuerySegment = "AND change_rev.rev_user = $userId";
		}

		$sqlQuerySegment .= " AND change_rev.rev_page = page_id";

		return " $sqlQuerySegment";
	}

	/**
	 * Construct an SQL query segment that will match only revisions NOT modified by the given user
	 * @param array $userArray An array with either an user_text entry or an user_id entry
	 * @return string the SQL query segment
	 */
	public function buildNotModifiedByQuerySegment( array $userArray ): string {
		if ( empty( $userArray ) ) {
			return '';
		}

		$revisionTable = $this->databaseConnection->tableName( 'revision' );

		if ( isset( $userArray['user_text'] ) ) {
			$userText = $this->databaseConnection->addQuotes( $userArray['user_text'] );
			$whereStatement = "$revisionTable.rev_user_text = $userText";
		} else {
			$userId = $this->databaseConnection->addQuotes( $userArray['user_id'] );
			$whereStatement = "$revisionTable.rev_user = $userId";
		}

		return <<<SQL
 AND NOT EXISTS (SELECT 1 FROM $revisionTable WHERE $revisionTable.rev_page=page_id AND $whereStatement LIMIT 1)
SQL;
	}

	/**
	 * Construct an SQL query segment that will match only revisions last modified by the given user
	 * @param array $userArray An array with either an user_text entry or an user_id entry
	 * @return string the SQL query segment
	 */
	public function buildLastModifiedByQuerySegment( array $userArray ): string {
		if ( empty( $userArray ) ) {
			return '';
		}

		$revisionTable = $this->databaseConnection->tableName( 'revision' );

		if ( isset( $userArray['user_text'] ) ) {
			$userNameOrId = $this->databaseConnection->addQuotes( $userArray['user_text'] );
			$userField = 'rev_user_text';
		} else {
			$userNameOrId = $this->databaseConnection->addQuotes( $userArray['user_id'] );
			$userField = 'rev_user';
		}

		return <<<SQL
 AND (SELECT $userField FROM $revisionTable WHERE $revisionTable.rev_page=page_id ORDER BY $revisionTable.rev_timestamp DESC LIMIT 1) = $userNameOrId
SQL;
	}

	/**
	 * Construct an SQL query segment that will match only revisions NOT last modified by the given user
	 * @param array $userArray An array with either an user_text entry or an user_id entry
	 * @return string the SQL query segment
	 */
	public function buildNotLastModifiedByQuerySegment( array $userArray ): string {
		if ( empty( $userArray ) ) {
			return '';
		}

		$revisionTable = $this->databaseConnection->tableName( 'revision' );

		if ( isset( $userArray['user_text'] ) ) {
			$userNameOrId = $this->databaseConnection->addQuotes( $userArray['user_text'] );
			$userField = 'rev_user_text';
		} else {
			$userNameOrId = $this->databaseConnection->addQuotes( $userArray['user_id'] );
			$userField = 'rev_user';
		}

		return <<<SQL
 AND (SELECT $userField FROM $revisionTable WHERE $revisionTable.rev_page=page_id ORDER BY $revisionTable.rev_timestamp DESC LIMIT 1) != $userNameOrId
SQL;
	}
}
