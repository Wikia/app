<?php

/**
 * Add JWPlayer mediaId to wgFeaturedVideo
 *
 */
require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );

class MigrateOoyalaVideos extends Maintenance {

	protected $dryRun = true;

	protected $map = [];

	// pass access token
	const ACCESS_TOKEN = '';

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

	private function toDevURL($url) {
		return str_replace('.wikia.com', '.ktatala.wikia-dev.pl', $url);
	}

	private function addMapping($url, $mediaId) {
		global $wgDevelEnvironment;

		$data = [
			'url' => $url,
			'media_id' => $mediaId,
		];
		$options = [
			'postData' => json_encode( $data ),
			'headers' => [
				'Content-Type' => 'application/json',
				'Accept' => 'application/json',
				'X-Wikia-AccessToken' => self::ACCESS_TOKEN,
			],
			'returnInstance' => true,
		];

		$endpointUrl = 'https://services.wikia.com/article-video/mappings';

		if ( $wgDevelEnvironment ) {
			$endpointUrl = 'https://services.wikia-dev.pl/article-video/mappings';
		}

		return Http::post( $endpointUrl, $options );
	}

	private function doUpdate( $varId, $varName ) {
		global $wgDevelEnvironment;
		// Get all wikis with var set
		$wikisWithVar = ( WikiFactory::getListOfWikisWithVar( $varId, 'array', '!=', [] ) );

		$this->output( 'Found ' . count( $wikisWithVar ) . "wikis with " . $varName . " config\n" );


		// Iterate over all wikis that have the var set
		foreach ( $wikisWithVar as $wikiId => $wiki ) {
			$this->output( 'Working on wikiId: ' . $wikiId . '; name: ' . $wiki['t'] . "\n" );
			$videoConfig = WikiFactory::getVarValueByName( $varName, $wikiId );
			$this->output( 'Found ' . count( $videoConfig ) . " pages with Featured Video\n\n" );

			foreach ( $videoConfig as $pageName => &$config ) {
				$baseUrl = $wgDevelEnvironment ? $this->toDevURL( $wiki['u'] ) : $wiki['u'];
				$url = $baseUrl . 'wiki/' . $pageName;
				$this->output( 'Working on page: ' . $pageName . "\n" );
				$this->output( 'Url: ' . $url . "\n" );
				if ( !empty( $config['mediaId'] ) ) {
					$this->output( 'MediaId: ' . $config['mediaId'] . "\n" );
					$result = $this->addMapping( $url, $config['mediaId'] );
					$status = $result->getStatus();
					if ( $status === 201 ) {
						$this->output( 'Mapping has been saved.' . "\n"  );
					} else {
						$this->output( 'ERROR ' . $status . '. Mapping has not been saved.' . "\n" );
						$this->output( $result->getContent() . "\n"  );
					}
				} else {
					$this->output( 'No mediaId!' . "\n" );
				}
				$this->output( "\n" );
			}
			$this->output( "####################################################\n\n" );
		}
	}
}

$maintClass = 'MigrateOoyalaVideos';
require_once( RUN_MAINTENANCE_IF_MAIN );