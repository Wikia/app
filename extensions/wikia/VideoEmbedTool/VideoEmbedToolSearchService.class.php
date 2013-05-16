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
	protected $expectedFields = [ 'pageid', 'wid', 'title' ];
	
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
		$config = $this->getConfig()->setCityId( Wikia\Search\QueryService\Select\Video::VIDEO_WIKI_ID )
		                            ->setQuery( $this->getSuggestionQuery() )
		                            ->setVideoEmbedToolSearch( true );
		
		return $this->postProcessSearchResponse( $this->getFactory()->getFromConfig( $config )->searchAsApi( $this->getExpectedFields(), true ) );
	}
	
	/**
	 * Returns an array of results for a given query, based on settings in config
	 * @param string $query
	 * @return array
	 */
	public function videoSearch() {
		$config = $this->getConfig()->setVideoSearch( true );
		return $this->postProcessSearchResponse( $this->getFactory()->getFromConfig( $config ) )->searchAsApi( $this->getExpectedFields(), true );
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
		$data = [];
		$start = $this->getConfig()->getStart();
		$pos = $start;
		foreach ( $searchResponse['items'] as $singleVideoData ) {
			(new WikiaFileHelper)->inflateArrayWithVideoData( 
					$singleVideoData, 
					Title::newFromText($singleVideoData['title'], NS_FILE ),
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
		return [
				'totalItemCount' => count( $data ),
				'nextStartFrom' => $start + $this->getConfig()->getLimit(),
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
	 * Sets the search config instance
	 * @var Wikia\Search\Config $config
	 * @return VideoEmbedToolSearchService provides fluent interface
	 */
	public function setConfig( Wikia\Search\Config $config ) {
		$this->config = $config;
		return $this;
	}
	
	/**
	 * Lazy loading DI, but generally we want config set externally.
	 * @return Wikia\Search\Config
	 */
	protected function getConfig() {
		if ( $this->config === null ) {
			$this->config = new Wikia\Search\Config;
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
	 * Read-only expected field value because arrays can't be class constants.
	 * @return array
	 */
	protected function getExpectedFields() {
		return $this->expectedFields;
	}
}