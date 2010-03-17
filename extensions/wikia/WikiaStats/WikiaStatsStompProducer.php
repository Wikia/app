<?php

/**
 * @package MediaWiki
 * @author Bartlomiej Lapinski <bartek@wikia.com>, Tomasz Odrobny <tomek@wikia.com> for Wikia.com
 * @copyright (C) 2010, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 * @version: whatever goes here
 */

$wgHooks['ArticleSaveComplete'][] = "WikiaStatsStompProducer::saveComplete";
//$wgHooks['ArticleDeleteComplete'][] = "WikiaStatsStompProducer::deleteComplete";
//$wgHooks['UndeleteComplete'][] = "WikiaStatsStompProducer::undeleteComplete";

class WikiaStatsStompProducer {
	private
		$mCityId,
		$mCityTag,
		$mCityLang,
		$mPageId,
		$mPageName,
		$mPageURL,		
		$mEditorId,
		$mEventTimestamp,
		$mIsContentNs,
		$mPageNs,
		$mRevId,
		$mDBname,
		$mWikiname,
		$mWikiURL,
		$mUsername,
		$mUserGroups;

	/**
	 * constructor
	 *
	 * @author Bartek Lapinski
	 */
	function __construct( $cityId, $factoryTags, $pageId = null, $title = null, $user = null, $timestamp = null ) {
		global $wgLanguageCode, $wgEnableBlogArticles, $wgDBname, $wgSitename, $wgServer, $wgEnableBlogArticles;

		$this->mCityId = $cityId;
		$this->mCityTag = serialize( $factoryTags );
		$this->mCityLang = $wgLanguageCode;

		if( empty( $pageId ) ) {
			if( !empty( $title ) ) {
				// check if it is a blog comment, if so, then load all the data from "parent" blog article
				if ( $wgEnableBlogArticles ) {
					if( NS_BLOG_ARTICLE_TALK == $title->getNamespace() ) {
						$comment = BlogComment::newFromId( $title->getArticleId() );						
						$title = $comment->getBlogTitle();					
					}					
				}
				$this->mPageId = $title->getArticleId();				
			} else {
				$this->mPageId = $pageId;
				$title = Title::newFromID( $pageId );
			}
		}
		if( !empty( $user ) ) {
			$this->mEditorId = $user->getId();
			$this->mUsername = $user->getName();
			$groups = $user->getGroups();			
			$this->mUserGroups = implode(";", $groups) ;			
		} 

		if( empty( $Timestamp) ) {
			$this->mEventTimestamp = wfTimestampNow();
		} else {
			$this->mEventTimestamp = $Timestamp;
		}		
		if( !empty( $title ) ) {
			$this->mPageName = $title->getDBkey();
			$this->mPageURL = $title->getFullURL();
			$this->mPageNs = $title->getNamespace();
			$this->mIsContentNs =
				( $title->isContentPage() ) &&
				(
				 ($wgEnableBlogArticles) &&
				 (!in_array($this->mPageNs, array(NS_BLOG_ARTICLE, NS_BLOG_ARTICLE_TALK, NS_BLOG_LISTING, NS_BLOG_LISTING_TALK)))
				);
			$this->mRevId = $title->getLatestRevID();
		}

		$this->mDBname = $wgDBname;
		$this->mWikiname = $wgSitename;
		$this->mWikiURL = $wgServer;
	}

	/**
	 * storeData -- push data frame to Stomp
	 *
	 * @param String $type
	 * @author Bartek Lapinski 
	 * @access private
	 *
	 */
	private function storeData( $type ) {
		global $wgStompServer, $wgStompUser, $wgStompPassword, $wgCityId;
		wfProfileIn( __METHOD__ );
		try {
			$stomp = new Stomp( $wgStompServer );
			$stomp->connect( $wgStompUser, $wgStompPassword );
			$stomp->sync = false;
//			wfDebug( "Adding info to Stomp\n" );
			$key = 'wikia.article.' . $type . '.' . $wgCityId;
			$stomp->send( $key,
					Wikia::json_encode( array(
							'key'			=> $key,
							'cityId'		=> $this->mCityId,
							'cityTag'		=> $this->mCityTag,							
							'cityLang'		=> $this->mCityLang,
							'pageId'		=> $this->mPageId,
							'pageName'		=> $this->mPageName,
							'pageURL'		=> $this->mPageURL,
							'editorId'		=> $this->mEditorId,
							'eventTimestamp'	=> $this->mEventTimestamp,
							'isContentNs'		=> $this->mIsContentNs,	
							'pageNs'		=> $this->mPageNs,
							'revId'			=> $this->mRevId,
							'DBname'		=> $this->mDBname,
							'wikiname'		=> $this->mWikiname,
							'wikiURL'		=> $this->mWikiURL,
							'username'		=> $this->mUsername,
							'userGroups'		=> $this->mUserGroups,
							) ),
					array(
						'exchange' => 'amq.topic',
						'bytes_message' => 1,
						'routing_key' => $key
					)
				    );
			$stomp->disconnect();
		}
		catch( StompException $e ) {
			Wikia::log( __METHOD__, 'stomp_exception', $e->getMessage() );
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
	 * @author Bartek Lapinski 
	 * @return true
	 */
	static public function saveComplete(&$article, &$user ) {
		global $wgCityId, $wgWikiFactoryTags;
		wfProfileIn( __METHOD__ );
		if( empty( $wgWikiFactoryTags ) ) {
                	wfProfileOut( __METHOD__ );
			return true;			
		}

		$title = $article->mTitle; 

		if( ( !class_exists( 'BlogComment' ) && ( NS_BLOG_ARTICLE_TALK == $title->getNamespace() ) ) ) {
			// NY blogs, not Eloy's - cut them down, they would break the code...
                	wfProfileOut( __METHOD__ );
			return true;			
		}		

		if ( ( $article instanceof Article ) && ( $user instanceof User ) ) {
			$oEdits = new WikiaStatsStompProducer( $wgCityId, $wgWikiFactoryTags, null, $title, $user );
			$oEdits->storeData( 'edit' );
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
	 * @author Bartek Lapinski
	 * @return true
	 */
        static public function deleteComplete( &$article, &$user, $reason, $articleId ) {
		global $wgCityId;
                wfProfileIn( __METHOD__ );
		if ( ( $article instanceof Article ) && ( $user instanceof User ) ) {
			$title = $article->mTitle;
			$oEdits = new WikiaStatsStompProducer( $wgCityId, $articleId, $title, $user );
			$oEdits->storeData( 'delete' );
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
	 * @author Bartek Lapinski
	 * @return true
	 */
	static public function undeleteComplete( &$title, $user, $reason ) {
		global $wgCityId;
                wfProfileIn( __METHOD__ );
		if ( ( $title instanceof Title ) && ( $user instanceof User ) ) {
			$oEdits = new WikiaStatsStompProducer( $wgCityId, null, $title, $user );
			$oEdits->storeData( 'undelete' );
		}

                wfProfileOut( __METHOD__ );
                return true;
        }
}

