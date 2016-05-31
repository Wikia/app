<?php
/**
 * A service to retrieve plain text snippets from articles
 *
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 */
class ArticleService extends WikiaObject {
	const MAX_LENGTH = 500;
	const CACHE_VERSION = 9;
	const SOLR_SNIPPETS_FIELD = 'snippet_s';
	const SOLR_ARTICLE_TYPE_FIELD = 'article_type_s';

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
		// strip decimal entities
		'/&#\d{2,5};/u' => '',
		// strip hex entities
		'/&#x[a-fA-F0-7]{2,8};/u' => '',
		// this should be always the last
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
	 * @return ArticleService fluent interface
	 */
	public function setArticleById( $articleId ) {
		$this->article = Article::newFromID( $articleId );
		return $this;
	}

	/**
	 * Sets the Article instance via Title object
	 * @param Title $title Title object
	 * class to use as a source of content
	 * @return ArticleService fluent interface
	 */
	public function setArticleByTitle( Title $title ) {
		$this->article = new Article( $title );
		return $this;
	}

	/**
	 * Gets a plain text snippet from an article.  An optional second argument allows a break limit.
	 * When given, if the text is greater than $breakLimit, truncate it to $length, if its less than
	 * $breakLimit, return the whole snippet.  This allows better snippets for text that is very close
	 * in character count to $length.
	 *
	 * For example if $length=100 and $breakLimit=200 and the source text is 205 characters, the content
	 * will be truncated at the word closest to 100 characters.  If the source text is 150 characters,
	 * then this method will return all 150 characters.
	 *
	 * If however we only give one parameter, $length=200 and the source text is 205 characters, we
	 * will return text truncated at the word nearest 200 characters, likely only leaving out a single
	 * word from the snippet.  This can lead to a strange user experience in some cases (e.g. a user
	 * clicks a link in a notification email to see the full edit and finds that there's only one word
	 * they weren't able to read from the email)
	 *
	 * @param integer $length [OPTIONAL] The maximum snippet length, defaults to 100
	 * @param integer $breakLimit A breakpoint for showing the full snippet.
	 *
	 * @return string The plain text snippet, it includes SUFFIX at the end of the string
	 * if the length of the article's content is longer than $length, the text will be cut
	 * respecting the integrity of the words
	 *
	 * @throws WikiaException If $length is bigger than MAX_LENGTH
	 *
	 * @example
	 * $service = new ArticleService( $article );
	 * $snippet = $service->getTextSnippet( 250, 400 );
	 *
	 * $service->setArticleById( $title->getArticleID() );
	 * $snippet = $service->getTextSnippet( 50 );
	 *
	 * $service->setArticle( $anotherArticle );
	 * $snippet = $service->getTextSnippet();
	 */
	public function getTextSnippet( $length = 100, $breakLimit = null ) {
		// don't allow more than the maximum to avoid flooding Memcached
		if ( $length > self::MAX_LENGTH ) {
			throw new WikiaException( 'Maximum allowed length is ' . self::MAX_LENGTH );
		}

		// It may be that the article is just not there
		if ( !( $this->article instanceof Article ) ) {
			return '';
		}

		$id = $this->article->getID();
		if ( $id <= 0 ) {
			return '';
		}

		$text = $this->getTextSnippetSource( $id );
		$length = $this->adjustTextSnippetLength( $text, $length, $breakLimit );
		$snippet = wfShortenText( $text, $length, $useContentLanguage = true );

		return $snippet;
	}

	private function getTextSnippetSource( $articleId ) {
		// Memoize to avoid Memcache access overhead when the same article needs to be processed
		// more than once in the same process
		if ( array_key_exists( $articleId, self::$localCache ) ) {
			$text = self::$localCache[$articleId];
		} else {
			$key = self::getCacheKey( $articleId );
			$service = $this;
			$text = self::$localCache[$articleId] = WikiaDataAccess::cache(
				$key,
				86400 /*24h*/,
				function() use ( $service ) {
					$content = '';
					if ( !$this->wg->DevelEnvironment && !empty( $this->wg->SolrMaster ) ) {
						$content = $service->getTextFromSolr();
					}

					if ( $content === '' ) {
						// back-off is to use mediawiki
						$content = $service->getUncachedSnippetFromArticle();
					}

					return $content;
				}
			);
		}

		return $text;
	}

