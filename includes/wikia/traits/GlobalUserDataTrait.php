<?php
/**
 * A trait that extends the User class with methods to gather
 * global data on a user's activity.
 *
 * @author Adam Karmiński <adamk@wikia-inc.com>
 */

trait GlobalUserDataTrait {
	// Required base-class methods
	abstract function getId();

	/**
	 * Gets unique IDs of wikias that a user has contributed at.
	 *
	 * @return array An array of IDs
	 */
	public function getWikiasWithUserContributions() {
		$db = wfGetDB( DB_SLAVE, [], F::app()->wg->wgDWStatsDB );

		$wikis = ( new WikiaSQL() )->skipIf( empty( F::app()->wg->StatsDBEnabled ) )
			->SELECT( 'wiki_id' )
			->FROM( 'rollup_edit_events' )
			->WHERE( 'user_id' )->EQUAL_TO( $this->getId() )
			->GROUP_BY( 'wiki_id' )
			->runLoop( $db, function( &$wikis, $row ) {
				$wikis[] = intval( $row->wiki_id );
			} );

		return (array) $wikis;
	}
}
