<?php
/**
 * Enables Discussions on the given wikis, after verifying there are no threaded forum posts on each wiki
 * Usage: php enableDiscussionsWithNoForums.php <listfile>
 * Where:
 * 	<listfile> is a file where each line is a site ID where we want to enable discussions
 *
 * @ingroup Maintenance
 */
use Swagger\Client\ApiException;
use Swagger\Client\Discussion\Api\SitesApi;
use Wikia\DependencyInjection\Injector;
use Wikia\Service\Swagger\ApiProvider;
require_once( __DIR__ . '/Maintenance.php' );

class EnableDiscussionsWithNoForums extends Maintenance {

	const CURL_TIMEOUT = 5;
	const SERVICE_NAME = 'discussions';

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Enables Discussions on given wikis with no threaded forum posts";
		$this->addArg( 'listfile', 'File with site IDs to enable discussions on, separated by newlines.' );
	}

	public function execute() {
		$fh = fopen( $this->getArg() , 'r' );

		if ( !$fh ) {
			$this->error( 'Unable to read from input file, exiting', true );
		}

		$schwartzToken = F::app()->wg->TheSchwartzSecretToken;

		while ( !empty( $wikiId = trim( fgets( $fh ) ) ) ) {
			$wiki =  WikiFactory::getWikiByID( $wikiId );
			$dbw = wfGetDB( DB_SLAVE, [], $wiki->city_dbname );
			$row = $dbw->selectRow(
				[ 'comments_index', 'page' ],
				[ 'count(*) cnt' ],
				[
					'parent_comment_id' => 0,
					'archived' => 0,
					'deleted' => 0,
					'removed' => 0,
					'page_namespace' => NS_WIKIA_FORUM_BOARD_THREAD
				],
				__METHOD__,
				[ ],
				[ 'page' => [ 'LEFT JOIN', [ 'page_id=comment_id' ] ] ]
			);

			$totalThreads = intval( $row->cnt );

			if ( $totalThreads > 0 ) {
				$this->error( "$wikiId has $totalThreads forum threads. Skipping!" );
				continue;
			}

			$site = new \Swagger\Client\Discussion\Models\SiteInput(
				[
					'id' => $wikiId,
					'language_code' => $wiki->city_lang,
					'name' => $wiki->city_sitename,
				]
			);
			try {
				$this->getDiscussionsSitesApi()->createSite( $site, $schwartzToken );
			} catch ( ApiException $e ) {
				$this->error(
					'Creating site caused an error (siteId: ' . $wikiId . ',  error: ' . $e->getMessage() . ')'
				);
			}
		}
	}

	private function getDiscussionsSitesApi() {
		/** @var ApiProvider $apiProvider */
		$apiProvider = Injector::getInjector()->get( ApiProvider::class );
		/** @var SitesApi $api */
		$api = $apiProvider->getApi( self::SERVICE_NAME, SitesApi::class );
		$api->getApiClient()->getConfig()->setCurlTimeout( self::CURL_TIMEOUT );
		return $api;
	}
}

$maintClass = "EnableDiscussionsWithNoForums";
require_once( RUN_MAINTENANCE_IF_MAIN );
