<?php

/**
 * @package MediaWiki
 * @subpackage WikiFactory
 * @author Krzysztof Krzyżaniak <eloy@wikia.com> for Wikia.com
 * @version: $Id$
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is MediaWiki extension.\n";
	exit( 1 ) ;
}



/**
 * WikiMover:
 *  class basicly moves articles from one _database_ to another _database_
 */
class WikiMover {

	public $mParams = null;                    #--- params, used when called by WikiaExternalMover
	public $mSourceID = null;                  #--- source database id in city_list
	public $mTargetID = null;                  #--- target database id in city_list
	public $mSourceName = null;                #--- source database name in mysqld
	public $mTargetName = null;                #--- target database name in mysqld
	public $mSourceMetaSpace = null;           #--- metaspace used as prefix in target
	public $mSourceUploadDirectory = null;     #--- metaspace used as prefix in target
	public $mTargetUploadDirectory = null;     #--- metaspace used as prefix in target
	public $mFrom = null;                      #--- used on load(), determine of method
	public $mType = null;                      #--- used on load(), determine if external
	public $mOverwrite = false;                #--- startes overwrite articles no matter what
	public $mMoveUserGroups = true;            #--- toggle for user groups transfer
	public $mDataLoaded = false;
	public $mInternalLogger = array();
	public $mTargetTextFields = array();       #--- contains fields from "text" table

	public $mRunJobs = false;                  #--- set true to run jobs
	public $mRefreshLinks = false;             #--- set true to refresh articles links after move
	public $mRevisionUser = null;              #--- user to be set for all moved revisions

	/**
	 * almost empty constructor
	 */
	public function __construct()    {

	}

	/**
	 * @method newFromIDs
	 * @access public
	 * @static
	 *
	 * @param $source integer source id from city_list
	 * @param $target integer target id from city_list ,
	 *
	 * @return WikiMover object
	 *
	 */
	public static function newFromIDs( $source, $target ) {
		$oMover = new WikiMover;

		$oMover->mSourceID = $source;
		$oMover->mTargetID = $target;
		$oMover->mFrom = 'id';
		$oMover->mType = 'internal';

		return $oMover;
	}

	/**
	 * @method newFromNames
	 * @access public
	 * @static
	 *
	 * @param $source string - source database name from city_list
	 * @param $target string - target database name from city_list
	 * @param $params mixed default null -
	 *
	 * @return WikiMover object
	 */
	public static function newFromNames( $source, $target, $params = null ) {
		$oMover = new WikiMover;

		$oMover->mSourceName = $source;
		$oMover->mTargetName = $target;
		$oMover->mFrom = 'name';
		$oMover->mType = 'internal';

		if( !empty( $params["type"] )) {
			$oMover->mType = $params["type"];
		}

		return $oMover;
	}

