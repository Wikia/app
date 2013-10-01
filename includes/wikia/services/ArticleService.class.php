<?php
/**
 * A service to retrieve plain text snippets from articles
 *
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 */
class ArticleService extends WikiaObject {
	const MAX_LENGTH = 500;
	const CACHE_VERSION = 8;

	/** @var Article $article */
	private $article = null;
	private $tags = array(
			'script',
			'style',
			'noscript',
			'div',
			'table',
			'figure',
			'figcaption',
			'aside',
			'details',
			'h1',
			'h2',
			'h3',
			'h4',
			'h5',
			'h6'
	);
	private $patterns = array(
		//strip decimal entities
		'/&#\d{2,5};/ue' => '',
		//strip hex entities
		'/&#x[a-fA-F0-7]{2,8};/ue' => '',
		//this should be always the last
		'/\s+/' => ' '
	);
	private static $localCache = array();

	/**
	 * Using SolrDocumentService to access preprocessed article content
	 * @var SolrDocumentService
	 */
	protected $solrDocumentService;

	/**
	 * ArticleService constructor
	 *
	 * @param Article|Title|int $articleOrId [OPTIONAL] An Article or Title instance or a valid article ID (lower performance)
	 */
	public function __construct( $articleOrId = null ) {
		parent::__construct();

		if ( !is_null( $articleOrId ) ) {
			if ( is_numeric( $articleOrId ) ) {
				$this->setArticleById( $articleOrId );
			} elseif ( $articleOrId instanceof Article ) {
				$this->setArticle( $articleOrId );
			} elseif ( $articleOrId instanceof Title ) {
				$this->setArticleByTitle( $articleOrId );
			}
		}
	}

	/**
	 * Sets the Article instance
	 * @param Article $article An instance of the Article
	 * class to use as a source of content
	 * @return ArticleService fluent interface
	 */
	public function setArticle( Article $article ) {
		$this->article = $article;
		return $this;
	}

	/**
	 * Sets the Article instance via an article ID
	 * @param integer $articleId A valid article ID from which
	 * an Article instance will be constructed to be used as a
	 * source of content
	 */
	public function setArticleById( $articleId ) {
		$this->article = Article::newFromID($articleId);
		return $this;
	}

	/**
	 * Sets the Article instance via Title object
	 * @param Title $article Title object
	 * class to use as a source of content
	 * @return ArticleService fluent interface
	 */
	public function setArticleByTitle( Title $title ) {
		$this->article = new Article($title);
		return $this;
	}

	/**
	 * Gets a plain text snippet from an article
	 *
	 * @param integer $length [OPTIONAL] The maximum snippet length, defaults to 100
	 *
	 * @return string The plain text snippet, it includes SUFFIX at the end of the string
	 * if the length of the article's content is longer than $length, the text will be cut
	 * respecting the integrity of the words
	 *
	 * @throws WikiaException If $length is bigger than MAX_LENGTH
	 *
	 * @example
	 * $service = new ArticleService( $article );
	 * $snippet = $service->getTextSnippet( 250 );
	 *
	 * $service->setArticleById( $title->getArticleID() );
	 * $snippet = $service->getTextSnippet( 50 );
	 *
	 * $service->setArticle( $anotherArticle );
	 * $snippet = $service->getTextSnippet();
	 */
	public function getTextSnippet( $length = 100 ) {
		//don't allow more than the maximum to avoid flooding Memcached
		if ( $length > self::MAX_LENGTH ) {
			throw new WikiaException( 'Maximum allowed length is ' . self::MAX_LENGTH );
		}

		// it may sometimes happen that the aricle is just not there
		if ( !( $this->article instanceof Article ) ) {
			return '';
		}

		$fname = __METHOD__;
		wfProfileIn( __METHOD__ );

		$id = $this->article->getID();
		// in case the article is missing just return empty string
		if ( $id <= 0 ) {
			wfProfileOut( __METHOD__ );
			return '';
		}

		//memoize to avoid Memcache access overhead
		//when the same article needs to be processed
		//more than once in the same process
		if ( array_key_exists( $id, self::$localCache ) ) {
			$text = self::$localCache[$id];
		} else {
			$key = self::getCacheKey( $id );
			$service = $this;
			$text = self::$localCache[$id] = WikiaDataAccess::cache(
				$key,
				86400 /*24h*/,
				function() use ( $service, $fname ){
					wfProfileIn( $fname . '::CacheMiss' );

					$content = '';
					if ( !empty( $this->wg->SolrMaster ) ) {
						$content = $service->getTextFromSolr();
					}

					if ( $content === '' ) {
						// back-off is to use mediawiki
						$content = $service->getUncachedSnippetFromArticle();
					}

					wfProfileOut( $fname . '::CacheMiss' );
					return $content;
				}
			);
		}

		$snippet = wfShortenText( $text, $length, true /*use content language*/ );

		wfProfileOut( __METHOD__ );
		return $snippet;
	}

