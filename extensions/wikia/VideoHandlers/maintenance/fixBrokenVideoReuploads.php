<?php

/**
 * This script tries to fix the videos affected by and old (and already fixed) issue
 * that was reverting video uploads as simple images, without keeping video metadata.
 *
 * @see SUS-3469
 *
 * @author Macbre
 * @ingroup Maintenance
 */

require_once( __DIR__ . '/../../../../maintenance/Maintenance.php' );

/**
 * Maintenance script class
 */
class FixBrokenVideoReuploads extends Maintenance {

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();

		$this->mDescription = 'This script tries to fix the videos affected by CONCF-227';

		$this->addOption( 'fix-it', "Set this flag to perform changes", false );
	}

	/**
	 * @param DatabaseBase $db
	 * @return Generator
	 */
	private function getVideos( DatabaseBase $db ) {
		$res = $db->select(
			[ 'image', 'oldimage' ],
			[
				'img_name',
				'img_timestamp',
				'oldimage.oi_timestamp',
				'oldimage.oi_sha1'
			],
			[
				'oldimage.oi_major_mime' => 'video',
				'image.img_major_mime' => 'image',
			],
			__METHOD__,
			[
				'ORDER BY' => 'oi_timestamp',
				'GROUP BY' => 'img_name',
			],
			[
				'oldimage' => [ 'JOIN', 'oldimage.oi_name = image.img_name' ]
			]
		);

		foreach($res as $row) {
			yield $row;
		}
	}

	/**
	 * @param stdClass $row
	 */
	private function processVideo( $row ) {
		global $wgDBname;

		$repo = RepoGroup::singleton()->getLocalRepo();

		$old = OldLocalFile::newFromKey( $row->oi_sha1, $repo, $row->oi_timestamp );
		$metadata = unserialize($old->getMetadata());

		if ( empty( $metadata['provider'] ) ) {
			$this->output( sprintf( "%s: <%s> no provider defined!\n",
				$wgDBname, $old->getName() ) );

			return;
		}

		$provider = $metadata['provider'];
		$videoId = $metadata['videoId'];

		// do fix the video, re-upload it
		if ( $this->getOption('fix-it') ) {
			$title = Title::newFromText($old->getName(), NS_FILE);
			$res = VideoFileUploader::uploadVideo( $provider, $videoId, $title );
		}
		else {
			$res = Status::newFatal( 'dry-run' );
		}

		$this->output( sprintf( "%s: <%s> %s #%s - %s -> %s\n",
			$wgDBname, $old->getName(), $provider, $videoId, $old->getTimestamp(),
			$res->isOk() ? 'OK' : $res->getMessage()
		) );
	}

	public function execute() {
		global $wgDBname, $wgUser;

		// perform video re-uploads as FANDOMbot
		$wgUser = User::newFromName( Wikia::BOT_USER );

		$videos = $this->getVideos( $this->getDB( DB_SLAVE ) );
		$cnt = 0;

		foreach($videos as $video) {
			$this->processVideo( $video );
			$cnt++;
		}

		$this->output( sprintf("%s: videos affected %d\n", $wgDBname, $cnt ) );
	}
}

$maintClass = FixBrokenVideoReuploads ::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
