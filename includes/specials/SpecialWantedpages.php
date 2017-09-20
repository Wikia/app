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
			// @todo FIXME: nlinks is ignored
			//$nlinks = isset( $parts[1] ) && $parts[1] === 'nlinks';
			$this->offset = 0;
		} else {
			//$nlinks = true;
		}
		$this->setListoutput( $inc );
		$this->shownavigation = !$inc;
		parent::execute( $par );
	}

	function getQueryInfo() {
		global $wgWantedPagesThreshold;
		$count = $wgWantedPagesThreshold - 1;
		$query = [
			'tables' => [
				'pagelinks',
				'pg1' => 'page',
				'pg2' => 'page'
			],
			'fields' => [
				'namespace' => 'pl_namespace',
				'title' => 'pl_title',
				'value' => 'COUNT(*)'
			],
			'conds' => [
				'pg1.page_namespace IS NULL',
				"pl_namespace NOT IN ( '" . NS_USER . "', '" . NS_USER_TALK . "' )",
				"pg2.page_namespace != '" . NS_MEDIAWIKI . "'",
				"NOT (RIGHT(pg2.page_title, 3) = '.js' OR RIGHT(pg2.page_title, 4) = '.css' OR pg2.page_namespace = '" . NS_MODULE . "')"
			],
			'options' => [
				'HAVING' => [
					"COUNT(*) > $count",
					"COUNT(*) > SUM(pg2.page_is_redirect)"
				],
				'GROUP BY' => [ 'pl_namespace', 'pl_title' ]
			],
			'join_conds' => [
				'pg1' => [
					'LEFT JOIN', [
						'pg1.page_namespace = pl_namespace',
						'pg1.page_title = pl_title'
					]
				],
				'pg2' => [ 'LEFT JOIN', 'pg2.page_id = pl_from' ]
			]
		];
		// Replacement for the WantedPages::getSQL hook
		Hooks::run( 'WantedPages::getQueryInfo', [ $this, &$query ] );

		return $query;
	}
}
