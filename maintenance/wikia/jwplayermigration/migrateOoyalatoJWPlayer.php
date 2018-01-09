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

			foreach ( $videoConfig as $pageName => &$config ) {
				$this->output( 'Working on page: ' . $pageName . "\n" );

				unset( $config['videoId'] );
				unset( $config['thumbnailUrl'] );
				unset( $config['time'] );
				unset( $config['player'] );
				unset( $config['title'] );

				if ( empty( $config ) ) {
					unset( $videoConfig[$pageName] );
				}
			}

			try {
				WikiFactory::setVarById( $varId, $wikiId, $videoConfig, 'Automatic migration of Ooyala videos to JWPlayer' );
			} catch ( Exception $exception ) {
				$this->output( 'Exception: ' . $exception->getMessage() );
			}
		}
	}
}

$maintClass = 'MigrateOoyalaVideos';
require_once( RUN_MAINTENANCE_IF_MAIN );