<?php
/*
 * @author Piotr Molski <MoLi> <moli@wikia-inc.com>
 */

class WikiaUpdater {

	public static function get_patch_dir() {
		global $IP;
		return $IP . "/maintenance/archives/wikia/";
	}

	public static function get_extensions_dir() {
		return MWInit::getExtensionsDirectory();
	}

	public static function is_valid_utf8_text( $text ) {
		$converted = @iconv('utf8','utf8',$text);
		return $text === $converted;
	}

	public static function update( DatabaseUpdater $updater ) {
		global $wgCityId, $wgDBname, $wgExternalSharedDB;

		$dir = self::get_patch_dir();
		$ext_dir = self::get_extensions_dir();

		$wikia_update = array(
			# tables
			array( 'addTable', 'page_vote', $dir . 'patch-create-page_vote.sql', true ),
			array( 'addTable', 'page_visited', $dir . 'patch-create-page_visited.sql', true ),
			array( 'addTable', 'blog_listing_relation', $dir . 'patch-create-blog_listing_relation.sql', true ),
			array( 'addTable', 'page_wikia_props', $ext_dir . '/wikia/ImageServing/sql/table.sql', true ),
			array( 'addTable', 'wall_history', $ext_dir . '/wikia/Wall/sql/wall_history_local.sql', true ),
			array( 'addTable', 'wall_related_pages', $ext_dir . '/wikia/Wall/sql/wall_related_pages.sql', true ),
			# fields
			array( 'addField', 'watchlist', 'wl_wikia_addedtimestamp', $dir . 'patch-watchlist-improvements.sql', true ),
			array( 'modifyField', 'recentchanges', 'rc_ip', $dir . 'patch-rc_ip-varbinary.sql', true ),
			array( 'addField', 'recentchanges', 'rc_ip_bin',$dir . 'patch-rc_ip_bin.sql', true ), // SUS-3079
			// SUS-805
			array( 'dropField', 'ipblocks', 'ipb_by_text', $dir . 'patch-drop-ipb_by_text.sql', true ),

			# indexes
			array( 'addIndex', 'archive', 'page_revision', $dir. 'patch-index-archive-page_revision.sql', true ),

			# indexes drop
			array( 'dropIndex', 'ach_user_badges', 'id',  $dir . 'patch-ach-user-badges-drop-id.sql', true ), // SUS-3097
			array( 'dropIndex', 'ach_user_badges', 'notified_id',  $dir . 'patch-ach-user-badges-drop-notified_id.sql', true ), // SUS-3097
			array( 'dropIndex', 'ach_custom_badges', 'id',  $dir . 'patch-ach_custom_badges-drop-id.sql', true ), // SUS-3098
			array( 'dropIndex', 'wall_related_pages', 'comment_id_idx',  $dir . 'patch-wall_related_pages-drop-comment_id_idx.sql', true ), // SUS-3096
			array( 'dropIndex', 'wall_related_pages', 'page_id_idx_2',  $dir . 'patch-wall_related_pages-drop-page_id_idx_2.sql', true ), // SUS-3096

			# functions
			array( 'WikiaUpdater::do_page_vote_unique_update' ),
			array( 'WikiaUpdater::do_page_wikia_props_update' ),
			array( 'WikiaUpdater::do_drop_table', 'imagetags' ),
			array( 'WikiaUpdater::do_drop_table', 'send_queue' ),
			array( 'WikiaUpdater::do_drop_table', 'send_stats' ),
			array( 'WikiaUpdater::do_drop_table', 'validate' ),
			array( 'WikiaUpdater::do_drop_table', 'cur' ),
			array( 'WikiaUpdater::do_drop_table', 'searchindex', !empty( $wgCityId ) ),
			array( 'WikiaUpdater::do_drop_table', 'spam_regex' ),
			array( 'WikiaUpdater::do_drop_table', 'page_stats' ),
			array( 'WikiaUpdater::do_drop_table', 'user_board' ),
			array( 'WikiaUpdater::do_drop_table', 'user_points_monthly' ),
			array( 'WikiaUpdater::do_drop_table', 'user_points_weekly' ),
			array( 'WikiaUpdater::do_drop_table', 'user_gift' ),
			array( 'WikiaUpdater::do_drop_table', 'user_relationship_request' ),
			array( 'WikiaUpdater::do_drop_table', 'user_register_track' ),
			array( 'WikiaUpdater::do_drop_table', 'user_board' ),
			array( 'WikiaUpdater::do_drop_table', 'watchlist_old' ),
			array( 'WikiaUpdater::do_drop_table', 'hidden' ), // SUS-2401
			array( 'WikiaUpdater::do_clean_math_table' ),
			array( 'WikiaUpdater::do_transcache_update' ),
			array( 'WikiaUpdater::do_wall_history_ipv6_update' ), // SUS-2257
			array( 'WikiaUpdater::doLoggingTableUserCleanup' ), // SUS-3222
			array( 'WikiaUpdater::migrateRecentChangesIpData' ), // SUS-3079
			array( 'dropField', 'interwiki', 'iw_api', $dir . 'patch-drop-iw_api.sql', true ),
			array( 'dropField', 'interwiki', 'iw_wikiid', $dir . 'patch-drop-wikiid.sql', true ),
			array( 'dropField', 'cu_changes', 'cuc_user_text', $ext_dir . '/CheckUser/patch-cu_changes.sql', true ), // SUS-3080
			array( 'WikiaUpdater::do_drop_table', 'tag_summary' ), // SUS-3066
		);

		if ( $wgDBname === $wgExternalSharedDB ) {
			$wikia_update[] = array( 'addTable', 'city_list', $dir . 'wf/patch-create-city_list.sql', true );
			$wikia_update[] = array( 'addTable', 'city_list', $dir . 'wf/patch-create-city_cats.sql', true );
		}

		foreach ( $wikia_update as $update ) {
			$updater->addExtensionUpdate( $update );
		}

		return true;
	}

