<?php

/**
 * Class SitemapXmlController
 *
 * This code is designed to generate XML sitemaps very fast.
 * A sitemap consisting of 10k URLs should be generated in a fraction of a second.
 *
 * To make this possible:
 *
 *  * Don't construct a Title object for every URL
 *  * Don't call wfTimestamp for each timestamp read from database
 *  * Don't use templates or XML-building libraries (including XMLWriter) to render the XML
 */
class SitemapXmlController extends WikiaController {
	/**
	 * Number of URLs to include per sitemap
	 */
	const URLS_PER_PAGE = 5000;

	/**
	 * Maximum size of a single sitemap (measured before any compression).
	 * If a sitemap exceeds this number, an error is logged to Kibana
	 */
	const SITEMAP_SIZE_LIMIT = 10 * 1024 * 1024;

	/**
	 * The namespaces that get their own sitemaps
	 */
	const SEPARATE_SITEMAPS = [
		NS_MAIN,
		NS_FILE,
		NS_CATEGORY,
	];

	/**
	 * All the other namespaces are merged into the "others" sitemap
	 * Well, all beside talk namespaces (odd-numbered), and those
	 */
	const EXCLUDED_NAMESPACES = [
		NS_USER,
		NS_PROJECT,
		NS_MEDIAWIKI,
		NS_TEMPLATE,
		NS_HELP,
		110,
		1100,
		1200,
		1202,
	];

	/**
	 * Each item in the sitemap gets a priority based on the article namespace
	 */
	const PRIORITIES = [
		NS_MAIN => '1.0',
		NS_CATEGORY => '1.0',
	];

	/**
	 * If not listed above, here's the default priority to use
	 */
	const DEFAULT_PRIORITY = '0.5';

	/**
	 * @var SitemapXmlModel
	 */
	private $model;

	public function __construct() {
		$this->model = new SitemapXmlModel();
	}

	public function index() {
		$start = microtime( true ) * 1000;
		$response = $this->getResponse();

		$path = $this->getRequest()->getVal( 'path', 'sitemap-index.xml' );
		$parsedPath = $this->parsePath( $path );

		if ( $parsedPath->index ) {
			$out = $this->generateSitemapIndex();
		} elseif ( $parsedPath->namespaces ) {
			$out = $this->generateSitemapPage( $parsedPath->namespaces, $parsedPath->page );
		} else {
			$title = ( new WikiaHtmlTitle() )->setParts( [ 'Not Found' ] )->getTitle();
			$body = '<title>%s</title><h1>Not Found</h1><p>The requested URL was not found</p>';

			$response->setCode( 404 );
			$response->setBody( sprintf( $body, htmlspecialchars( $title ) ) );
			return;
		}

		$out .= sprintf( '<!-- Generation time: %dms -->' . PHP_EOL, microtime( true ) * 1000 - $start );
		$out .= sprintf( '<!-- Generation date: %s -->' . PHP_EOL, wfTimestamp( TS_ISO_8601 ) );

		if ( !$this->isRequestedGzipped() ) {
			$out .= '<!-- Sitemap requested without gzip! -->' . PHP_EOL;
			\Wikia\Logger\WikiaLogger::instance()->warning( 'Sitemap requested without gzip', [
				'ex' => new Exception( 'Sitemap requested without gzip' ),
				'path' => $path,
				'user-agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'null',
			] );
		}

		if ( strlen( $out ) > self::SITEMAP_SIZE_LIMIT ) {
			$out .= '<!-- Sitemap is too big! -->' . PHP_EOL;
			\Wikia\Logger\WikiaLogger::instance()->error( 'Sitemap is too big', [
				'ex' => new Exception( 'Sitemap is too big' ),
				'curSize' => strlen( $out ),
				'maxSize' => self::SITEMAP_SIZE_LIMIT,
				'path' => $path,
			] );
		}

		$response->setContentType( 'application/xml; charset=utf-8' );
		$response->setCacheValidity( WikiaResponse::CACHE_STANDARD );
		$response->setBody( $out );
	}

	private function getIso8601Timestamp( $touched ) {
		return
			$touched[0] . $touched[1] . $touched[2] . $touched[3] . '-' .
			$touched[4] . $touched[5] . '-' .
			$touched[6] . $touched[7] . 'T' .
			$touched[8] . $touched[9] . ':' .
			$touched[10] . $touched[11] . ':' .
			$touched[12] . $touched[13] . 'Z';
	}

