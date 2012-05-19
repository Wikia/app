<?php

/**
 * Board Helper
 * @author Kyle Florence, Saipetch Kongkatong, Tomasz Odrobny
 */
class ForumBoardHelper extends WikiaModel {

	/**
	 * get list of board
	 * @return array boards
	 */
	public function getBoardList() {
		$this->wf->profileIn( __METHOD__ );

		$db = $this->wf->GetDB( DB_SLAVE );

		// get board list
		$result = $db->select(
			array( 'page' ),
			array( 'page_id, page_title' ),
			array( 'page_namespace' => NS_WIKIA_FORUM_BOARD ),
			__METHOD__,
			array( 'ORDER BY' => 'page_title' )
		);

		$boards = array();
		while ( $row = $db->fetchObject($result) ) {
			$boardId = $row->page_id;
			$title = F::build( 'Title', array( $boardId ), 'newFromID' );
			if( $title instanceof Title ) {
				$board = $this->getBoardInfo( $boardId );
				$board['id'] = $boardId;
				$board['name'] = $title->getText();
				$board['url'] = $title->getFullURL();

				$boards[$boardId] = $board;
			}
		}

		$this->wf->profileOut( __METHOD__ );

		return $boards;
	}

	/**
	 * get board info: the number of threads, the number of posts, the username and timestamp of the last post
	 * @param integer $boardId
	 * @return array $info
	 */
	public function getBoardInfo( $boardId ) {
		$this->wf->ProfileIn( __METHOD__ );

		$memKey = $this->getMemKeyBoardInfo( $boardId );
		$info = $this->wg->Memc->get( $memKey );
		if ( empty($info) ) {
			$db = $this->wf->GetDB( DB_SLAVE );

			$row = $db->selectRow(
				array( 'comments_index' ),
				array( 'count(if(parent_comment_id=0,1,null)) threads, count(*) posts, max(first_rev_id) rev_id' ),
				array( 'parent_page_id' => $boardId ),
				__METHOD__
			);

			$info = array( 'postCount' => 0, 'threadCount' => 0 );
			if ( $row ) {
				$info = array(
					'postCount' => $row->posts,
					'threadCount' => $row->threads,
				);

				// get last post info
				$revision = F::build( 'Revision', array( $row->rev_id ), 'newFromId' );
				if ( $revision instanceof Revision ) {
					if ( $revision->getRawUser() == 0 ) {
						$username = $this->wf->Msg( 'oasis-anon-user' );
					} else {
						$username = $revision->getRawUserText();
					}

					$userprofile = Title::makeTitle( $this->wg->EnableWallExt ? NS_USER_WALL : NS_USER_TALK, $username )->getFullURL();

					$info['lastPost'] = array(
						'username' => $username,
						'userprofile' => $userprofile,
						'timestamp' => $revision->getTimestamp(),
					);
				}
			}
			$this->wg->Memc->set($memKey, $info, 60*60*12);
		}

		$this->wf->ProfileOut( __METHOD__ );

		return $info;
	}

	/**
	 * get memcache key of board info
	 * @param integer $boardId
	 * @return string 
	 */
	protected function getMemKeyBoardInfo( $boardId ) {
		return $this->wf->MemcKey( 'forum_boardinfo_'.$boardId );
	}

	/**
	 * clear cache for board info
	 * @param array $parentPageIds
	 */
	public function clearCacheBoardInfo( $parentPageIds ) {
		foreach( $parentPageIds as $parentPageId ) {
			$memKey = $this->getMemKeyBoardInfo( $parentPageId );
			$this->wg->Memc->delete($memKey);
		}
	}
}