	public static function do_drop_table ( DatabaseUpdater $updater, $table, $condition = true ) {
		if ( !$condition ) {
			$updater->output( "Dropping $table table not allowed\n" );
			return;
		}

		$db = $updater->getDB();
		$updater->output( "Checking wikia $table table...\n" );
		if ( $db->tableExists( $table ) ) {
			$updater->output( "...dropping $table table... " );
			$db->dropTable( $table, __METHOD__ );
			$updater->output( "ok\n" );
		}
	}

	public static function do_page_vote_unique_update( DatabaseUpdater $updater ) {
		$db = $updater->getDB();
		$dir = self::get_patch_dir();
		$updater->output( "Checking wikia page_vote table...\n" );
		if( $updater->getDB()->indexExists( 'page_vote', 'unique_vote' ) ) {
			$updater->output( "...page_vote unique key already set.\n" );
		} else {
			$updater->output( "Making page_vote unique key... " );
			$db->sourceFile( $dir . 'patch-page_vote_unique_vote.sql' );
			$updater->output( "ok\n" );
		}
	}

	public static function do_page_wikia_props_update( DatabaseUpdater $updater ) {
		$db = $updater->getDB();
		$updater->output( "Checking wikia page_wikia_props table...\n" );
		if ( $db->tableExists( 'page_wikia_props' ) ) {
			$tableInfo = $db->fieldInfo( 'page_wikia_props', 'propname' );
			if ( $tableInfo && $tableInfo->type() === 'string' ) {
				/**
				 * remove duplicates
				 */
				$res = $db->query( 'SELECT page_id FROM page_wikia_props GROUP BY page_id HAVING count(*) > 1', __METHOD__  );
				$updater->output( "... removing duplicates first: " );
				$dups = 0;
				while( $row = $db->fetchObject( $res ) ) {
					$db->delete(
						'page_wikia_props',
						array(
							'page_id'	=> $row->page_id,
							'propname'	=> 'imageOrder'
						),
						__METHOD__
					);
					$dups++;
				}
				$updater->output( "{$dups}\n" );
				$db->query( 'ALTER TABLE page_wikia_props CHANGE propname propname INT(10) NOT NULL', __METHOD__ );
				$updater->output( "... altered to integer.\n" );
			}
			else {
				$updater->output( "... already altered to integer.\n" );
			}
		}
	}

