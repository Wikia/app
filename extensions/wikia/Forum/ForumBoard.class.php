<?php

//TODO: move this to wall class php ??

/**
 * Forum Board
 * @author Kyle Florence, Saipetch Kongkatong, Tomasz Odrobny
 */
class ForumBoard extends Wall {
	
	static public function getEmpty() {
		return new ForumBoard();
	}
	
	/**
	 * get board info: the number of threads, the number of posts, the username and timestamp of the last post
	 * @return array $info
	 */
	public function getBoardInfo($db = DB_SLAVE) {
		$this->wf->ProfileIn( __METHOD__ );

		$memKey = $this->wf->MemcKey( 'forum_board_info', $this->getId() );
		
		if($db == DB_SLAVE) {
			$info = $this->wg->Memc->get( $memKey );
		}
		
		if ( empty($info) ) {
			$db = $this->wf->GetDB( $db );

			$row = $db->selectRow(
				array( 'comments_index' ),
				array( 'count(if(parent_comment_id=0,1,null)) threads, count(*) posts, max(first_rev_id) rev_id' ),
				array( 'parent_page_id' => $this->getId() ),
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
			$this->wg->Memc->set( $memKey, $info, 60*60*12 );
		}

		$this->wf->ProfileOut( __METHOD__ );

		return $info;
	}

	/**
	 * get number of active threads (exclude deleted and removed threads)
	 * @return integer activeThreads
	 */
	public function getTotalActiveThreads($relatedPageId = 0, $db = DB_SLAVE) {
		$this->wf->ProfileIn( __METHOD__ );

		$memKey = $this->wf->MemcKey( 'forum_board_active_threads', $this->getId() );
		
		if($db == DB_SLAVE) {
			$activeThreads = $this->wg->Memc->get( $memKey );
		}
		
		if ( !empty($relatedPageId) || $activeThreads === false ) {
			$db = $this->wf->GetDB( $db );

			$filter = 'parent_page_id ='.((int) $this->getId());
			
			if(!empty($relatedPageId)) {
				$filter = "comment_id in (select comment_id from wall_related_pages where page_id = {$relatedPageId})";	
			}

			$activeThreads = $db->selectField(
				array( 'comments_index' ),
				array( 'count(*) cnt' ),
				array(
					$filter,
					'parent_comment_id' => 0,
					'deleted' => 0,
					'removed' => 0,
					'last_touched > curdate() - interval 7 day',
				),
				__METHOD__
			);

			$activeThreads = intval( $activeThreads );
			$this->wg->Memc->set( $memKey, $activeThreads, 60*60*12 );
		}

		$this->wf->ProfileOut( __METHOD__ );

		return $activeThreads;
	}

	/**
	 * clear cache for board info
	 * @param array $parentPageIds
	 */
	public function clearCacheBoardInfo() {
		$this->getBoardInfo(DB_MASTER);
		$this->getTotalActiveThreads(DB_MASTER);

		$title = F::build( 'Title', array( $this->getId() ), 'newFromID' );
		if ( $title instanceof Title ) {
			$title->purgeSquid();
		}
	}
}
