<?php

/**
 * A foreign repository with a MediaWiki database accessible via the configured LBFactory
 * that uses WikiaForeignDBFile
 * 
 * @ingroup FileRepo
 */
class WikiaForeignDBViaLBRepo extends ForeignDBViaLBRepo {

	var $fileFactory = array( 'WikiaForeignDBFile', 'newFromTitle' );
	var $fileFromRowFactory = array( 'WikiaForeignDBFile', 'newFromRow' );
	var $oldFileFactory = array( 'OldWikiaLocalFile', 'newFromTitle' );
	var $oldFileFromRowFactory = array( 'OldWikiaLocalFile', 'newFromRow' );
}

