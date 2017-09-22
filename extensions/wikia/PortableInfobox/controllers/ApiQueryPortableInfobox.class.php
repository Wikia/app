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

					$pageSet->getResult()->addValue(
						[ 'query', 'pages', $id, 'infoboxes', $count ],
						'parser_tag_version',
						$infobox['parser_tag_version']
					);

					$metadata = $infobox['metadata'];

					$pageSet->getResult()->addValue(
						[ 'query', 'pages', $id, 'infoboxes', $count ], 'metadata', $metadata
					);
					$pageSet->getResult()->setIndexedTagName_internal(
						[ 'query', 'pages', $id, 'infoboxes', $count, 'metadata' ],
						'metadata'
					);
					$this->setIndexedTagNamesForGroupMetadata(
						$metadata,
						[ 'query', 'pages', $id, 'infoboxes', $count, 'metadata' ],
						$pageSet->getResult()
					);
				}
			}
		}
	}

	/**
	 * XML format requires all indexed arrays to have _element defined
	 * This method adds it recursively for all groups
	 *
	 * @param array $metadata
	 * @param array $rootPath
	 * @param ApiResult $result
	 */
	private function setIndexedTagNamesForGroupMetadata( array $metadata, array $rootPath, ApiResult $result ) {
		foreach ( $metadata as $nodeCount => $node ) {
			if ( $node['type'] === 'group' ) {
				$path = array_merge( $rootPath, [ $nodeCount, 'metadata' ] );
				$result->setIndexedTagName_internal( $path, 'metadata' );
				$this->setIndexedTagNamesForGroupMetadata( $node[ 'metadata' ], $path, $result );
			}
		}
	}
}
