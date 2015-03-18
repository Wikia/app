<?php

class WallRelatedPages extends WikiaModel {
	
	/**
	 * Create table if it dosen't exists
	 */
	function createTable() {
		wfProfileIn( __METHOD__ );
		$dir = dirname(__FILE__);
		
		if ( !wfReadOnly() ) {
			$db = wfGetDB( DB_MASTER );
			if ( !$db->tableExists('wall_related_pages') ) {
				$db->sourceFile( $dir . '/sql/wall_related_pages.sql' );
				wfProfileOut( __METHOD__ );
				return true;
			}
		}
		
		wfProfileOut( __METHOD__ );
		return false;
	}
	
	/**
	 * set last update use for ordering on aritcle page 
	 * 
	 */
	
	function setLastUpdate($messageId) {	 
	 	wfProfileIn( __METHOD__ );
		$db = wfGetDB( DB_MASTER );
		$db->begin();
		$db->query( "update `wall_related_pages` set last_update = NOW() where comment_id = $messageId ", __METHOD__ );
		$db->commit();
		wfProfileOut( __METHOD__ );
	}
	
	/**
	 * set message to article relation
	 * 
	 * @param int $messageId
	 * @param array $pages - array( 'order_index' => 'page_id' )  
	 */
	
	function set($messageId, $pages = array() ) {
		wfProfileIn( __METHOD__ );
		$db = wfGetDB( DB_MASTER );
		
		$this->createTable();
		
		$db->begin();
		$db->delete('wall_related_pages', array(
			'comment_id' => $messageId
		), __METHOD__);

		foreach($pages as $key => $val) {
			$db->query( "INSERT  INTO `wall_related_pages` (comment_id,page_id,last_update,order_index) VALUES ('$messageId','$val',NOW(), $key)",  __METHOD__ ); 
		}
		
		$db->commit();
		wfProfileOut( __METHOD__ );
	}
	
	/**
	 * set message to article relation
	 * 
	 * @param int $messageId
	 * @param array $pages - array( 'order_index' => 'page_id' )  
	 */
	
	function setWithURLs($messageId, $url = array() ) {
		wfProfileIn( __METHOD__ );
		$out = array();
		
		foreach($url as $key => $value) {
			$title = Title::newFromURL( $value );
			if(!empty($title)) {
				$out[$key] = $title->getArticleId();
			}
		}
		
		$this->set($messageId, $out);
		wfProfileOut( __METHOD__ );
	} 
		
	/**
	 * 
	 * invalidate caches 
	 * 
	 */
	
	function invalidateCache($messageId) {
		
	}
	
	/** 
	 * get messages related to messages
	 * 
	 * @param $messageId
	 */
	
	function getMessageRelatetMessageIds($messageId) {
		wfProfileIn( __METHOD__ );
		$articles = $this->getMessagesRelatedArticleIds($messageId);
		$messages = $this->getArticlesRelatedMessgesIds($articles, 'cnt desc, last_child_comment_id desc');
		wfProfileOut( __METHOD__ );
		return $messages;
	}
	
	/**
	 * 
	 * get list of article releated to messages
	 * 
	 * @param array $messageId
	 */
	
	function getMessagesRelatedArticleIds($messageIds, $orderBy = 'order_index', $db = DB_SLAVE) {
		wfProfileIn( __METHOD__ );
		$pageIds = array();
		
		//Loading from cache 
		$db = wfGetDB( $db );
		
		if ( ! $db->tableExists('wall_related_pages') && wfReadOnly() ) {
			wfProfileOut( __METHOD__ );
			return array();
		}
		
		if($this->createTable()) {
			$db = wfGetDB( $db );
		}
		
		$result = $db->select(
			array( 'wall_related_pages' ),
			array( 'page_id, count(*) as cnt' ),
			array( 'comment_id' => $messageIds ),
			__METHOD__,
			array(
				'ORDER BY' => $orderBy, 
				'GROUP BY' => 'page_id'
			)
		);

		while ( $row = $db->fetchObject($result) ) {
			$pageIds[] = $row->page_id;
		}
		wfProfileOut( __METHOD__ );
		return $pageIds; 
	}
	
	/**
	 * 
	 * get list of article titles releated to messages
	 * 
	 * @param array $messageId
	 */
	
