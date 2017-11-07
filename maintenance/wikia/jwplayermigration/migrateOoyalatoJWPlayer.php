<?php

/**
 * Add JWPlayer mediaId to wgFeaturedVideo
 *
 */
require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );

class MigrateOoyalaVideos extends Maintenance {

	protected $dryRun = true;

	protected $map = [];

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Migrate videos";
		$this->addOption( 'dry-run', 'Dry run mode', false, false, 'd' );

		$videos = array_map( 'str_getcsv', file( 'output.csv' ) );
		$map = [];

		foreach ( $videos as $video ) {
			$map[$video[1]] = $video[0];
		}

		$this->map = $map;
	}


	public function execute() {
		$this->dryRun = $this->hasOption( 'dry-run' );
		$this->output( "Start \n" );

		$this->doUpdate( 1689, 'wgArticleVideoFeaturedVideos' );
		$this->doUpdate( 1749, 'wgArticleVideoFeaturedVideos2' );
	}

	private function doUpdate( $varId, $varName ) {
		// Get all wikis with var set
		$wikisWithVar = ( WikiFactory::getListOfWikisWithVar( $varId, 'array', '!=', [] ) );

		$this->output( 'Found ' . count( $wikisWithVar ) . "wikis with " . $varName . " config\n" );


		// Iterate over all wikis that have the var set
		foreach ( $wikisWithVar as $wikiId => $wiki ) {
			$this->output( 'Working on wikiId: ' . $wikiId . '; name: ' . $wiki['t'] . "\n" );
			$videoConfig = WikiFactory::getVarValueByName( $varName, $wikiId );
			$this->output( 'Found ' . count( $videoConfig ) . " pages with Featured Video\n" );
			$counter = 0;
			foreach ( $videoConfig as $pageName => &$config ) {
				$this->output( 'Working on page: ' . $pageName . "\n" );

				// If videoId exists in csv add mediaId and player to the var
				if ( key_exists( 'videoId', $config ) && key_exists( $config['videoId'], $this->map ) &&
					((key_exists( 'player', $config ) && $config['player'] !== 'jwplayer') || !key_exists( 'player', $config ))
				) {
					$this->output( ' updated ' . $config['videoId'] . ' to ' . $this->map[$config['videoId']] . "\n" );
					$config['mediaId'] = $this->map[$config['videoId']];
					$config['player'] = 'jwplayer';
					$counter++;
				}
			}


			try {
				//uncomment to do update
				if ( $counter > 0 ) {
					WikiFactory::setVarById( $varId,  $wikiId, $videoConfig , 'Automatic migration of Ooyala videos to JWPlayer' );
				} else {
					$this->output( "No changes for wikiId:" . $wikiId );
				}
			} catch ( Exception $exception ) {
				$this->output( 'Exception: ' . $exception->getMessage() );
			}
		}
	}
}

$maintClass = 'MigrateOoyalaVideos';
require_once( RUN_MAINTENANCE_IF_MAIN );