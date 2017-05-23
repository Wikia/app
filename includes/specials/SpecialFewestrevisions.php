<?php
/**
 * Implements Special:Fewestrevisions
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
 * Special page for listing the articles with the fewest revisions.
 *
 * @ingroup SpecialPage
 * @author Martin Drashkov
 */
class FewestrevisionsPage extends QueryPage {

	function __construct( $name = 'Fewestrevisions' ) {
		parent::__construct( $name );
	}

	function isExpensive() {
		return true;
	}

	function isSyndicated() {
		return false;
	}

	function getQueryInfo() {
		return [
			'tables' => [ 'revision', 'page' ],
			'fields' => [
				'page_namespace AS namespace',
				'page_title AS title',
				'COUNT(*) AS value',
			],
			'conds' => [
				'page_is_redirect' => 0,
				'page_namespace' => MWNamespace::getContentNamespaces(),
				'page_id = rev_page',
			],
			'options' => [
				'GROUP BY' => 'page_namespace, page_title'
			]
		];
	}


	function sortDescending() {
		return false;
	}

	/**
	 * @param $skin Skin object
	 * @param $result Object: database row
	 * @return string formatted HTML of a single row
	 */
	function formatResult( $skin, $result ) {
		global $wgContLang;

		$nt = Title::makeTitleSafe( $result->namespace, $result->title );
		if( !$nt ) {
			return '<!-- bad title -->';
		}

		$text = htmlspecialchars( $wgContLang->convert( $nt->getPrefixedText() ) );
		$plink = Linker::linkKnown( $nt, $text );

		$nl = $this->msg( 'nrevisions' )->numParams( $result->value )->escaped();
		$nlink = Linker::linkKnown(
			$nt,
			$nl,
			[],
			[ 'action' => 'history' ]
		);

		return $this->getLanguage()->specialList( $plink, $nlink );
	}
}
