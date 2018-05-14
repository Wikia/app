<?php

class ArticleCommentUserNameRemover {

	private $batchSize;

	public function doMigration() {
		$lbFactory = wfGetLBFactory();
		$dbr = wfGetDB( DB_SLAVE );

		do {
			$res = $this->getTitlesAfter( $dbr );

			foreach ( $res as $row ) {
				if ( strpos( $row->page_title, ARTICLECOMMENT_PREFIX ) !== false ) {
					list( $title, $parts ) = explode( '/', $row->page_title, 2 );

				}
			}
		}
	}

	private function processTitle( string $title ): string {
		list( $base, $parts ) = explode( '/', $title, 2 );


	}

	private function getTitlesAfter( DatabaseBase $dbr, string $offset = '' ) {
		return $dbr->select(
			'page',
			[ 'page_namespace', 'page_title' ],
			[ 'page_namespace' => $this->namespaces, 'page_title > ' . $dbr->addQuotes( $offset ) ],
			__METHOD__,
			[ 'ORDER BY' => 'page_title ASC', 'LIMIT' => $this->batchSize ]
		);

		return TitleArray::newFromResult( $res );
	}
}
