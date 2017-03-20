<?php

use \Wikia\SwiftStorage;

/**
 * Script that purges images from Fastly using their surrogate keys
 *
 * @ingroup Maintenance
 */

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );

/**
 * Maintenance script class
 */
class PurgeImages extends Maintenance {

	private $listLimit = 200;

	private $isDryRun = false;
	private $containerName = '';
	private $cdnUrl = '';
	private $cdnHeaderKey = '';
	private $cdnHeaderValue = '';

	/* @var SwiftStorage $storage */
	private $storage;

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();
		$this->addOption( 'dry-run', 'Don\'t perform any operations' );
		$this->addOption( 'cdn-url', 'CDN url used for purging', false, true );
		$this->addOption( 'cdn-header-key', 'CDN header key sent with purge request', false, true );
		$this->addOption( 'cdn-header-value', 'CDN header value sent with purge request', false, true );
		$this->addOption( 'list-limit', 'Batch size for object scanning', false, true );

		$this->mDescription = 'This script purges images entries from CDN';
	}

	private function imageSurrogateKey( $imagePath ) {
		return sha1( $this->containerName . "/" . $imagePath );
	}

	private function purgeImages( $images ) {
		$requests = [];
		foreach ( $images as $image ) {
			$key = $this->imageSurrogateKey( $image );
			$this->output( "Will purge image {$image} using surrogate key {$key}\n" );
			$requests[ $image ] = [ 'url' => sprintf( $this->cdnUrl, $key ) ];
		}
		$options = \CurlMultiClient::getDefaultOptions();
		unset( $options[ CURLOPT_PROXY ] );
		$options[ CURLOPT_CUSTOMREQUEST ] = 'POST';
		if ( $this->cdnHeaderKey ) {
			$options[ CURLOPT_HTTPHEADER ] = [ sprintf( "%s: %s", $this->cdnHeaderKey, $this->cdnHeaderValue ) ];
		}

		return \CurlMultiClient::request( $requests, $options );
	}

	public function execute() {
		global $wgCityId;
		$this->storage = SwiftStorage::newFromWiki( $wgCityId );
		$container = $this->storage->getContainer();
		$this->containerName = $container->name;

		$this->isDryRun = $this->hasOption( 'dry-run' );
		$this->cdnUrl = $this->getOption( 'cdn-url' );
		$this->cdnHeaderKey = $this->getOption( 'cdn-header-key' );
		$this->cdnHeaderValue = $this->getOption( 'cdn-header-value' );
		if ( $this->hasOption( 'list-limit' ) ) {
			$this->listLimit = (int)$this->getOption( 'list-limit' );
		}

		// get the list of images
		$prefix = sprintf( '%s', trim( $this->storage->getPathPrefix(), '/' ) );
		$this->output( "Looking for thumbnails in <{$prefix}>...\n\n" );

		// marker for getting the next batch of images from DFS
		$marker = null;

		// stats
		$scanned = 0;
		$found = 0;
		$purged = 0;
		$errors = 0;

		do {
			$this->output( " * Next batch..." );
			$objects = $container->get_objects( $this->listLimit, $marker, $prefix );

			$scanned += count( $objects );

			// update the marker for getting the next batch
			$marker = end( $objects )->name;
			$this->output( " ends with '{$marker}'\n" );

			$images = [];
			foreach ( $objects as $obj ) {
				$name = $obj->name;
				// skip thumbnails, temp images, archived and deleted
				if ( ( 0 === strpos( $name, 'images/thumb/' ) ) ||
					( 0 === strpos( $name, 'images/archive/' ) ) ||
					( 0 === strpos( $name, 'images/temp/' ) ) ||
					( 0 === strpos( $name, 'images/deleted/' ) )
				) {
					continue;
				}
				$images[] = $name;
				if ( $this->isDryRun ) {
					$this->output( "Skipping image {$name} - dry run\n" );
				}
			}
			$found += count( $images );

			if ( !$this->isDryRun && ( count( $images ) > 0 ) ) {
				$results = $this->purgeImages( $images );

				foreach ( $results as $image => $result ) {
					if ( $results[ $image ]['error'] != null ) {
						$errors++;
						$this->output( "Purge error for " . $image . ": " . $results[ $image ]['error'] . "\n" );
					} else {
						$purged++;
					}
				}
			}
		} while ( count( $objects ) === $this->listLimit );
		$this->output( "{$scanned} objects scanned, {$found} images found, {$purged} images purged, " .
			"{$errors} errors we're done!\n" );
	}
}

$maintClass = "PurgeImages";
require_once( RUN_MAINTENANCE_IF_MAIN );
