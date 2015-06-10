<?php

class UnconvertedInfoboxesPage extends PageQueryPage {
	const LIMIT = 1000;

	function __construct( $name = 'UnconvertedInfoboxes' ) {
		parent::__construct( $name );
	}

	public function sortDescending() {
		return true;
	}

	public function isExpensive() {
		return true;
	}

	public function doQuery( $offset = false, $limit = self::LIMIT ) {
		return $this->fetchFromCache( $limit, $offset );
	}

	public function recache( $limit = false, $ignoreErrors = true ) {
		$dbw = wfGetDB( DB_MASTER );

		/**
		 * 1. Get the new data first
		 */
		$nonportableTemplates = $this->reallyDoQuery();
		$dbw->begin();

		/**
		 * 2. Delete the existing records
		 */
		( new WikiaSQL() )
			->DELETE( 'querycache' )
			->WHERE( 'qc_type' )->EQUAL_TO( $this->getName() )
			->run( $dbw );

		/**
		 * 3. Insert the new records if the $nonportableTemplates array is not empty
		 */
		$num = 0;
		if ( !empty( $nonportableTemplates ) ) {

			( new WikiaSQL() )
				->INSERT()->INTO( 'querycache', [
					'qc_type',
					'qc_value',
					'qc_namespace',
					'qc_title'
				] )
				->VALUES( $nonportableTemplates )
				->run( $dbw );

			$num = $dbw->affectedRows();
			if ( $num === 0 ) {
				$dbw->rollback();
				$num = false;
			} else {
				$dbw->commit();
			}
		}

		return $num;
	}

	public function reallyDoQuery( $limit = false, $offset = false ) {
		$dbr = wfGetDB( DB_SLAVE, [ $this->getName(), __METHOD__, 'vslow' ] );

		$nonportableTemplates = ( new WikiaSQL() )
			->SELECT( 'page_title as title' )
			->FROM( 'page' )
			->WHERE( 'page_namespace' )->EQUAL_TO( NS_TEMPLATE )
			->runLoop( $dbr, function( &$nonportableTemplates, $row ) {
				$title = Title::newFromText( $row->title, NS_TEMPLATE );

				if ( $title !== null && self::isTitleWithNonportableInfobox( $title ) ) {
					$links = $this->showIndirectLinksRaw( 0, $title );
					$nonportableTemplates[] = [
						$this->getName(),
						count( $links ),
						NS_TEMPLATE,
						$row->title,
					];
				}
			} );

		return $nonportableTemplates;
	}

	public static function isTitleWithNonportableInfobox( Title $title ) {
		$content = ( new WikiPage( $title ) )->getText();

		$titleRegEx = '/infobox/i';
		$titleRegExMatch = preg_match( $titleRegEx, $title->getText() );
		if ( !empty( $titleRegExMatch ) ) {
			$portableInfoboxRegEx = '/\<infobox\>/';
			$portableInfoboxRegExMatch = preg_match( $portableInfoboxRegEx, $content );

			// If a portable infobox markup was not found
			// the $portableInfoboxRegExMatch is empty
			return empty( $portableInfoboxRegExMatch );
		} else {
			$nonportableInfoboxRegEx = '/(class=\".*infobox.*\")|(/i';
			$nonportableInfoboxRegExMatch = preg_match( $nonportableInfoboxRegEx, $content );

			// If a non-portable infobox markup was found
			// the $nonportableInfoboxRegExMatch is not empty
			return !empty( $nonportableInfoboxRegExMatch );
		}
	}

