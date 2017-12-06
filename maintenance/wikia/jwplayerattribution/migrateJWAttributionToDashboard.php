<?php

/**
 * Migrate JW videos attribution from WF to JW Dashboard
 *
 */
require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );
require_once('jwplayer-api-kit/botr/api.php');

class MigrateJWAttributionToDashboard extends Maintenance {

	protected $dryRun = true;

	protected $map = [];

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Migrate JW videos attribution from WF to JW Dashboard";
		$this->addOption( 'dry-run', 'Dry run mode', false, false, 'd' );

		$this->jwApi = new BotrAPI('key', 'secret');

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

				$payload = ['video_id' => $config['mediaId']];

				if ( array_key_exists('username', $config) ) {
					$this->output( 'username: ' . $config['username'] );
					$payload['custom.username'] = $config['username'];
				}

				if ( array_key_exists('userUrl', $config) ) {
					$this->output( 'userUrl: ' . $config['userUrl'] );
					$payload['custom.userUrl'] = $config['userUrl'];
				}

				if ( array_key_exists('userAvatarUrl', $config) ) {
					$this->output( 'userAvatarUrl: ' . $config['userAvatarUrl'] );
					$payload['custom.userAvatarUrl'] = $config['userAvatarUrl'];
				}
			}

			try {
				$this->jwApi->call('/videos/update', $payload);
			} catch ( Exception $exception ) {
				$this->output( 'Exception: ' . $exception->getMessage() );
			}
		}
	}
}

$maintClass = 'MigrateJWAttributionToDashboard';
require_once( RUN_MAINTENANCE_IF_MAIN );