	/**
	 *  @method load
	 *
	 *  load and setup configuration before actual moving
	 *  and checking
	 *
	 *  @author eloy@wikia
	 *  @access public
	 *
	 *  @return nothing
	 */
	public function load() {
		global $wgContLang;

		if ( $this->mDataLoaded ) {
			return;
		}
		wfProfileIn( __METHOD__ );

		$this->mDataLoaded = true;
		switch ( $this->mFrom ) {
			case "id":
				$this->mSourceName = WikiFactory::IDtoDB( $this->mSourceID, true );
				$this->mTargetName = WikiFactory::IDtoDB( $this->mTargetID, true );
			break;

			case "name":
				if ( $this->mType === "external" ) {

					#---
					# mType === external means that we move from temporary
					# database, it's external import, we don't have id
					# for that database in city_list
					$this->mSourceID = WikiFactory::DBtoID( $this->mSourceName );
				}
				#--- but target wiki have to be created before task anyway
				$this->mTargetID = WikiFactory::DBtoID( $this->mTargetName );
				break;
		}
		/**
		 * get some configurations data from source and target database
		 * NOTE: this should be handled in another way in WikiMover External
		 * because it use temporary database and doesn't have configuration
		 * stored in wikicities database. So you have to provide proper values
		 * in constructor params
		 */


		if ( $this->mType === "external" ) {
			$this->mSourceMetaSpace = $this->mParams("wgMetaNamespace");
			$this->mSourceUploadDirectory = $this->mParams("wgUploadDirectory");
		}
		else {
			#--- source wgMetaNamespace
			$this->mSourceMetaSpace = WikiFactory::getVarValueByName( "wgMetaNamespace", $this->mSourceID );

			if ( empty($this->mSourceMetaSpace) ) {
				$this->mSourceMetaSpace = str_replace( ' ', '_', WikiFactory::getVarValueByName( "wgSitename", $this->mSourceID ));
			}

			if ( empty( $this->mSourceMetaSpace )) {
				$this->mSourceMetaSpace = $wgContLang->ucfirst( $this->mSourceName );
			}

			#--- source path for images
			$this->mSourceUploadDirectory = WikiFactory::getVarValueByName( "wgUploadDirectory", $this->mSourceID );
		}

		#--- target path for images
		$this->mTargetUploadDirectory = WikiFactory::getVarValueByName( "wgUploadDirectory", $this->mTargetID );

		/**
		 * table "text" could be in old format (three fields instead eleven)
		 */
		$dbTarget = wfGetDB( DB_MASTER, array(), $this->mTargetName );
		$oRes = $dbTarget->query(sprintf("SHOW COLUMNS FROM %s",$this->targetTable( "text" )));
		while ( $oRow = $dbTarget->fetchObject( $oRes ) ) {
			$this->mTargetTextFields[] =  $oRow->Field;
		}
		$dbTarget->freeResult($oRes);

		wfProfileOut( __METHOD__ );
	}

	/**
	 * setSourceUploadDirectory
	 *
	 * @param String	$path	source image directory
	 */
	public function setSourceUploadDirectory( $path ) {
		$this->mSourceUploadDirectory = $path;
	}

	/**
	 * mTargetUploadDirectory
	 *
	 * @param String	$path	target image directory
	 */
	public function setTargetUploadDirectory( $path ) {
		$this->mTargetUploadDirectory = $path;
	}


	/**
	 * setRunJobs
	 *
	 * @param Boolean	$param
	 */
	public function setRunJobs( $value = true ) {
		$this->mRunJobs = $value;
	}

	/**
	 * setRunJobs
	 *
	 * @param Boolean	$param
	 */
	public function setRefreshLinks( $value = true ) {
		$this->mRefreshLinks = $value;
	}

