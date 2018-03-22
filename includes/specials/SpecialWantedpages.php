<?php
/**
 * Implements Special:Wantedpages
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 * @ingroup SpecialPage
 */

/**
 * A special page that lists most linked pages that does not exist
 *
 * @ingroup SpecialPage
 */
class WantedPagesPage extends WantedQueryPage {
	
	function __construct( $name = 'Wantedpages' ) {
		parent::__construct( $name );
		$this->mIncludable = true;
	}

	function execute( $par ) {
		$inc = $this->including();

		if ( $inc ) {
			$parts = explode( '/', $par, 2 );
			$this->limit = (int)$parts[0];
			$this->offset = 0;
		}

		$this->setListoutput( $inc );
		$this->shownavigation = !$inc;
		parent::execute( $par );
	}

	function getQueryInfo() {
		$dbr = wfGetDB( DB_SLAVE );

		$query = [
			'tables' => [
				'pagelinks',
				'pg1' => 'page',
				'pg2' => 'page',
			],
			'fields' => [
				'pl_namespace AS namespace',
				'pl_title AS title',
				'pg2.page_namespace AS source_namespace'
			],
			'conds' => [
				'pg1.page_namespace IS NULL',
				'pl_namespace NOT IN (' . $dbr->makeList( $this->getExcludedNamespaces() ) . ')',
			],
			'options' => [],
			'join_conds' => [
				'pg1' => [
					'LEFT JOIN',
					[
						'pg1.page_namespace = pl_namespace',
						'pg1.page_title = pl_title',
					],
				],
				'pg2' => [ 'LEFT JOIN', 'pg2.page_id = pl_from' ],
			],
		];
		// Replacement for the WantedPages::getSQL hook
		Hooks::run( 'WantedPages::getQueryInfo', [ $this, &$query ] );

		return $query;
	}

	function reallyDoQuery( $limit, $offset = false ) {
		$res = parent::reallyDoQuery( false, $offset );

		// SUS-3561: Group, filter and sort the results in PHP level due to abysmal query performance
		$excludedSourceNamespaces = array_flip( $this->getExcludedSourceNamespaces() );
		$pageGroup = [];

		foreach ( $res as $row ) {
			if ( !isset( $excludedSourceNamespaces[$row->source_namespace] ) ) {
				$page = $row->namespace . $row->title;

				if ( !isset( $pageGroup[$page] ) ) {
					$pageGroup[$page] = $row;
					$pageGroup[$page]->value = 0;
				}

				$pageGroup[$page]->value++;
			}
		}

		usort( $pageGroup, function ( $x, $y ) {
			return $y->value - $x->value;
		} );

		if ( $limit !== false ) {
			return array_slice( $pageGroup, 0, intval( $limit ) );
		}

		return $pageGroup;
	}

	function getOrderFields() {
		return [];
	}

	/**
	 * List of namespaces whose pages will never show up as wanted in WantedPages
	 * @return int[]
	 */
	protected function getExcludedNamespaces(): array {
		$namespaces = [ NS_USER, NS_USER_TALK ];

		Hooks::run( 'WantedPages::getExcludedNamespaces', [ &$namespaces ] );

		return $namespaces;
	}

	/**
	 * List of namespaces whose outgoing redlinks will not generate a WantedPages entry for the target page
	 * @return int[]
	 */
	protected function getExcludedSourceNamespaces(): array {
		$namespaces = [ NS_MEDIAWIKI ];

		Hooks::run( 'WantedPages::getExcludedSourceNamespaces', [ &$namespaces ] );

		return $namespaces;
	}
}
