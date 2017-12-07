<?php

use \Wikia\Logger\WikiaLogger;

/**
 * This script queries Solr index for videos coming from all registered providers.
 *
 * Providers that have the last vidoe uploaded more than X days ago
 * are considered outdated. Log message is sent via ELK and Jira ticker is filled
 * via Jira Reporter
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
class FindOutdatedVideoProviders extends Maintenance {

	// this will be pushed to ELK and filled as Jira ticket by Jira reporter
	const REPORT_TENPLATE = <<<TEXT
h2. *\$provider* video provider is out date

The last uploaded video is from \$last_upload.

*URL*: <\$url>
*Number of videos from this provider*: \$videos

h3. Context

{code}
\$context
{code}
TEXT;

	// report providers that failed to provide a video in last 30 days
	const UPLOADED_X_DAYS_AGO_THRESHOLD = 30;

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();

		$this->mDescription = 'This script queries Solr index for videos coming from all registered providers';
	}

	private static function getSolr() : Solarium_Client {
		global $wgSolrMaster, $wgSolrPort;
		$solariumConfig = [
			'adapter' => 'Solarium_Client_Adapter_Curl',
			'adapteroptions' => [
				'host' => $wgSolrMaster,
				'port' => $wgSolrPort,
				'path' => '/solr/',
				'core' => 'main',
				'timeout' => 30,
			]
		];

		return new Solarium_Client( $solariumConfig );
	}

	private static function queryForVideos( Solarium_Client $solr, string $provider) {
		$select = $solr->createSelect();
		$select
			->setQuery( sprintf(
				'ns: %d AND is_video: true AND video_provider_s: "%s"',
				NS_FILE, $provider
			) );
		$select->setFields( [ 'touched', 'url', 'video_provider_s' ] );

		// just give me the latest video
		$select->addSort( 'touched', 'desc' );
		$select->setRows( 1 );

		$result = $solr->select( $select );
		$videosCount = $result->getNumFound();

		if ( $videosCount > 0 ) {
			return [ $videosCount, $result->getDocuments()[0] ];
		}
		else {
			return [ $videosCount, false ];
		}
	}

	private static function reportProvider( string $provider, array $stats = [] ) {
		WikiaLogger::instance()->warning(
			sprintf('Video provider is out of data - %s', $provider),
			[
				'jira_reporter' => 1,
				'tags' => [
					'video-providers',
					'video-' . $provider,
					'sunset',
				],
				'body' => trim( strtr(
					self::REPORT_TENPLATE,
					[
						'$provider' => $provider,
						'$last_upload' => $stats['last_upload'] ?: 'n/a',
						'$url' => $stats['last_upload_url'] ?: 'n/a',
						'$videos' => $stats['videos'] ?: 0,
						'$context' => json_encode( $stats, JSON_PRETTY_PRINT )
					]
				))
			]
		);
	}

	public function execute() {
		global $wgMediaHandlers;
		$solr = self::getSolr();

		// e.g. $wgMediaHandlers['video/crunchyroll'] = 'CrunchyrollVideoHandler';
		foreach( $wgMediaHandlers as $key => $_ ) {
			list( $type, $provider ) = explode( '/', $key, 2 );

			// ignore non-video providers
			if ( $type !== 'video' ) continue;

			$this->output( "Checking '{$provider}' video provider...");

			// query Solr for videos from a given provider
			list( $videos, $firstVideo ) = self::queryForVideos( $solr, $provider );

			if ( $videos > 0 ) {
				/* @var Solarium_Document_ReadOnly $firstVideo */
				$data = $firstVideo->getFields(); #var_dump($data);

				$stats = [
					'videos' => $videos,
					'last_upload' => $data['touched'],
					'last_upload_days_ago' =>
						floor( ( time() - strtotime($data['touched'] ) ) / 86400 ),
					'last_upload_url' => $data['url'],
				];

				$this->output( sprintf(
					" found %d videos, last upload from %s (%d days ago) - <%s>\n",
					$stats['videos'], $stats['last_upload'],
					$stats['last_upload_days_ago'], $stats['last_upload_url']
				) );

				if ( $stats['last_upload_days_ago'] > self::UPLOADED_X_DAYS_AGO_THRESHOLD ) {
					self::reportProvider( $provider, $stats );
				}
			}
			else {
				$this->output( " no vidoes were found!\n" );
				self::reportProvider( $provider, [
					'last_upload' => false,
					'last_upload_url' => 'none',
					'videos' => 'no videos!'
				] );
			}
		}
	}
}

$maintClass = FindOutdatedVideoProviders ::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
