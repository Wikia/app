<?php
/**
 * DB accessable external objects, all revisions from all databases are merged
 * in one table.
 */


$wgHooks[ "RevisionInsertComplete" ][] = "ExternalStorageUpdate::addDeferredUpdate";

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
		$id       = $path[3];

		wfProfileIn( __METHOD__ );
		if( $this->mRevision instanceof Revision ) {
			$this->mPageId = $this->mRevision->getPage();
			$Title = Title::newFromID( $this->mPageId, GAID_FOR_UPDATE );
			if( ! $Title  ) {
				global $wgDBname;
				wfDebug( __METHOD__.": title is null, page_id={$this->mPageId}; city_id={$wgCityId}, dbname={$wgDBname}" );
				error_log( __METHOD__.": title is null, page_id={$this->mPageId}; city_id={$wgCityId}, dbname={$wgDBname}" );
				wfProfileOut( __METHOD__ );
				return false;
			}

			$dbw = wfGetDBExt( DB_MASTER, $cluster );
			$ip = ip2long(wfGetIP());

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
					"rev_timestamp" => wfTimestamp( TS_DB, $this->mRevision->mTimestamp ),
					"rev_ip" 		=> $ip
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
					array(
						"page_id" => $this->mPageId,
						"page_wikia_id" => $wgCityId
					),
					__METHOD__
				);
				if( isset( $Row->page_id ) && !empty( $Row->page_id ) ) {
					/**
					 * update, but do this only when different
					 */
					$title = $Title->getText();
					$namespace = $Title->getNamespace()
					if( $Row->page_title != $title || $Row->page_namespace != $namespace ) {
						$dbw->update(
							"pages",
							array(
								"page_wikia_id"  => $wgCityId,
								"page_namespace" => $namespace,
								"page_title"     => $title,
							),
							array(
								"page_id"        => $this->mPageId,
							),
							__METHOD__
						);
					}
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
				if( $dbw->getFlag( DBO_TRX ) ) {
					$dbw->commit();
				}
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