	/**
	 *  @method move
	 *
	 *  move articles from source to target with some additional conditions
	 *  and checking.
	 *
	 *  when mOverwrite is false it changes titles for conflicted articles
	 *  when mOverwrite is true it takes last revision from source and put it
	 *  on top in target
	 *
	 *  @author eloy@wikia
	 *  @access public
	 *
	 *  @return nothing
	 */
	public function move()
	{
		global $wgCanonicalNamespaceNames, $IP, $wgWikiaLocalSettingsPath, $wgContLang;

		if (empty( $this->mSourceName )) {
			$this->log( "wikimover: source database name is empty" );
			return false;
		}

		if (empty( $this->mTargetName )) {
			$this->log("wikimover: target database name is empty", true);
			return false;
		}

		if( ( $this->mTargetName === $this->mSourceName) || ($this->mSourceID == $this->mTargetID) ) {
			$this->log("wikimover: source and target are exactly the same", true);
			return false;
		}

		wfProfileIn( __METHOD__ );

		$this->mCurrTime = wfTime();
		$startTime = $this->mCurrTime;

		#--- seems like we can start moving articles
		$this->log( "Moving articles from {$this->mSourceName} ({$this->mSourceID}) to $this->mTargetName ({$this->mTargetID})" );

		$dbSource = wfGetDB( DB_MASTER, array(), $this->mSourceName );
		$dbTarget = wfGetDB( DB_MASTER, array(), $this->mTargetName );

		/**
		 * get all pages for source DB
		 */
		$skipNamespaces = array( NS_MEDIAWIKI, NS_MEDIAWIKI_TALK );
		$aSourcePages = array();
		$oRes = $dbSource->select(
			array(
				$this->sourceTable( "page" ),
				$this->sourceTable( "revision" ),
				$this->sourceTable( "text" )
			),
			array( "*" ),
			array(
				"page_id = rev_page",
				"rev_text_id = old_id"
			 ),
			__METHOD__
		);
		while ( $oRow = $dbSource->fetchObject( $oRes ) ) {
			if ( !isset( $aSourcePages[ $oRow->page_id ] ) ) {
				$aSourcePages[ $oRow->page_id ] = array();
				$aSourcePages[ $oRow->page_id ][ "data" ] = $oRow;
			}

			if ( !isset( $aSourcePages[ $oRow->page_id ][ "revision" ] ) ) {
				$aSourcePages[ $oRow->page_id ][ "revision" ] = array();
			}
			$aSourcePages[ $oRow->page_id ][ "revision" ][ $oRow->rev_id ] = $oRow;
		}
		$dbSource->freeResult( $oRes );

		$this->log( "Get data from source database" );
		/**
		 * get all pages for target DB
		 */
		$aTargetPages = array();
		//array( "page_namespace not in (" . implode(",", $skipNamespaces) . ")" ),
		$oRes = $dbTarget->select(
			array( $this->targetTable( "page" ) ),
			array( "*" ),
			null,
			__METHOD__
		);

		while ( $oRow = $dbTarget->fetchObject( $oRes ) ) {
			$aTargetPages[ $oRow->page_namespace ][ $oRow->page_title ] = $oRow->page_id;
		}
		$dbTarget->freeResult( $oRes );

		$this->log( "Get all pages from target database" );
		$imageDirs = array();
		foreach ( $aSourcePages as $id => $page ) {
			/**
			 * auto incrementy: revision.rev_id, text.old_id, page.page_id
			 *
			 * potentialy for moving as well:
			 *
			 * categorylinks
			 * externallinks
			 * imagelinks
			 * langlinks
			 * templatelinks
			 * image
			 */

			#--- check if such article exists in target database
			$targetPageId = 0;
			if ( isset( $aTargetPages[ $page["data"]->page_namespace ][ $page["data"]->page_title ] ) ) {
				$targetPageId = $aTargetPages[ $page["data"]->page_namespace ][ $page["data"]->page_title ];
			}

			if ( empty( $targetPageId ) ) {
				#--- go ahead and dance, article doesn't exist\
				switch( $page["data"]->page_namespace ) {
					case NS_IMAGE:
						#--- get image dir
						$aImages = $this->getImagePaths( $page["data"]->page_title, false );
						$this->log( sprintf("Found image in DB -> %s copy to %s ", $aImages["source"], $aImages["target"] ) );
						if ( !isset( $imageDirs[ $aImages["target"] ] ) ) {
							wfMkdirParents(dirname($aImages["target"]));
						}
						#--- copy file to target
						@copy( $aImages["source"], $aImages["target"] );
						$this->log( sprintf("%s copied to %s ", $aImages["source"], $aImages["target"]) );
						#--- remember image dir
						$imageDirs[$aImages["target"]] = 'Done';
						break;
				}
				$this->movePage( $page );
				$this->log(sprintf( "%s copied to %s",
					$this->pageName($page["data"]->page_namespace, $page["data"]->page_title),
					$this->pageName($page["data"]->page_namespace, $page["data"]->page_title)
				));
			} else {
				switch( $page["data"]->page_namespace ) {
					#--- user page namespace
					#--- user_talk page namespace
					case NS_USER:
					case NS_USER_TALK:
						$sTargetTtitle = $page["data"]->page_title . "/" .$this->mSourceMetaSpace;
						$this->log(sprintf(
							"Rename %s to %s",
							$this->pageName($page["data"]->page_namespace, $page["data"]->page_title),
							$this->pageName($page["data"]->page_namespace, $sTargetTtitle)
						));
						$this->movePage( $page, $sTargetTtitle );
						break;

					#--- image namespace
					#--- image_talk namespace
					case NS_IMAGE:
					case NS_IMAGE_TALK:
						if ($this->mOverwrite === false) {
							$this->log(
								sprintf("Image %s not moved because of conflict",
									$this->pageName($page["data"]->page_namespace, $page["data"]->page_title)
							));
						}
						else {
							#--- get image dir
							$aImages = $this->getImagePaths( $page["data"]->page_title, false );
							$this->log( sprintf("Found image (new) in DB -> %s copy to %s ", $aImages["source"], $aImages["target"] ) );
							#--- mkdir if needed
							if ( !isset( $imageDirs[ $aImages["target"] ] ) ) {
								wfMkdirParents(dirname($aImages["target"]));
							}
							#--- copy file to target
							@copy( $aImages["source"], $aImages["target"] );
							$this->log( sprintf( "Overwrite %s in target", $page["data"]->page_title ) );
							$imageDirs[$aImages["target"]] = 'Done';
							#---
							$this->moveLastRevision( $page, $targetPageId );
						}
						break;

					#--- main article
					case NS_MAIN:
					case NS_TALK:
					#--- Template namespace
					case NS_MEDIAWIKI:
					case NS_MEDIAWIKI_TALK:
					#--- Template namespace
					case NS_TEMPLATE:
					case NS_TEMPLATE_TALK:
					#--- Help namespace
					case NS_HELP:
					case NS_HELP_TALK:
						if ($this->mOverwrite === false) {
							$sTargetTtitle = $this->mSourceMetaSpace."_".$page["data"]->page_title;
							$this->log( sprintf( "Rename %s to %s", $page["data"]->page_title, $sTargetTtitle ) );
							$this->movePage( $page, $sTargetTtitle );
						}
						else {
							$this->log( sprintf( "Overwrite %s in target", $page["data"]->page_title ) );
							$this->moveLastRevision( $page, $targetPageId );
						}
						break;

					#--- other namespaces
					default:
						$this->log(
							sprintf("Page not moved %s because exists in target",
								$this->pageName($page["data"]->page_namespace, $page["data"]->page_title)
							)
						);
				}
			}

		}

		$this->log( "run moveImages() " );
		$this->moveImages();
		$this->log( "run moveUserGroups() " );
		$this->moveUserGroups();

		#--- and last cleaning
		if ( $this->mRunJobs === true ) {
			wfShellExec( "SERVER_ID={$this->mTargetID} php $IP/maintenance/runJobs.php --conf {$wgWikiaLocalSettingsPath}" );
			$this->log( "run SERVER_ID={$this->mTargetID} php $IP/maintenance/runJobs.php --conf {$wgWikiaLocalSettingsPath}" );
		}

		#--- refresh links - related to rt#6189
		if ( $this->mRefreshLinks === true ) {
			wfShellExec( "SERVER_ID={$this->mTargetID} php $IP/maintenance/refreshLinks.php --conf {$wgWikiaLocalSettingsPath}" );
			$this->log( "run SERVER_ID={$this->mTargetID} php $IP/maintenance/refreshLinks.php --conf {$wgWikiaLocalSettingsPath}" );
		}

		$this->log( sprintf("Total (mover): %F", wfTime() - $startTime) );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * setOverwrite
	 *
	 * set internal mOverwrite parameter
	 *
	 * @author eloy@wikia
	 * @access public
	 *
	 * @return void
	 */
	public function setOverwrite( $toggle ) {
		$this->mOverwrite = (bool) $toggle;
	}

	/**
	 * @method movePage
	 * @author eloy@wikia
	 * @access private
	 *
	 * @param array $aPage  - data for page with revisions and text
	 * @param string $sTitle - new title for page, could be null
	 *
	 * @return nothing
	 */
	private function movePage( $aPage, $sTitle = null ) {

		$dbTarget = wfGetDB( DB_MASTER, array(), $this->mTargetName );
		if ( !empty( $sTitle )) {
			$sNewTitle = $sTitle;
		} else {
			$sNewTitle = $aPage["data"]->page_title;
		}

		$iOldArticleID = $aPage["data"]->page_id;
		$iNewArticleID = 0;
		$iOldLastRevision = $aPage["data"]->page_latest;
		$iNewLastRevision = 0;

		$dbTarget->begin();
		try {
			$dbTarget->insert(
				$this->targetTable("page"),
				array(
					"page_id"           => null,
					"page_namespace"    => $aPage["data"]->page_namespace,
					"page_title"        => $sNewTitle,
					"page_restrictions" => $aPage["data"]->page_restrictions,
					"page_counter"      => $aPage["data"]->page_counter,
					"page_is_redirect"  => $aPage["data"]->page_is_redirect,
					"page_is_new"       => $aPage["data"]->page_is_new,
					"page_random"       => $aPage["data"]->page_random,
					"page_touched"      => $aPage["data"]->page_touched,
					"page_latest"       => $aPage["data"]->page_latest,
					"page_len"          => $aPage["data"]->page_len
				)
			);
			$iNewArticleID = $dbTarget->insertId();

			foreach ( $aPage["revision"] as $id => $oRevision ) {

				#---
				# first insert text and get old_id (which is new rev_text_id)
				# text table can have different layout in different wikia

				$dbTarget->insert(
					$this->targetTable("text"),
					$this->rowToText($oRevision),
					__METHOD__
				);
				$iNewTextID = $dbTarget->insertId();

				if(($this->mRevisionUser instanceof User) && $this->mRevisionUser->getId()) {
					$sRevUser = $this->mRevisionUser->getId();
					$sRevUserText = $this->mRevisionUser->getName();
				}
				else {
					$sRevUser = $oRevision->rev_user;
					$sRevUserText = $oRevision->rev_user_text;
				}

				$dbTarget->insert(
					$this->targetTable("revision"),
					array(
						"rev_id"            => null,
						"rev_page"          => $iNewArticleID,
						"rev_comment"       => $oRevision->rev_comment,
						"rev_user"          => $sRevUser,
						"rev_user_text"     => $sRevUserText,
						"rev_timestamp"     => $oRevision->rev_timestamp,
						"rev_minor_edit"    => $oRevision->rev_minor_edit,
						"rev_deleted"       => $oRevision->rev_deleted,
						"rev_text_id"       => $iNewTextID
					),
					__METHOD__
				);
				if ( $oRevision->rev_id == $iOldLastRevision ) {
					$iNewLastRevision = $dbTarget->insertId();
				}

				#--- update page with new last revision
				$dbTarget->update(
					$this->targetTable("page"),
					array( "page_latest" => $iNewLastRevision ),
					array( "page_id" => $iNewArticleID ),
					__METHOD__
				);
			}
			$dbTarget->commit();
		}
		catch( DBQueryError $e ) {
			$this->log(
				sprintf("Error %s not moved because it already exists in target database",
					$this->pageName( $aPage["data"]->page_namespace, $sNewTitle )
			));
			$dbTarget->rollback();
		}
	}

	/**
	 * moveLastRevision
	 *
	 * move only last revision of page, used in overwritting articles
	 *
	 * @author eloy@wikia
	 * @access private
	 *
	 * @param array $aPage: data for page with revisions and text
	 * @param integer $targetID: page_id in target database
	 *
	 * @return nothing
	 */
	private function moveLastRevision( $aPage, $targetID ) {
		$dbTarget = wfGetDB( DB_MASTER, array(), $this->mTargetName );

		$iOldArticleID = $aPage["data"]->page_id;
		$iNewArticleID = $targetID;
		$iOldLastRevision = $aPage["data"]->page_latest;
		$iNewLastRevision = 0;

		#--- get only data for last revision
		$dbTarget->begin();
		$oRevision = $aPage["revision"][$aPage["data"]->page_latest];

		$sNow = wfTimestampNow();
		$aText = $this->rowToText($oRevision);

		if ( isset( $aText["old_timestamp"] )) {
			$aText["old_timestamp"] = $sNow;
		}

		$dbTarget->insert(
			$this->targetTable("text"),
			$aText,
			__METHOD__
		);
		$iNewTextID = $dbTarget->insertId();

		if(($this->mRevisionUser instanceof User) && $this->mRevisionUser->getId()) {
			$sRevUser = $this->mRevisionUser->getId();
			$sRevUserText = $this->mRevisionUser->getName();
		}
		else {
			$sRevUser = $oRevision->rev_user;
			$sRevUserText = $oRevision->rev_user_text;
		}

		$dbTarget->insert(
			$this->targetTable("revision"),
			array(
				"rev_id"            => null,
				"rev_page"          => $iNewArticleID,
				"rev_comment"       => $oRevision->rev_comment,
				"rev_user"          => $sRevUser,
				"rev_user_text"     => $sRevUserText,
				"rev_timestamp"     => $sNow, //$oRevision->rev_timestamp
				"rev_minor_edit"    => $oRevision->rev_minor_edit,
				"rev_deleted"       => $oRevision->rev_deleted,
				"rev_text_id"       => $iNewTextID
			),
			__METHOD__
		);

		$iNewLastRevision = $dbTarget->insertId();

		#--- update page with new last revision
		$dbTarget->update(
			$this->targetTable("page"),
			array( "page_latest" => $iNewLastRevision ),
			array( "page_id" => $iNewArticleID ),
			__METHOD__
		);
		echo "last-revision: {$iNewLastRevision} article-id: {$iNewArticleID}\n";
		$dbTarget->commit();
	}

	/**
	 * setRevisionUser
	 *
	 * set the user name for all moving revisions
	 *
	 * @access public
	 * @param object $oUser Mediawiki user object
	 *
	 */
	public function setRevisionUser(User $oUser) {
		$this->mRevisionUser = $oUser;
	}

	/**
	 * rowToText
	 *
	 * text table could have different format, so this function check
	 * which fields are available and fill array accordingy
	 *
	 * @access private
	 * @author eloy@wikia
	 *
	 * @param object $oRevision: database object with mixed revision and text data
	 *
	 * @return array composed array with proper values
	 */
	private function rowToText( $oRevision ) {
		$aTextFields = array();
		foreach ($this->mTargetTextFields as $field) {
			switch( $field ) {
				case "old_id":
					$aTextFields["old_id"] = null;
					break;

				case "old_namespace":
					$aTextFields["old_namespace"] = $oRevision->old_namespace;
					break;

				case "old_title":
					$aTextFields["old_title"] = $oRevision->old_title;
					break;

				case "old_text":
					$aTextFields["old_text"] = $oRevision->old_text;
					break;

				case "old_comment":
					$aTextFields["old_comment"] = $oRevision->old_comment;
					break;

				case "old_user":
					$aTextFields["old_user"] = $oRevision->old_user;
					break;

				case "old_user_text":
					$aTextFields["old_user_text"] = $oRevision->old_user_text;
					break;

				case "old_timestamp":
					$aTextFields["old_timestamp"] = $oRevision->old_timestamp;
					break;

				case "old_minor_edit":
					$aTextFields["old_minor_edit"] = $oRevision->old_minor_edit;
					break;

				case "old_flags":
					$aTextFields["old_flags"] = $oRevision->old_flags;
					break;

				case "inverse_timestamp":
					$aTextFields["inverse_timestamp"] = $oRevision->inverse_timestamp;
					break;
			}
		}
		return $aTextFields;
	}

	/**
	 * @method redirect
	 *
	 * redirect source wikia url to target wikia url
	 *
	 * @author eloy@wikia
	 * @access public
	 *
	 * @return nothing
	 */
	public function redirect() {
		global $wgExternalSharedDB;

		if (empty( $this->mSourceID )) {
			$this->log( "wikimover: source id is empty. Cannot redirect" );
			return false;
		}

		if (empty( $this->mTargetID )) {
			$this->log( "wikimover: target id is empty. Cannot redirect" );
			return false;
		}


		$dbCentral = WikiFactory::db( DB_MASTER );
		$dbCentral->begin();
		#--- set city_public to 2 for source
		$dbCentral->update(
			"city_list",
			array( "city_public" => 2 ), #--- means redirected
			array( "city_id" => $this->mSourceID ),
			__METHOD__
		);
		$oTargetWiki = $dbCentral->selectRow(
			"city_list",
			array( "city_url" ),
			array( "city_id" => $this->mTargetID ),
			__METHOD__
		);

		#--- set city_url for source from target
		$dbCentral->update(
			"city_list",
			array( "city_url" => $oTargetWiki->city_url ),
			array( "city_id" => $this->mSourceID ),
			__METHOD__
		);

		$dbCentral->commit();
	}

	/**
	 * moveUserGroups
	 *
	 * copy user_groups from source to target
	 *
	 * @author eloy@wikia
	 * @access public
	 *
	 * @return nothing
	 */
	public function moveUserGroups() {
		if (empty( $this->mMoveUserGroups )) {
			$this->log('Skipped moving user groups as instructed');
			return true;
		}

		if (empty( $this->mSourceName )) {
			wfDebug("wikimover: source database name is empty", true);
			return false;
		}

		if (empty( $this->mTargetName )) {
			wfDebug("wikimover: target database name is empty", true);
			return false;
		}

		wfProfileIn( __METHOD__ );
		$aUserGroups = array();

		$dbSource = wfGetDB( DB_MASTER, array(), $this->mSourceName );
		$dbTarget = wfGetDB( DB_MASTER, array(), $this->mTargetName );

		#--- get user_groups data from source
		$oRes = $dbSource->select(
			$this->sourceTable("user_groups"),
			array("*"),
			null,
			__METHOD__
		);

		while ( $oRow = $dbSource->fetchObject($oRes)) {
			$aUserGroups[] = $oRow;
		}

		$dbSource->freeResult( $oRes );

		$dbTarget->begin();
		#--- iterate, delete, insert
		foreach ( $aUserGroups as $oUserRow ) {
			$dbTarget->delete(
				$this->targetTable("user_groups"),
				array(
					"ug_user" => $oUserRow->ug_user,
					"ug_group" => $oUserRow->ug_group
				),
				__METHOD__
			);
			$dbTarget->insert(
				$this->targetTable("user_groups"),
				array(
					"ug_user" => $oUserRow->ug_user,
					"ug_group" => $oUserRow->ug_group
				),
				__METHOD__
			);
			$this->log(sprintf("User %s/%s moved to target database", $oUserRow->ug_user, $oUserRow->ug_group));
		}
		$dbTarget->commit();
		wfProfileOut( __METHOD__ );
	}

	/**
	 * moveImages
	 *
	 * copy image table from source database to target database
	 *
	 * @author eloy@wikia
	 * @access public
	 *
	 * @return nothing
	 */
	public function moveImages() {
		if (empty( $this->mSourceName )) {
			wfDebug("wikimover: source database name is empty", true);
			return false;
		}

		if (empty( $this->mTargetName )) {
			wfDebug("wikimover: target database name is empty", true);
			return false;
		}

		wfProfileIn( __METHOD__ );
		$aImages = array();

		$dbSource = wfGetDB( DB_MASTER, array(), $this->mSourceName );
		$dbTarget = wfGetDB( DB_MASTER, array(), $this->mTargetName );

		$this->log( "load images from source database" );
		#--- get image data from source
		$oRes = $dbSource->select(
			$this->sourceTable("image"),
			array("*"),
			null,
			__METHOD__
		);

		while ( $oRow = $dbSource->fetchObject($oRes)) {
			$aImages[] = array (
				"img_name"          => $oRow->img_name,
				"img_size"          => $oRow->img_size,
				"img_description"   => $oRow->img_description,
				"img_user"          => $oRow->img_user,
				"img_user_text"     => $oRow->img_user_text,
				"img_timestamp"     => $oRow->img_timestamp,
				"img_width"         => $oRow->img_width,
				"img_height"        => $oRow->img_height,
				"img_bits"          => $oRow->img_bits,
				"img_metadata"      => $oRow->img_metadata,
				"img_media_type"    => $oRow->img_media_type,
				"img_major_mime"    => $oRow->img_major_mime,
				"img_minor_mime"    => $oRow->img_minor_mime,
				"img_sha1"			=> $oRow->img_sha1
			);
		}
		$dbSource->freeResult( $oRes );

		$this->log( "load images from target database" );
		#--- get image data from target
		$oRes = $dbTarget->select(
			$this->targetTable("image"),
			array("img_name, img_size"),
			null,
			__METHOD__
		);
		$targetImages = array();
		while ( $oRow = $dbTarget->fetchObject($oRes)) {
			$targetImages[$oRow->img_name] = $oRow->img_size;
		}
		$dbTarget->freeResult( $oRes );

		$dbTarget->begin();
		#--- iterate, delete, insert
		foreach( $aImages as $aImage ) {
			#--- check if exists in target database (compare img_name)
			if( isset($targetImages[$aImage["img_name"]]) ) {
				#--- delete only if overwrite is enabled
				if ($this->mOverwrite === true) {
					$dbTarget->delete( $this->targetTable("image"), array("img_name" => $aImage["img_name"]), __METHOD__ );
					$dbTarget->insert( $this->targetTable("image"), $aImage, __METHOD__ );
					$this->log(sprintf("image %s moved to target database", $aImage["img_name"]));
				} else {
					$this->log(sprintf("image %s not moved to target database", $aImage["img_name"]));
				}
			} else {
				$dbTarget->insert( $this->targetTable("image"), $aImage, __METHOD__ );
				$this->log(sprintf("image %s moved to target database", $aImage["img_name"]));
			}
		}
		$dbTarget->commit();

		$this->log( "moved images to target database" );
		wfProfileOut( __METHOD__ );
	}

	/**
	 * @method log
	 * @access private
	 *
	 * @param string $info - info we want to log in internal logger
	 *
	 * @return nothing
	 */
	private function log( $info ) {
		$this->mInternalLogger[] = array(
			"timestamp" => wfTimestampNow(),
			"info" => $info
		);
		$info = sprintf( "%s: %F", $info, wfTime() - $this->mCurrTime );
		Wikia::log( __METHOD__, "log", $info );
		$this->mCurrTime = wfTime();
	}

	/**
	 * @method getLog
	 * @access public
	 *
	 * @param $wantarray bolean defaul false - return array or string
	 *
	 * @return string|array with log or empty if there is no any
	 */
	public function getLog( $wantarray = false ) {
		if (is_array($this->mInternalLogger)) {

			$sReturn = "";
			if ( empty( $wantarray ) ) {
				foreach ( $this->mInternalLogger as $line ) {
					$sReturn .= sprintf("%s: %s\n", $line["timestamp"], $line["info"]);
				}
				return $sReturn;
			}
			else {
				return $this->mInternalLogger;
			}
		}
		return null;
	}

	/**
	 * @method getImagePaths
	 * @access private
	 *
	 * @param $fname string - name of image in source database
	 * @param $rename boolean - check if we should rename image
	 *
	 * @return array with both source and target paths
	 */
	private function getImagePaths( $fname, $rename = false ) {
		if ( $this->mDataLoaded === false ) {
			wfDebug( "wikimover: data is not loaded yet.", true );
			return null;
		}

		$aRetVal = array();

		$hash = md5( $fname );
		$sSourceImage = '/' . $hash{0} . '/' . substr( $hash, 0, 2 ) . '/' . $fname;

		if ( $rename === false ) {
			$sTargetImage = $sSourceImage;
		}
		else {
			$hash = md5( $this->mSourceMetaSpace."_".$fname );
			$sTargetImage = '/' . $hash{0} . '/' . substr( $hash, 0, 2 ) . '/' . $this->mSourceMetaSpace."_".$fname;
		}

		$aRetVal[ "source" ] = $this->mSourceUploadDirectory. $sSourceImage;
		$aRetVal[ "target" ] = $this->mTargetUploadDirectory. $sTargetImage;

		$this->log("{$aRetVal[ "source" ]} copied to {$aRetVal[ "target" ]}" );
		return $aRetVal;
	}

	/**
	 * pageName
	 *
	 * make pageName from namespace and title
	 *
	 * @access private
	 * @author eloy@wikia
	 *
	 * @param $namespace integer - number of namespace
	 * @param $title string - title for page
	 *
	 * @return string with new pagename
	 */
	private function pageName( $namespace, $title ) {
		global $wgCanonicalNamespaceNames;

		if ( empty($namespace )) {
			return $title;
		}
		if ( !isset($wgCanonicalNamespaceNames[$namespace]) ){
			return sprintf( "%s:%s", $namespace, $title );
		}
		return sprintf( "%s:%s", $wgCanonicalNamespaceNames[$namespace], $title );
	}

	/**
	 * sourceTable
	 *
	 * create table name with source database name
	 *
	 * @access private
	 * @author eloy@wikia
	 *
	 * @param $table string - table name
	 *
	 * @return string with new table name
	 */
	private function sourceTable( $table ) {
		return !empty( $this->mSourceName ) ?
			"`$this->mSourceName`.`$table`" : "`$table`";
	}

	/**
	 * targetTable
	 *
	 * create table name with source database name
	 *
	 * @access private
	 * @author eloy@wikia
	 *
	 * @param $table string - table name
	 *
	 * @return string with new table name
	 */
	private function targetTable( $table ) {
		return !empty( $this->mTargetName ) ?
			"`$this->mTargetName`.`$table`" : "`$table`";
	}
}
