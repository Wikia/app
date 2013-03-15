<?php

/**
 * @package MediaWiki
 * @author Moli for Wikia.com
 * @copyright (C) 2010, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 * @version: whatever goes here
 */

$wgHooks['ArticleSaveComplete'][] = "ScribeProducer::saveComplete";
$wgHooks['NewRevisionFromEditComplete'][] = "ScribeProducer::saveRevisionComplete";
$wgHooks['ArticleDeleteComplete'][] = "ScribeProducer::deleteComplete";
#$wgHooks['ArticleRevisionUndeleted'][] = "ScribeProducer::revisionUndeleted";
$wgHooks['ArticleUndelete'][] = "ScribeProducer::articleUndelete";
# move page
$wgHooks['TitleMoveComplete'][] = "ScribeProducer::moveComplete";

class ScribeProducer {
	private
		$mCityId,
		$mPageId,
		$mLogId,
		$mRevId,
		$mKey,
		$mServerName,
		$mArchive;

	const
		EDIT_CATEGORY 		= 'log_edit',
		CREATEPAGE_CATEGORY	= 'log_create',
		UNDELETE_CATEGORY	= 'log_undelete',
		DELETE_CATEGORY		= 'log_delete',
		REINDEX_CATEGORY	= 'log_reindex';

	const
		EDIT_CATEGORY_INT 		= 1,
		CREATEPAGE_CATEGORY_INT	= 2,
		DELETE_CATEGORY_INT		= 3,
		UNDELETE_CATEGORY_INT	= 4,
		REINDEX_CATEGORY_INT	= 5;

	/**
	 * constructor
	 *
	 * @author Piotr Molski (MoLi)
	 */
	function __construct( $key, $page_id, $rev_id = 0, $log_id = 0, $archive = 0 ) {
		global $wgCityId, $wgServer;

		switch ( $key ) {
			case 'edit' 		: $this->mKey = self::EDIT_CATEGORY; break;
			case 'create' 		: $this->mKey = self::CREATEPAGE_CATEGORY; break;
			case 'delete' 		: $this->mKey = self::DELETE_CATEGORY; break;
			case 'undelete'		: $this->mKey = self::UNDELETE_CATEGORY; break;
			case 'reindex'		: $this->mKey = self::REINDEX_CATEGORY; break;
		}

		$this->mCityId		= $wgCityId;
		$this->mPageId		= $page_id;
		$this->mRevId 		= $rev_id;
		$this->mLogId		= $log_id;
		$this->mServerName 	= $wgServer;
		$this->mArchive		= $archive;
	}

	/**
	 * storeData -- push data frame to Stomp
	 *
	 * @param String $type
	 * @author Piotr Molski (MoLi)
	 * @access private
	 *
	 */
	private function send_log() {
		wfProfileIn( __METHOD__ );
		try {
			$data = json_encode( array(
					'cityId'		=> $this->mCityId,
					'pageId'		=> $this->mPageId,
					'revId'			=> $this->mRevId,
					'logId'			=> $this->mLogId,
					'serverName'	=> $this->mServerName,
					'archive'		=> $this->mArchive,
					'hostname'		=> wfHostname(),
					'beaconId'		=> wfGetBeaconId()
				)
			);
			WScribeClient::singleton( $this->mKey )->send( $data );
		}
		catch( TException $e ) {
			Wikia::log( __METHOD__, 'scribeClient exception', $e->getMessage() );
		}
		wfProfileOut( __METHOD__ );
	}

