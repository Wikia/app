<?php

class ForumHooksHelper {

	/**
	 * Render the wall on board page
	 */

	public function onArticleViewHeader(&$article, &$outputDone, &$useParserCache) {
		$app = F::App();
		$title = $article->getTitle();
		if( $title->getNamespace() === NS_WIKIA_FORUM_BOARD && $title->exists()
		) {
			//message wall index
			$outputDone = true;
			$app->wg->SuppressPageHeader = true;
			$app->wg->WallBrickHeader = true;
			$app->wg->Out->addHTML($app->renderView('ForumController', 'board', array( 'title' => $article->getTitle() ) ));
		}
		return true;
	}

	/**
	 * Render the alternative version of thread page
	 */

	public function onWallBeforeRenderThread($title, $wm) {
		$app = F::App();
		if($title->getNamespace() == NS_WIKIA_FORUM_BOARD_THREAD) {
			$app->wg->Out->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/Forum/css/ForumThread.scss'));
			$app->wg->IsForum = true;
		}
		return true;
	}

	/**
	 * on thread header change header title
	 */
	public function onWallThreadHeader($title, $wallMessage, &$path, &$response, &$request) {
		if(MWNamespace::getSubject($title->getNamespace()) == NS_WIKIA_FORUM_BOARD) {
			$app = F::App();
			$path = array_merge($this->getPath($wallMessage), array($path[1]));
		}
		return true;
	}


	public function onWallHistoryThreadHeader($title, $wallMessage, &$path, &$response, &$request) {
		if(MWNamespace::getSubject($title->getNamespace()) == NS_WIKIA_FORUM_BOARD) {
			$app = F::App();
			$indexPage = F::build('Title', array('Forum', NS_SPECIAL), 'newFromText' );
			$path = array_merge($this->getPath($wallMessage), array($path[1]));
		}
		return true;
	}

	public function onWallHeader($title, &$path, &$response, &$request) {
		if( $title->getNamespace() === NS_WIKIA_FORUM_BOARD) {
			$path[] = $this->getIndexPath();
			$path[] = array(
				'title' =>	wfMsg( 'forum-board-title', $title->getText()),
			);

		}
		return true;
	}

	public function onWallNewMessage($title, &$response) {
		if( $title->getNamespace() === NS_WIKIA_FORUM_BOARD) {
			$response->setVal( 'wall_message', wfMsg( 'forum-discussion-placeholder-message', $title->getText()));
		}
		return true;
	}

	protected function getPath($wallMessage){
		$path = array();
		$app = F::App();
		$indexPage = F::build('Title', array('Forum', NS_SPECIAL), 'newFromText' );
		$path[] = $this->getIndexPath();
		$path[] = array(
			'title' => wfMsg( 'forum-board-title', $wallMessage->getArticleTitle()->getText()),
			'url' =>  $wallMessage->getArticleTitle()->getFullUrl()
		);

		return $path;
	}

	protected function getIndexPath() {
		$app = F::App();
		$indexPage = F::build('Title', array('Forum', NS_SPECIAL), 'newFromText' );
		return array(
			'title' => wfMsg( 'forum-forum-title', $app->wg->sitename ),
			'url' => $indexPage->getFullUrl()
		);
	}

	/**
	 * change the message in WikiActivity for forum namespace
	 */

	public function onAfterWallWikiActivityFilter(&$item, $wmessage) {
		if(!empty($item['ns']) && MWNamespace::getSubject($item['ns']) == NS_WIKIA_FORUM_BOARD) {
			$app = F::App();

			$board = $wmessage->getArticleTitle();
			$item['wall-msg'] = wfMsg( 'forum-wiki-activity-msg',
				'<a href="'. $board->getFullURL() .'">'. wfMsg( 'forum-wiki-activity-msg-name', $board->getText()).'</a>');
		}
		return true;
	}

	public static function getUserPermissionsErrors( &$title, &$user, $action, &$result ) {
		$result = null;
		if ( $title->getNamespace() == NS_WIKIA_FORUM_BOARD ) {
			if ( (!$user->isAllowed( 'boardedit' )) && ($action == 'create' || $action == 'edit') ) {
				$result = array( 'badaccess-group0' );
				return false;
			}
		}

		return true;
	}

	public function onWallContributionsLine($pageNamespace, $wallMessage, $wfMsgOptsBase, &$ret ) {
		if($pageNamespace != NS_WIKIA_FORUM_BOARD) {
			return true;
		}

		$app = F::App();

		if(empty($wfMsgOptsBase['articleTitleVal'])) {
			$wfMsgOptsBase['articleTitleTxt'] = $app->wf->Msg('forum-recentchanges-deleted-reply-title');
		}

		$wfMsgOpts = array(
			$wfMsgOptsBase['articleUrl'],
			$wfMsgOptsBase['articleTitleTxt'],
			$wfMsgOptsBase['wallPageUrl'],
			$wfMsgOptsBase['wallPageName'],
			$wfMsgOptsBase['createdAt'],
			$wfMsgOptsBase['DiffLink'],
			$wfMsgOptsBase['historyLink']
		);

		if( $wfMsgOptsBase['isThread'] && $wfMsgOptsBase['isNew'] ) {
			$wfMsgOpts[7] = Xml::element('strong', array(), 'N ');
		} else {
			$wfMsgOpts[7] = '';
		}

		$ret .= $app->wf->Msg('forum-contributions-line', $wfMsgOpts);

		if( !$wfMsgOptsBase['isNew'] ) {
			$ret .= ' ' . Xml::openElement('span', array('class' => 'comment')) . $app->wf->Msg('wall-recentchanges-edit') . Xml::closeElement('span');
		}

		return false;
	}

