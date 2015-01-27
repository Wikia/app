<?php

use \Wikia\SwiftStorage;

/**
 * Script that removes WebP thumbnails from DFS and purges their CDN entries
 *
 * @see PLATFORM-283
 *
 * @author Macbre
 * @ingroup Maintenance
 */

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );

/**
 * Maintenance script class
 */
class PurgeWebPThumbs extends Maintenance {

	const LIST_LIMIT = 1000;

	const THUMB_SUFFIX = '.webp';
	#const THUMB_SUFFIX = '.png';

	// remove thumbnails generated during given period
	const TIMESTAMP_FROM = '2014-06-09 09:00:00';
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
		$this->mDescription = 'This script removes WebP thumbnails from DFS and purges their CDN entries';
	}

	/**
	 * Remove the thumb from DFS and purge it from CDN
	 *
	 * @param string $thumb
	 */
	private function purgeThumb($thumb) {
		$url = sprintf("http://images.wikia.com/%s%s/%s",
			$this->storage->getContainerName(), $this->storage->getPathPrefix(), $thumb);

		#$this->output(sprintf("%s: %s <%s>...", __METHOD__, $thumb, $url));
		$this->output(sprintf("%s: '%s'... ", __METHOD__, $thumb));

		if ($this->isDryRun) {
			$this->output("dry run!\n");
		}
		else {
			$this->storage->remove($thumb);
			SquidUpdate::purge([$url]);

			$this->output("done\n");
		}
	}

	public function execute() {
		global $wgCityId;
		$this->storage = SwiftStorage::newFromWiki($wgCityId);
		$container = $this->storage->getContainer();

		$this->isDryRun = $this->hasOption( 'dry-run' );

		// get the list of WebP thumbs
		$prefix = sprintf('%s/thumb', trim($this->storage->getPathPrefix(), '/'));
		$this->output("Looking for thumbnails in <{$prefix}>...\n\n");

		// marker for getting the next batch of images from DFS
		$marker = null;

		// stats
		$scanned = 0;
		$removed = 0;

		// timestamps
		$timestampFrom = strtotime(self::TIMESTAMP_FROM);
		$timestampTo = strtotime(self::TIMESTAMP_TO);

		do {
			$this->output(" * Next batch...");
			$thumbs = $container->get_objects(self::LIST_LIMIT, $marker, $prefix);

			$scanned += count($thumbs);

			// update the marker for getting the next batch
			$marker = end($thumbs)->name;
			$this->output(" ends with '{$marker}'\n");

			foreach($thumbs as $thumb) {
				$name = $thumb->name;

				if (endsWith($name, self::THUMB_SUFFIX)) {
					$name = substr($name, strlen($this->storage->getPathPrefix())); // remove path prefix from thumb path

					// check the timestamp
					$lastMod = strtotime($thumb->last_modified);

					if ($lastMod > $timestampFrom && $lastMod < $timestampTo) {
						$this->purgeThumb($name);
						$removed++;
					}
					else {
						$this->output("Skipping {$name} ({$thumb->last_modified})\n");
					}
				}
			}
		}
		while (count($thumbs) === self::LIST_LIMIT);

		$this->output( "\n{$scanned} thumbnails scanned, {$removed} purged, we're done!\n" );
	}
}

$maintClass = "PurgeWebPThumbs";
require_once( RUN_MAINTENANCE_IF_MAIN );