	private function getOtherNamespaces() {
		$nsIds = array_unique( $this->wg->ContLang->getNamespaceIds() );
		return array_filter( $nsIds, [ $this, 'isOtherNamespace' ] );
	}

	private function generateSitemapPage( array $namespaces, $page ) {
		$out = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
		$out .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;
		$out .= '<!-- Namespaces: ' . implode( ', ', $namespaces ) . '; page: ' . $page . ' -->' . PHP_EOL;

		$offset = self::URLS_PER_PAGE * ( $page - 1 );
		$limit = self::URLS_PER_PAGE;

		foreach ( $namespaces as $ns ) {
			$priority[$ns] = self::PRIORITIES[$ns] ?? self::DEFAULT_PRIORITY;
			$title = Title::newFromText( '$1', $ns );
			$urlPrefix[$ns] = str_replace( '$1', '', $title->getFullURL() );
		}

		foreach ( $this->model->getItems( $namespaces, $offset, $limit ) as $page ) {
			$encodedTitle = wfUrlencode( str_replace( ' ', '_', $page->page_title ) );
			$lastmod = $this->getIso8601Timestamp( $page->page_touched );

			$out .= '<url>' . PHP_EOL;
			$out .= '<loc>' . $urlPrefix[$page->page_namespace] . $encodedTitle . '</loc>' . PHP_EOL;
			$out .= '<lastmod>' . $lastmod . '</lastmod>' . PHP_EOL;
			$out .= '<priority>' . $priority[$page->page_namespace] . '</priority>' . PHP_EOL;
			$out .= '</url>' . PHP_EOL;
		}

		$out .= '</urlset>' . PHP_EOL;
		return $out;
	}

	private function generateSitemapIndex() {
		$out = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
		$out .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

		$baseUrl = $this->wg->Server;

		foreach ( self::SEPARATE_SITEMAPS as $ns ) {
			$nsPages = $this->model->getPageNumber( [ $ns ], self::URLS_PER_PAGE );
			for ( $page = 1; $page <= $nsPages; $page++ ) {
				$url = $baseUrl . '/sitemap-newsitemapxml-NS_' . $ns . '-p' . $page . '.xml';
				$out .= '<sitemap><loc>' . $url . '</loc></sitemap>' . PHP_EOL;
			}
		}

		$otherPages = $this->model->getPageNumber( $this->getOtherNamespaces(), self::URLS_PER_PAGE );

		for ( $page = 1; $page <= $otherPages; $page++ ) {
			$url = $baseUrl . '/sitemap-newsitemapxml-others-p' . $page . '.xml';
			$out .= '<sitemap><loc>' . $url . '</loc></sitemap>' . PHP_EOL;
		}

		$out .= '</sitemapindex>' . PHP_EOL;

		return $out;
	}

	private function isOtherNamespace( $nsId ) {
		// Exclude negative namespaces
		if ( $nsId < 0 ) {
			return false;
		}

		// Exclude namespaces with separate sitemaps
		if ( in_array( $nsId, self::SEPARATE_SITEMAPS ) ) {
			return false;
		}

		// Exclude talk pages
		if ( $nsId % 2 !== 0 ) {
			return false;
		}

		// Excluded namespaces
		if ( in_array( $nsId, self::EXCLUDED_NAMESPACES ) ) {
			return false;
		}

		return true;
	}

	private function isRequestedGzipped() {
		$acceptEncoding = $_SERVER['HTTP_ACCEPT_ENCODING'] ?? '';
		return strpos( $acceptEncoding, 'gzip' ) !== false;
	}

	private function parsePath( $path ) {
		$parsed = (object) [
			'index' => false,
			'namespaces' => null,
			'page' => null,
		];

		if ( $path === 'sitemap-newsitemapxml-index.xml' || $path === 'sitemap-index.xml' ) {
			$parsed->index = true;
			return $parsed;
		}

		$m = null;

		if ( !preg_match(
			'/^sitemap-(newsitemapxml-)?(others|NS_([0-9]+))-p(\d+)\.xml$/', $path, $m )
		) {
			return $parsed;
		}

		$space = $m[2];
		$specificNamespace = intval( $m[3] );
		$page = intval( $m[4] );

		if ( $space !== 'others' && !in_array( $specificNamespace, self::SEPARATE_SITEMAPS ) ) {
			return $parsed;
		}

		$parsed->namespaces = ( $space === 'others' ) ? $this->getOtherNamespaces() : [ $specificNamespace ];
		$parsed->page = $page;

		return $parsed;
	}

}
