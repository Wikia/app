<?php

/**
 * Class BetterXmlSitemapController
 *
 * This code is designed to generate sitemaps very fast.
 * A sitemap consisting of 10k URLs should be generated in a fraction of a second.
 *
 * Things to avoid to make this possible:
 *
 *  * Don't construct Title for every URL
 *  * Don't call wfTimestamp for each timestamp read from database
 *  * Don't use templates or XML-building libraries (including XMLWriter) to render the XML
 *
 * Next steps:
 *
 *  * Separate namespaces for NS_MAIN, NS_FILE and others
 *  * "Paginated" sitemaps
 */
class BetterXmlSitemapController extends WikiaSpecialPageController {
	const PRIORITIES = [
		NS_MAIN => '1.0',
		NS_CATEGORY => '1.0',
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

	public function __construct( $name = 'BetterXmlSitemap' ) {
		parent::__construct( $name );
	}

	private function getNamespaces() {
		global $wgContLang;

		$nsIds = array_unique( $wgContLang->getNamespaceIds() );

		return array_filter( $nsIds, function ( $id ) {
			// Exclude negative namespaces
			if ( $id < 0 ) {
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

	public function execute( $subpage ) {
		$this->getOutput()->disable();

		$start = microtime( true ) * 1000;

		header( 'Content-type: application/xml; charset=utf-8' );

		echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
		echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

		foreach ( $this->getNamespaces() as $ns ) {
			echo '<!-- Namespace ' . $ns . ' -->' . PHP_EOL;
			$this->printNamespace( $ns );
		}

		echo '</urlset>' . PHP_EOL;
		echo sprintf( '<!-- Generation time: %dms -->' . PHP_EOL, microtime( true ) * 1000 - $start );
	}

	private function printNamespace( $ns ) {
		$priority = self::PRIORITIES[$ns] ? : self::DEFAULT_PRIORITY;

		$title = Title::newFromText( '$1', $ns );
		$urlPrefix = str_replace( '$1', '', $title->getFullURL() );

		$dbr = wfGetDB( DB_SLAVE, 'vslow' );

		$query = $dbr->select(
			'page',
			[
				'page_title',
				'page_touched',
			],
			[
				'page_namespace' => $ns,
				'page_is_redirect' => false,
			],
			__METHOD__,
			[
				'ORDER BY' => 'page_id',
				'USE INDEX' => 'PRIMARY',
				'LIMIT' => 15000,
			]
		);

		while ( $row = $dbr->fetchObject( $query ) ) {
			$iso8601 = $row->page_touched[0] . $row->page_touched[1] . $row->page_touched[2] . $row->page_touched[3] . '-' .
				$row->page_touched[4] . $row->page_touched[5] . '-' .
				$row->page_touched[6] . $row->page_touched[7] . 'T' .
				$row->page_touched[8] . $row->page_touched[9] . ':' .
				$row->page_touched[10] . $row->page_touched[11] . ':' .
				$row->page_touched[12] . $row->page_touched[13] . 'Z';

			$url = $urlPrefix . wfUrlencode( str_replace( ' ', '_', $row->page_title ) );

			echo '<url>' . PHP_EOL;
			echo '<loc>' . $url . '</loc>' . PHP_EOL;
			echo '<lastmod>' . $iso8601 . '</lastmod>' . PHP_EOL;
			echo '<priority>' . $priority . '</priority>' . PHP_EOL;
			echo '</url>' . PHP_EOL;
		}
	}
}
