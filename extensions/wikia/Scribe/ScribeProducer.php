<?php

/**
 * @package MediaWiki
 * @author Moli for Wikia.com
 * @copyright (C) 2010, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 * @version: whatever goes here
 */

$wgHooks['ArticleSaveComplete'][] = "ScribeProducer::saveComplete";
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
		$mServerName;

	const 
		EDIT_CATEGORY 		= 'log_edit',
		CREATEPAGE_CATEGORY	= 'log_create',
		UNDELETE_CATEGORY	= 'log_undelete',
		DELETE_CATEGORY		= 'log_delete';

	/**
	 * constructor
	 *
	 * @author Piotr Molski (MoLi)
	 */
	function __construct( $key, $page_id, $rev_id = 0, $log_id = 0 ) {
		global $wgCityId, $wgServer;

		switch ( $key ) {
			case 'edit' 		: $this->mKey = self::EDIT_CATEGORY; break;
			case 'create' 		: $this->mKey = self::CREATEPAGE_CATEGORY; break;
			case 'delete' 		: $this->mKey = self::DELETE_CATEGORY; break;
			case 'undelete'		: $this->mKey = self::UNDELETE_CATEGORY; break;
		}

		$this->mCityId		= $wgCityId;
		$this->mPageId		= $page_id;
		$this->mRevId 		= $rev_id;
		$this->mLogId		= $log_id;
		$this->mServerName 	= $wgServer;
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
			$data = Wikia::json_encode( array(
					'cityId'		=> $this->mCityId,
					'pageId'		=> $this->mPageId,
					'revId'			=> $this->mRevId,
					'logId'			=> $this->mLogId,
					'serverName'	=> $this->mServerName,
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
	 * @param Article $Article,
	 * @param User $User
	 *
	 * @author Piotr Molski (MoLi)
	 * @return true
	 */
	static public function saveComplete( &$oArticle, &$oUser, $text, $summary, $minor, $undef1, $undef2, &$flags, $oRevision, &$status, $baseRevId ) {
		wfProfileIn( __METHOD__ );
		
		if ( ( $oArticle instanceof Article ) && ( $oUser instanceof User ) ) {
			$revid = ( $oRevision instanceof Revision ) ? $oRevision->getId() : 0;
			$pageId = ( $oArticle instanceof Article ) ? $oArticle->getID() : 0;
			if ( $revid > 0 && $pageId > 0 ) { 
				$key = ( isset($status->value['new']) && $status->value['new'] == 1 ) ? 'create' : 'edit';
				$oScribeProducer = new ScribeProducer( $key, $pageId, $revid );
				if ( is_object( $oScribeProducer ) ) {
					$oScribeProducer->send_log();
				}
			}
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
	 * @param Article $Article,
	 * @param User $User,
	 * @param String $reason,
	 * @param String $articleId,
	 *
	 * @author Piotr Molski (MoLi)
	 * @return true
	 */
	static public function deleteComplete( &$oArticle, &$oUser, $reason, $articleId ) {
		wfProfileIn( __METHOD__ );

		$use_api = 0;
		if ( ( $oArticle instanceof Article ) && ( $oUser instanceof User ) ) {
			$pageId = ( !empty($articleId) ) ? $articleId : $oArticle->getID();
			$logid = 0;
			if ( $pageId > 0 ) {
				if ( $use_api == 1 ) {
					$pageName = Title::makeName($oArticle->mTitle->getNamespace, $oArticle->mTitle->getDBkey());
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
					$what = array('rc_logid');
					$cond = array(
						'rc_title'		=> $oArticle->mTitle->getDBkey(),
						'rc_namespace'	=> $oArticle->mTitle->getNamespace(),
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
					$oScribeProducer = new ScribeProducer( 'delete', $pageId, 0, $logid );
					if ( is_object( $oScribeProducer ) ) {
						$oScribeProducer->send_log();
					}
				}
			}
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
	 * @param Article $Article,
	 * @param User $User,
	 * @param String $reason,
	 *
	 * @author Piotr Molski (MoLi)
	 * @return true
	 */
	static public function revisionUndeleted( &$oTitle, $oRevision, $archivePageId ) {
		wfProfileIn( __METHOD__ );
		if ( ( $oTitle instanceof Title ) && ( $oRevision instanceof Revision ) ) {
			$pageId = $oRevision->getPage();
			$revId = $oRevision->getId();
			if ( $revId > 0 && $pageId > 0 ) {
				$oScribeProducer = new ScribeProducer( 'edit', $pageId, $revId );
				if ( is_object( $oScribeProducer ) ) {
					$oScribeProducer->send_log();
				}
			}
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
	 * @param Article $Article,
	 * @param User $User,
	 * @param String $reason,
	 *
	 * @author Piotr Molski (MoLi)
	 * @return true
	 */
	static public function articleUndelete( &$oTitle, $is_new = false ) {
		wfProfileIn( __METHOD__ );
		if ( $oTitle instanceof Title ) {
			$oArticle = new Article( $oTitle, 0 );
			if ( $oArticle instanceof Article ) {
				$pageId = $oArticle->getID();
				$revId = $oTitle->getLatestRevID(GAID_FOR_UPDATE);
				if ( $revId > 0 && $pageId > 0 ) {
					$oScribeProducer = new ScribeProducer( 'undelete', $pageId, $revId );
					if ( is_object( $oScribeProducer ) ) {
						$oScribeProducer->send_log();
					}
				}
			}
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
	 * @param Integer redirId,
	 *
	 * @author Piotr Molski (MoLi)
	 * @return true
	 */
	static public function moveComplete( &$oOldTitle, &$oNewTitle, &$oUser, $pageId, $redirId ) {
		wfProfileIn( __METHOD__ );

		if ( $oNewTitle instanceof Title ) {
			$oRevision = Revision::newFromTitle( $oNewTitle );
			if ( $oRevision instanceof Revision ) {
				$revId = $oRevision->getId();
				if ( $revId > 0 && $pageId > 0 ) {
					$oScribeProducer = new ScribeProducer( 'edit', $pageId, $revId );
					if ( is_object( $oScribeProducer ) ) {
						$oScribeProducer->send_log();
					}
				}
			}
		}
		
		if ( $redirId > 0 ) {
			# old title as a #Redirect 
			if ( $oOldTitle instanceof Title ) {
				$oRevision = Revision::newFromTitle( $oOldTitle );
				if ( $oRevision instanceof Revision ) {
					$revId = $oRevision->getId();
					$newPageId = $oOldTitle->getArticleId();
					if ( $revId > 0 && $newPageId > 0 ) {
						$oScribeProducer = new ScribeProducer( 'edit', $newPageId, $revId );
						if ( is_object( $oScribeProducer ) ) {
							$oScribeProducer->send_log();
						}
					}
				}
			}
		}
		wfProfileOut( __METHOD__ );
		return true;
	}
	
}

