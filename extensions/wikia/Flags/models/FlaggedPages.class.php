<?php

/**
 * A model that reflects an instance of a FlaggedPages
 *
 * @author Kamil Koterba <kamil@wikia-inc.com>
 * @copyright (c) 2015 Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

namespace Flags\Models;

class FlaggedPages extends FlagsBaseModel {
	/**
	 * GET methods
	 */

	/**
	 * Retrieves list of pages marked with flags
	 *
	 * @param int|null $flagTypeId Flag type id to filter results
	 * @param int $wikiId
	 * @return array
	 * @throws \FluentSql\Exception\SqlException
	 */
	public function getFlaggedPagesFromDatabase( $wikiId, $flagTypeId = null ) {
		$db = $this->getDatabaseForRead();

		$flaggedPages = ( new \WikiaSQL() )
			->SELECT()
			->DISTINCT( 'page_id' )
			->FROM( 'flags_to_pages' )
			->WHERE( 'wiki_id' )->EQUAL_TO( $wikiId );

		if ( $flagTypeId !== null ) {
			$flaggedPages->AND_( 'flag_type_id' )->EQUAL_TO( $flagTypeId );
		}

		$flaggedPages = $flaggedPages->runLoop( $db, function( &$flaggedPages, $row ) {
			$flaggedPages[] = $row->page_id;
		} );

		return $flaggedPages;
	}

}