	public static function do_transcache_update( DatabaseUpdater $updater ) {
		$db = $updater->getDB();
		$transcache = $db->tableName( 'transcache' );
		$res = $db->query( "SHOW COLUMNS FROM transcache" );
		$columns = array(
			'tc_contents' => array(
				'old' => 'text',
				'new' => 'blob'
			),
			'tc_url'      => array(
				'old' => 'varchar(255)',
				'new' => 'varbinary(255)'
			)
		);
		$patch = array();
		while ( $row = $db->fetchObject( $res ) ) {
			if ( !$row ) continue;
			$column = !empty( $columns[ $row->Field ] ) ? $columns[ $row->Field ] : '';

			if ( $column && $columns[ $row->Field ]['old'] == $row->Type ) {
				$patch[] = sprintf( "MODIFY %s %s", $row->Field, $columns[ $row->Field ]['new'] );
			} else {
				$updater->output( "...{$row->Field} is up-to-date.\n" );
			}
		}

		if ( !empty( $patch ) ) {
			$db->query( sprintf( "ALTER TABLE transcache %s", implode( ",", $patch ) ), __METHOD__ );
			$updater->output( "... altered to binary.\n" );
		}
		else {
			$updater->output( "... transcache table is up-to-date.\n" );
		}
	}

	/**
	 * @author Mix <mix@fandom.com>
	 */
	public static function do_wall_history_ipv6_update( DatabaseUpdater $updater ) {
		$db = $updater->getDB();
		$table = 'wall_history';
		$old_column = 'post_user_ip';
		$new_column = 'post_user_ip_bin';

		$updater->output( sprintf( "starting %s...\n", __METHOD__ ) );

		if ( ! $db->tableExists( $table ) ) {
			$updater->output( "$table does not exist, skipping $table update.\n" );
			return false;
		}

		if ( ! $db->fieldInfo( $table, $old_column ) ) {
			$updater->output( "$table has already been migrated, skipping the update.\n" );
			return false;
		}

		if ( ! $db->fieldInfo( $table, $new_column ) ) {
			$updater->output( "adding $new_column in $table...\n" );
			$db->query( sprintf( 'ALTER TABLE %s ADD COLUMN %s VARBINARY(16) DEFAULT NULL AFTER %s', $table, $new_column, $old_column), __METHOD__ );
		} else {
			$updater->output( "$new_column already exists in $table but it is OK...\n" );
		}

		$updater->output( "migrating data from $old_column to $new_column...\n" );
		$db->query(
			sprintf( 'UPDATE %s SET %s = INET6_ATON(INET_NTOA(%s)) WHERE %s IS NULL AND %s IS NOT NULL;',
				$table, $new_column, $old_column, $new_column, $old_column),
			__METHOD__
		);

		$updater->output( "dropping $old_column in $table...\n" );
		$db->query( sprintf( 'ALTER TABLE %s DROP COLUMN %s', $table, $old_column ), __METHOD__ );

		$updater->output( "done.\n" );
	}

	public static function doLoggingTableUserCleanup( DatabaseUpdater $databaseUpdater ) {
		$databaseConnection = $databaseUpdater->getDB();

		if ( !$databaseConnection->fieldExists( 'logging', 'log_user_text', __METHOD__ ) ) {
			$databaseUpdater->output( "logging.log_user_text column does not exist.\n" );
			return;
		}

		$databaseUpdater->output( 'Migrating legacy chat ban log entries... ' );

		// Attribute old chat ban log entries to FANDOMbot
		$databaseConnection->update(
			'logging',
			[ 'log_user' => 32794352 ],
			[
				'log_user' => 0,
				'log_type' => 'chatban'
			],
			__METHOD__
		);

		$databaseUpdater->output( "done.\n" );
		$databaseUpdater->output( 'Deleting log entries attributed to anons... ' );

		$databaseConnection->delete( 'logging', [ 'log_user' => 0 ], __METHOD__ );

		$databaseUpdater->output( "done.\n" );
		$databaseUpdater->output( 'Dropping logging.log_user_text column... ' );

		$databaseConnection->query( 'ALTER TABLE logging DROP COLUMN log_user_text', __METHOD__ );

		$databaseUpdater->output( "done.\n" );

		wfWaitForSlaves();
	}

