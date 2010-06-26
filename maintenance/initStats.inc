<?php
/**
 * @file
 * @ingroup Maintenance
 */

function wfInitStats( $options=array() ) {
	global $wgExternalSharedDB, $wgMemc, $wgRCMaxAge, $wgDBname;

	$m = array();
	preg_match('/^techteam/', $wgDBname, $m);
	if ( !empty($m) ) {
		wfOut( "Found techteam-XX database..." );
		$edits = $good = $pages = $users = $active_users = $admin = $image = $views = 0;
	} else {
		$dbr = wfGetDB( DB_SLAVE, 'vslow' );
		$dbc = wfGetDB( DB_SLAVE, 'vslow', $wgExternalSharedDB );

		wfOut( "Counting total edits..." );
		$edits = $dbr->selectField( 'revision', 'COUNT(*)', '', __METHOD__ );
		$edits += $dbr->selectField( 'archive', 'COUNT(*)', '', __METHOD__ );
		wfOut( "{$edits}\nCounting number of articles..." );

		global $wgContentNamespaces;
		$good  = $dbr->selectField( 'page', 'COUNT(*)', array( 'page_namespace' => $wgContentNamespaces, 'page_is_redirect' => 0, 'page_len > 0' ), __METHOD__ );
		wfOut( "{$good}\nCounting total pages..." );

		$pages = $dbr->selectField( 'page', 'COUNT(*)', '', __METHOD__ );
		wfOut( "{$pages}\nCounting number of users..." );

		/**
		 * wikia, use cached information about users - we create wikis on demand so
		 * query is quite expensive. Value of this key is increased after user
		 * registration but frankly we don't care about proper value
		 */
		if( empty( $wgMemc ) ) {
			$wgMemc = wfGetMainCache();
		}
		$users = $wgMemc->get( wfSharedMemcKey( "registered-users-number" ) );
		if( empty( $users ) || $wgDBname !== $wgExternalSharedDB ) {
			$users = $dbc->selectField( '`user`', 'COUNT(*)', '', __METHOD__ );
			$wgMemc->set( wfSharedMemcKey( "registered-users-number" ), $users, 86400 );
			wfOut( " (from db) ");
		}
		else {
			wfOut( " (from cache)  ");
		}
		wfOut( "{$users}\nCounting number of active users..." );

		$active_users_conds = array(
			'rc_user != 0',
			'rc_bot' => 0,
			"rc_log_type != 'newusers' OR rc_log_type IS NULL"
		);
		if ( !empty($wgRCMaxAge) ) {
			$active_users_conds[] = sprintf("rc_timestamp >= '%s'", date( 'YmdHis', time()- $wgRCMaxAge ));
		}
		$active_users = $dbr->selectField( 'recentchanges', 'COUNT( DISTINCT rc_user_text )', $active_users_conds, __METHOD__ );
		wfOut( "{$active_users}\nCounting number of admins..." );

		$admin = $dbr->selectField( 'user_groups', 'COUNT(*)', array( 'ug_group' => 'sysop' ), __METHOD__ );
		wfOut( "{$admin}\nCounting number of images..." );

		$image = $dbr->selectField( 'image', 'COUNT(*)', '', __METHOD__ );
		wfOut( "{$image}\n" );

		if( !isset( $options['noviews'] ) ) {
			wfOut( "Counting total page views..." );
			$views = $dbr->selectField( 'page', 'SUM(page_counter)', '', __METHOD__ );
			wfOut( "{$views}\n" );
		}
	}

	wfOut( "\nUpdating site statistics..." );

	$dbw = wfGetDB( DB_MASTER );
	$values = array( 'ss_total_edits' => $edits,
					'ss_good_articles' => $good,
					'ss_total_pages' => $pages,
					'ss_users' => $users,
					'ss_active_users' => $active_users,
					'ss_admins' => $admin,
					'ss_images' => $image );
	$conds = array( 'ss_row_id' => 1 );
	$views = array( 'ss_total_views' => isset( $views ) ? $views : 0 );

	if( isset( $options['update'] ) ) {
		$dbw->update( 'site_stats', $values, $conds, __METHOD__ );
	} else {
		$dbw->delete( 'site_stats', $conds, __METHOD__ );
		$dbw->insert( 'site_stats', array_merge( $values, $conds, $views ), __METHOD__ );
	}

	wfOut( "done.\n" );
}
