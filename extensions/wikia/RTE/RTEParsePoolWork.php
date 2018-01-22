<?php

/**
 * PoolCounter job for producing RTE parser output for a given page + revision.
 * @see PoolWorkArticleView - regular parser output counterpart
 */
class RTEParsePoolWork extends PoolCounterWork {
	/** @var RTEParserCache $parserCache */
	private $parserCache;

	/** @var EditPage $editPage */
	private $editPage;

	/** @var int $revisionId */
	private $revisionId;

	/** @var RTEParser $rteParser */
	private $rteParser;

	/** @var ParserOptions $parserOptions */
	private $parserOptions;

	/** @var ParserOutput $parserOutput */
	private $parserOutput;

	function __construct( RTEParserCache $parserCache, EditPage $editPage, ParserOptions $parserOptions ) {
		$article = $editPage->getArticle();

		$revisionId = $article->getRevIdFetched();
		$parserCacheKey = $parserCache->getKey( $article, $parserOptions );

		$poolCounterKey = "$parserCacheKey:revision:$revisionId";

		parent::__construct( 'RTEParsePool', $poolCounterKey );

		// Tell PoolCounter whether it can use cached results for this work
		$this->cacheable = $article->getPage()->isParserCacheUsed( $parserOptions, $revisionId );

		$this->parserCache = $parserCache;
		$this->rteParser = new RTEParser();
		$this->editPage = $editPage;
		$this->revisionId = $revisionId;
		$this->parserOptions = $parserOptions;
	}

	/**
	 * Actually perform the work, caching it if needed.
	 */
	function doWork() {
		$cacheTime = wfTimestampNow();

		$this->parserOutput = $this->rteParser->parse(
			$this->editPage->textbox1,
			$this->editPage->getTitle(),
			$this->parserOptions,
			true,
			true,
			$this->revisionId );

		if ( $this->cacheable && $this->parserOutput->isCacheable() ) {
			// set a custom TTL (7 days instead of 14 for normal parser output)
			$this->parserOutput->updateCacheExpiry( RTEParserCache::TTL );

			$this->parserCache->save(
				$this->parserOutput,
				$this->editPage->getArticle(),
				$this->parserOptions,
				$cacheTime );
		}

		return true;
	}

	function getCachedWork() {
		$cachedParserOutput = $this->parserCache->get( $this->editPage->getArticle(), $this->parserOptions );

		if ( $cachedParserOutput instanceof ParserOutput ) {
			$this->parserOutput = $cachedParserOutput;
			return true;
		}

		return false;
	}

	function fallback() {
		$dirtyParserOutput = $this->parserCache->getDirty( $this->editPage->getArticle(), $this->parserOptions );

		if ( $dirtyParserOutput instanceof ParserOutput ) {
			$this->parserOutput = $dirtyParserOutput;
			return true;
		}

		return false;
	}

	/**
	 * @return ParserOutput
	 */
	public function getParserOutput(): ParserOutput {
		return $this->parserOutput;
	}
}
