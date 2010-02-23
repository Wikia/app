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
	function __construct( $cityId, $FactoryTags, $pageId = null, $Title = null, $User = null, $Timestamp = null ) {
		global $wgLanguageCode, $wgEnableBlogArticles, $wgDBname, $wgSitename, $wgServer;

		$this->mCityId = $cityId;
		$this->mCityTag = serialize( $FactoryTags );
		$this->mCityLang = $wgLanguageCode;

		if( empty( $pageId ) ) {
			if( !empty( $Title ) ) {
				// check if it is a blog comment, if so, then load all the data from "parent" blog article
				if( NS_BLOG_ARTICLE_TALK == $Title->getNamespace() ) {
					$comment = BlogComment::newFromId( $Title->getArticleId() );						
					$Title = $comment->getBlogTitle();					
				}
				$this->mPageId = $Title->getArticleId();				
			} else {
				$this->mPageId = $pageId;
				$Title = Title::newFromID( $pageId );
			}
		}
		if( !empty( $User ) ) {
			$this->mEditorId = $User->getId();
			$this->mUsername = $User->getName();
			$groups = $User->getGroups();			
			$this->mUserGroups = implode(";", $groups) ;			
		} 

		if( empty( $Timestamp) ) {
			$this->mEventTimestamp = wfTimestampNow();
		} else {
			$this->mEventTimestamp = $Timestamp;
		}		
		if( !empty( $Title ) ) {
			$this->mPageName = $Title->getDBkey();
			$this->mPageURL = $Title->getFullURL();
			$this->mPageNs = $Title->getNamespace();
			$this->mIsContentNs =
				( $Title->isContentPage() ) &&
				(
				 ($wgEnableBlogArticles) &&
				 (!in_array($this->mPageNs, array(NS_BLOG_ARTICLE, NS_BLOG_ARTICLE_TALK, NS_BLOG_LISTING, NS_BLOG_LISTING_TALK)))
				);
			$this->mRevId = $Title->getLatestRevID();
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
		catch( Stomp_Exception $e ) {
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
	static public function saveComplete(&$Article, &$User ) {
		global $wgCityId, $wgWikiFactoryTags;
		wfProfileIn( __METHOD__ );
		if( empty( $wgWikiFactoryTags ) ) {
                	wfProfileOut( __METHOD__ );
			return true;			
		}
		if ( ( $Article instanceof Article ) && ( $User instanceof User ) ) {
			$Title = $Article->mTitle;
			$oEdits = new WikiaStatsStompProducer( $wgCityId, $wgWikiFactoryTags, null, $Title, $User );
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
        static public function deleteComplete( &$Article, &$User, $reason, $articleId ) {
		global $wgCityId;
                wfProfileIn( __METHOD__ );
		if ( ( $Article instanceof Article ) && ( $User instanceof User ) ) {
			$Title = $Article->mTitle;
			$oEdits = new WikiaStatsStompProducer( $wgCityId, $articleId, $Title, $User );
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
	static public function undeleteComplete( &$Title, $User, $reason ) {
		global $wgCityId;
                wfProfileIn( __METHOD__ );
		if ( ( $Title instanceof Title ) && ( $User instanceof User ) ) {
			$oEdits = new WikiaStatsStompProducer( $wgCityId, null, $Title, $User );
			$oEdits->storeData( 'undelete' );
		}

                wfProfileOut( __METHOD__ );
                return true;
        }
}