	/**
	 * Get list of pages with searched template
	 * Based on Special:Whatlinkshere showIndirectLinks method
	 */
	public function showIndirectLinksRaw( $level, Title $target ) {
		global $wgContentNamespaces;

		$rows = [];

		$dbr = wfGetDB( DB_SLAVE );
		$options = [];

		$hidelinks = false;
		$hideredirs = false;
		$hidetrans = false;
		$hideimages = false; //$target->getNamespace() != NS_FILE;

		$fetchlinks = ( !$hidelinks || !$hideredirs );

		// Make the query
		$plConds = [
			'page_id=pl_from',
			'pl_namespace' => $target->getNamespace(),
			'pl_title' => $target->getDBkey(),
		];
		if( $hideredirs ) {
			$plConds['rd_from'] = null;
		} elseif( $hidelinks ) {
			$plConds[] = 'rd_from is NOT NULL';
		}

		$tlConds = [
			'page_id=tl_from',
			'tl_namespace' => $target->getNamespace(),
			'tl_title' => $target->getDBkey(),
		];

		$ilConds = [
			'page_id=il_from',
			'il_to' => $target->getDBkey(),
		];

		if ( is_array( $wgContentNamespaces ) && !empty( $wgContentNamespaces ) ) {
			$namespaces = implode( ',', $wgContentNamespaces );

			$plConds[] = 'page_namespace IN (' . $namespaces . ')';
			$tlConds[] = 'page_namespace IN (' . $namespaces . ')';
			$ilConds[] = 'page_namespace IN (' . $namespaces . ')';
		} elseif ( is_int( $wgContentNamespaces ) ) {
			$plConds['page_namespace'] = $wgContentNamespaces;
			$tlConds['page_namespace'] = $wgContentNamespaces;
			$ilConds['page_namespace'] = $wgContentNamespaces;
		}

		// Enforce join order, sometimes namespace selector may
		// trigger filesorts which are far less efficient than scanning many entries
		$options[] = 'STRAIGHT_JOIN';

		//$options['LIMIT'] = $queryLimit;
		$fields = [ 'page_id', 'page_namespace', 'page_title', 'rd_from' ];

		$joinConds = [
			'redirect' => [
				'LEFT JOIN',
				[
					'rd_from = page_id',
					'rd_namespace' => $target->getNamespace(),
					'rd_title' => $target->getDBkey(),
					'(rd_interwiki is NULL) or (rd_interwiki = \'\')',
				]
			]
		];

		if( $fetchlinks ) {
			$options['ORDER BY'] = 'pl_from';
			$plRes = $dbr->select(
				[ 'pagelinks', 'page', 'redirect' ],
				$fields,
				$plConds,
				__METHOD__,
				$options,
				$joinConds
			);
		}

		if( !$hidetrans ) {
			$options['ORDER BY'] = 'tl_from';
			$tlRes = $dbr->select(
				[ 'templatelinks', 'page', 'redirect' ],
				$fields,
				$tlConds,
				__METHOD__,
				$options,
				$joinConds
			);
		}

		if( !$hideimages ) {
			$options['ORDER BY'] = 'il_from';
			$ilRes = $dbr->select(
				[ 'imagelinks', 'page', 'redirect' ],
				$fields,
				$ilConds,
				__METHOD__,
				$options,
				$joinConds
			);
		}

		// Read the rows into an array and remove duplicates
		// templatelinks comes second so that the templatelinks row overwrites the
		// pagelinks row, so we get (inclusion) rather than nothing
		if( $fetchlinks ) {
			foreach ( $plRes as $row ) {
				$row->is_template = 0;
				$row->is_image = 0;
				$rows[$row->page_id] = $row;
			}
		}
		if( !$hidetrans ) {
			foreach ( $tlRes as $row ) {
				$row->is_template = 1;
				$row->is_image = 0;
				$rows[$row->page_id] = $row;
			}
		}
		if( !$hideimages ) {
			foreach ( $ilRes as $row ) {
				$row->is_template = 0;
				$row->is_image = 1;
				$rows[$row->page_id] = $row;
			}
		}

		foreach ( $rows as $row ) {

			$nt = Title::makeTitle( $row->page_namespace, $row->page_title );

			if ( $row->rd_from && $level < 2 ) {
				$this->showIndirectLinksRaw( $level + 1, $nt );
			}
		}

		return $rows;
	}
}