	function getMessagesRelatedArticleTitles($messageIds, $orderBy = 'order_index') {
		wfProfileIn( __METHOD__ );
		$ids = $this->getMessagesRelatedArticleIds($messageIds, $orderBy);
		
		$titles = array();
		foreach($ids as $val) {
			$title = Title::newFromId($val);
			if(!empty($title)) {
				$titles[] = $title; 
			}
		}
		
		wfProfileOut( __METHOD__ );
		return $titles;
	}
	
	
	public function getArticlesRelatedMessgesSnippet($pageId, $messageCount, $replyCount) {
		$messages = $this->getArticlesRelatedMessgesIds($pageId, 'last_update desc', $messageCount);
			
		$out = array();
		
		$update = array(0);
		$helper = new WallHelper();
			
		foreach($messages as $value) {
			$wallThread = WallThread::newFromId($value['comment_id']);
			
			if(empty($wallThread)) {
				continue;
			}
			
			$wallMessage = $wallThread->getThreadMainMsg();

			if(empty($wallMessage)) {
				continue;
			}

			$wallMessage->load();

			$update[] = $wallMessage->getCreateTime(TS_UNIX);

			$row = array();
			$row['metaTitle'] = $wallMessage->getMetaTitle();
			$row['threadUrl'] = $wallMessage->getMessagePageUrl(); 
			$row['totalReplies'] = $wallThread->getRepliesCount();
			
			$row['displayName'] = $wallMessage->getUserDisplayName();
			$row['userName'] = $wallMessage->getUser()->getName();
			$row['userUrl'] = $wallMessage->getUserWallUrl();
			$strippedText = $helper->strip_wikitext( $wallMessage->getRawText(), $wallMessage->getTitle() );
			$row['messageBody'] = $helper->shortenText( $strippedText );
			$row['timeStamp'] = $wallMessage->getCreateTime();
			
			$row['replies'] = array();
			
			$replies = array_reverse($wallThread->getRepliesWallMessages(2, "DESC"));
			
			foreach($replies as $reply) {
				/** @var WallMessage $reply */
				$reply->load();
				$update[] = $reply->getCreateTime(TS_UNIX);
				
				if(!$reply->isRemove() && !$reply->isAdminDelete()) {
					$strippedText = $helper->strip_wikitext( $reply->getRawText(), $reply->getTitle() );
					$replyRow = array(
						'displayName' =>  $reply->getUserDisplayName(),
						'userName' => $reply->getUser()->getName(),
						'userUrl' => $reply->getUserWallUrl(),
						'messageBody' => $helper->shortenText( $strippedText ),
						'timeStamp' => $reply->getCreateTime()
					);
					$row['replies'][] = $replyRow;
				}
			}
			
			$out[] = $row;
		}


		$out['lastupdate'] = max($update);
		
		return $out;
	}

	public function invalidateData( $threads, $replies ) {
		
	}

	
	/**
	 * 
	 * get list of messages related to Article
	 * 
	 * @param array $pageId
	 */
	
	function getArticlesRelatedMessgesIds($pageIds, $orderBy = 'order_index', $limit = 10) {
		wfProfileIn( __METHOD__ );
		if(empty($pageIds)) {
			wfProfileOut( __METHOD__ );
			return array();
		}
		
		$messgesIds = array();
		
		//Loading from cache 
		$db = wfGetDB( DB_SLAVE );
		
	    if ( ! $db->tableExists('wall_related_pages') && wfReadOnly() ) {
			wfProfileOut( __METHOD__ );
			return array();
		}
		
		if($this->createTable()) {
			$db = wfGetDB( DB_MASTER );
		}
		
		//Loading from cache 
		$result = $db->select(
			array( 'wall_related_pages', 'comments_index' ),
			array( 'comments_index.comment_id, count(*) as cnt, last_child_comment_id' ),
			array(
				'page_id' => $pageIds,	
				'removed' => 0,
				'wall_related_pages.comment_id = comments_index.comment_id' 
			),
			__METHOD__,
			array(
				'ORDER BY' => $orderBy, 
				'GROUP BY' => 'comments_index.comment_id',
				'LIMIT' => $limit
			)
		);
		
		while ( $row = $db->fetchObject($result) ) {
			$messge = array(
				'comment_id' => $row->comment_id, 
			);
			
			if(	$row->comment_id != $row->last_child_comment_id ) {
				$messge['last_child'] = $row->last_child_comment_id;
			}
			
			$messgesIds[] = $messge;
		}
		
		wfProfileOut( __METHOD__ );
		return $messgesIds; 
	}
}

