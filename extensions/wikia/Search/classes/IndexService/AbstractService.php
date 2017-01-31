<?php
/**
 * Class definition for \Wikia\Search\IndexService\AbstractService
 *
 * @author relwell
 */
namespace Wikia\Search\IndexService;

use Wikia\Sass\Exception;
use Wikia\Search\MediaWikiService;

/**
 * This class allows us to define a standard API for indexing services
 *
 * @author relwell
 * @abstract
 * @package Search
 * @subpackage IndexService
 */
abstract class AbstractService {
	/**
	 * This allows us to abstract out logic core to MediaWiki.
	 * Eventually, we could have other 'drivers' for our logic interface here.
	 * Sorry I didn't have a better name for this one -- maybe "driver"?
	 *
	 * @var \Wikia\Search\MediaWikiService
	 */
	protected $service;

	/**
	 * Stores page ids so that we don't need to pass it to execute method
	 * This allows us to reuse wiki-scoped logic
	 *
	 * @var array
	 */
	protected $pageIds = [];

	/**
	 * A pointer to the page ID we're currently operating on.
	 * Allows us to interact with a specific page ID during iteration without passing it.
	 *
	 * @var int
	 */
	protected $currentPageId;

	/**
	 * Allows us to avoid duplication
	 *
	 * @var array
	 */
	protected $processedDocIds = [];

	/**
	 * Allows us to instantiate a service with pageIds already set
	 *
	 * @param array $pageIds
	 */
	public function __construct( array $pageIds = [] ) {
		$this->pageIds = $pageIds;
	}

	/**
	 * Used when we're only executing a single iteration
	 *
	 * @param int $pageId
	 *
	 * @return AbstractService
	 */
	public function setPageId( $pageId ) {
		$this->currentPageId = $pageId;

		return $this;
	}

	/**
	 * Declares the page scope of the indexing service
	 *
	 * @param array $pageIds
	 *
	 * @return AbstractService
	 */
	public function setPageIds( array $pageIds = [] ) {
		$this->pageIds = $pageIds;

		return $this;
	}

	/**
	 * We should return an associative array that keys document fields to values
	 * If this operates within the scope of an entire wiki
	 *
	 * @return AbstractService
	 */
	abstract public function execute();

	/**
	 * Allows us to reuse the same basic JSON structure for any number of service calls
	 *
	 * @return string
	 */
	public function getResponseForPageIds() {

		$result = [ 'contents' => '', 'errors' => [] ];
		$documents = [];

		foreach ( $this->pageIds as $pageId ) {
			$this->currentPageId = $pageId;
			/**
			 * For redirects,
			 * $currentId represents the actual Id of the document taking into
			 * consideration redirects;
			 * $originalId is the Id of the document containing the redirect itself
			 *
			 * For non-redirects they are the same
			 */
			$currentId = $this->getCurrentDocumentId();
			$originalId = $this->getCurrentDocumentId( false );

			if ( $currentId != $originalId ) {
				$documents[] = [ "delete" => [ "id" => $originalId ] ];
				continue;
			}

			// page was either delete or should not be indexed (SUS-1446)
			if ( !$this->getService()->pageIdExists( $pageId ) || !$this->getService()->pageIdCanBeIndexed( $pageId ) ) {
				$documents[] = [ "delete" => [ "id" => $currentId ] ];
				continue;
			}

			if ( in_array( $currentId, $this->processedDocIds ) ) {
				continue;
			}

			try {
				$response = $this->getResponse();

				$this->processedDocIds[] = $originalId;
				if ( !empty( $response ) ) {
					$documents[] = $this->getJsonDocumentFromResponse( $response );
				}
			} catch ( \WikiaException $e ) {
				$result['errors'][] = $pageId;
			}
		}

		$result['contents'] = $documents;

		return $result;
	}

	/**
	 * Generates a unique ID based on wiki ID and page ID
	 *
	 * @param bool $resolveRedirect
	 *
	 * @return string
	 */
	public function getCurrentDocumentId( $resolveRedirect = true ) {
		return sprintf(
			'%s_%s',
			$this->getService()->getWikiId(),
			$resolveRedirect ? $this->getService()->getCanonicalPageIdFromPageId( $this->currentPageId ) :
				$this->currentPageId
		);
	}

	/**
	 * Returns an array formatted for the JSON response
	 *
	 * @param array $response
	 *
	 * @return array
	 */
	public function getJsonDocumentFromResponse( array $response ) {
		$toJson = [ 'id' => $this->getCurrentDocumentId() ];
		foreach ( $response as $field => $value ) {
			if ( $field !== 'id' ) {
				$toJson[$field] = [ 'set' => $value ];
			}
		}

		return $toJson;
	}

	/**
	 * Lazy-loads service dependency
	 *
	 * @return MediaWikiService
	 */
	protected function getService() {
		if ( $this->service === null ) {
			$this->service = new MediaWikiService;
		}

		return $this->service;
	}

	/**
	 * @param \Wikia\Search\MediaWikiService $service
	 */
	public function setService( $service ) {
		$this->service = $service;
	}


	/**
	 * Hook for resetting any state specific to a single page
	 *
	 * @return AbstractService
	 */
	protected function reinitialize() {
		return $this;
	}

	/**
	 * Execute with hook to reinitialize
	 *
	 * @throws \Exception
	 * @return AbstractService
	 */
	public function getResponse() {
		try {
			$response = $this->execute();
		} catch ( \Exception $e ) {
			$this->reinitialize();
			throw $e;
		}
		$this->reinitialize();

		return $response;
	}

}
