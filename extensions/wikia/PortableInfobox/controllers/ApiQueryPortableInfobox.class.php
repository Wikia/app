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
					$sl = isset( $infobox[ 'sourcelabels' ] ) ?
						$infobox[ 'sourcelabels' ] :
						$this->sourceLabelsFallback( $infobox, $articleTitle );

					$pageSet->getResult()->addValue( [ 'query', 'pages', $id, 'infoboxes', $count ], 'id', $count );
					$pageSet->getResult()->setIndexedTagName( $sl, "sourcelabels" );
					$pageSet->getResult()->addValue(
						[ 'query', 'pages', $id, 'infoboxes', $count ], 'sourcelabels', $sl
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
	private function sourceLabelsFallback( $infobox, $title ) {
		global $wgCityId;

		Wikia\Logger\WikiaLogger::instance()->info( 'Portable Infobox ApiQuery sourcelabels fallback' );

		$task = new Wikia\Tasks\Tasks\RefreshLinksForTitleTask();
		$task->title( $title );
		$task->call( 'refresh' );
		$task->wikiId( $wgCityId );
		$task->queue();

		return $infobox[ 'sources' ] ? array_fill_keys( $infobox[ 'sources' ], '' ) : [ ];
	}
}
