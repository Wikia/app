<?php

/**
 * Static class with functions interact with watchlist groups.
 * 
 * @since 0.1
 * 
 * @file SWL_Groups.php
 * @ingroup SemanticWatchlist
 * 
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
final class SWLGroups {
	
	/**
	 * Cached list of all watchlist groups.
	 * 
	 * @var array of SWLGroup
	 */
	protected static $groups = false;
	
    /**
     * Returns all watchlist groups.
     *
     * @since 0.1
     *
     * @return array of SWLGroup
     */	
	public static function getAll() {
		if ( self::$groups === false ) {
			self::$groups = array();
			
	        $dbr = wfGetDB( DB_SLAVE );
	
	        $groups = $dbr->select( 'swl_groups', array(
	        	'group_id',
	        	'group_name',
	        	'group_categories',
	        	'group_namespaces',
	        	'group_properties',
	        	'group_concepts'
	        ) );
	
	        foreach ( $groups as $group ) {
	        	self::$groups[] = SWLGroup::newFromDBResult( $group );
	        }
		}
        
        return self::$groups;
	}
	
    /**
     * Returns all watchlist groups that watch the specified page.
     *
     * @since 0.1
     *
     * @param Title $title
     *
     * @return array of SWLGroup
     */
    public static function getMatchingWatchGroups( Title $title ) {
        $matchingGroups = array();

        foreach ( self::getAll() as /* SWLGroup */ $group ) {
            if ( $group->coversPage( $title ) ) {
                $matchingGroups[] = $group;
            }
        }

        return $matchingGroups;
    }

    /**
     * Returns all watchlist groups that are watched by the specified user.
     *
     * @since 0.1
     *
     * @param User $user
     *
     * @return array of SWLGroup
     */    
	public static function getGroupsForUser( User $user ) {
        $matchingGroups = array();

        foreach ( self::getAll() as /* SWLGroup */ $group ) {
            if ( $group->isWatchedByUser( $user ) ) {
                $matchingGroups[] = $group;
            }
        }

        return $matchingGroups;		
	} 
	
}
