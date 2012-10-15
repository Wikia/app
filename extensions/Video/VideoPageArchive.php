<?php
/**
 * A subclass of PageArchive for restoring deleted videos.
 * Based on Bartek Łapiński's code.
 *
 * @file
 */

class VideoPageArchive extends PageArchive {

	/**
	 * List the deleted file revisions for this video page.
	 * Returns a result wrapper with various oldvideo fields.
	 *
	 * @return ResultWrapper
	 */
	function listFiles() {
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			'oldvideo',
			array(
				'ov_name', 'ov_archive_name', 'ov_url', 'ov_type',
				'ov_user_id', 'ov_user_name', 'ov_timestamp'
			),
			array( 'ov_name' => $this->title->getDBkey() ),
			__METHOD__,
			array( 'ORDER BY' => 'ov_timestamp DESC' )
		);
		$ret = $dbr->resultObject( $res );
		return $ret;
	}

	/**
	 * Restore the given (or all) text and video revisions for the page.
	 * Once restored, the items will be removed from the archive tables.
	 * The deletion log will be updated with an undeletion notice.
	 *
	 * @param $timestamps Array: pass an empty array to restore all revisions,
	 *                           otherwise list the ones to undelete.
	 * @param $comment String: reason for undeleting
	 * @param $fileVersions Array
	 * @param $unsuppress Boolean: false by default
	 *
	 * @return array(number of file revisions restored, number of video revisions restored, log message)
	 *         on success, false on failure
	 */
	function undelete( $timestamps, $comment = '', $fileVersions = array(), $unsuppress = false ) {
		// We currently restore only whole deleted videos, a restore link from
		// log could take us here...
		if ( $this->title->exists() ) {
			return;
		}

		$dbw = wfGetDB( DB_MASTER );

		$result = $dbw->select(
			'oldvideo',
			'*',
			array( 'ov_name' => $this->title->getDBkey() ),
			__METHOD__,
			array( 'ORDER BY' => 'ov_timestamp DESC' )
		);

		$insertBatch = array();
		$insertCurrent = false;
		$archiveName = '';
		$first = true;

		foreach ( $result as $row ) {
			if( $first ) { // this is our new current revision
				$insertCurrent = array(
					'video_name' => $row->ov_name,
					'video_url' => $row->ov_url,
					'video_type' => $row->ov_type,
					'video_user_id' => $row->ov_user_id,
					'video_user_name' => $row->ov_user_name,
					'video_timestamp' => $row->ov_timestamp
				);
			} else { // older revisions, they could be even elder current ones from ancient deletions
				$insertBatch = array(
					'ov_name' => $row->ov_name,
					'ov_archive_name' => $archiveName,
					'ov_url' => $row->ov_url,
					'ov_type' => $row->ov_type,
					'ov_user_id' => $row->ov_user_id,
					'ov_user_name' => $row->ov_user_name,
					'ov_timestamp' => $row->ov_timestamp
				);
			}
			$first = false;
		}

		unset( $result );

		if ( $insertCurrent ) {
			$dbw->insert( 'video', $insertCurrent, __METHOD__ );
		}
		if ( $insertBatch ) {
			$dbw->insert( 'oldvideo', $insertBatch, __METHOD__ );
		}

		// run parent version, because it uses a private function inside
		// files will not be touched anyway here, because it's not NS_FILE
		parent::undelete( $timestamps, $comment, $fileVersions, $unsuppress );

		return array( '', '', '' );
	}

}