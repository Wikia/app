<?php
/**
 * A repository that stores files in the local filesystem and registers them
 * in the wiki's own database.
 *
 * Extends most commonly used repository class to allow us to use some extra file functions.
 * 
 * @ingroup FileRepo
 */
class WikiaLocalRepo extends LocalRepo {
	var $fileFactory = array( 'WikiaLocalFile', 'newFromTitle' );
	var $oldFileFactory = array( 'OldWikiaLocalFile', 'newFromTitle' );
	var $fileFromRowFactory = array( 'WikiaLocalFile', 'newFromRow' );
	var $oldFileFromRowFactory = array( 'OldWikiaLocalFile', 'newFromRow' );

	function newFromArchiveName( $title, $archiveName ) {
		return OldWikiaLocalFile::newFromArchiveName( $title, $this, $archiveName );
	}


}

