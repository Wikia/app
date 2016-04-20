<?php
/**
 * Class definition for WikiaSearchIndexerController
 */
use Wikia\Search\MediaWikiService;

/**
 * This class is responsible for providing responses for atomic updates of documents.
 * @author relwell
 * @package Search
 * @subpackage Controller
 */
class WikiaSearchIndexerController extends WikiaController
{
	const REQUEST_PARAMETER_API_KEY = 'apiKey';
	/**
	 * Allows us to avoid direct calls to MediaWiki components
	 * @var Wikia\Search\MediaWikiService
	 */
	protected $service;

	/**
	 * Constructor method.
	 * Sets defaults -- no writing to memache, and a default search indexer instance
	 */
	public function __construct()
	{
		parent::__construct();
		$this->service = new MediaWikiService;
		$this->service->setGlobal( 'AllowMemcacheWrites', false )
		                ->setGlobal( 'AppStripsHtml', true );

		if ( function_exists( 'newrelic_disable_autorum') ) {
			newrelic_disable_autorum();
		}
		if( function_exists( 'newrelic_background_job' ) ) {
			newrelic_background_job(true);
		}

	}

	/**
	 * Produces a JSON response based on calls to the provided pages' WikiaSearchIndexer::getPageDefaultValues method.
	 */
	public function get()
	{
		$this->getResponse()->setFormat('json');

		$serviceName = 'Wikia\Search\IndexService\\' . $this->getVal( 'service', 'DefaultContent' );
		$ids = explode( '|', $this->getVal( 'ids', '' ) );
		if ( class_exists( $serviceName ) ) {
			$service = new $serviceName( $ids );
			$ids = $this->getVal( 'ids' );
			if ( !empty( $ids ) ) {
				$data = $service->getResponseForPageIds();
				$this->response->setData( $data );
				/* extra logging - remove later */
				if ( isset( $data['contents'] ) ) {
					foreach ( $data['contents'] as $content ) {
						if ( isset( $content['html_en']['set'] ) && $content['html_en']['set'] === ' ' ) {
							\Wikia\Logger\WikiaLogger::instance()->warning(
								'Meta description containing just a space',
								[
									'variant' => 'WikiaSearchIndexerController::get',
									'serviceName' => $serviceName,
									'id' => isset( $content['id'] ) ? $content['id'] : 'none',
									'snippet_s' => isset( $content['snippet_s'] ) ? $content['snippet_s'] : 'none',
									'ex' => new Exception(),
								]
							);
						}
					}
				}
				/* end of extra logging */
			}
		} else {
			\Wikia\Logger\WikiaLogger::instance()->error( 'WikiaSearchIndexer invoked with bad service param.',
				[ 'serviceName' => $serviceName ] );
		}
	}

	/**
	 * Provides a JSON response for services that work on a wiki-wide level
	 * The response includes the wiki ID, the URL of the wiki, and the stubbed-out XML
	 * It is the responsibility of the back-end script to access all page IDs using the appropriate API
	 * and replace placeholder values with
	 */
	public function getForWiki()
	{
		$this->getResponse()->setFormat('json');

		$serviceName = 'Wikia\Search\IndexService\\' . $this->getVal( 'service' );
		$service = new $serviceName();

		$this->response->setData( $service->getStubbedWikiResponse() );
	}

	/**
	 * Check for existence of specific key in request.
	 * If key exists - access is allowed
	 * @return bool
	 */
	public function isAnonAccessAllowedInCurrentContext() {
		$originalRequest = RequestContext::getMain()->getRequest();
		$apiKey = $originalRequest->getVal( self::REQUEST_PARAMETER_API_KEY, null );
		global $wgPrivateWikiaApiAccessKey;
		if( ( $apiKey !== null ) && ( $apiKey === $wgPrivateWikiaApiAccessKey ) ) {
			return true;
		}
		return false;
	}
}
