<?php
/**
 * Implements Special:Wantedtemplates
 *
 * Copyright © 2008, Danny B.
 * Based on SpecialWantedcategories.php by Ævar Arnfjörð Bjarmason <avarab@gmail.com>
 * makeWlhLink() taken from SpecialMostlinkedtemplates by Rob Church <robchur@gmail.com>
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
 * @author Danny B.
 */

/**
 * A querypage to list the most wanted templates
 *
 * @ingroup SpecialPage
 */
class WantedTemplatesPage extends WantedQueryPage {

	function __construct( $name = 'Wantedtemplates' ) {
		parent::__construct( $name );
	}

	function getQueryInfo() {
		return [
			'tables' => [
				'templatelinks',
				'pg1' => 'page',
				'pg2' => 'page'
			],
			'fields' => [
				'namespace' => 'tl_namespace',
				'title' => 'tl_title',
				'value' => 'COUNT(*)'
			],
			'conds' => [
				'pg1.page_title IS NULL',
				'tl_namespace' => NS_TEMPLATE,
				"NOT (RIGHT(pg2.page_title, 3) = '.js' OR RIGHT(pg2.page_title, 4) = '.css' OR pg2.page_namespace = '" . NS_MODULE . "')"
			],
			'options' => [ 'GROUP BY' => [ 'tl_namespace', 'tl_title' ] ],
			'join_conds' => [
				'pg1' => [ 'LEFT JOIN', [
					'pg1.page_namespace = tl_namespace',
					'pg1.page_title = tl_title'
				] ],
				'pg2' => [ 'LEFT JOIN', 'pg2.page_id = tl_from' ]
			]
		];
	}
}
