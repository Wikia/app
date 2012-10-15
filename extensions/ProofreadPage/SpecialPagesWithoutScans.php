<?php
/**
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
 * @ingroup Extensions
 */

/**
 * Special page that lists the texts that have no transclusions
 * Pages in MediaWiki:Proofreadpage_notnaked_category are excluded.
 */
class PagesWithoutScans extends QueryPage {

	function __construct( $name = 'PagesWithoutScans' ) {
		parent::__construct( $name );
		$this->page_namespace = wfMsgForContent( 'proofreadpage_namespace' );
	}

	function isExpensive() {
		return true;
	}

	function isSyndicated() {
		return false;
	}

	/**
	 * Return a clause with the list of disambiguation templates.
	 * This function was copied verbatim from specials/SpecialDisambiguations.php
	 */
	function disambiguation_templates( $dbr ) {
		$dMsgText = wfMsgForContent('disambiguationspage');

		$linkBatch = new LinkBatch;

		# If the text can be treated as a title, use it verbatim.
		# Otherwise, pull the titles from the links table
		$dp = Title::newFromText($dMsgText);
		if( $dp ) {
			if($dp->getNamespace() != NS_TEMPLATE) {
				# FIXME we assume the disambiguation message is a template but
				# the page can potentially be from another namespace :/
				wfDebug("Mediawiki:disambiguationspage message does not refer to a template!\n");
			}
			$linkBatch->addObj( $dp );
		} else {
			# Get all the templates linked from the Mediawiki:Disambiguationspage
			$disPageObj = Title::makeTitleSafe( NS_MEDIAWIKI, 'disambiguationspage' );
			$res = $dbr->select(
				array('pagelinks', 'page'),
				'pl_title',
				array('page_id = pl_from', 'pl_namespace' => NS_TEMPLATE,
					'page_namespace' => $disPageObj->getNamespace(), 'page_title' => $disPageObj->getDBkey()),
				__METHOD__ );

			foreach ( $res as $row ) {
				$linkBatch->addObj( Title::makeTitle( NS_TEMPLATE, $row->pl_title ));
			}
		}
		return $linkBatch->constructSet( 'tl', $dbr );
	}
	
	function getQueryInfo() {
		$dbr = wfGetDB( DB_SLAVE );
		$page_ns_index = MWNamespace::getCanonicalIndex( strtolower( str_replace( ' ', '_', $this->page_namespace ) ) );
		
		// Construct subqueries
		$pagesWithScansSubquery = $dbr->selectSQLText(
			array( 'templatelinks', 'page' ),
			'DISTINCT tl_from',
			array(
				'page_id=tl_from',
				'tl_namespace' => $page_ns_index,
				'page_namespace' => NS_MAIN
			)
		);
		
		// Exclude disambiguation pages too
		$dt = $this->disambiguation_templates( $dbr );
		$disambigPagesSubquery = $dbr->selectSQLText(
			array( 'page', 'templatelinks' ),
			'page_id',
			array(
				'page_id=tl_from',
				'page_namespace' => NS_MAIN,
				$dt
			)
		);
		
		return array(
			'tables' => 'page',
			'fields' => array(
				"'PagesWithoutScans' AS type",
				'page_namespace AS namespace',
				'page_title AS title',
				'page_len AS value' ),
			'conds' => array(
				'page_namespace' => NS_MAIN,
				'page_is_redirect' => 0,
				"page_id NOT IN ($pagesWithScansSubquery)",
				"page_id NOT IN ($disambigPagesSubquery)" ),
			'options' => array( 'USE INDEX' => 'page_len' )
		);	
	}

	function sortDescending() {
		return true;
	}

	function formatResult( $skin, $result ) {
		global $wgLang, $wgContLang;
		$dm = $wgContLang->getDirMark();

		$title = Title::makeTitleSafe( $result->namespace, $result->title );
		if ( !$title ) {
			return '<!-- Invalid title ' .  htmlspecialchars( "{$result->namespace}:{$result->title}" ) . '-->';
		}
		$hlink = $skin->linkKnown(
			$title,
			wfMsgHtml( 'hist' ),
			array(),
			array( 'action' => 'history' )
		);
		$plink = $this->isCached()
					? $skin->link( $title )
					: $skin->linkKnown( $title );
		$size = wfMsgExt( 'nbytes', array( 'parsemag', 'escape' ), $wgLang->formatNum( htmlspecialchars( $result->value ) ) );

		return $title->exists()
				? "({$hlink}) {$dm}{$plink} {$dm}[{$size}]"
				: "<s>({$hlink}) {$dm}{$plink} {$dm}[{$size}]</s>";
	}
}

