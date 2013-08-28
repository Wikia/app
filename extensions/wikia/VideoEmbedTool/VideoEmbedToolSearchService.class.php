<?php
/**
 * Class definition for VideoEmbedToolSearchService, intended to be an interface between VET and Search
 */
class VideoEmbedToolSearchService
{
	use Wikia\Search\Traits\ArrayConfigurableTrait;
	
	/**
	 * Default width of video
	 * @var int
	 */
	const VIDEO_THUMB_DEFAULT_WIDTH = 160;
	
	/**
	 * Default height of video
	 * @var int
	 */
	const VIDEO_THUMB_DEFAULT_HEIGHT = 90;
	
	/**
	 * Fields required for preprocessing to work when searching as API 
	 * @var array
	 */
	protected $expectedFields = [ 'pageid', 'wid', 'title', 'title_en' ];
	
	/**
	 * Height of video
	 * @var int
	 */
	protected $height = self::VIDEO_THUMB_DEFAULT_HEIGHT;
	
	/**
	 * Width of video
	 * @var int
	 */
	protected $width = self::VIDEO_THUMB_DEFAULT_WIDTH;

	/**
	 * The query used for suggestion
	 * @var string
	 */
	protected $suggestionQuery;
	
	/**
	 * Whether to do preprocessing on title, and then character limit if so
	 * @var int
	 */
	protected $trimTitle = 0;

	/**
	 * Start to be set in config
	 * @var int
	 */
	protected $start = 0;
	
	/**
	 * Limit to be set in config
	 * @var int
	 */
	protected $limit = 20;
	
	/**
	 * The ranking style to be set in the config
	 * @var string
	 */
	protected $rank = Wikia\Search\Config::RANK_DEFAULT;
	
	/**
	 * Determines what wiki ID we use.
	 * @var string
	 */
	protected $searchType = 'local';
	
	/**
	 * Wikia Search Config
	 * @var Wikia\Search\Config
	 */
	protected $config;
	
	/**
	 * Factory responsible for instantiating correct query service
	 * @var Wikia\Search\QueryService\Factory
	 */
	protected $factory;
	
	/**
	 * Encapsulates MediaWiki behavior
	 * @var Wikia\Search\MediaWikiService
	 */
	protected $mwService;
	
	/**
	 * Allows us to use the arrayconfigurable trait
	 * @param array $dependencies
	 */
	public function __construct( $dependencies = [] ) {
		$this->configureByArray( $dependencies );
	}
	
	/**
	 * Provided an article ID, return an array of suggested videos.
	 * @param int $articleId
	 * @return array
	 */
	public function getSuggestionsForArticleId( $articleId )
	{
		$this->setSuggestionQueryByArticleId( $articleId );
		$query = $this->getSuggestionQuery();
		$service = $this->getMwService();
		$expectedFields = $this->getExpectedFields();
		$config = $this->getConfig()->setWikiId( Wikia\Search\QueryService\Select\Dismax\Video::VIDEO_WIKI_ID )
		                            ->setQuery( $query )
									->setRequestedFields( $expectedFields )
		                            ->setFilterQuery( "+(title_en:({$query}) OR video_actors_txt:({$query}) OR nolang_txt:({$query}) OR html_media_extras_txt:({$query}))" )
		                            ->setVideoEmbedToolSearch( true )
		  
		  ;
		return $this->postProcessSearchResponse( $this->getFactory()->getFromConfig( $config )->searchAsApi( $expectedFields, true ) );
	}
	
	/**
	 * Returns an array of results for a given query, based on settings in config
	 * @param string $query
	 * @return array
	 */
	public function videoSearch( $query ) {
		$expectedFields = $this->getExpectedFields();
		$config = $this->getConfig()->setVideoSearch( true )->setQuery( $query )->setRequestedFields( $expectedFields );
		return $this->postProcessSearchResponse( $this->getFactory()->getFromConfig( $config )->searchAsApi( $expectedFields, true ) );
	}
	
	/**
	 * Given an article ID, stores the suggestion query.
	 * @param int
	 * @return VideoEmbedToolSearchService provides fluent interface
	 */
	protected function setSuggestionQueryByArticleId( $articleId ) {
		$title = '';
		try {
			$service = $this->getMwService();
			$title = $service->getTitleStringFromPageId( $service->getCanonicalPageIdFromPageId( $articleId ) );
		} catch ( \Exception $e ) {} 
		return $this->setSuggestionQuery( $title );
	}
	
	/**
	 * Gets the query used for VET suggestions
	 * @return string
	 */
	public function getSuggestionQuery() {
		return $this->suggestionQuery;
	}
	
	/**
	 * Sets the query used for video suggestion
	 * @param string $query
	 * @return VideoEmbedToolSearchService provides fluent interface
	 */
	public function setSuggestionQuery( $query ) {
		$this->suggestionQuery = $query;
		return $this;
	}
	
