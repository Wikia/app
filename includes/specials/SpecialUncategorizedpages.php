<?php
/**
 * @file
 * @ingroup SpecialPage
 */

/**
 * A special page looking for page without any category.
 * @ingroup SpecialPage
 */
class UncategorizedPagesPage extends PageQueryPage {
	function getName() {
		return "Uncategorizedpages";
	}

	function sortDescending() {
		return false;
	}

	function isExpensive() {
		return true;
	}
	function isSyndicated() { return false; }

	function getSQL() {
		global $wgContentNamespaces;

		$dbr = wfGetDB( DB_SLAVE );
		list( $page, $categorylinks ) = $dbr->tableNamesN( 'page', 'categorylinks' );
		$name = $dbr->addQuotes( $this->getName() );

		return
			"
			SELECT
				$name as type,
				page_namespace AS namespace,
				page_title AS title,
				page_title AS value
			FROM $page
			LEFT JOIN $categorylinks ON page_id=cl_from
			WHERE cl_from IS NULL AND page_namespace IN ( " . explode( ', ', $wgContentNamespaces ) . " )
			AND page_is_redirect=0
			";
	}
}

/**
 * constructor
 */
function wfSpecialUncategorizedpages() {
	list( $limit, $offset ) = wfCheckLimits();

	$lpp = new UncategorizedPagesPage();

	return $lpp->doQuery( $offset, $limit );
}
