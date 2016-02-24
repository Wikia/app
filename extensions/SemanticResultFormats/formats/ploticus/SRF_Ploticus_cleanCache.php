<?php
/**
 * Purges old/orphan/temporary plots, maps, CSVs, drawdumps from the ploticus cache directory.
 *
 *
 * Note: if SMW is not installed in its standard path under ./extensions
 *       then the MW_INSTALL_PATH environment variable must be set.
 *       See README in the maintenance directory.
 *
 * Usage:
 * php SRF_Ploticus_cleanCache.php [options...]
 *
 * -a <age in hours>    Override $srfgPloticusCacheAge setting and purge files of this age and greater
 * -v                   Be verbose about the progress.
 *
 * @author Joel Natividad
 * @file
 * @ingroup SRFMaintenance
 */

$optionsWithArgs = array( 'a' );

require_once ( getenv( 'MW_INSTALL_PATH' ) !== false
    ? getenv( 'MW_INSTALL_PATH' ) . "/maintenance/commandLine.inc"
    : dirname( __FILE__ ) . '/../../../maintenance/commandLine.inc' );

global $wgUploadDirectory, $srfgPloticusCacheAgeHours;

if ( !empty( $options['a'] ) ) {
	$fileAge = intval( $options['a'] ) * 3600; // 60 secs * 60 mins
} else {
        if ( isset( $srfgPloticusCacheAgeHours ) ) {
                $fileAge = $srfgPloticusCacheAgeHours * 3600;
        } else {
                $fileAge = 604800; // if $srfgPloticusCacheAgeHours is not set in LocalSettings.php defaults to 7 days
        }
}

$verbose = array_key_exists( 'v', $options );

$now = strftime( "%c", time() );
if ( $fileAge <= 0 ) {
    if ( $verbose )
        echo "$now: Ploticus cache cleaning disabled.\n";
    return;
}

$ploticusDirectory = $wgUploadDirectory . '/ploticus/';

if ( !is_dir( $ploticusDirectory ) ) {
    if ( $verbose )
        echo "$now: $ploticusDirectory does not exist!\n";
    return;
}

if ( $verbose )
    echo "$now: Purging $ploticusDirectory cache of files >= $fileAge seconds old.\n";

$deletecount = rfr( $ploticusDirectory, "*.*", $fileAge, $verbose );

if ( $verbose ) {
    $now = strftime( "%c", time() );
    if ( $deletecount > 0 ) {
        echo "$now: $deletecount files successfully deleted from Ploticus cache.\n";
    } else {
        echo "$now: No files deleted.  Check if you have permission to delete files from $ploticusDirectory.\n";
    }
}

/* recursive file delete function */
function rfr( $path, $match, $fileAge, $verbose ) {
   static $deleted = 0;
   $dirs = glob( $path . "*" );
   $files = glob( $path . $match );
   foreach ( $files as $file ) {
      if ( is_file( $file ) && @filemtime( $file ) < ( time() - $fileAge ) ) {
		if ( $verbose ) echo "$file...";
		if ( @unlink( $file ) ) {
			if ( $verbose ) echo "deleted.\n";
                        $deleted++;
		 } else {
			if ( $verbose ) echo "ooops!\n";
		 }
      }
   }
   foreach ( $dirs as $dir ) {
      if ( is_dir( $dir ) ) {
         $dir = basename( $dir ) . "/";
         rfr( $path . $dir, $match, $fileAge, $verbose );
      }
   }
   return $deleted;
}