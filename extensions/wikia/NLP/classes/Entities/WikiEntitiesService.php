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
	 * The top 5 topics for this wiki as determined by running latent dirichlet analysis
	 * against 5000 wikis with 999 topics. Each topic is a max of 3 characters (integers)
	 * @todo should we refactor these into a higher-radix integer (e.g. hex) to compress length even more?
	 * @return bool
	 */
	public function registerLdaTopicsWithDFP() {
		$mwService = $this->getMwService();
		$topics = $this->getLdaTopics();
		if ( count( $topics ) ) {
			$keyValues = explode( ';', $mwService->getGlobalWithDefault( 'wgDartCustomKeyValues', '' ) );
			foreach ( $topics as &$topic ) {
				$topic = 'wtpx='.$topic;
			}
			$mwService->setGlobal( 'wgDartCustomKeyValues', implode( ';', array_merge( $keyValues, array_slice( $topics, 0, 5 ) ) ) );
		}
		return true;
	}
	
	/**
	 * Returns on average 18 different topics, numbered 1-999.
	 * These were extracted using latent dirichlet analysis against the top 5k WAM wikis
	 * We asked for 999 unsupervised topics, and this is what we got.
	 * They are ordered by a weight value randing from 0 to 1, descending
	 * @return array
	 */
	public function getLdaTopics() {
		return $this->getMwService()->getGlobalWithDefault( 'WikiLdaTopics', [] );
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