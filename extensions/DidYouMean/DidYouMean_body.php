<?php
/**
 * Class definition for DidYouMean functions
 */
class DidYouMean {

	# turn the array of titles into some wikitext we can add to an article

	public static function build_sees( $sees ) {
		global $wgDymUseSeeTemplate;
   
		if ( $wgDymUseSeeTemplate )
			return '{{see|' . implode('|', $sees) . '}}';
		else
			return '<div>\'\'See also:\'\' \'\'\'[[' . implode(']]\'\'\', \'\'\'[[', $sees) . ']]\'\'\'</div>';
	}
	
	# pass pageid = 0 to lookup by normtitle
	public static function lookup( $pageid, $title ) {
		wfDebug( 'HIPP: ' . __METHOD__ . "\n" );
   
		$sees = array();
   
		$dbr = wfGetDB( DB_SLAVE );
   
		if ( $dbr->tableExists( 'dympage' ) &&  $dbr->tableExists( 'dymnorm' ) ) {
			$normid = false;
   
			if ($pageid) {
				wfDebug( "HIPP: lookup by pageid: $pageid\n" );
				$normid = $dbr->selectField(
					array( 'page', 'dympage' ),
					'dp_normid',
					array( 'page_id = dp_pageid', 'page_id' => $pageid )
				);
			} else {
				wfDebug( "HIPP: lookup by normtitle: " . wfDymNormalise($title) . "\n" );
				$normid = $dbr->selectField(
					'dymnorm',
					'dn_normid',
					array( 'dn_normtitle' => wfDymNormalise($title) )
				);
			}
   
			if ($normid) {
				$res = $dbr->select(
						/* FROM   */ array( 'page', 'dympage' ),
						/* SELECT */ 'page_title',
						/* WHERE  */ array( 'page_id = dp_pageid', 'dp_normid' => $normid )
				);
   
				$nr = $dbr->numRows( $res );
   
				if ($nr == 0) {
					wfDebug( "HIPP: DB New Miss\n" );
				} else {
					wfDebug( "HIPP: DB New  Hit\n" );
   
					# accumulate the db results
					while( $o = $dbr->fetchObject( $res ) ) {
						$t2 = str_replace('_', ' ', $o->page_title);
						$dbo = $t2;
						if ($title != $t2) {
							array_push( $sees, $t2 );
							$dbo = '++ ' . $dbo;
						}
						else
							$dbo = '  (' . $dbo . ')';
						wfDebug( "HIPP: $dbo\n" );
					}
   
					$dbr->freeResult( $res );
				}
			}
		} else {
			wfDebug( "HIPP: No dympage or dymnorm table\n" );
		}
   
		return $sees;
	}
	
	public static function doInsert( $pageid , $title ) {
		wfDebug( 'HIPP: ' . __METHOD__ . " INSERT\n" );
		$dbw = wfGetDB( DB_MASTER );
   
		$norm = wfDymNormalise($title);
   
		# find or create normid for the new title
		$normid = $dbw->selectField( 'dymnorm', 'dn_normid', array( 'dn_normtitle' => $norm ) );
		if ($normid) {
			wfDebug( "HIPP: old: $title ->\t$norm = $normid\n" );
		} else {
			$nsvid = $dbw->nextSequenceValue( 'dymnorm_dn_normid_seq' );
			$dbw->insert( 'dymnorm', array( 'dn_normid' => $nsvid, 'dn_normtitle' => $norm ) );
			$normid = $dbw->insertId();
			wfDebug( "HIPP: NEW: $title ->\t$norm = $normid\n" );
		}
		$dbw->insert( 'dympage', array( 'dp_pageid' => $pageid, 'dp_normid' => $normid ) );
   
		# touch all pages which will now link here
		self::touchPages( "dp_normid=$normid" );
   
	}

	private static function touchPages( $condition ) {
		global $wgDBtype;
   
		$dbw = wfGetDB( DB_MASTER );
		$page = $dbw->tableName('page');
		$dpage = $dbw->tableName('dympage');
   
		$whereclause = "WHERE page_id = dp_pageid AND $condition";
		if ($wgDBtype == 'postgres') {
			$sql = "UPDATE $page SET page_touched=now() FROM $dpage $whereclause";
		} else {
			$sql = "UPDATE $page, $dpage SET page_touched = " .
				$dbw->addQuotes( $dbw->timestamp() ) .
				" $whereclause";
		}
   
		$dbw->query( $sql, __METHOD__ );
   
	}

	public static function doDelete( $pageid ) {
		wfDebug( 'HIPP: ' . __METHOD__ . " DELETE\n" );
		$dbw = wfGetDB( DB_MASTER );
   
		$normid = $dbw->selectField( 'dympage', 'dp_normid', array('dp_pageid' => $pageid) );
   
		$dbw->delete( 'dympage', array('dp_pageid' => $pageid) );
   
		$count = $dbw->selectField( 'dympage', 'COUNT(*)', array('dp_normid' => $normid) );
   
		if ($count == 0)
			$dbw->delete( 'dymnorm', array('dn_normid' => $normid) );
   
		# touch all pages which will now link here
		if( $normid ) {
			self::touchPages( "dp_normid=$normid" );
		}
	}

	public static function doUpdate( $pageid, $title ) {
		wfDebug( 'HIPP: ' . __METHOD__ . " MOVE\n" );
		$dbw = wfGetDB( DB_MASTER );
   
		$norm = wfDymNormalise($title);
   
		$normid = $dbw->selectField( 'dymnorm', 'dn_normid', array( 'dn_normtitle' => $norm ) );
		if ($normid) {
			wfDebug( "HIPP: old: $title ->\t$norm = $normid\n" );
		} else {
			$nsvid = $dbw->nextSequenceValue( 'dymnorm_dn_normid_seq' );
			$dbw->insert( 'dymnorm', array( 'dn_normid' => $nsvid, 'dn_normtitle' => $norm ) );
			$normid = $dbw->insertId();
			wfDebug( "HIPP: NEW: $title ->\t$norm = $normid\n" );
		}
   
		$oldnormid = $dbw->selectField( 'dympage', 'dp_normid', array('dp_pageid' => $pageid) );
   
		if ($oldnormid != $normid) {
			$dbw->update( 'dympage', array( 'dp_normid' => $normid ), array( 'dp_pageid' => $pageid ) );
   
			$count = $dbw->selectField( 'dympage', 'COUNT(*)', array('dp_normid' => $oldnormid) );
   
			if ($count == 0)
				$dbw->delete( 'dymnorm', array('dn_normid' => $oldnormid) );
   
			# touch all pages which linked to the old name or will link to the new one
			self::touchPages( "(dp_normid=$normid OR dp_normid=$oldnormid)" );
   
		}
	}
}