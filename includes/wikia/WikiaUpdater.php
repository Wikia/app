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

			# indexes
			array( 'addIndex', 'archive', 'page_revision', $dir. 'patch-index-archive-page_revision.sql', true ),

			# functions
			array( 'WikiaUpdater::do_page_vote_unique_update' ),
			array( 'WikiaUpdater::do_page_wikia_props_update' ),
			array( 'WikiaUpdater::do_drop_table', 'imagetags' ),
			array( 'WikiaUpdater::do_drop_table', 'send_queue' ),
			array( 'WikiaUpdater::do_drop_table', 'send_stats' ),
			array( 'WikiaUpdater::do_drop_table', 'validate' ),
			array( 'WikiaUpdater::do_drop_table', 'cur' ),
			array( 'WikiaUpdater::do_drop_table', 'searchindex', !empty( $wgCityId ) ),
			array( 'WikiaUpdater::do_drop_table', 'page_stats' ),
			array( 'WikiaUpdater::do_drop_table', 'user_board' ),
			array( 'WikiaUpdater::do_drop_table', 'user_points_monthly' ),
			array( 'WikiaUpdater::do_drop_table', 'user_points_weekly' ),
			array( 'WikiaUpdater::do_drop_table', 'user_gift' ),
			array( 'WikiaUpdater::do_drop_table', 'user_relationship_request' ),
			array( 'WikiaUpdater::do_drop_table', 'user_register_track' ),
			array( 'WikiaUpdater::do_drop_table', 'user_board' ),
			array( 'WikiaUpdater::do_drop_table', 'watchlist_old' ),
			array( 'WikiaUpdater::do_clean_math_table' ),
			array( 'WikiaUpdater::do_transcache_update' )
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
