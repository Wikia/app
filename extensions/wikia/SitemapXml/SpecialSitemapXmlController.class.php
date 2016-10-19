<?php

/**
 * Class SpecialSitemapXmlController
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
class SpecialSitemapXmlController extends WikiaSpecialPageController {
	const URLS_PER_PAGE = 5000;

	const PRIORITIES = [
		NS_MAIN => '1.0',
		NS_CATEGORY => '1.0',
	];

	const SEPARATE_SITEMAPS = [
		NS_MAIN,
		NS_FILE,
	];

	const DEFAULT_PRIORITY = '0.5';

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

	private $model;

	public function __construct( $name = 'SitemapXml' ) {
		parent::__construct( $name, '', false );
		$this->model = new SitemapXmlModel();
	}

	public function execute( $subpage ) {
		$start = microtime( true ) * 1000;

		if ( $subpage === 'sitemap-index.xml' ) {
			$this->getOutput()->disable();

			header( 'Content-type: application/xml; charset=utf-8' );
			header( 'Cache-Control: maxage=86400' );

			echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
			echo '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

			$baseUrl = $this->getTitle()->getFullURL();

			$ns_0_pages = $this->model->getNumberOfPagesForNamespaces( [ NS_MAIN ], self::URLS_PER_PAGE );
			$ns_6_pages = $this->model->getNumberOfPagesForNamespaces( [ NS_FILE ], self::URLS_PER_PAGE );
			$other_pages = $this->model->getNumberOfPagesForNamespaces( $this->getOtherNamespaces(), self::URLS_PER_PAGE );

			for ( $page = 1; $page <= $ns_0_pages; $page++ ) {
				$url = $baseUrl . '/sitemap-NS_0-p' . $page . '.xml';
				echo '<sitemap><loc>' . $url . '</loc></sitemap>' . PHP_EOL;
			}

			for ( $page = 1; $page <= $ns_6_pages; $page++ ) {
				$url = $baseUrl . '/sitemap-NS_6-p' . $page . '.xml';
				echo '<sitemap><loc>' . $url . '</loc></sitemap>' . PHP_EOL;
			}

			for ( $page = 1; $page <= $other_pages; $page++ ) {
				$url = $baseUrl . '/sitemap-other-p' . $page . '.xml';
				echo '<sitemap><loc>' . $url . '</loc></sitemap>' . PHP_EOL;
			}

			echo '</sitemapindex>' . PHP_EOL;
			echo sprintf( '<!-- Generation time: %dms -->' . PHP_EOL, microtime( true ) * 1000 - $start );
			echo sprintf( '<!-- Generation date: %s -->' . PHP_EOL, wfTimestamp( TS_ISO_8601 ) );

			return;
		}

		$m = null;
		if ( !preg_match( '/^sitemap-([\w_]+)-p(\d+)\.xml$/', $subpage, $m ) ) {
			return;
		}

		$space = $m[1];
		$page = $m[2];

		if ( !in_array( $space, [ 'NS_0', 'NS_6', 'other' ] ) ) {
			return;
		}

		$this->getOutput()->disable();

		header( 'Content-type: application/xml; charset=utf-8' );
		header( 'Cache-Control: maxage=86400' );

		echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
		echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

		if ( $space === 'NS_0' ) {
			echo '<!-- Namespace ' . NS_MAIN . '; page: ' . $page . ' -->' . PHP_EOL;
			$this->printNamespace( [ NS_MAIN ], self::URLS_PER_PAGE * ( $page - 1 ), self::URLS_PER_PAGE );
		}

		if ( $space === 'NS_6' ) {
			echo '<!-- Namespace ' . NS_FILE . '; page: ' . $page . ' -->' . PHP_EOL;
			$this->printNamespace( [ NS_FILE ], self::URLS_PER_PAGE * ( $page - 1 ), self::URLS_PER_PAGE );
		}

		if ( $space === 'other' ) {
			$nses = $this->getOtherNamespaces();
			echo '<!-- Namespaces: ' . implode( ', ', $nses ) . '; page: ' . $page . ' -->' . PHP_EOL;
			$this->printNamespace( $nses, self::URLS_PER_PAGE * ( $page - 1 ), self::URLS_PER_PAGE );
		}

		echo '</urlset>' . PHP_EOL;
		echo sprintf( '<!-- Generation time: %dms -->' . PHP_EOL, microtime( true ) * 1000 - $start );
		echo sprintf( '<!-- Generation date: %s -->' . PHP_EOL, wfTimestamp( TS_ISO_8601 ) );
	}

	private function getOtherNamespaces() {
		$nsIds = array_unique( $this->wg->ContLang->getNamespaceIds() );

		return array_filter( $nsIds, function ( $id ) {
			// Exclude negative namespaces
			if ( $id < 0 ) {
				return false;
			}

			// Exclude namespaces with separate sitemaps
			if ( in_array( $id, self::SEPARATE_SITEMAPS ) ) {
				return false;
			}

			// Exclude talk pages
			if ( $id % 2 !== 0 ) {
				return false;
			}

			// Excluded namespaces
			if ( in_array( $id, self::EXCLUDED_NAMESPACES ) ) {
				return false;
			}

			return true;
		} );
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

	private function printNamespace( array $nses, $offset, $limit ) {
		foreach ( $nses as $ns ) {
			$priority[$ns] = self::PRIORITIES[$ns] ?? self::DEFAULT_PRIORITY;
			$title = Title::newFromText( '$1', $ns );
			$urlPrefix[$ns] = str_replace( '$1', '', $title->getFullURL() );
		}

		foreach ( $this->model->getPages( $nses, $offset, $limit ) as $row ) {
			echo '<url>' . PHP_EOL;
			echo '<loc>' . $urlPrefix[$row->page_namespace] . wfUrlencode( str_replace( ' ', '_', $row->page_title ) ) . '</loc>' . PHP_EOL;
			echo '<lastmod>' . $this->getIso8601Timestamp( $row->page_touched ) . '</lastmod>' . PHP_EOL;
			echo '<priority>' . $priority[$row->page_namespace] . '</priority>' . PHP_EOL;
			echo '</url>' . PHP_EOL;
		}
	}
}
