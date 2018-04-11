<?php

use Wikia\Util\GlobalStateWrapper;

/**
 * A service to retrieve plain text snippets from articles
 *
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 */
class ArticleService extends WikiaObject {
	const MAX_LENGTH = 500;
	const CACHE_VERSION = 9;
	const SOLR_ARTICLE_TYPE_FIELD = 'article_type_s';

	/** @var Article $article */
	private $article = null;

	private static $localCache = array();

	/**
	 * Using SolrDocumentService to access preprocessed article content
	 * @var SolrDocumentService
	 */
	protected $solrDocumentService;

	private $solrHostname;

	/**
	 * ArticleService constructor
	 *
	 * @param Article|Title|int $articleOrId [OPTIONAL] An Article or Title instance or a valid article ID (lower performance)
	 */
	public function __construct( $articleOrId = null ) {
		parent::__construct();
		global $wgSolrHost, $wgSolrKvHost;
		if (isset($wgSolrKvHost)){
			$this->solrHostname = $wgSolrKvHost;
		} else {
			$this->solrHostname = $wgSolrHost;
		}

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
				86400 * 14 /* 14 days, same as parser cache */,
				function () use ( $service ) {
					return $service->getUncachedSnippetFromArticle();
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
	private function getUncachedSnippetFromArticle(): string {
		// get standard parser cache for anons,
		// 99% of the times it will be available but
		// generate it in case is not
		$page = $this->article->getPage();
		$opts = $page->makeParserOptions( new User() );
		$parserOutput = $page->getParserOutput( $opts );
		try {
			return $this->getContentFromParser( $parserOutput );
		} catch ( Exception $e ) {
			\Wikia\Logger\WikiaLogger::instance()->error(
				'ArticleService, not parser output object found',
				['parserOutput' => $parserOutput, 'parserOptions' => $opts, 'wikipage_dump' => $page, 'exception' => $e]
			);

			return '';
		}
	}

	private function getContentFromParser( $output ): string {
		global $wgContLang;

		if ( !$output instanceof ParserOutput ) {
			throw new Exception("Not ParserOutput instance.");
		}

		$text = $output->getText();
		$parser = new SnippetParser( $wgContLang );

		return $parser->getSnippet( $text );
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
		$wrapper = new GlobalStateWrapper(['wgSolrHost' => $this->solrHostname]);
		$document = $wrapper->wrap(function() {
			$service = new SolrDocumentService();
			$service->setArticleId( $this->article->getID() );
			return $service->getResult();
		});

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
	private static function getCacheKey( $articleId ): string {
		return wfMemcKey(
			__CLASS__,
			self::CACHE_VERSION,
			$articleId
		);
	}

	/**
	 * Regenerate article snippet when a page is edited
	 *
	 * @param WikiPage $page
	 * @param $editInfo
	 * @throws Exception
	 */
	public static function onArticleEditUpdates( WikiPage $page, $editInfo ) {
		global $wgMemc;

		$id = $page->getId();
		$service = new ArticleService( $id );

		$wgMemc->set( self::getCacheKey( $id ), $service->getContentFromParser( $editInfo->output ), 86400 * 14 );

		// clear in memory cache too
		if ( array_key_exists( $id, self::$localCache ) ) {
			unset( self::$localCache[$id] );
		}
	}
}
