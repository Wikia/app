<?php
/**
 * Class definition for Wikia\NLP\Entities\PageEntitiesService
 */
namespace Wikia\NLP\Entities;
use Wikia\Search\MediaWikiService;
/**
 * Responsible for interacting with entities on the page level.
 * @author relwell
 */
class PageEntitiesService
{
	/**
	 * Accesses an array of page-scoped entities for a provided page ID
	 * @todo this is probably better done using SolrDocumentService
	 * @param int $pageId
	 * @return array
	 */
	public function getEntitiesForPage( $pageId ) {
		$unserialized = false;
		$db = wfGetDB( DB_SLAVE );
		$result = $db->select(
				'page_wikia_props', 
				[ 'props' ], 
				array( 'page_id' => $pageId, 'propname' => PAGE_ENTITIES_KEY )
		);
		$row = $db->fetchRow( $result );
		if ( ( $row != false ) && isset( $row['props'] ) ) {
			$unserialized = unserialize( $row['props'] );
		}
		return $unserialized ?: [];
	}
	
	/**
	 * Responsible for storing page entities
	 * @return bool
	 */
	public function registerEntitiesWithDFP() {
		$mwService = $this->getMwService();
		$entityList = $this->getEntitiesForPage( $mwService->getGlobal( 'ArticleId' ) );
		if ( count( $entityList ) ) {
			$keyValues = explode( ';', $mwService->getGlobalWithDefault( 'wgDartCustomKeyValues', '' ) );
			foreach ( $entityList as &$val ) {
				$val = sprintf( 'pageentities=%s', substr( $val, 0, 20 ) );
			}
			$mwService->setGlobal( 'wgDartCustomKeyValues', implode( ';', array_merge( $keyValues, $entityList ) ) );
		}
		return true;
	}
	
	/**
	 * Dependency lazy-loader.
	 * @return \Wikia\Search\MediaWikiService
	 */
	protected function getMwService() {
		if ( $this->mwService === null ) {
			$this->mwService = new MediaWikiService;
		}
		return $this->mwService;
	}
	
}