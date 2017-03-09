<?php
/**
 * Implements Special:Wantedcategories
 *
 * Copyright © 2005 Ævar Arnfjörð Bjarmason
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
 * A querypage to list the most wanted categories - implements Special:Wantedcategories
 *
 * @ingroup SpecialPage
 */
class WantedCategoriesPage extends WantedQueryPage {

	function __construct( $name = 'Wantedcategories' ) {
		parent::__construct( $name );
	}

	function getQueryInfo() {
		return [
			'tables' => [
				'categorylinks',
				'pg1' => 'page',
				'pg2' => 'page'
			],
			'fields' => [
				'namespace' => NS_CATEGORY,
				'title' => 'cl_to',
				'value' => 'COUNT(*)'
			],
			'conds' => [
				'pg1.page_title IS NULL',
				"NOT (RIGHT(pg2.page_title, 3) = '.js' OR RIGHT(pg2.page_title, 4) = '.css' OR pg2.page_namespace = '" . NS_MODULE . "')"
			],
			'options' => [ 'GROUP BY' => 'cl_to' ],
			'join_conds' => [
				'pg1' => [ 'LEFT JOIN', [
					'pg1.page_title = cl_to',
					'pg1.page_namespace' => NS_CATEGORY
				] ],
				'pg2' => [ 'LEFT JOIN', 'pg2.page_id = cl_from' ]
			]
		];
	}

	/**
	 * @param $skin Skin
	 * @param $result
	 * @return string
	 */
	function formatResult( $skin, $result ) {
		global $wgContLang;

		$nt = Title::makeTitle( $result->namespace, $result->title );
		$text = htmlspecialchars( $wgContLang->convert( $nt->getText() ) );

		$plink = $this->isCached() ?
			Linker::link( $nt, $text ) :
			Linker::link(
				$nt,
				$text,
				array(),
				array(),
				array( 'broken' )
			);

		$nlinks = $this->msg( 'nmembers' )->numParams( $result->value )->escaped();
		return $this->getLanguage()->specialList( $plink, $nlinks );
	}
}
