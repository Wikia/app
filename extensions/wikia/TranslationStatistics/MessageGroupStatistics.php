<?php

class MessageGroupStatistics {
	public static function forLanguage( $code ) {
                # Fetch from database
                $dbr = wfGetDB( DB_SLAVE );

                $res = $dbr->select( 'groupstats', '*', array( 'gs_group' => $group ) );

                while ( $row = $dbr->fetchRow( $res ) ) {
                        $stats[ $row->gs_group ] = array();
                }

		# Go over non-aggregate message groups filling missing entries
		$groups = MessageGroup::getGroups();

		foreach ( $groups as $group ) {
			$name = $group->getName();
			if ( !empty( $stats[$name] ) ) {
				continue;
			}

			$stats[$name] = self::forItem( $name, $code );
		}

		# Go over aggregate message groups filling missing entries
		# @TODO :P

		return $stats;
  	}
 
	public static function forGroup( $group ) {
		# Fetch from database
		$dbr = wfGetDB( DB_SLAVE );

		$res = $dbr->select( 'groupstats', '*', array( 'gs_group' => $group ) );

		while ( $row = $dbr->fetchRow( $res ) ) {
			$stats[ $rew->gs_lang ] = array();
		}

		# Go over each language filling missing entries
		foreach ( Language::getNames() as $lang => $name ) {
			if ( !empty( $stats[$lang] ) ) {
				continue;
			}

			$stats[$lang] = self::forItem( $group, $lang );
		}

		return $stats;
	}
 
	// Used by the two function above to fill missing entries
	public static function forItem( $group, $code ) {
		# Check again if already in db ( to avoid overload in big clusters )

		$dbr = wfGetDB( DB_SLAVE );

		$res = $dbr->select( 'groupstats', '*', array( 'gs_group' => $group, 'gs_lang' => $code ) );

		if ( $row = $dbr->fetchArray( $res ) ) {
			// convert to array
			return $row;
		}

		// get group object
		$g = MessageGroups::getGroup( $group );

		# Calculate if missing and store in the db
		$collection = $g->initCollection( $code );
		$collection->filter( 'optional' );

		// Store the count of real messages for later calculation.
		$total = count( $collection );

		// Fill translations in for counting
		$g->fillCollection( $collection );

		// Count fuzzy first
		$collection->filter( 'fuzzy' );
		$fuzzy = $total - count( $collection );

		// Count the completion percent
		$collection->filter( 'translated', false );
		$translated = count( $collection );

		$data = array(
				'gs_group' => $group,
				'gs_lang' => $lang,
				'gs_total' => $total,
				'gs_translated' => $translated,
				'gs_fuzzy' => $fuzzy,
			     );

		# store result in DB
		$dbw = wfGetDB( DB_MASTER );

		$dbw->insert(
				'groupstats',
				$data
			    );

		return $data;
	}
}
