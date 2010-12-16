<?php
/*
 * @file
 * @ingroup SpecialPage
 */

/**
 * Querypage that lists the most wanted files - implements Special:Wantedfiles
 *
 * @ingroup SpecialPage
 *
 * @author Soxred93 <soxred93@gmail.com>
 * @copyright Copyright © 2008, Soxred93
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */
class WantedFilesPage extends WantedQueryPage {

	function getName() {
		return 'Wantedfiles';
	}

	function getSQL() {
		$dbr = wfGetDB( DB_SLAVE );
		list( $imagelinks, $page ) = $dbr->tableNamesN( 'imagelinks', 'page' );
		$name = $dbr->addQuotes( $this->getName() );
		$sql = "
			SELECT
				$name as type,
				" . NS_FILE . " as namespace,
				il_to as title,
				COUNT(*) as value
			FROM $imagelinks
			LEFT JOIN $page ON il_to = page_title AND page_namespace = ". NS_FILE ."
			WHERE page_title IS NULL
			GROUP BY il_to
			";
		wfRunHooks( 'WantedFiles::getSQL', array( &$sql, &$this, $name, $imagelinks, $page ) ); // wikia: Bartek
		return $sql;
	}
}

/**
 * constructor
 */
function wfSpecialWantedFiles() {
	list( $limit, $offset ) = wfCheckLimits();

	$wpp = new WantedFilesPage();

	$wpp->doQuery( $offset, $limit );
}
