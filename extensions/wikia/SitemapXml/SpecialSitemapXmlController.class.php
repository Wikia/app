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
 *
 * Next steps:
 *
 *  * Separate namespaces for NS_MAIN, NS_FILE and others
 *  * "Paginated" sitemaps for bigger wikis
 *  * Include some special pages (Special:Images, Special:Videos, Local_Sitemap)
 */
class SpecialSitemapXmlController extends WikiaSpecialPageController {
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
		parent::__construct( $name, '', false );
	}

	public function execute( $subpage ) {
		$this->getOutput()->disable();

		$start = microtime( true ) * 1000;

		header( 'Content-type: application/xml; charset=utf-8' );
		header( 'Cache-Control: maxage=86400' );

		echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
		echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

		foreach ( $this->getNamespaces() as $ns ) {
			echo '<!-- Namespace ' . $ns . ' -->' . PHP_EOL;
			$this->printNamespace( $ns );
		}

		echo '</urlset>' . PHP_EOL;
		echo sprintf( '<!-- Generation time: %dms -->' . PHP_EOL, microtime( true ) * 1000 - $start );
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

	private function getNamespaces() {
		$nsIds = array_unique( $this->wg->ContLang->getNamespaceIds() );

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

	private function printNamespace( $ns ) {
		$priority = self::PRIORITIES[$ns] ?? self::DEFAULT_PRIORITY;

		$title = Title::newFromText( '$1', $ns );
		$urlPrefix = str_replace( '$1', '', $title->getFullURL() );

		$dbr = wfGetDB( DB_SLAVE );

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
			echo '<url>' . PHP_EOL;
			echo '<loc>' . $urlPrefix . wfUrlencode( str_replace( ' ', '_', $row->page_title ) ) . '</loc>' . PHP_EOL;
			echo '<lastmod>' . $this->getIso8601Timestamp( $row->page_touched ) . '</lastmod>' . PHP_EOL;
			echo '<priority>' . $priority . '</priority>' . PHP_EOL;
			echo '</url>' . PHP_EOL;
		}
	}
}
