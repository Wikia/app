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
$wgHooks['ArticleRevisionUndeleted'][] = "ScribeProducer::revisionUndeleted";
# move page
$wgHooks['TitleMoveComplete'][] = "ScribeProducer::moveComplete"; 
# api hooks
$wgHooks['APIQueryRevisionsTokens'][] = "ScribeProducer::tokenFunction";

class ScribeProducer {
	private
		$mCityId,
		$mPageId,
		$mRevId,
		$mUserIP,
		$mServerName;

	const 
		EDIT_CATEGORY 		= 'edit_log',
		DELETE_CATEGORY		= 'delete_log',
		UNDELETE_CATEGORY 	= 'undelete_log';

	/**
	 * constructor
	 *
	 * @author Piotr Molski (MoLi)
	 */
	function __construct( $page_id, $rev_id = 0 ) {
		global $wgCityId, $wgServer, $wgUser;

		$this->mCityId		= $wgCityId;
		$this->mPageId		= $page_id;
		$this->mRevId 		= $rev_id;
		$this->mServerName 	= $wgServer;
		$this->mUserIp 		= wfGetIP();
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
				case 'delete' 		: $catLog = self::DELETE_CATEGORY; break;
				case 'undelete' 	: $catLog = self::UNDELETE_CATEGORY; break;
			}

