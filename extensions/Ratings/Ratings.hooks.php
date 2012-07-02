<?php

/**
 * Static class for hooks handled by the Ratings extension.
 * 
 * @since 0.1
 * 
 * @file Ratings.hooks.php
 * @ingroup Ratings
 * 
 * @licence GNU GPL v3
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
final class RatingsHooks {
	
	/**
	 * Schema update to set up the needed database tables.
	 * 
	 * @since 0.1
	 * 
	 * @param DatabaseUpdater $updater
	 * 
	 * @return true
	 */	
	public static function onSchemaUpdate( /* DatabaseUpdater */ $updater = null ) {
		global $wgDBtype;
		
		if ( $wgDBtype == 'mysql' ) {
			// Set up the current schema.
			if ( $updater === null ) {
				global $wgExtNewTables, $wgExtNewIndexes;
				
				$wgExtNewTables[] = array(
					'votes',
					dirname( __FILE__ ) . '/Ratings.sql',
					true
				);
				$wgExtNewTables[] = array(
					'votes_props',
					dirname( __FILE__ ) . '/Ratings.sql',
					true
				);

				$wgExtNewIndexes[] = array(
					'votes',
					'vote',
					dirname( __FILE__ ) . '/sql/Ratings_addVotesIndex.sql',
					true
				);

				$wgExtNewIndexes[] = array(
					'vote_props',
					'prop_name',
					dirname( __FILE__ ) . '/sql/Ratings_addPropsIndex.sql',
					true
				);				
			}
			else {
				$updater->addExtensionUpdate( array( 
					'addTable',
					'votes',
					dirname( __FILE__ ) . '/Ratings.sql',
					true
				) );
				$updater->addExtensionUpdate( array( 
					'addTable',
					'votes_props',
					dirname( __FILE__ ) . '/Ratings.sql',
					true
				) );
				$updater->addExtensionUpdate( array(
					'addIndex',
					'votes',
					'vote',
					dirname( __FILE__ ) . '/sql/Ratings_addVotesIndex.sql',
					true
				) );
				$updater->addExtensionUpdate( array(
					'addIndex',
					'vote_props',
					'prop_name',
					dirname( __FILE__ ) . '/sql/Ratings_addPropsIndex.sql',
					true
				) );
			}		
		}
		
		return true;
	}
	
}
