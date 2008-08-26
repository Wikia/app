<?php
/**
 * DB accessable external objects, all revisions from all databases are merged
 * in one table.
 */

/**+ tables definition

CREATE TABLE `blobs` (
  `blob_id` int(10) NOT NULL auto_increment,
  `rev_wikia_id` int(8) unsigned NOT NULL,
  `rev_id` int(10) unsigned default NULL,
  `rev_page_id` int(10) unsigned NOT NULL,
  `rev_namespace` int(10) unsigned NOT NULL default '0',
  `rev_user` int(10) unsigned NOT NULL default '0',
  `rev_user_text` varchar(255) character set latin1 collate latin1_bin NOT NULL default '',
  `rev_timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `blob_text` mediumtext NOT NULL,
  `rev_flags` tinyblob default NULL
  PRIMARY KEY  (`blob_id`),
  KEY `rev_page_id` (`rev_wikia_id`,`rev_page_id`,`rev_id`),
  KEY `rev_namespace` (`rev_wikia_id`,`rev_page_id`,`rev_namespace`),
  KEY `rev_user` (`rev_wikia_id`,`rev_user`,`rev_timestamp`),
  KEY `rev_user_text` (`rev_wikia_id`,`rev_user_text`,`rev_timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `pages` (
  `page_wikia_id` int(8) unsigned NOT NULL,
  `page_id` int(10) unsigned NOT NULL,
  `page_namespace` int(10) unsigned NOT NULL default '0',
  `page_title` varchar(255) NOT NULL,
  `page_counter` int(8) unsigned NOT NULL default '0',
  `page_edits` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY (`page_wikia_id`,`page_id`),
  KEY `page_namespace` (`page_wikia_id`,`page_namespace`,`page_title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
**/

$wgHooks[ "RevisionInsertComplete" ][] = array( "ExternalStorageUpdate::addDeferredUpdate" ) ;

class ExternalStorageUpdate {

	private $mId, $mUrl, $mPageId, $mRevision, $mFlags;

	public function __construct( $url, $revision, $flags ) {
		$this->mUrl = $url;
		$this->mRevision = $revision;
		$this->mFlags = $flags;
	}

	/**
	 * doUpdate
	 *
	 * called on deferred update loop
	 *
	 * @access public
	 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia.com>
	 *
	 * @return boolean status of operation
	 */
	public function doUpdate() {

		global $wgCityId;

		$path = explode( "/", $this->mUrl );
		$store    = $path[0];
		$cluster  = $path[2];
		$id	      = $path[3];

		wfProfileIn( __METHOD__ );
		if( $this->mRevision instanceof Revision ) {
			$this->mPageId = $this->mRevision->getPage();
			$Title = Title::newFromID( $this->mPageId );
			if( ! $Title  ) {
				wfDebug( __METHOD__.": title is null, page id = {$this->mPageId}" );
				wfProfileOut( __METHOD__ );
				return false;
			}

			/**
			 * we should not call this directly, we'll use new loadbalancer factory
			 * when 1.13 will be alive
			 */
			$external = new ExternalStoreDB();
			$dbw = $external->getMaster( $cluster );

			$ret = $dbw->update(
				"blobs",
				array(
					"rev_id"        => $this->mRevision->getId(),
					"rev_user"      => $this->mRevision->getUser(),
					"rev_page_id"   => $this->mPageId,
					"rev_wikia_id"  => $wgCityId,
					"rev_namespace" => $Title->getNamespace(),
					"rev_user_text" => $this->mRevision->getUserText(),
					"rev_flags"     => $this->mFlags,
					"rev_timestamp" => wfTimestamp( TS_DB, $this->mRevision->mTimestamp )
				),
				array( "blob_id" => $id ),
				__METHOD__
			);

			if( $ret ) {
				/**
				 * insert or update
				 */
				$Row = $dbw->selectRow(
					"pages",
					array( "page_id" ),
					array( "page_id" => $this->mPageId ),
					__METHOD__
				);
				if( isset( $Row->page_id ) && !empty( $Row->page_id ) ) {
					/**
					 * update
					 */
					$dbw->update(
						"pages",
						array(
							"page_wikia_id"  => $wgCityId,
							"page_namespace" => $Title->getNamespace(),
							"page_title"     => $Title->getText(),
						),
						array(
							"page_id"        => $this->mPageId,
						),
						__METHOD__
					);
				}
				else {
					/**
					 * insert
					 */
					$dbw->insert(
						"pages",
						array(
							"page_wikia_id"  => $wgCityId,
							"page_id"        => $this->mPageId,
							"page_namespace" => $Title->getNamespace(),
							"page_title"     => $Title->getText(),
							"page_counter"   => 0,
							"page_edits"     => 0,
						),
						__METHOD__
					);
				}
				/**
				 * be sure that data is written
				 */
				$dbw->commit();
			}
		}
		else {
			wfDebug( __METHOD__.": revision object is not Revision instance\n" );
		}
		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * addDeferredUpdate
	 *
	 * static method called as hook
	 *
	 * @static
	 * @access public
	 * @author Krzysztof Krzyżaniak <eloy@wikia.com>
	 *
	 * @param Revision	$revision	revision object
	 * @param string	$url		url to external object
	 * @param string	$flags		flags for this revision
	 *
	 * @return true means process other hooks
	 */
	static public function addDeferredUpdate( &$revision, &$url, &$flags ) {
		global $wgDeferredUpdateList;

		if( strpos( $flags, "external" ) !== false ) {
			$u = new ExternalStorageUpdate( $url, $revision, $flags );
			array_push( $wgDeferredUpdateList, $u );
		}
		return true;
	}
};
