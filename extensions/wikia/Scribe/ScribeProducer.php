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
		$mServerName;

	const 
		EDIT_CATEGORY 		= 'edit_log',
		CREATEPAGE_CATEGORY	= 'create_log',
		UNDELETE_CATEGORY	= 'undelete_log',
		DELETE_CATEGORY		= 'delete_log';

	/**
	 * constructor
	 *
	 * @author Piotr Molski (MoLi)
	 */
	function __construct( $page_id, $rev_id = 0, $log_id = 0 ) {
		global $wgCityId, $wgServer, $wgUser;

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
	private function send_log( $category = 'edit' ) {
		global $wgCityId;
		wfProfileIn( __METHOD__ );
		try {
			$catLog = '';
			switch ( $category ) {
				case 'edit' 		: $catLog = self::EDIT_CATEGORY; break;
				case 'create' 		: $catLog = self::CREATEPAGE_CATEGORY; break;
				case 'delete' 		: $catLog = self::DELETE_CATEGORY; break;
				case 'undelete'		: $catLog = self::UNDELETE_CATEGORY; break;
			}

			$data = Wikia::json_encode( array(
					'cityId'		=> $this->mCityId,
					'pageId'		=> $this->mPageId,
					'revId'			=> $this->mRevId,
					'logId'			=> $this->mLogId,
					'serverName'	=> $this->mServerName,
				) 
			);
			WScribeClient::singleton( $catLog )->send( $data );
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
				$oScribeProducer = new ScribeProducer( $pageId, $revid );
				if ( is_object( $oScribeProducer ) ) {
					$is_new = ( isset($status->value['new']) ) ? 'create' : 'edit';
					$oScribeProducer->send_log( $is_new );
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

		if ( ( $oArticle instanceof Article ) && ( $oUser instanceof User ) ) {
			$pageId = ( !empty($articleId) ) ? $articleId : $oArticle->getID();
			if ( $pageId > 0 ) {
				#action=query&list=logevents&letype=delete&letitle=TestDel2
				$oFauxRequest = new FauxRequest(array(
					'action' 	=> 'query',
					'list' 		=> 'logevents',
					'letype' 	=> 'delete',
					'letitle'	=> $oArticle->mTitle->getPrefixedText(),
					'lelimit'	=> 1
				));
				$logid = 0;
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

				#---
				$oScribeProducer = new ScribeProducer( $pageId, 0, $logid );
				if ( is_object( $oScribeProducer ) ) {
					$oScribeProducer->send_log( 'delete' );
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
				$oScribeProducer = new ScribeProducer( $pageId, $revId );
				if ( is_object( $oScribeProducer ) ) {
					$oScribeProducer->send_log( 'edit' );
				}
			}
		}
		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * articleUndeleted -- hook 
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
	static public function articleUndeleted( &$oTitle, $is_new = false ) {
		wfProfileIn( __METHOD__ );
		if ( $oTitle instanceof Title ) {
			$oRevision = Revision::newFromTitle( $oTitle );
			if ( $oRevision instanceof Revision ) {
				$pageId = $oRevision->getPage();
				$revId = $oRevision->getId();
				if ( $revId > 0 && $pageId > 0 ) {
					$oScribeProducer = new ScribeProducer( $pageId, $revId );
					if ( is_object( $oScribeProducer ) ) {
						$oScribeProducer->send_log( 'undelete' );
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
					$oScribeProducer = new ScribeProducer( $pageId, $revId );
					if ( is_object( $oScribeProducer ) ) {
						$oScribeProducer->send_log( 'edit' );
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
						$oScribeProducer = new ScribeProducer( $newPageId, $revId );
						if ( is_object( $oScribeProducer ) ) {
							$oScribeProducer->send_log( 'edit' );
						}
					}
				}
			}
		}
		wfProfileOut( __METHOD__ );
		return true;
	}
}