	public function onWallRecentchangesMessagePrefix($namespace, &$prefix) {
		if($namespace == NS_WIKIA_FORUM_BOARD) {
			$prefix = 'forum-recentchanges';
			return false;
		}
		return true;
	}

	// Hook: clear cache when editing comment
	public function onEditCommentsIndex( $title, $commentsIndex ) {
		if ( $title->getNamespace() == NS_WIKIA_FORUM_BOARD_THREAD ) {
			$parentPageIds = $commentsIndex->getParentPageIds();
			foreach( $parentPageIds as $parentPageId ) {
				$board = F::build( 'ForumBoard', array( $parentPageId ), 'newFromId' );
				$board->clearCacheBoardInfo();
			}
		}

		return true;
	}

	/**
	 * Hook: add comments_index table when adding board
	 */
	public function onArticleInsertComplete( &$article, &$user, $text, $summary, $minoredit, $watchthis, $sectionanchor, &$flags, $revision ) {
		$title = $article->getTitle();
		if ( $title->getNamespace() == NS_WIKIA_FORUM_BOARD ) {
			$commentsIndex = F::build( 'CommentsIndex' );
			$commentsIndex->createTableCommentsIndex();
		}

		return true;
	}

	// Hook: get query for load thread list
	public function onWallLoadThreadListFromDB( $title, &$query ) {
		$app = F::App();

		if ( $title->getNamespace() == NS_WIKIA_FORUM_BOARD || !empty($app->wg->EnableCommentsIndex) ) {
			$boardId = $title->getArticleID();
			$query = <<<SQL
				SELECT comment_id as page_id, page_title
				FROM comments_index
				LEFT JOIN page ON comment_id = page_id
				WHERE parent_page_id = $boardId and parent_comment_id = 0 and deleted = 0 and removed = 0 and archived = 0
				ORDER BY comment_id
SQL;
		}

		return true;
	}

	// Hook: load data for threads on the notCached list and send it to objects on threads list
	public function onWallPreloadThreadsGrouped( $title, $master, $notCached, &$threadMapping, &$threads, &$return ) {
		$app = F::App();

		if ( $title->getNamespace() != NS_WIKIA_FORUM_BOARD || empty($app->wg->EnableCommentsIndex) ) {
			return true;
		}

		$return = true;
		$boardId = $title->getArticleID();
		$commentIds = array_keys( $notCached );

		$db = $app->wf->GetDB( $master ? DB_MASTER : DB_SLAVE );

		$res = $db->select(
			array( 'comments_index', 'page' ),
			array( 'comment_id as page_id, page_title' ),
			array(
				'parent_page_id' => $boardId,
				'parent_comment_id in ('.implode( ',', $commentIds ).')'
			),
			__METHOD__,
			array( 'ORDER BY' => 'comment_id ASC' ),
			array(
				'page' => array(
					'LEFT JOIN',
					array( 'comment_id=page_id' )
				)
			)
		);

		$replyThreadMapping = array();
		$threadWithNoReplies = array_flip( $notCached );
		while( $row = $db->fetchObject($res) ) {
			$parent = Wall::getParentTitleFromReplyTitle( $row->page_title );
			if( !isset($replyThreadMapping[$parent]) ) {
				$replyThreadMapping[$parent] = array();
				unset( $threadWithNoReplies[$parent] );
			}
			array_push( $replyThreadMapping[$parent], $row->page_id );
		}

		foreach( $replyThreadMapping as $title => $ids ) {
			if( !isset($threadMapping[$title]) ) {
				// replies to thread that doesn't exist
				// ignore
			} else {
				$parentId = $threadMapping[$title];
				$threads[$parentId]->setReplies( $ids );
			}
		}

		foreach( $threadWithNoReplies as $title => $id ) {
			$threads[$id]->setReplies( array() );
		}

		return true;
	}

	// Hooks: get reply ids for thread
	public function onWallThreadLoadReplyIdsFromDB( $title, $master, &$list ) {
		$app = F::App();

		if ( $title->getNamespace() != NS_WIKIA_FORUM_BOARD_THREAD || empty($app->wg->EnableCommentsIndex) ) {
			return true;
		}

		$threadId = $title->getArticleID();

		$db = $app->wf->GetDB( $master ? DB_MASTER : DB_SLAVE );

		$result = $db->select(
				array( 'comments_index' ),
				array( 'distinct comment_id' ),
				array( 'parent_comment_id = '.$threadId ),
				__METHOD__,
				array( 'ORDER BY' => 'comment_id ASC' )
		);

		$list = array();
		while ( $row = $db->fetchObject( $result ) ) {
			$list[] = $row->comment_id;
		}

		return true;
	}
	
	/**
	 * clear the caches
	 */

	public function onAfterBuildNewMessageAndPost(&$mw) {
		$title = $mw->getTitle();
		if($title->getNamespace() == NS_WIKIA_FORUM_BOARD_THREAD ) {
			$forum = F::build( 'Forum' );
			$forum->clearCacheTotalActiveThreads();
			$forum->clearCacheTotalThreads();
		}
		return true; 
	}
}
