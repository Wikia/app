<?php
/**
 * Class definition for \Wikia\Search\IndexService\AbstractWikiService
 * @author relwell
 */
namespace Wikia\Search\IndexService;
/**
 * Allows us to restrict wiki-wide capabilities to specific classes.
 * AbstractWikiService can also operate on single pages as well, but provide the ability 
 * to send a stubbed-out response that can be applied to all pages on the backend.
 * @author relwell
 * @abstract
 * @package Search
 * @subpackage IndexService
 */
abstract class AbstractWikiService extends AbstractService
{
	/**
	 * Allows us to reuse an atomic update for multiple documents on the backend, if it applies to a wiki and not a page.
	 */
	const PAGEID_PLACEHOLDER = '#WIKIA_PAGE_ID_VALUE#';
	
    /**
	 * Writes an XML response without the <add> wrapper and a placeholder for pageid
	 * Assumes that we are not operating on a provided page ID
	 * @throws \Exception
	 * @return string
	 */
	public function getStubbedWikiResponse() {
		if ( $this->currentPageId !== null ) {
			throw new \Exception( 'A stubbed response is not appropriate for services interacting with page IDs' );
		}
		$response = $this->getJsonDocumentFromResponse( $this->execute() );
		// let the backend insert the id
		unset( $response['id'] );
		return array( 'contents' => $response, 'wid' => $this->getService()->getWikiId() );
	}
	
	/**
	 * Returns a placeholder if there isn't a current page ID
	 * @see \Wikia\Search\IndexService\AbstractService::getCurrentDocumentId()
	 * @param boolean $resolveRedirect Ignored; for compatibility with parent's signature
	 * @return string
	 */
    public function getCurrentDocumentId($resolveRedirect = true) {
    	return sprintf( '%s_%s', $this->getService()->getWikiId(), $this->currentPageId  ?: self::PAGEID_PLACEHOLDER );
    }
}
