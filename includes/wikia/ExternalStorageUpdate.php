<?php
/**
 * DB accessable external objects, all revisions from all databases are merged
 * in one table.
 */


$wgHooks[ "RevisionInsertComplete" ][]	= "ExternalStorageUpdate::addDeferredUpdate";
$wgHooks[ "ArticleDeleteComplete" ][]	= "ExternalStorageUpdate::deleteArticleExternal";
$wgHooks[ "NewRevisionFromEditComplete" ][] = "ExternalStorageUpdate::setRevisionFromEdit";

class ExternalStorageUpdate {

	private $mId, $mUrl, $mPageId, $mRevision, $mFlags;
	const
		REV_ACTIVE 	= 'active', /*default*/
		REV_DELETED = 'delete',
		REV_HIDDEN 	= 'hidden';

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

		global $wgCityId, $wgExternalDatawareDB;

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
				Wikia::log( __METHOD__, "err", " title is null, page_id={$this->mPageId}; city_id={$wgCityId}, dbname={$wgDBname}" );
				wfProfileOut( __METHOD__ );
				return false;
			}


			/**
			 * ... but pages are always on dataware
			 */
			$dba = wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );

			$Row = $dba->selectRow(
				"pages",
				array( "page_id", "page_title", "page_namespace", "page_status" ),
				array(
					"page_id" => $this->mPageId,
					"page_wikia_id" => $wgCityId
				),
				__METHOD__
			);

			/**
			 * @todo add more statuses to $page_status
			 */
			$page_title     = $Title->getDBkey();
			$page_namespace = $Title->getNamespace();
			$page_status    = $Title->isRedirect(GAID_FOR_UPDATE) ? 1 : 0;
			$page_latest    = $Title->getLatestRevID();

			if( isset( $Row->page_id ) && !empty( $Row->page_id ) ) {
				/**
				 * update
				 */
				if( $Row->page_title != $page_title || $Row->page_namespace != $page_namespace ) {
					$dba->update(
						"pages",
						array(
							"page_wikia_id"    => $wgCityId,
							"page_namespace"   => $page_namespace,
							"page_title"       => $page_title,
							"page_title_lower" => mb_strtolower( $page_title ),
							"page_latest"      => $page_latest,
							"page_status"      => $page_status
						),
						array(
							"page_id"        => $this->mPageId,
							"page_wikia_id"  => $wgCityId
						),
						__METHOD__
					);
				}
			}
			else {
				/**
				 * insert
				 */
				$dba->insert(
					"pages",
					array(
						"page_wikia_id"    => $wgCityId,
						"page_id"          => $this->mPageId,
						"page_namespace"   => $page_namespace,
						"page_title"       => $page_title,
						"page_title_lower" => mb_strtolower( $page_title ),
						"page_latest"      => $page_latest,
						"page_status"      => $page_status,
						"page_counter"     => 0,
						"page_edits"       => 0,
					),
					__METHOD__
				);
			}

			/**
			 * be sure that data is written
			 */
			if( $dba->getFlag( DBO_TRX ) ) {
				$dba->commit();
			}
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
	 * @param Revision	$revision	revision object (reference)
	 * @param string	$url		url to external object
	 * @param string	$flags		flags for this revision
	 *
	 * @return true means process other hooks
	 */
	static public function addDeferredUpdate( &$revision, $url, $flags ) {
		global $wgDeferredUpdateList;

		if( strpos( $flags, "external" ) !== false ) {
			$u = new ExternalStorageUpdate( $url, $revision, $flags );
			array_push( $wgDeferredUpdateList, $u );
		}
		return true;
	}

	/**
	 * deleteArticleExternal
	 *
	 * static method called as hook
	 *
	 * @static
	 * @access public
	 * @author Piotr Molski <moli@wikia.com>
	 *
	 * @param Revision	$oArticle	article object
	 * @param User		$oUser		user object
	 * @param string	$reason		reason of object removing
	 * @param int		$page_id	page_id to remove
	 *
	 * @return true means process other hooks
	 */
	static public function deleteArticleExternal(&$oArticle, &$oUser, $reason, $page_id) {
		global $wgCityId, $wgExternalDatawareDB;

		wfProfileIn( __METHOD__ );
		if( !empty( $page_id ) ) {
			$dbw = wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );
			/* begin transaction */
			$dbw->begin();
			$dbw->update(
				"pages",
				array( "page_status" => 2 ),
				array(
					"page_id"       => $page_id,
					"page_wikia_id" => $wgCityId
				),
				__METHOD__
			);
			/* commit */
			$dbw->commit();
		}
		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * setRevisionFromEdit
	 *
	 * static method called as hook
	 *
	 * @static
	 * @access public
	 * @author Piotr Molski <moli@wikia.com>
	 *
	 * @param Article	$oArticle	article object
	 * @param Revision	$oRevision	revision object
	 * @param int		$baseRevId	base revision ID (false if not used)
	 * @param User		$oUser		user object
	 *
	 * @return true means process other hooks
	 */
	static public function setRevisionFromEdit( $oArticle, $oRevision, $baseRevId, $oUser) {
		global $wgCityId, $wgExternalDatawareDB;

		wfProfileIn( __METHOD__ );

		if ( !$oArticle instanceof Article ) {
			wfProfileOut( __METHOD__ );
			return true;
		}

		if ( !$oRevision instanceof Revision) {
			wfProfileOut( __METHOD__ );
			return true;
		}

		$Title   = $oArticle->getTitle();
		$page_id = $oArticle->getId();
		if( ! $Title  ) {
			Wikia::log( __METHOD__, "err", " title is null, page_id={$page_id}" );
			wfProfileOut( __METHOD__ );
			return false;
		}

		$page_status = $Title->isRedirect( GAID_FOR_UPDATE) ? 1 : 0;

		$dbw = wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );

		$dbw->update(
			"pages",
			array( /* SET */
				'page_latest'	=> $oRevision->getId(),
				'page_status' 	=> $page_status
			),
			array(
				'page_id' 		=> $oArticle->getId(),
				'page_wikia_id' => $wgCityId
			),
			__METHOD__
		);

		if( $dbw->getFlag( DBO_TRX ) ) {
			$dbw->commit();
		}

		wfProfileOut( __METHOD__ );
		return true;
	}
};