	/**
	 * Correctly formats response as expected by VET, and inflates video data on each result.
	 * @param array
	 * @return array
	 */
	protected function postProcessSearchResponse( array $searchResponse ) {
		$config = $this->getConfig();
		$data = [];
		$start = $config->getStart();
		$pos = $start;
		foreach ( $searchResponse['items'] as $singleVideoData ) {
			$videoTitleObject = Title::newFromText( $singleVideoData['title'], NS_FILE );
			if ( !empty( $videoTitleObject ) ) {
				(new WikiaFileHelper)->inflateArrayWithVideoData(
						$singleVideoData,
						$videoTitleObject,
						$this->getWidth(),
						$this->getHeight(),
						true
				);
				$trimTitle = $this->getTrimTitle();
				if (! empty( $trimTitle ) ) {
					$singleVideoData['title'] = mb_substr( $singleVideoData['title'], 0, $trimTitle );
				}
				$singleVideoData['pos'] = $pos++;
				$data[] = $singleVideoData;
			}
		}
		return [
				'totalItemCount' => $searchResponse['total'],
				'nextStartFrom' => $start + $config->getLimit(),
				'items' => $data
		];
	}
	
	/**
	 * Lazy-loaded DI
	 * @return Wikia\Search\QueryService\Factory
	 */
	protected function getFactory() {
		if ( $this->factory === null ) {
			$this->factory = new Wikia\Search\QueryService\Factory;
		}
		return $this->factory;
	}
	
	/**
	 * Lazy-loads config with values set from controller. Allows us to test config API.
	 * @return Wikia\Search\Config
	 */
	protected function getConfig() {
		if ( $this->config === null ) {
			$this->config = new Wikia\Search\Config;
			$this->config->setLimit( $this->getLimit() )
			             ->setStart( $this->getStart() )
			             ->setNamespaces( [ NS_FILE ] )
			             ->setRank( $this->getRank() );
			$this->config->setFilterQueryByCode( Wikia\Search\Config::FILTER_VIDEO );
			if ( $this->getSearchType() == 'premium' ) {
				$this->config->setWikiId( Wikia\Search\QueryService\Select\Dismax\Video::VIDEO_WIKI_ID );
			}
			
		}
		return $this->config;
	}
	
	protected function getMwService() {
		if ( $this->mwService === null ) {
			$this->mwService = new Wikia\Search\MediaWikiService;
		}
		return $this->mwService;
	}
	
	/**
	 * @return the $height
	 */
	public function getHeight() {
		return $this->height;
	}

	/**
	 * @return the $width
	 */
	public function getWidth() {
		return $this->width;
	}

	/**
	 * @param string $height
	 */
	public function setHeight( $height ) {
		$this->height = $height;
	}

	/**
	 * @param string $width
	 */
	public function setWidth( $width ) {
		$this->width = $width;
	}

	/**
	 * @return the $title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @return the $trimTitle
	 */
	public function getTrimTitle() {
		return $this->trimTitle;
	}

	/**
	 * @param boolean $trimTitle
	 * @return VideoEmbedToolSearchService provides fluent interface
	 */
	public function setTrimTitle( $trimTitle ) {
		$this->trimTitle = $trimTitle;
		return $this;
	}
	
	/**
	 * Allows controller to set limit on service, which injects into its config
	 * @param int $limit
	 * @return VideoEmbedToolSearchService provides fluent interface
	 */
	public function setLimit( $limit ) {
		$this->limit = $limit;
		return $this;
	}
	
	/**
	 * Returns limit set by controller
	 * @return int
	 */
	public function getLimit() {
		return $this->limit;
	}
	
	/**
	 * Allows controller to set start on service, which injects into its config
	 * @param int $start
	 * @return VideoEmbedToolSearchService provides fluent interface
	 */
	public function setStart( $start ) {
		$this->start = $start;
		return $this;
	}
	
	/**
	 * Return start set by controller
	 * @return int $start
	 */
	public function getStart() {
		return $this->start;
	}
	
	/**
	 * Allows controller to set rank on service, which injects into its config
	 * @param string $rank
	 * @return VideoEmbedToolSearchService provides fluent interface
	 */
	public function setRank( $rank ) {
		$this->rank = $rank;
		return $this;
	}
	
	/**
	 * Return start set by controller
	 * @return string $rank
	 */
	public function getRank() {
		return $this->rank;
	}
	
	/**
	 * Allows us to set wiki ID based on search type
	 * @param string $searchType
	 * @return VideoEmbedToolSearchService provides fluent interface
	 */
	public function setSearchType( $type ) {
		$this->searchType = $type;
		return $this;
	}
	
	/**
	 * Return search type set by controller
	 * @return string $searchType
	 */
	public function getSearchType() {
		return $this->searchType;
	}
	
	/**
	 * Read-only expected field value because arrays can't be class constants.
	 * @return array
	 */
	protected function getExpectedFields() {
		return $this->expectedFields;
	}
}
