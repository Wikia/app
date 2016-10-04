<?php

/**
 * @package MediaWiki
 * @addtopackage maintenance
 *
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
 */

ini_set( "include_path", dirname(__FILE__)."/../../../../maintenance/" );

$optionsWithArgs = array( "limit" );

require_once( "commandLine.inc" );

class SimpleCloseWikiMaintenance {

	private $mTarget, $mOptions;

	/**
	 * constructor
	 *
	 * @access public
	 */
	public function __construct( $options ) {
		$this->mOptions = $options;
	}

	/**
	 * 1. go through all wikis which are marked for closing and check which one
	 * 	want to have images packed.
	 *
	 * 2. pack images, send them via rsync to  target server,
	 *
	 * 3. mark in city_list.city_flags that images are sent,
	 *
	 * 4. remove images
	 *
	 * @access public
	 */
	public function execute() {
		global $wgUploadDirectory, $wgDBname;

		if ( !isset( $this->mOptions['wiki_id'] ) ) {
			echo "Wiki Id is not valid";
			die( 1 );
		}

		$where = array( "city_id" => intval( $this->mOptions['wiki_id'] ) );

		$dbr = WikiFactory::db( DB_SLAVE );
		$row = $dbr->selectRow(
			array( "city_list" ),
			array( "city_id", "city_flags", "city_dbname", "city_url", "city_public" ),
			$where,
			__METHOD__
		);

		if ( is_object( $row ) ) {
			/**
			 * reasonable defaults for wikis and some presets
			 */
			$hide     = false;
			$xdumpok  = true;
			$newFlags = 0;
			$dbname   = $row->city_dbname;
			$folder   = WikiFactory::getVarValueByName( "wgUploadDirectory", $row->city_id );
			$cluster  = WikiFactory::getVarValueByName( "wgDBcluster", $row->city_id );

			/**
			 * safety check, if city_dbname is not unique die with message
			 */
			$check = $dbr->selectRow(
				array( "city_list" ),
				array( "count(*) as count" ),
				array( "city_dbname" => $dbname ),
				__METHOD__,
				array( "GROUP BY" => "city_dbname" )
			);
			if( $check->count > 1 ) {
				echo "{$dbname} is not unique. Check city_list and rerun script";
				die( 1 );
			}
			Wikia::log( __CLASS__, "info", "city_id={$row->city_id} city_url={$row->city_url} city_dbname={$dbname} city_flags={$row->city_flags} city_public={$row->city_public}");

			Wikia::log( __CLASS__, "info", "removing folder {$folder}" );
			if( is_dir( $wgUploadDirectory ) ) {
				/**
				 * what should we use here?
				 */
				$cmd = "rm -rf {$folder}";
				wfShellExec( $cmd, $retval );
				if( $retval ) {
					/**
					 * info removing folder was not possible
					 */
				}
			}

			/**
			 * clear wikifactory tables, condition for city_public should
			 * be always true there but better safe than sorry
			 */
			$dbw = WikiFactory::db( DB_MASTER );
			$dbw->delete(
				"city_list",
				array(
					"city_public" => array( 0, -1 ),
					"city_id" => $row->city_id
				),
				__METHOD__
			);
			Wikia::log( __CLASS__, "info", "{$row->city_id} removed from WikiFactory tables" );

			/**
			 * drop database, get db handler for proper cluster
			 */
			global $wgDBadminuser, $wgDBadminpassword;
			$centralDB = empty( $cluster) ? "wikicities" : "wikicities_{$cluster}";

			/**
			 * get connection but actually we only need info about host
			 */
			$local = wfGetDB( DB_MASTER, array(), $centralDB );
			$server = $local->getLBInfo( 'host' );
			$dbw = new DatabaseMysqli( $server, $wgDBadminuser, $wgDBadminpassword, $centralDB );
			$dbw->begin();
			$dbw->query( "DROP DATABASE `{$row->city_dbname}`");
			$dbw->commit();
			Wikia::log( __CLASS__, "info", "{$row->city_dbname} dropped from cluster {$cluster}" );
		}
	}
}

/**
 * used options:
 *
 * --first			-- run only once for first wiki in queue
 * --limit=<limit>	-- run for <limit> wikis
 */
$maintenance = new SimpleCloseWikiMaintenance( $options );
$maintenance->execute();
