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
 */
abstract class AbstractWikiService extends AbstractService
{
    /**
	 * Writes an XML response without the <add> wrapper and a placeholder for pageid
	 * Assumes that we are not operating on a provided page ID
	 * @todo this ought to be a trait
	 * @throws \Exception
	 * @return string
	 */
	public function getStubbedWikiResponse() {
		if ( $this->currentPageId !== null ) {
			throw new \Exception( 'A stubbed response is not appropriate for services interacting with page IDs' );
		}
		
		$updateXml = $this->getUpdateXmlForDocuments( array( $this->getDocumentFromResponse( $this->execute() ) ) );
		$updateXml = str_replace( '<update>', '', str_replace( '</update>', '', $updateXml ) );
		
		return array( 'contents' => $updateXml );
	}
}