	private function adjustTextSnippetLength( $text, $length, $breakLimit ) {
		if ( empty( $breakLimit ) ) {
			return $length;
		}

		$textLength = mb_strlen( $text );
		if ( $textLength >= $breakLimit ) {
			return $length;
		}

		return $breakLimit;
	}

	/**
	 * Accesses a snippet from MediaWiki.
	 * @return string
	 */
	public function getUncachedSnippetFromArticle()
	{
		// get standard parser cache for anons,
		// 99% of the times it will be available but
		// generate it in case is not
		$content = '';
		$page = $this->article->getPage();
		$opts = $page->makeParserOptions( new User() );
		$parserOutput = $page->getParserOutput( $opts );
		try {
			$content = $this->getContentFromParser( $parserOutput );
		} catch ( Exception $e ) {
			\Wikia\Logger\WikiaLogger::instance()->error(
				'ArticleService, not parser output object found',
				['parserOutput' => $parserOutput, 'parserOptions' => $opts, 'wikipage_dump' => $page, 'exception' => $e]
			);
		}

		// Run hook to allow wikis to modify the content (ie: customize their snippets) before the stripping and length limitations are done.
		wfRunHooks( 'ArticleService::getTextSnippet::beforeStripping', array( &$this->article, &$content, ArticleService::MAX_LENGTH ) );

		return $this->cleanArticleSnippet( $content );
	}

	/**
	 * Cleans up the content of the article snippet
	 *
	 * @param string $content
	 * @return string
	 */
	public function cleanArticleSnippet( $content ) {
		if ( mb_strlen( $content ) > 0 ) {
			// remove all unwanted tag pairs and their contents
			foreach ( $this->tags as $tag ) {
				$content = preg_replace( "/<{$tag}\b[^>]*>.*<\/{$tag}>/imsU", '', $content );
			}

			// cleanup remaining tags
			$content = strip_tags( $content );

			// apply some replacements
			foreach ( $this->patterns as $reg => $rep ) {
				$content = preg_replace( $reg, $rep, $content );
			}

			// decode entities
			$content = html_entity_decode( $content );
			$content = trim( $content );

			if ( mb_strlen( $content ) > ArticleService::MAX_LENGTH ) {
				$content = mb_substr( $content, 0, ArticleService::MAX_LENGTH );
			}
		}
		return $content;
	}

	private function getContentFromParser( $output ) {
		if ( !$output instanceof ParserOutput ) {
			throw new Exception("Not ParserOutput instance.");
		}
		return $output->getText();
	}

	/**
	 * Gets a plain text of an article using Solr.
	 *
	 * @return string The plain text as stored in solr. Will be empty if we don't have a result.
	 */
	public function getTextFromSolr() {
		global $wgSolrHost, $wgSolrKvHost;
		$wgSolrHost = $wgSolrKvHost;
		$service = new SolrDocumentService();
		// note that this will use wgArticleId without an article
		if ( $this->article ) {
			$service->setArticleId( $this->article->getId() );
		}
		$htmlField = Wikia\Search\Utilities::field( 'html' );

		$document = $service->getResult();

		$text = '';
		if ( $document !== null ) {
			if ( !empty( $document[ static::SOLR_SNIPPETS_FIELD ] ) ) {
				$text = $document[ static::SOLR_SNIPPETS_FIELD ];
			} elseif ( isset( $document[$htmlField] ) ) {
				$text = $document[$htmlField];
			}
		}
		return $text;
	}

	/**
	 * Gets the article type using Solr.
	 * Since SolrDocumentService uses memoization, we will NOT do an additional Solr request
	 * because of this method - both snippet and article type can use the same memoized
	 * result
	 *
	 * @return string The plain text as stored in solr. Will be empty if we don't have a result.
	 */
	public function getArticleType() {
		if ( !($this->article instanceof Article ) ) {
			return '';
		}
		global $wgSolrHost, $wgSolrKvHost;
		$wgSolrHost = $wgSolrKvHost;

		$service = new SolrDocumentService();
		$service->setArticleId( $this->article->getId() );
		$document = $service->getResult();

		$text = '';
		if ( $document !== null ) {
			if ( !empty( $document[ static::SOLR_ARTICLE_TYPE_FIELD] ) ) {
				$text = $document[ static::SOLR_ARTICLE_TYPE_FIELD];
			}
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