			$data = Wikia::json_encode( array(
					'cityId'		=> $this->mCityId,
					'pageId'		=> $this->mPageId,
					'revId'			=> $this->mRevId,
					'ip'			=> $this->mUserIP,
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
		
		error_log ("saveComplete \n", 3, "/tmp/moli.log");
		
		if ( ( $oArticle instanceof Article ) && ( $oUser instanceof User ) ) {
			$revid = ( $oRevision instanceof Revision ) ? $oRevision->getId() : 0;
			$pageId = ( $oArticle instanceof Article ) ? $oArticle->getID() : 0;
			if ( $revid > 0 && $pageId > 0 ) { 
				$oScribeProducer = new ScribeProducer( $pageId, $revid );
				if ( is_object( $oScribeProducer ) ) {
					$oScribeProducer->send_log( 'edit' );
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
	static public function deleteComplete( &$oAarticle, &$oUser, $reason, $articleId ) {
		wfProfileIn( __METHOD__ );

		if ( ( $oArticle instanceof Article ) && ( $oUser instanceof User ) ) {
			if ( $oAarticle instanceof Article ) {
				$pageId = ( !empty($articleId) ) ? $oAarticle->getID() : $articleId;
				if ( $pageId > 0 ) {
					$oScribeProducer = new ScribeProducer( $pageId );
					if ( is_object( $oScribeProducer ) ) {
						$oScribeProducer->send_log( 'delete' );
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
				$oScribeProducer = new ScribeProducer( $pageId, $revId );
				if ( is_object( $oScribeProducer ) ) {
					$oScribeProducer->send_log( 'undelete' );
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
		
/*		error_log ( "oOldTitle = " . print_r($oOldTitle, true), 3, "/tmp/moli.log" );
		error_log ( "oNewTitle = " . print_r($oNewTitle, true), 3, "/tmp/moli.log" );
		error_log ( "oUser = " . print_r($oUser, true), 3, "/tmp/moli.log" );
		error_log ( "page_id = " . print_r($pageId, true), 3, "/tmp/moli.log" );
		error_log ( "redir_id = " . print_r($redirId, true), 3, "/tmp/moli.log" );*/
		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * tokenFunction -- hook 
	 * Add tokens to tokenFunctions in ApiQueryRevisions.php
	 * To see all additional information call api method with
	 * additional parameter:
	 * rvtoken=userid|userisbot|redirect|content|imagelinks|videolinks|words
	 * 
	 *
	 * @static
	 * @access public
	 *
	 * @param Article $Article,
	 * @param Title $Title,
	 * @param Revision $revision,
	 *
	 * @author Piotr Molski (MoLi)
	 * @return true
	 */
	static public function tokenFunction( &$tokenFunctions ) {
		$tokenFunctions['userid'] = array('ScribeProducer', 'apiToken_userId');
		$tokenFunctions['userisbot'] = array('ScribeProducer', 'apiToken_userIsBot');
		$tokenFunctions['redirect'] = array('ScribeProducer', 'apiToken_revisionIsRedirect');
		$tokenFunctions['content'] = array('ScribeProducer', 'apiToken_revisionIsContent');
		$tokenFunctions['links'] = array('ScribeProducer', 'apiToken_links');
		$tokenFunctions['words'] = array('ScribeProducer', 'apiToken_words');
		return true;
	}
	
	/**
	 * apiToken_userId
	 * Token to obtain user ID (for each revision)
	 * See information in ApiQueryRevisions.php
	 * 
	 * rvtoken=userid should call func($pageid, $oTitle, $oRevision)
	 * and should return token or false
	 * 
	 * @static
	 * @access public
	 *
	 * @param Article $Article,
	 * @param Title $Title,
	 * @param Revision $revision,
	 *
	 * @author Piotr Molski (MoLi)
	 * @return Integer
	 */
	static public function apiToken_userId( $articleId = 0, $oTitle = false, $oRevision = false ) { 
		$user_id = 0;
		if ( $articleId > 0 && $oRevision instanceof Revision ) {
			$user_id = $oRevision->getUser();
		}
		return (int) $user_id;
	}

	/**
	 * apiToken_userIsBot
	 * Token to obtain if user is bot (for each revision)
	 * See information in ApiQueryRevisions.php
	 * 
	 * rvtoken=userid should call func($pageid, $oTitle, $oRevision)
	 * and should return token or false
	 * 
	 * @static
	 * @access public
	 *
	 * @param Article $Article,
	 * @param Title $Title,
	 * @param Revision $revision,
	 *
	 * @author Piotr Molski (MoLi)
	 * @return Integer
	 */
	static public function apiToken_userIsBot( $articleId = 0, $oTitle = false, $oRevision = false ) { 
		$user_is_bot = 0;
		if ( $articleId > 0 && $oRevision instanceof Revision ) {
			$user_text = $oRevision->getUserText();
			$oUser = User::newFromName($user_text);
			if ( $oUser instanceof User ) {
				$user_is_bot = $oUser->isBot();
			}
		}
		return (int) $user_is_bot;
	}

	/**
	 * apiToken_revisionIsRedirect
	 * See information in ApiQueryRevisions.php
	 * 
	 * rvtoken=redirect should call func($pageid, $oTitle, $oRevision)
	 * and should return token or false
	 * 
	 * @static
	 * @access public
	 *
	 * @param Article $Article,
	 * @param Title $Title,
	 * @param Revision $revision,
	 *
	 * @author Piotr Molski (MoLi)
	 * @return integer
	 */
	static public function apiToken_revisionIsRedirect( $articleId = 0, $oTitle = false, $oRevision = false ) { 
		$rev_is_redirect = 0;
		if ( $articleId > 0 && $oRevision instanceof Revision ) {
			$content = $oRevision->revText();
			$titleObj = Title::newFromRedirect( $content );
			$rev_is_redirect = is_object($titleObj) ;
		}
		return (int) $rev_is_redirect;
	}

	/**
	 * apiToken_revisionIsContent
	 * See information in ApiQueryRevisions.php
	 * 
	 * rvtoken=content should call func($pageid, $oTitle, $oRevision)
	 * and should return token or false
	 * 
	 * @static
	 * @access public
	 *
	 * @param Article $Article,
	 * @param Title $Title,
	 * @param Revision $revision,
	 *
	 * @author Piotr Molski (MoLi)
	 * @return Integer
	 */
	static public function apiToken_revisionIsContent( $articleId = 0, $oTitle = false, $oRevision = false ) { 
		global $wgEnableBlogArticles;
		$is_content_ns = 0;
		if ( $articleId > 0 && $oTitle instanceof title ) {
			$is_content_ns = $oTitle->isContentPage();
			if ( empty($is_content_ns) && $wgEnableBlogArticles ) { 
				$is_content_ns = (!in_array($oTitle->getNamespace(), array(NS_BLOG_ARTICLE, NS_BLOG_ARTICLE_TALK, NS_BLOG_LISTING, NS_BLOG_LISTING_TALK)));
			}
		}
		return (int) $is_content_ns;
	}

	/**
	 * apiToken_links
	 * See information in ApiQueryRevisions.php
	 * 
	 * rvtoken=links should call func($pageid, $oTitle, $oRevision)
	 * and should return token or false
	 * 
	 * @static
	 * @access public
	 *
	 * @param Article $Article,
	 * @param Title $Title,
	 * @param Revision $revision,
	 *
	 * @author Piotr Molski (MoLi)
	 * @return Integer
	 */
	static public function apiToken_links( $articleId = 0, $oTitle = false, $oRevision = false ) { 
		$links = array( 'image' => 0, 'video' => 0 );
		if ( $articleId > 0 && $oTitle instanceof Title && $oRevision instanceof Revision ) {
			$oArticle = Article::newFromId($oTitle->getArticleID());
			if ( $oArticle instanceof Article ) {
				$content = $oRevision->revText();
				$revid = $oRevision->getId();
				$editInfo = $oArticle->prepareTextForEdit( $content, $revid );
				$images = $editInfo->output->getImages();
				if ( !empty($images) ) {
					foreach ($images as $iname => $dummy) {
						if ( substr($iname, 0, 1) == ':' ) {
							$links['video']++;							
						} else {
							$links['image']++;
						}
					}
				}
			}
		}
		return $links;
	}

	/**
	 * apiToken_videoLinks
	 * See information in ApiQueryRevisions.php
	 * 
	 * rvtoken=videolinks should call func($pageid, $oTitle, $oRevision)
	 * and should return token or false
	 * 
	 * @static
	 * @access public
	 *
	 * @param Article $Article,
	 * @param Title $Title,
	 * @param Revision $revision,
	 *
	 * @author Piotr Molski (MoLi)
	 * @return Integer
	 */
	static public function apiToken_videoLinks( $articleId = 0, $oTitle = false, $oRevision = false ) { 
	}

	/**
	 * apiToken_words
	 * See information in ApiQueryRevisions.php
	 * 
	 * rvtoken=words should call func($pageid, $oTitle, $oRevision)
	 * and should return token or false
	 * 
	 * @static
	 * @access public
	 *
	 * @param Article $Article,
	 * @param Title $Title,
	 * @param Revision $revision,
	 *
	 * @author Piotr Molski (MoLi)
	 * @return Integer
	 */
	static public function apiToken_words( $articleId = 0, $oTitle = false, $oRevision = false ) { 
		$words = 0;
		if ( $articleId > 0 && $oRevision instanceof Revision ) {
			$content = $oRevision->revText();
			$words = str_word_count($words);
		}
		return (int) $words;
	}

}

