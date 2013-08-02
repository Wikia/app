<?php
/**
 * A repository that stores files in the local filesystem and registers them
 * in the wiki's own database.
 *
 * @ingroup FileRepo
 */
class WikiaLocalRepo extends LocalRepo {
	var $fileFactory = array( 'WikiaLocalFile', 'newFromTitle' );
	var $oldFileFactory = array( 'OldWikiaLocalFile', 'newFromTitle' );
	var $fileFromRowFactory = array( 'WikiaLocalFile', 'newFromRow' );
	var $oldFileFromRowFactory = array( 'OldWikiaLocalFile', 'newFromRow' );

	/* fixes hardcoded values of LocalRepo */
	function newFromArchiveName( $title, $archiveName ) {

		$oldFileClass = $this->oldFileFactory[0];
		return $oldFileClass::newFromArchiveName( $title, $this, $archiveName );
	}

	/**
	 * Get an UploadStash associated with this repo.
	 *
	 * @return UploadStash
	 */
	public function getUploadStash() {
		return new WikiaUploadStash( $this );
	}


}