	public static function migrateRecentChangesIpData( DatabaseUpdater $databaseUpdater ) {
		$databaseConnection = $databaseUpdater->getDB();

		if ( !$databaseConnection->fieldExists( 'recentchanges', 'rc_ip', __METHOD__ ) ) {
			$databaseUpdater->output( "recentchanges.rc_ip column already migrated.\n" );
			return;
		}

		$patchDir = static::get_patch_dir();

		$databaseUpdater->output( 'Migrating rc_ip column to VARBINARY(16) rc_ip_bin... ' );
		$databaseConnection->sourceFile( $patchDir . 'patch-populate-rc_ip_bin.sql' );
		$databaseUpdater->output( "done.\n" );

		$databaseUpdater->output( 'Dropping rc_ip index... ' );
		$databaseConnection->query( 'ALTER TABLE recentchanges DROP INDEX rc_ip' );
		$databaseUpdater->output( "done.\n" );

		$databaseUpdater->output( 'Dropping rc_user_text index... ' );
		$databaseConnection->query( 'ALTER TABLE recentchanges DROP INDEX rc_user_text' );
		$databaseUpdater->output( "done.\n" );

		$databaseUpdater->output( 'Dropping rc_ns_usertext index... ' );
		$databaseConnection->query( 'ALTER TABLE recentchanges DROP INDEX rc_ns_usertext' );
		$databaseUpdater->output( "done.\n" );

		$databaseUpdater->output( 'Dropping rc_ip column... ' );
		$databaseConnection->query( 'ALTER TABLE recentchanges DROP COLUMN rc_ip' );
		$databaseUpdater->output( "done.\n" );

		$databaseUpdater->output( 'Adding default empty value to rc_user_text column... ' );
		$databaseConnection->sourceFile( $patchDir . 'patch-rc_user_text-default.sql' );
		$databaseUpdater->output( "done.\n" );
		
		wfWaitForSlaves();
	}

	/**
	 * @author Władysław Bodzek <wladek@wikia-inc.com>
	 * @modify Piotr Molski <moli@wikia-inc.com>
	 */
	public static function do_clean_math_table( DatabaseUpdater $updater ) {
		$db = $updater->getDB();
		$table = 'math';
		$primaryKey = 'math_inputhash';
		$fields = array('math_inputhash','math_outputhash','math_html','math_mathml');

		$updater->output( "Checking {$table} table and removing rows with different encoding than utf8...\n" );

		if ( $db->tableExists( $table ) ) {
			$updater->output( "...scanning table..." );
			// Read the whole table
			$allFields = array_unique( array_merge( $fields, array( $primaryKey ) ) );
			$res = $db->select( " `{$table}`", $allFields, '',	__METHOD__ );
			// scan for all rows containing text which is not in utf8 encoding
			$wrong = array();
			while ( $row = $db->fetchRow( $res ) ) {
				foreach ( $fields as $field )
					if ( !self::is_valid_utf8_text( $row[ $field ] ) ) {
						$wrong[] = $row[ $primaryKey ];
						break;
					}
			}
			$db->freeResult( $res );
			$count = count($wrong);
			$updater->output( "ok (found " . count($wrong) . " rows)\n" );

			// and finally remove all the malformed rows
			if ($count > 0) {
				$updater->output( "...removing malformed rows..." );
				$pos = 0;
				$chunkSize = 500;
				while ($pos < $count) {
					$removing = array_slice($wrong,$pos,$chunkSize);
					$res = $db->delete( $table, array( $primaryKey => $removing ), __METHOD__ );
					$pos += $chunkSize;
				}
				$updater->output( "ok\n" );
			}
		}
	}
}
