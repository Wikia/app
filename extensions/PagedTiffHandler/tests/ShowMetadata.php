<?php
/**
 * To get this working you must
 * - set a valid path to PEAR
 * - check upload size in php.ini: Multipage.tiff needs at least 3M
 * - Upload the image truncated.tiff without PagedTiffHandler being active
 *   Caution: you need to allow tiff for upload:
 *   $wgFileExtensions[] = 'tiff';
 *   $wgFileExtensions[] = 'tif';
 * - Upload multipage.tiff when PagedTiffHandler is active
 */

if ( getenv( 'MW_INSTALL_PATH' ) ) {
	$IP = getenv( 'MW_INSTALL_PATH' );
} else {
	$IP = dirname( __FILE__ ) . '/../../..';
}
require_once( "$IP/maintenance/Maintenance.php" );

error_reporting( E_ALL );

$wgShowExceptionDetails = true;

class ShowMetadata extends Maintenance {
	public function __construct() {
		parent::__construct();
	}

	public function execute() {
		$handler = new PagedTiffHandler();

		$path = $this->mArgs[0];
		$file = UnregisteredLocalFile::newFromPath($path, "image/tiff");

		$metadata = $handler->getMetadata( $file, $path );

		if ( !$metadata ) {
		    print "FAILED! \n";
		    return;
		} 

		$metadata = unserialize( $metadata );

		if ( !$metadata ) {
		    print "BROKEN! \n";
		    return;
		} 

		print_r($metadata);
	}
}

$maintClass = "ShowMetadata";
require_once( DO_MAINTENANCE );
