<?php
/**
 * Iterates over all articles in the wiki, sends them to the entity recognition tool
 * and saves entities into DB
 *
 * @author jacek@wikia-inc.com
 * @author arturd@wikia-inc.com
 * @ingroup Maintenance
 */

define('CLASSIFIER_NAME', '1');

ini_set('display_errors', 'stderr');
ini_set('error_reporting', E_NOTICE);

require_once( dirname( __FILE__ ) . '/../../../extensions/wikia/PageClassification/EntityAPIClient.class.php' );
require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );
require_once( dirname( __FILE__ ) . '/../../../includes/HttpFunctions.php' );

class ScanWiki extends Maintenance {

	protected $wikiDomain = null;
	protected $apiClient = null;
	protected $wikiId = 0;

	function __construct() {
		$this->apiClient = new EntityAPIClient();
		$this->wikiId = $_SERVER['SERVER_ID'];
		return parent::__construct();
	}

	public function execute() {
		echo "\nExecuting scanWiki for: " . $this->getWikiDomain() . " \n\n";

		$this->iterateOverArticleList();

		echo "\n\n\nCOOL.\n";
	}

	public function setWikiDomain( $wikiDomain ) {
		$this->wikiDomain = $wikiDomain;
	}

	public function getWikiDomain() {
		global $wgDBname;

		if ( empty( $this->wikiDomain ) ) {
			$this->setWikiDomain( WikiFactory::DBtoDomain( $wgDBname ) );
		}
		return $this->wikiDomain;
	}

	public function getWikiApiEndpoint() {
		return "http://" . $this->getWikiDomain() . "/api.php";
	}

	protected function iterateOverArticleList() {
		$dbr = wfGetDB( DB_SLAVE );
		if (!is_null($dbr)) {
			$result = $dbr->select( 'page',
										array( 'page_id', 'page_title' ),
										array( 'page_is_redirect' => 0,
											   'page_namespace' => 0
									),'ScanWiki::fetchArticleList' );


			while ( $row = $dbr->fetchObject( $result ) ) {
				$this->queryPageForEntities( $row );
			}
		} else {
			$this->error( "Couldn't connect to DB", true );

		}
	}

	protected function queryPageForEntities( $pageData ) {
		$this->output( 'Quering: ' . $pageData->page_title . " \n " );
		$result = $this->scanPageWithEntityService( $pageData->page_title );
		$this->sendResultToDB( $result, $pageData );
	}

	protected function scanPageWithEntityService( $pageTitle ) {
		$result = $this->apiClient->get( $this->apiClient->getClassifierEndpoint($this->getWikiDomain(), $pageTitle) );
		return $result;
	}

	protected function sendResultToDB( $result, $pageData ) {
		$postData = array(
			"wikiId" => $this->wikiId,
			"pageId" => $pageData->page_id,
			"pageTitle" => $pageData->page_title,
			"classifierName" => CLASSIFIER_NAME,
			"humanVerified" => false,
			"quality"=> $this->getQualityFromResult( $result ),
			"entities" => $this->getEntitiesFromResult( $result['response'], $pageData )
		);

		if ( count($postData['entities']) > 0 ) {
			if ( $postData['entities'][0]["type"] != "other"  ) {
				$this->output( 'Saving...'."\n" );
				$this->output( json_encode( $postData ) );
				$response = $this->apiClient->postJson( $this->apiClient->getSaveEndpoint(), json_encode( $postData ) );
				print_r( $response );
			} else {
				$this->output( 'Other found. Not saving.' ."\n" );
			}
		} else {
			$this->output( 'Nothing found' ."\n" );
			print_r( $result );
		}
	}

	protected function getQualityFromResult( $result ) {
		if ( !empty( $result->class ) ) {
			$className = $result->class;
			if ( !empty( $result->classes->{$className} ) ) {
				return $result->classes->{$className};
			}
		}
		return 0;
	}

	protected function getEntitiesFromResult( $result, $pageData ) {
		$entities = array();
		if ( !empty( $result->class ) ) {
			$entities[] = array(
				"relevance" => $this->getQualityFromResult( $result ),
				"type" => $result->class,
				"name" => $this->sanitizePageTitle( $pageData->page_title )
			);
		}
		return $entities;
	}

	public function sanitizePageTitle( $pageTitle ) {
		return str_replace( "_", " ", $pageTitle );
	}
}


$maintClass = "ScanWiki";
require_once( RUN_MAINTENANCE_IF_MAIN );
