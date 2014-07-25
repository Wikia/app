<?php

use \Wikia\SwiftStorage;

/**
 * Script that removes promote images that are no longer in use
 *
 * @author SebastianMarzjan
 * @ingroup Maintenance
 */

require_once( dirname( __FILE__ ) . '/../../../../maintenance/Maintenance.php' );

/**
 * Maintenance script class
 */
class PromoteGarbageCollection extends Maintenance {

	const LIST_LIMIT = 1000;

	/**
	 * This looks complicated, but is not :)
	 * example of matched string: images/0/08/11229.1403254237.53a3f5dd6199e.png
	 */
	const IMAGE_PATTERN = '/^images\/[a-zA-Z0-9]\/[a-zA-Z0-9]{2}\/([a-zA-Z0-9]+\.[a-zA-Z0-9]+\.[a-zA-Z0-9]+).[a-zA-Z]+$/';
	const TIMESTAMP_TO = '2014-06-11 16:00:00';

	private $isDryRun = false;

	/* @var SwiftStorage $storage */
	private $storage;

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();
		$this->addOption( 'dry-run', 'Don\'t perform any operations' );
		$this->mDescription = 'This script removes unused Promote images from DFS';
	}

	public function execute() {
		global $wgExternalSharedDB;

		$this->storage = \Wikia\SwiftStorage::newFromContainer( 'promote', '/images' );
		$container = $this->storage->getContainer();
		$this->isDryRun = $this->hasOption( 'dry-run' );

		// get the list of images
		$prefix = sprintf( '%s', trim( $this->storage->getPathPrefix(), '/' ) );
		$this->output( "Looking for images in <{$prefix}>...\n\n" );

		// marker for getting the next batch of images from DFS
		$marker = null;

		// stats
		$scanned = 0;
		$removed = 0;

		$sdb = wfGetDB( DB_SLAVE, [ ], $wgExternalSharedDB );

		do {
			$this->output( " * Next batch..." );
			$imageNames = [ ];

			$images = $container->get_objects( self::LIST_LIMIT, $marker, $prefix );

			$scanned += count( $images );

			// update the marker for getting the next batch
			$marker = end( $images )->name;
			$this->output( " ends with '{$marker}'\n" );

			$imageNames = $this->getLikelyPromoteImages( $images, $imageNames );
			$foundImages = $this->findImagesExistingInPromote( $imageNames, $sdb );
			$danglingImages = array_diff( $imageNames, $foundImages );
			$removed += $this->removeDanglingImages( $danglingImages );
		} while ( count( $imageNames ) === self::LIST_LIMIT );

		$this->output( "\n{$scanned} images scanned, {$removed} removed, we're done!\n" );
	}

	/**
	 * @param $imageNames
	 * @param $sdb
	 * @return $array
	 */
	private function findImagesExistingInPromote( $imageNames, $sdb ) {
		$sql = ( new \WikiaSQL() )
			->SELECT( 'image_name' )
			->FROM( PromoImage::TABLE_CITY_VISUALIZATION_IMAGES_XWIKI )
			->WHERE( 'image_name' )
			->IN( $imageNames );

		$foundImages = $sql->run( $sdb, function ( $result ) {
			$foundImages = [];
			while ( $row = $result->fetchObject() ) {
				$foundImages [] = $row->image_name;
			}
			return $foundImages;
		} );

		return $foundImages;
	}

	/**
	 * @param $danglingImages
	 * @param $removed
	 * @return array
	 */
	private function removeDanglingImages( $danglingImages ) {
		$removed = 0;
        foreach ( $danglingImages as $image ) {
			if ( ! $this->isDryRun ) {
				PromoImage::getImage( $image )->removeFile();
				$removed ++;
			}
		}
        return $removed;
    }

	/**
	 * @param $images
	 * @param $imageNames
	 * @return array
	 */
	private function getLikelyPromoteImages( $images, $imageNames ) {
		foreach ( $images as $image ) {
			$name = $image->name;

			preg_match( self::IMAGE_PATTERN, $name, $matches );

			if ( ! empty( $matches[1] ) ) {
				$imageName = $matches[1];
				$imageNames [] = $imageName;
			}
		}
		return $imageNames;
	}
}

$maintClass = "PromoteGarbageCollection";
require_once( RUN_MAINTENANCE_IF_MAIN );
