<?php
/**
 * Custom job to perform updates on tables in busier environments
 */
class RenameUserJob extends Job {

	/**
	 * Constructor
	 *
	 * @param Title $title Associated title
	 * @param array $params Job parameters
	 */
	public function __construct( $title, $params ) {
		parent::__construct( 'renameUser', $title, $params );
	}

	/**
	 * Execute the job
	 *
	 * @return bool
	 */
	public function run() {
		$dbw = wfGetDB( DB_MASTER );

		$table = $this->params['table'];
		$column = $this->params['column'];
		$oldname = $this->params['oldname'];
		$userID = isset( $this->params['userID'] ) ? $this->params['userID'] : null;
		$uidColumn = isset( $this->params['uidColumn'] ) ? $this->params['uidColumn'] : null;
		$timestampColumn = isset( $this->params['timestampColumn'] ) ? $this->params['timestampColumn'] : null;
		$minTimestamp = $this->params['minTimestamp'];
		$maxTimestamp = $this->params['maxTimestamp'];
		$uniqueKey = isset( $this->params['uniqueKey'] ) ? $this->params['uniqueKey'] : null;
		$keyId = isset( $this->params['keyId'] ) ? $this->params['keyId'] : null;
		$newname = $this->params['newname'];
		$count = $this->params['count'];

		# Conditions like "*_user_text = 'x'
		$conds = array( $column => $oldname );
		# If user ID given, add that to condition to avoid rename collisions.
		if ( isset( $userID ) ) {
			$conds[$uidColumn] = $userID;
		}
		# Bound by timestamp if given
		if ( isset( $timestampColumn ) ) {
			$conds[] = "$timestampColumn >= '$minTimestamp'";
			$conds[] = "$timestampColumn <= '$maxTimestamp'";
		# Otherwise, bound by key (B/C)
		} elseif ( isset( $uniqueKey ) ) {
			$conds[$uniqueKey] = $keyId;
		} else {
			wfDebug( 'RenameUserJob::run - invalid job row given' ); // this shouldn't happen
			return false;
		}
		# Update a chuck of rows!
		$dbw->update( $table,
			array( $column => $newname ),
			$conds,
			__METHOD__
		);
		# Special case: revisions may be deleted while renaming...
		if ( $table == 'revision' && isset( $timestampColumn ) ) {
			$actual = $dbw->affectedRows();
			# If some revisions were not renamed, they may have been deleted.
			# Do a pass on the archive table to get these straglers...
			if ( $actual < $count ) {
				$dbw->update( 'archive',
					array( 'ar_user_text' => $newname ),
					array( 'ar_user_text' => $oldname,
						'ar_user' => $userID,
						// No user,rev_id index, so use timestamp to bound
						// the rows. This can use the user,timestamp index.
						"ar_timestamp >= '$minTimestamp'",
						"ar_timestamp <= '$maxTimestamp'" ),
					__METHOD__
				);
			}
		}
		# Special case: revisions may be restored while renaming...
		if ( $table == 'archive' && isset( $timestampColumn ) ) {
			$actual = $dbw->affectedRows();
			# If some revisions were not renamed, they may have been restored.
			# Do a pass on the revision table to get these straglers...
			if ( $actual < $count ) {
				$dbw->update( 'revision',
					array( 'rev_user_text' => $newname ),
					array( 'rev_user_text' => $oldname,
						'rev_user' => $userID,
						// No user,rev_id index, so use timestamp to bound
						// the rows. This can use the user,timestamp index.
						"rev_timestamp >= '$minTimestamp'",
						"rev_timestamp <= '$maxTimestamp'" ),
					__METHOD__
				);
			}
		}
		return true;
	}
}
