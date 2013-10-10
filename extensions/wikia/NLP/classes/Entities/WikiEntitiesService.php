<?php
/**
 * Class definition for Wikia\NLP\Entities\WikiEntitiesService
 */
namespace Wikia\NLP\Entities;
use Wikia\Search\MediaWikiService;
/**
 * Class responsible for interacting with wiki-scoped entities 
 * @author relwell
 */
class WikiEntitiesService
{
	/**
	 * Used to interact with MediaWiki components.
	 * @var Wikia\Search\MediaWikiService
	 */
	protected $mwService;
	
	/**
	 * Prepares entities for dart key-value pairs and stores it in the appropriate global variable 
	 * @return bool
	 */
	public function registerEntitiesWithDFP() {
		$mwService = $this->getMwService();
		$entityList = $this->getEntityList();
		if ( count( $entityList ) ) {
			array_walk( $entityList, function( &$val ) { $val = substr( $val, 0, 20 ); } );
			$keyValues = $mwService->getGlobalWithDefault( 'wgDartCustomKeyValues', '' )
			           . '&'
			           . http_build_query( [ 'wikientities' => $entityList ] );
			$mwService->setGlobal( 'wgDartCustomKeyValues', $keyValues );
		}
		return true;
	}
	
	
	/**
	 * Access entities from wikifactory, currently.
	 * @todo store entities in xwiki Solr document and use SolrDocumentService to access data.
	 * @return array
	 */
	public function getEntityList() {
		return $this->getMwService()->getGlobalWithDefault( 'WikiEntities', [] );
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