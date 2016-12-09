<?php


class ApiQueryPortableInfobox extends ApiQueryBase {

	public function __construct( $query, $moduleName ) {
		parent::__construct( $query, $moduleName, 'ib' );
	}

	public function execute() {
		$this->runOnPageSet( $this->getPageSet() );
	}

	public function getVersion() {
		return __CLASS__ . '$Id$';
	}

	protected function runOnPageSet( ApiPageSet $pageSet ) {
		$articles = $pageSet->getGoodTitles();

		foreach ( $articles as $id => $articleTitle ) {
			$parsedInfoboxes = PortableInfoboxDataService::newFromTitle( $articleTitle )->getData();

			if ( is_array( $parsedInfoboxes ) && count( $parsedInfoboxes ) ) {
				$inf = [ ];

				foreach ( array_keys( $parsedInfoboxes ) as $k => $v ) {
					$inf[ $k ] = [ ];
				}

				$pageSet->getResult()->setIndexedTagName( $inf, 'infobox' );
				$pageSet->getResult()->addValue( [ 'query', 'pages', $id ], 'infoboxes', $inf );

				foreach ( $parsedInfoboxes as $count => $infobox ) {
					$pageSet->getResult()->addValue( [ 'query', 'pages', $id, 'infoboxes', $count ], 'id', $count );

					$metadata = $infobox['metadata'] ?? $this->metadataFallback( $infobox, $articleTitle );

					$pageSet->getResult()->setIndexedTagName( $metadata, 'metadata' );
					$pageSet->getResult()->addValue(
						[ 'query', 'pages', $id, 'infoboxes', $count ], 'metadata', $metadata
					);
				}
			}
		}
	}

	/**
	 * We still have old infobox sources in page properties, so we need this fallback.
	 * Monitor kibana and remove it after logs stop appear
	 *
	 * @param $infobox
	 * @param $title
	 * @return array
	 */
	private function metadataFallback( $infobox, $title ) {
		global $wgCityId;

		Wikia\Logger\WikiaLogger::instance()->info( 'Portable Infobox ApiQuery metadata fallback' );

		$task = new Wikia\Tasks\Tasks\RefreshLinksForTitleTask();
		$task->setTitle( $title );
		$task->title( $title );
		$task->call( 'refresh' );
		$task->wikiId( $wgCityId );
		$task->queue();

		// TODO reparse and get fresh data
		$data = PortableInfoboxDataService::newFromTitle( $title )->purge()->getData();
		var_dump($infobox);
		var_dump($data);
		die;

		return $infobox[ 'sources' ] ? array_fill_keys( $infobox[ 'sources' ], '' ) : [ ];
	}
}
