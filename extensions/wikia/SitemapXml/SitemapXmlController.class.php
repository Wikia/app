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
		NS_CATEGORY,
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
		} elseif ( is_int( $parsedPath->namespace ) ) {
			$out = $this->generateSitemapPage( $parsedPath->namespace, $parsedPath->begin,  $parsedPath->end  );
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

	private function getLastMod( $touched ) {
		global $wgDomainChangeDate;
		$touchedTime = strtotime( $touched );
		if ( !empty( $wgDomainChangeDate ) ) {
			$domainChangeTime = strtotime( $wgDomainChangeDate );
			if ( $domainChangeTime > $touchedTime ) {
				return date( 'Y-m-d\TH:i:s\Z', $domainChangeTime );
			}
		}

		return date( 'Y-m-d\TH:i:s\Z', $touchedTime );
	}

	private function generateSitemapPage($namespace, $begin, $end ) {
		$out = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
		$out .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;
		$out .= '<!-- Namespace: ' . $namespace . '; begin: ' . $begin . '; end: ' . $end . ' -->' . PHP_EOL;


		$priority = self::PRIORITIES[$namespace] ?? self::DEFAULT_PRIORITY;
		$title = Title::newFromText( '$1', $namespace );
		$urlPrefix = str_replace( '$1', '', $title->getFullURL() );

		foreach ($this->model->getItemsBetween( $namespace, $begin, $end ) as $item ) {
			$encodedTitle = wfUrlencode( str_replace( ' ', '_', $item->page_title ) );
			$lastmod = $this->getLastMod( $item->page_touched );

			$out .= '<url>' . PHP_EOL;
			$out .= '<loc>' . $urlPrefix . $encodedTitle . '</loc>' . PHP_EOL;
			$out .= '<lastmod>' . $lastmod . '</lastmod>' . PHP_EOL;
			$out .= '<priority>' . $priority . '</priority>' . PHP_EOL;
			$out .= '</url>' . PHP_EOL;
		}

		$out .= '</urlset>' . PHP_EOL;
		return $out;
	}

	private function generateSitemapIndex() {
		global $wgCityId, $wgEnableDiscussions;

		$out = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
		$out .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

		$baseUrl = $this->wg->Server . $this->wg->ScriptPath;

		foreach ( self::SEPARATE_SITEMAPS as $ns ) {
			$prev = "0";
			foreach ( $this->model->getSubSitemaps( $ns, self::URLS_PER_PAGE ) as $page ) {
				$url = $baseUrl . '/sitemap-newsitemapxml-NS_' . $ns . '-id-' .$prev. '-' . $page->page_id .'.xml';
				$out .= '<sitemap><loc>' . $url . '</loc></sitemap>' . PHP_EOL;
				$prev = $page->page_id;
			}
		}

		if ( $wgEnableDiscussions ) {
			$urlProvider = new \Wikia\Service\Gateway\KubernetesExternalUrlProvider();
			$discussionsSitemapUrl = $urlProvider->getUrl( 'discussions-sitemap' ) . '/sitemap/' . $wgCityId;
			$out .= '<sitemap><loc>' . $discussionsSitemapUrl . '</loc></sitemap>' . PHP_EOL;
		}

		$out .= '</sitemapindex>' . PHP_EOL;

		return $out;
	}

	private function isRequestedGzipped() {
		$acceptEncoding = $_SERVER['HTTP_ACCEPT_ENCODING'] ?? '';
		return strpos( $acceptEncoding, 'gzip' ) !== false;
	}

	private function parsePath( $path ) {
		$parsed = (object) [
			'index' => false,
			'namespace' => null,
			'begin' => null,
			'end' => null,
		];

		if ( $path === 'sitemap-newsitemapxml-index.xml' || $path === 'sitemap-index.xml' ) {
			$parsed->index = true;
			return $parsed;
		}

		$m = null;

		if ( !preg_match(
			'/^sitemap-(newsitemapxml-)?(NS_([0-9]+))-id-(\d+)-(\d+)\.xml$/', $path, $m )
		) {
			return $parsed;
		}

		$space = $m[2];
		$specificNamespace = intval( $m[3] );
		$begin = intval( $m[4] );
		$end = intval( $m[5] );

		if ( !in_array( $specificNamespace, self::SEPARATE_SITEMAPS ) ) {
			return $parsed;
		}

		$parsed->namespace = $specificNamespace;
		$parsed->begin = $begin;
		$parsed->end = $end;

		return $parsed;
	}

}