	/**
	 * Accesses a snippet from MediaWiki.
	 * @return string
	 */
	public function getUncachedSnippetFromArticle() {
		//get standard parser cache for anons,
		//99% of the times it will be available but
		//generate it in case is not
		$page = $this->article->getPage();
		$opts = $page->makeParserOptions( new User() );
		$content = $page->getParserOutput( $opts )->getText();

		//Run hook to allow wikis to modify the content (ie: customize their snippets) before the stripping and length limitations are done.
		wfRunHooks( 'ArticleService::getTextSnippet::beforeStripping', array( &$this->article, &$content, ArticleService::MAX_LENGTH ) );

		if ( mb_strlen( $content ) > 0 ) {
			//remove all unwanted tag pairs and their contents
			foreach ( $this->tags as $tag ) {
				$content = preg_replace( "/<{$tag}\b[^>]*>.*<\/{$tag}>/imsU", '', $content );
			}

			//cleanup remaining tags
			$content = strip_tags( $content );

			//apply some replacements
			foreach ( $this->patterns as $reg => $rep ) {
				$content = preg_replace( $reg, $rep, $content );
			}

			//decode entities
			$content = html_entity_decode( $content );
			$content = trim( $content );

			if ( mb_strlen( $content ) > ArticleService::MAX_LENGTH ) {
				$content = mb_substr( $content, 0, ArticleService::MAX_LENGTH );
			}
		}
		return $content;
	}

	public function getWikiText() {
		global $wgOut;

		//get raw wikitext
		$page = $this->article->getPage();
		$content = $page->getRawText();

		//preprocess dependacies
//		$parser = new Parser();
//		$pre = $parser->preprocess( $content, Title::newFromID( 50 ), $wgOut->parserOptions() );
		$wparser = new WikiParser();
		$wparser->setText( $content );

		$result = $wparser->parse();
		
		return $result;
	}

	/**
	 * Gets a plain text of an article using Solr.
	 *
	 * @return string The plain text as stored in solr. Will be empty if we don't have a result.
	 */
	public function getTextFromSolr() {
		$service = new SolrDocumentService();
		// note that this will use wgArticleId without an article
		if ( $this->article ) {
			$service->setArticleId( $this->article->getId() );
		}
		$htmlField = Wikia\Search\Utilities::field( 'html' );

		$document = $service->getResult();

		$text = '';
		if ( ( $document !== null ) && ( isset( $document[$htmlField] ) ) ) {
			$text = $document[$htmlField];
		}
		return $text;
	}

	/**
	 * Gets the cache key associated to an article
	 *
	 * @param  integer $articleId A valid article ID
	 *
	 * @return string The cache key associated to the article
	 */
	static public function getCacheKey( $articleId ) {
		return wfMemcKey(
			__CLASS__,
			self::CACHE_VERSION,
			$articleId
		);
	}

	/**
	 * Clear the snippet cache when the page is purged
	 */
	static public function onArticlePurge( WikiPage $page ) {
		/**
		 * @var $service ArticleService
		 */
		if ( $page->exists() ) {
			$id = $page->getId();

			F::app()->wg->Memc->delete( self::getCacheKey( $id ) );

			if ( array_key_exists( $id, self::$localCache ) ) {
				unset( self::$localCache[$id] );
			}
		}

		return true;
 	}

	/**
	 * Clear the cache when the page is edited
	 */
	static public function onArticleSaveComplete( WikiPage &$page, &$user, $text, $summary, $minoredit, $watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId ) {
		/**
		 * @var $service ArticleService
		 */
		if ( $page->exists() ) {
			$id = $page->getId();

			F::app()->wg->Memc->delete( self::getCacheKey( $id ) );

			if ( array_key_exists( $id, self::$localCache ) ) {
				unset( self::$localCache[$id] );
			}
		}

		return true;
	}
}