	/**
	 * saveComplete -- hook
	 *
	 * @static
	 * @access public
	 *
	 * @param WikiPage $oArticle,
	 * @param User $User
	 *
	 * @author Piotr Molski (MoLi)
	 * @return true
	 */
	static public function saveComplete( &$oArticle, &$oUser, $text, $summary, $minor, $undef1, $undef2, &$flags, Revision $oRevision, &$status, $baseRevId ) {
		global $wgCityId;
		wfProfileIn( __METHOD__ );

		$revId = $pageId = 0;
		if ( ( is_object($oArticle) ) && ( $oUser instanceof User ) ) {

			# revision
			if ( $oRevision instanceof Revision ) {
				$revId = $oRevision->getId();
				$pageId = $oRevision->getPage();
			}

			if ( empty($revId) ) {
				$revId = $oArticle->getTitle()->getLatestRevID(Title::GAID_FOR_UPDATE);
			}

			# article
			if ( empty($pageId) || $pageId < 0 ) {
				$pageId = $oArticle->getID();
			}

			if ( $revId > 0 && $pageId > 0 ) {
				$key = ( isset($status->value['new']) && $status->value['new'] == 1 ) ? 'create' : 'edit';
				$oScribeProducer = new ScribeProducer( $key, $pageId, $revId, 0, (!empty($undef1)) ? 1 : 0 );
				if ( is_object( $oScribeProducer ) ) {
					$oScribeProducer->send_log();
				}
			} else {
				Wikia::log( __METHOD__, "error", "Cannot send log via scribe ($wgCityId): revision not found for page: $pageId" );
			}
		} else {
			$isArticle = is_object($oArticle);
			$isUser = is_object($oUser);
			Wikia::log( __METHOD__, "error", "Cannot send log via scribe ($wgCityId): invalid user: $isUser, invalid article: $isArticle" );
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * saveRevisionComplete -- hook
	 *
	 * @static
	 * @access public
	 *
	 * @param WikiPage $oArticle,
	 * @param Revision $oRevision,
	 * @param Integer $latestRevId
	 * @param User $oUser
	 *
	 * @author Piotr Molski (MoLi)
	 * @return true
	 */
	static public function saveRevisionComplete( $oArticle, $oRevision, $latestRevId, $oUser ) {
		global $wgCityId;
		wfProfileIn( __METHOD__ );

		if ( ( is_object($oArticle) ) && ( $oUser instanceof User ) ) {
			$revId = $pageId = 0;
			# revision
			if ( $oRevision instanceof Revision ) {
				$revId = $oRevision->getId();
				$pageId = $oRevision->getPage();
			}

			if ( empty($revId) && !empty($latestRevId) ) {
				$revId = $latestRevId;
			}

			# article
			if ( empty($pageId) || $pageId < 0 ) {
				$pageId = $oArticle->getID();
			}

			if ( $revId > 0 && $pageId > 0 ) {
				$key = 'edit';
				$oScribeProducer = new ScribeProducer( $key, $pageId, $revId, 0, 0 );
				if ( is_object( $oScribeProducer ) ) {
					$oScribeProducer->send_log();
				}
			} else {
				Wikia::log( __METHOD__, "error", "Cannot send log via scribe ($wgCityId): revision not found for page: $pageId" );
			}
		} else {
			$isArticle = is_object($oArticle);
			$isUser = is_object($oUser);
			Wikia::log( __METHOD__, "error", "Cannot send log via scribe ($wgCityId): invalid user: $isUser, invalid article: $isArticle" );
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * deleteComplete -- hook
	 *
	 * @static
	 * @access public
	 *
	 * @param WikiPage $oArticle,
	 * @param User $oUser,
	 * @param String $reason,
	 * @param String $articleId,
	 *
	 * @author Piotr Molski (MoLi)
	 * @return true
	 */
	static public function deleteComplete( &$oArticle, &$oUser, $reason, $articleId ) {
		global $wgCityId;
		wfProfileIn( __METHOD__ );

		$use_api = 0;
		if ( ( is_object($oArticle) ) && ( $oUser instanceof User ) ) {
			$pageId = ( !empty($articleId) ) ? $articleId : $oArticle->getID();
			$logid = 0;
			if ( $pageId > 0 ) {
				if ( $use_api == 1 ) {
					$oTitle = $oArticle->getTitle();
					$pageName = Title::makeName($oTitle->getNamespace(), $oTitle->getDBkey());
					$oFauxRequest = new FauxRequest(array(
						'action' 	=> 'query',
						'list' 		=> 'logevents',
						'letype' 	=> 'delete',
						'letitle'	=> $pageName,
						'lelimit'	=> 1
					));
					$oApi = new ApiMain($oFauxRequest);
					try {
						#---
						$oApi->execute();
						$aResult = $oApi->GetResultData();
						if ( isset( $aResult['query']['logevents'] ) && !empty( $aResult['query']['logevents'] ) ) {
							list ($row) = $aResult['query']['logevents'];
							if ( isset($row['logid']) ) {
								$logid = $row['logid'];
							}
						}
					}
					catch (Exception $e) {
						Wikia::log( __METHOD__, 'cannot fetch data from logging table via API request', $e->getMessage() );
					};
				} else {
					$table = 'recentchanges';
					$oTitle = $oArticle->getTitle();
					$what = array('rc_logid');
					$cond = array(
						'rc_title'		=> $oTitle->getDBkey(),
						'rc_namespace'	=> $oTitle->getNamespace(),
						'rc_log_action'	=> 'delete',
						'rc_user' 		=> $oUser->getID()
					);
					$options = array(
						'ORDER BY' => 'rc_id DESC'
					);

					$dbr = wfGetDB( DB_MASTER );
					$oRow = $dbr->selectRow( $table, $what, $cond, __METHOD__, $options );
					if ( $oRow ) {
						$logid = $oRow->rc_logid;
					}
				}

				if ( $logid > 0 ) {
					#---
					$oScribeProducer = new ScribeProducer( 'delete', $pageId, 0, $logid, 0 );
					if ( is_object( $oScribeProducer ) ) {
						$oScribeProducer->send_log();
					}
				} else {
					$title = $oArticle->getTitle()->getText();
					Wikia::log( __METHOD__, "error", "Cannot send log via scribe ($wgCityId): log id not found: $title" );
				}
			} else {
				$title = $oArticle->getTitle()->getText();
				Wikia::log( __METHOD__, "error", "Cannot send log via scribe ($wgCityId): page ID is empty: $title" );
			}
		} else {
			$isArticle = is_object($oArticle);
			$isUser = is_object($oUser);
			Wikia::log( __METHOD__, "error", "Cannot send log via scribe ($wgCityId): invalid user: $isUser, invalid article: $isArticle" );
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * revisionUndeleted -- hook
	 *
	 * @static
	 * @access public
	 *
	 * @param Title $oTitle,
	 * @param Revision $oRevision,
	 *
	 * @author Piotr Molski (MoLi)
	 * @return true
	 */
	static public function revisionUndeleted( &$oTitle, $oRevision, $archivePageId ) {
		global $wgCityId;
		wfProfileIn( __METHOD__ );
		if ( ( $oTitle instanceof Title ) && ( $oRevision instanceof Revision ) ) {
			$pageId = $oRevision->getPage();
			$revId = $oRevision->getId();
			if ( $revId > 0 && $pageId > 0 ) {
				$oScribeProducer = new ScribeProducer( 'edit', $pageId, $revId, 0, 0 );
				if ( is_object( $oScribeProducer ) ) {
					$oScribeProducer->send_log();
				}
			} else {
				$title = $oTitle->getText();
				Wikia::log( __METHOD__, "error", "Cannot send log via scribe ($wgCityId) for title: $title, page Id: $pageId, rev Id: $revId" );
			}
		} else {
			$isTitle = is_object($oTitle);
			$isRevision = is_object($oRevision);
			Wikia::log( __METHOD__, "error", "Cannot send log via scribe ($wgCityId): invalid title: $isTitle, invalid revision: $isRevision" );
		}
		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * articleUndelete -- hook
	 *
	 * @static
	 * @access public
	 *
	 * @param Title $oTitle,
	 *
	 * @author Piotr Molski (MoLi)
	 * @return true
	 */
	static public function articleUndelete( &$oTitle, $is_new = false ) {
		global $wgCityId;
		wfProfileIn( __METHOD__ );
		if ( $oTitle instanceof Title ) {
			$pageId = 0;
			$oArticle = new Article( $oTitle, 0 );

			if ( is_object($oArticle) ) {
				$pageId = $oArticle->getID();
			}

			if ( empty($pageId) || $pageId < 0 ) {
				$pageId = $oTitle->getArticleID( Title::GAID_FOR_UPDATE );
			}

			$revId = $oTitle->getLatestRevID(Title::GAID_FOR_UPDATE);
			if ( $revId > 0 && $pageId > 0 ) {
				$oScribeProducer = new ScribeProducer( 'undelete', $pageId, $revId );
				if ( is_object( $oScribeProducer ) ) {
					$oScribeProducer->send_log();
				}
			} else {
				$title = $oTitle->getText();
				Wikia::log( __METHOD__, "error", "Cannot send log via scribe ($wgCityId): invalid revision or page Id: $title, page Id: $pageId, rev Id: $revId" );
			}
		} else {
			$isTitle = is_object($oTitle);
			Wikia::log( __METHOD__, "error", "Cannot send log via scribe ($wgCityId): invalid title: $isTitle" );
		}
		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * moveComplete -- hook
	 *
	 * @static
	 * @access public
	 *
	 * @param Title $oOldTitle,
	 * @param Title $oNewTitle,
	 * @param User $oUser,
	 * @param Integer $pageId,
	 * @param Integer $redirId,
	 *
	 * @author Piotr Molski (MoLi)
	 * @return true
	 */
	static public function moveComplete( &$oOldTitle, &$oNewTitle, &$oUser, $pageId, $redirId = 0 ) {
		global $wgCityId;
		wfProfileIn( __METHOD__ );

		if ( $oNewTitle instanceof Title ) {
			$oRevision = Revision::newFromTitle( $oNewTitle );
			if ( $oRevision instanceof Revision ) {
				$revId = $oRevision->getId();
				if ( empty($pageId) ) {
					$pageId = $oRevision->getPage();
				}
				if ( $revId > 0 && $pageId > 0 ) {
					$oScribeProducer = new ScribeProducer( 'edit', $pageId, $revId );
					if ( is_object( $oScribeProducer ) ) {
						$oScribeProducer->send_log();
					}
				} else {
					Wikia::log( __METHOD__, "error", "Cannot send log via scribe ($wgCityId): empty revision or page id: $revId, $pageId" );
				}
			} else {
				Wikia::log( __METHOD__, "error", "Cannot send log via scribe ($wgCityId): invalid revision for new title" );
			}
		} else {
			$isTitle = is_object($oNewTitle);
			Wikia::log( __METHOD__, "error", "Cannot send log via scribe ($wgCityId): invalid new title: $isTitle" );
		}

		if ( $redirId > 0 ) {
			# old title as a #Redirect
			if ( $oOldTitle instanceof Title ) {
				$oRevision = Revision::newFromTitle( $oOldTitle );

				if ( !is_object($oRevision) ) {
					$db = wfGetDB( DB_MASTER );
					$oRevision = Revision::loadFromPageId( $db, $redirId );
				}

				if ( $oRevision instanceof Revision ) {
					$revId = $oRevision->getId();
					$newPageId = $oRevision->getPage();
					if ( empty($newPageId) || $newPageId < 0 ) {
						$newPageId = $oOldTitle->getArticleId();
					}
					if ( $revId > 0 && $newPageId > 0 ) {
						$oScribeProducer = new ScribeProducer( 'edit', $newPageId, $revId );
						if ( is_object( $oScribeProducer ) ) {
							$oScribeProducer->send_log();
						}
					} else {
						Wikia::log( __METHOD__, "error", "Cannot send log via scribe ($wgCityId): empty revision or new page id: $revId, $newPageId" );
					}
				} else {
					Wikia::log( __METHOD__, "error", "Cannot send log via scribe ($wgCityId): invalid revision for old title: $redirId" );
				}
			} else {
				$isTitle = is_object($oOldTitle);
				Wikia::log( __METHOD__, "error", "Cannot send log via scribe ($wgCityId): invalid old title: $isTitle" );
			}
		}
		wfProfileOut( __METHOD__ );
		return true;
	}
	
	/**
	 * @see Wikia\Search\Indexer::reindexWiki
	 */
	public function reindexPage()
	{
		wfProfileIn( __METHOD__ );
		if ( $this->mKey !== self::REINDEX_CATEGORY ) {
			$this->send_log();
		} else {
			throw new Exception( 'This method should only be called by ScribeProducer instances keyed for reindexing' );
		}
		wfProfileOut( __METHOD__ );
	}
}

