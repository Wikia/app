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
$wgHooks['UndeleteComplete'][] = "ScribeProducer::undeleteComplete";

class ScribeProducer {
	private
		$mCityId,
		$mPageId,
		$mRevId,
		$mUserId,
		$mPageNS,
		$mPageIsContent,
		$mPageIsRedirect,
		$mUserIP,
		$mRevTimestamp,
		$mImageLinks,
		$mVideoLinks,
		$mTotalWords,
		$mWikiLangId;

	const 
		EDIT_CATEGORY 		= 'edit_log',
		DELETE_CATEGORY		= 'delete_log',
		UNDELETE_CATEGORY 	= 'undelete_log';

	/**
	 * constructor
	 *
	 * @author Piotr Molski (MoLi)
	 */
	function __construct($oArticle, $oUser = false, $rev_id = 0, $text = '') {
		global 
			$wgCityId, 
			$wgLanguageCode, 
			$wgDBname, 
			$wgSitename, 
			$wgServer, 
			$wgEnableBlogArticles,
			$wgUser;

		/* title */
		$oTitle = $oArticle->mTitle; 

		/* Wikia Id */
		$this->mCityId = $wgCityId;

		/* article ID */
		if ( empty( $page_id ) && ( !empty( $oTitle ) ) ) {
			if ( $wgEnableBlogArticles ) {
				if( ( defined( "NS_BLOG_ARTICLE_TALK" ) ) && ( NS_BLOG_ARTICLE_TALK == $oTitle->getNamespace()) ) {
					$oComment = BlogComment::newFromId( $oTitle->getArticleId() );						
					$oTitle = $oComment->getBlogTitle();					
				}					
			}
			$this->mPageId = $oTitle->getArticleId();				
		} elseif ( !empty( $page_id ) ) {
			$this->mPageId = $page_id;
			if ( empty( $oTitle ) ) {
				$oTitle = Title::newFromID( $page_id );
			}
		} else {
			Wikia::log( __METHOD__, 'scribe_exception', 'Empty page_id and title' );
			return null;
		}

		/* revision ID */
		$this->mRevId = ( empty($revid) ) ? $oTitle->getLatestRevID(GAID_FOR_UPDATE) : $revid;

		/* page namespace */
		$this->mPageNS = $oTitle->getNamespace();
		
		/* is contentNamespace page ? */
		$this->mPageIsContent = $oTitle->isContentPage(); /* and blogs ? */
		
		/* is redirect */
		$this->mPageIsRedirect = $oTitle->isRedirect();
		
		/* timestamp */
		$this->mRevTimestamp = $oArticle->getTimestamp();

		/* user ID */
		if( $oUser === false ) {
			$this->mUserId = $oUser->getId();
		} else {
			$this->mUserId = $wgUser->getId();
		}
		
		/* ip */
		$this->mUserIP = wfGetIP();

		/* lang id */
		$this->mWikiLangId = WikiFactory::LangCodeToId($wgLanguageCode);
		
		/* number of words */
		if ( !empty($text) ) {
			$text = $oArticle->getContent();
		}
		$this->mTotalWords = str_word_count( $text );

		/* number of image links */
		$this->mImageLinks = 0;

		/* number of video links */
		$this->mVideoLinks = 0;
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
					'langId'		=> $this->mWikiLangId,
					'pageId'		=> $this->mPageId,
					'revId' 		=> $this->mRevId,
					'userId'		=> $this->mUserId,
					'pageNs'		=> $this->mPageNS,
					'isContent'		=> $this->mPageIsContent,
					'isRedirect'	=> $this->mPageIsRedirect,
					'ip'			=> $this->mUserIP,
					'revTimestamp'	=> $this->mRevTimestamp,
					'imageLinks'	=> $this->mImageLinks,
					'videoLinks'	=> $this->mVideoLinks,
					'totalWords'	=> $this->mTotalWords,
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
			$oScribeProducer = new ScribeProducer( $oArticle, $oUser, $revid, $text);
			if ( is_object( $oScribeProducer ) ) {
				$oScribeProducer->send_log( 'edit' );
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
			$oScribeProducer = new ScribeProducer( $oArticle, $oUser );
			if ( is_object( $oScribeProducer ) ) {
				$oScribeProducer->send_log( 'delete' );
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * undeleteComplete -- hook 
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
	static public function undeleteComplete( &$oTitle, $oUser, $reason ) {
		wfProfileIn( __METHOD__ );
		if ( ( $oTitle instanceof Title ) && ( $oUser instanceof User ) ) {
			$oArticle = Article::newFromTitle($oTitle);
			$oScribeProducer = new ScribeProducer( $oArticle, $oUser );
			if ( is_object( $oScribeProducer ) ) {
				$oScribeProducer->send_log( 'undelete' );
			}
		}
		wfProfileOut( __METHOD__ );
		return true;
	}
}

