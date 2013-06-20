<?php
/**
 * Class definition for Wikia\Search\ResultSet\Grouping
 */
namespace Wikia\Search\ResultSet;
use \Wikia\Search\MediaWikiService, \ArrayIterator, \Solarium_Result_Select, \Wikia\Search\Config, Wikia\Search\Utilities, DataMartService;
/**
 * This class handles sub-groupings of results for inter-wiki search.
 * @author relwell
 * @package Search
 * @subpackage ResultSet
 */
class Grouping extends Base
{
	
	/**
	 * Stores top pages' IDs
	 * @var array
	 */
	protected $topPages = [];

	/**
	 * The wrapper handling this particular grouping instance
	 * @var GroupingSet
	 */
	protected $parent;
	
	/**
	 * The host for grouping.
	 * @var string
	 */
	protected $host;
	
	/**
	 * Returns a truncated description based on desired word count.
	 * @param int $wordCount
	 * @return string
	 */
	public function getDescription( $wordCount = 60 ) {
		$desc = $this->getHeader( 'desc' );
		$count = str_word_count( $desc );
		$ellipses = $count > $wordCount ? '&hellip;' : '';
		return empty( $desc ) ? '' : implode( ' ', array_slice( explode( ' ', $desc ), 0, $wordCount ) ) . $ellipses;
	}

	public function getDescriptionByLength( $chars = 100 ) {
		$desc = $this->getHeader( 'desc' );
		$count = strlen( $desc );
		$ellipses = $count > $chars ? '&hellip;' : '';

		$words = explode( ' ', $desc );
		if ( !empty( $words ) ) {
			$result = 0;
			foreach( $words as $key => $word ) {
				if ( $result + strlen( $word ) + strlen( $ellipses ) + 1 > $chars ) {
					return implode( ' ', array_slice( $words, 0, $key ) ) . $ellipses;
				}
				$result += strlen( $word ) + 1;
			}
			return $desc;
		}
		return '';
	}

	/**
	 * Returns the top four articles for this wiki
	 * @return array of Articles
	 */
	public function getTopPages() {
		if ( empty( $this->topPages ) ) {
			$wikiId = $this->getHeader( 'wid' );
			$articles = (new DataMartService)->getTopArticlesByPageview(
					$wikiId,
					null,
					null,
					false,
					5 //compensation for Main Page
					);
			$mainId = $this->service->getMainPageIdForWikiId( $wikiId );
			$counter = 0;
			unset( $articles[$mainId] );
			$this->topPages = array_slice( array_keys( $articles ), 0, 4 );
		}
		return $this->topPages;
	}
	
	/**
	 * Uses DependencyContainer to pre-populate attributes, and then configures stuff.
	 * @param DependencyContainer $container
	 */
	protected function configure( DependencyContainer $container ) {
		$this->searchResultObject = $container->getResult();
		$this->searchConfig       = $container->getConfig();
		$this->service          = $container->getService();
		$this->parent             = $container->getParent();
		$this->metaposition       = $container->getMetaposition();
		$this->results            = new ArrayIterator( array() );
		
		$this->setResultsFromHostGrouping()
		     ->configureHeaders();
	}
	
	/**
	 * Finds current grouping from result and sets documents accordingly.
	 * @return \Wikia\Search\ResultSet\Grouping
	 */
	protected function setResultsFromHostGrouping() {
		$valueGroups = $this->getHostGrouping()->getValueGroups();
		$valueGroup  = $valueGroups[$this->metaposition];
		$this->host  = $valueGroup->getValue();
		$this->resultsFound = $valueGroup->getNumFound();
		$this->setResults( $valueGroup->getDocuments() );
		return $this;
	}
	
	/**
	 * Sets a bunch of headers associated with wiki info
	 * @return Wikia\Search\ResultSet\Grouping
	 */
	protected function configureHeaders() {
		$doc = end( $this->results ); // there's only one
		$wikiId = $doc['wid'];
		$wikiId = $wikiId ?: $this->service->getWikiIdByHost( $this->host );
		$title = $this->service->getGlobalForWiki( 'wgSitename', $wikiId );
		$visualizationInfo = $this->service->getVisualizationInfoForWikiId( $wikiId );
		unset( $visualizationInfo['lang'] ); // untrustworthy
		if (! empty( $doc ) ) {
			$this->addHeaders( $doc->getFields() );
			$title = $title ?: $doc[Utilities::field( 'wikititle' )]; // apparently wgSitename can be false for some wiki IDs
		}
		$this->addHeaders( $visualizationInfo )
			 ->addHeaders( $this->service->getStatsInfoForWikiId( $wikiId ) )
			 ->setHeader ( 'wikititle', $title )
			 ->setHeader ( 'title', $title )
			 ->setHeader ( 'hub', $this->service->getHubForWikiId( $wikiId ) );
		if ( $this->getDescription() == '' ) {
			$this->setHeader( 'desc', $this->service->getSimpleMessage( 'wikiasearch2-crosswiki-description', array( $title ) ) );
		}
		return $this;
	}
	
	/**
	 * Reusable method for grabbing the resultset grouped by host.
	 * @throws Exception
	 * @return Solarium_Result_Select_Grouping_FieldGroup
	 */
	protected function getHostGrouping() {
		$grouping = $this->searchResultObject->getGrouping();
		if (! $grouping ) {
		    throw new \Exception("Search config was grouped but result was not.");
		}
		$hostGrouping = $grouping->getGroup('host');
		if (! $hostGrouping ) {
		    throw new \Exception("Search results were not grouped by host field.");
		}
		return $hostGrouping;
	}

	/**
	 * Returns the parent value set during instantiation
	 * @return GroupingSet|null
	 */
	public function getParent() {
		return $this->parent;
	}

	/**
	 * Returns the host value of the grouping.
	 * @return string
	 */
	public function getId() {
		return $this->host;
	}
	
	/**
	 * Allows us to serialize some core values from an expected wiki for json requests
	 * @return array
	 */
	public function toArray() {
		return $this->getHeader();
	}

	/**
	 * Returns a formatted message about the number of articles on a wiki
	 * @return string
	 */
	public function getArticlesCountMsg() {
		return $this->service->shortNumForMsg($this->getHeader('articles_count')?:0, 'wikiasearch2-pages');
	}

	/**
	 * Returns a formatted message about the number of images on a wiki
	 * @return string
	 */
	public function getImagesCountMsg() {
		return $this->service->shortNumForMsg($this->getHeader('images_count')?:0, 'wikiasearch2-images');
	}

	/**
	 * Returns a formatted message about the number of videos on a wiki
	 * @return string
	 */
	public function getVideosCountMsg() {
		return $this->service->shortNumForMsg($this->getHeader('videos_count')?:0, 'wikiasearch2-videos');
	}

}