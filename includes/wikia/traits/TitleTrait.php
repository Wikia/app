<?php
/**
 * A trait that let's you expand the base Title class
 *
 * @author Adam Karmiński <adamk@wikia-inc.com>
 */

trait TitleTrait {
	// Required base-class methods
	abstract function getNamespace();
	abstract function getDBkey();

	/**
	 * Returns a list of pages that link to that Title. It is based on the method used in
	 * Special:WhatLinksHere but returns raw results instead of a ready (and useless) HTML markup.
	 *
	 * @param int $level How deep should I go? 0 means to the bottom (which is limited to 2)
	 * @return array
	 */
	public function getIndirectLinks( $level = 0 ) {
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
			'pl_namespace' => $this->getNamespace(),
			'pl_title' => $this->getDBkey(),
		];

		if ( $hideredirs ) {
			$plConds['rd_from'] = null;
		} elseif ( $hidelinks ) {
			$plConds[] = 'rd_from is NOT NULL';
		}

		$tlConds = [
			'page_id=tl_from',
			'tl_namespace' => $this->getNamespace(),
			'tl_title' => $this->getDBkey(),
		];

		$ilConds = [
			'page_id=il_from',
			'il_to' => $this->getDBkey(),
		];

		if ( is_array( $wgContentNamespaces ) && !empty( $wgContentNamespaces ) ) {
			$namespaces = $dbr->makeList( $wgContentNamespaces );

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
					'rd_namespace' => $this->getNamespace(),
					'rd_title' => $this->getDBkey(),
					'(rd_interwiki is NULL) or (rd_interwiki = \'\')',
				]
			]
		];

		// Read the rows into an array and remove duplicates
		// templatelinks comes second so that the templatelinks row overwrites the
		// pagelinks row, so we get (inclusion) rather than nothing

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
			foreach ( $plRes as $row ) {
				$row->is_template = 0;
				$row->is_image = 0;
				$rows[$row->page_id] = $row;
			}
		}

		if ( !$hidetrans ) {
			$options['ORDER BY'] = 'tl_from';
			$tlRes = $dbr->select(
				[ 'templatelinks', 'page', 'redirect' ],
				$fields,
				$tlConds,
				__METHOD__,
				$options,
				$joinConds
			);
			foreach ( $tlRes as $row ) {
				$row->is_template = 1;
				$row->is_image = 0;
				$rows[$row->page_id] = $row;
			}
		}

		if ( !$hideimages ) {
			$options['ORDER BY'] = 'il_from';
			$ilRes = $dbr->select(
				[ 'imagelinks', 'page', 'redirect' ],
				$fields,
				$ilConds,
				__METHOD__,
				$options,
				$joinConds
			);
			foreach ( $ilRes as $row ) {
				$row->is_template = 0;
				$row->is_image = 1;
				$rows[$row->page_id] = $row;
			}
		}

		foreach ( $rows as $row ) {
			$title = Title::makeTitle( $row->page_namespace, $row->page_title );

			if ( $row->rd_from && $level < 2 ) {
				$title->getIndirectLinks( $level + 1 );
			}
		}

		return $rows;
	}
}
