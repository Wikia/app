<?php
/**
 * attribution cache for answers.wikia articles
 * @author ADi
 */
class AttributionCache {

	static private $instance = null;
	private $contribsCacheTime = 10800; // 3 hours
	private $editPointsCacheTime = 7200; // 2 hours
	private $contribs = array();
	private $editPoints = array();
	private $lastModified = array();
	private $firstEditDate = array();

	private function __construct() {
	}

	private function __clone() { }

	/**
	 * @static
	 * @return AttributionCache
	 */
	static public function getInstance() {
		if(self::$instance == null) {
			self::$instance = new AttributionCache;
		}
		return self::$instance;
	}

	private function getArticleContribsFromCache($articleId) {
		global $wgMemc;

		if(!isset($this->contribs[$articleId])) {
			$key = wfMemcKey( 'AttributionCache', $articleId, 'contribs' );
			$contribs = $wgMemc->get($key);
			if(!empty($contribs)) {
				// refresh edit points
				foreach($contribs as &$contrib) {
					if($contrib['user_id'] != 0) {
						// ignore anons
						$contrib['edits'] = $this->getUserEditPoints($contrib['user_id']);
					}
				}
				$contribs = $this->sortContribs($contribs);
			}
			$this->contribs[$articleId] = $contribs;
		}

		return $this->contribs[$articleId];
	}

	private function setArticleContribsToCache($articleId, Array $contribs) {
		global $wgMemc;

		// sort contribs by number of edits first
		$contribs = $this->sortContribs($contribs);

		$key = wfMemcKey( 'AttributionCache', $articleId, 'contribs' );
		$wgMemc->set( $key, $contribs, $this->contribsCacheTime );
		$this->contribs[$articleId] = $contribs;
		return $contribs;
	}

	public function getArticleContribs(Title $title) {
		wfProfileIn(__METHOD__);

		$contribs = $this->getArticleContribsFromCache($title->getArticleID());

		if(empty($contribs)) {
			//rebuild contribs cache
			$contribs = $this->rebuildArticleContribs($title);
		}

		wfProfileOut(__METHOD__);
		return $contribs;
	}

	public function getUserLastModifiedFromCache($userId) {
		global $wgMemc;

		if(!isset($this->lastModified[$userId])) {
			$key = wfMemcKey( 'AttributionCache', $userId, 'edits' );
			$value = $wgMemc->get($key);
			// check if we have array here
			$this->lastModified[$userId] = is_array($value) ? $value['last_modified'] : '';
		}

		return $this->lastModified[$userId];
	}

	public function getUserFirstEditDateFromCache($userId) {
		global $wgMemc;

		if(!isset($this->firstEditDate[$userId])) {
			$key = wfMemcKey( 'AttributionCache', $userId, 'edits' );
			$value = $wgMemc->get($key);
			// check if we have array here
			$this->firstEditDate[$userId] = is_array($value) ? $value['first_edit'] : '';
		}

		return $this->firstEditDate[$userId];
	}

	private function getUserEditPointsFromCache($userId) {
		global $wgMemc;

		if(!isset($this->editPoints[$userId])) {
			$key = wfMemcKey( 'AttributionCache', $userId, 'edits' );
			$value = $wgMemc->get($key);
			// check if we have array here
			$this->editPoints[$userId] = is_array($value) ? $value['edits'] : $value;
		}

		return $this->editPoints[$userId];
	}

	private function setUserEditPointsToCache($userId, $editPoints, $firstEditDate = null) {
		global $wgMemc;

		$lastModified = wfTimestampNow();
		$value = array( 'edits' => $editPoints, 'last_modified' => $lastModified, 'first_edit' => $firstEditDate );

		$key = wfMemcKey( 'AttributionCache', $userId, 'edits' );
		$wgMemc->set( $key, $value, $this->editPointsCacheTime );

		$this->editPoints[$userId] = $editPoints;
		$this->lastModified[$userId] = $lastModified;
		$this->firstEditDate[$userId] = $firstEditDate;
	}

	public function getUserEditPoints($userId) {
		wfProfileIn(__METHOD__);

		$edits = $this->getUserEditPointsFromCache($userId);

		if(empty($edits)) {
			//rebuild edit points cache
			$edits = $this->rebuildUserEditPoints($userId);
		}

		wfProfileOut(__METHOD__);
		return intval( $edits );
	}

	/**
	 * rebuild and cache contributors list for an article
	 */
	private function rebuildArticleContribs(Title $title) {
		global $wgAnswerHelperIDs, $wgMemc;
		wfProfileIn(__METHOD__);

		$results = array();

		$dbs = wfGetDB( DB_MASTER );
		$res = $dbs->select( 'revision', array( 'rev_user', 'rev_user_text' ), array( 'rev_page' => $title->getArticleID() ), __METHOD__, array( 'GROUP BY' => 'rev_user' ) );

		$firstRevisionUserId = $this->getFirstRevisionUserId($title);
		while($row = $dbs->fetchObject($res)) {
			if(!in_array($row->rev_user, $wgAnswerHelperIDs)) {
				$user = User::newFromId($row->rev_user);
				if($user->isBlocked()) {
					//ignore blocked users
					continue;
				}
				if($user->isAllowed('bot')) {
					//ignore bots
					continue;
				}
				if ((bool)$user->getGlobalPreference("hidefromattribution")) {
					//allow users to opt out from being shown on the attribution list
					continue;
				}
				if($row->rev_user == $firstRevisionUserId) {
					$pageUserEditPoints = $this->rebuildUserEditPoints($row->rev_user, $title->getArticleID());
					if($pageUserEditPoints == 1) {
						// don't show the asker as one of the answerers (#27081) ..unless he made more than just one edit
						continue;
					}
				}

				if ( $row->rev_user > 0 ) {
					$userName = $user->getName();
				} else {
					$userName = $row->rev_user_text;
				}
				$results[] = $this->getContribsEntry( $row->rev_user, $this->getUserEditPoints( $row->rev_user ), $userName );
			}
		}

		// get helper's edits
		$answerHelperEdits = 0;
		foreach($wgAnswerHelperIDs as $helperId) {
			$answerHelperEdits += $this->rebuildUserEditPoints( $helperId, $title->getArticleID() );
		}
		if($answerHelperEdits > 0) {
			$results[] = $this->getContribsEntry(0, $answerHelperEdits);
		}

		$results = $this->setArticleContribsToCache($title->getArticleID(), $results);

		wfProfileOut(__METHOD__);
		return $results;
	}

	public function getFirstRevisionUserId(Title $title) {
		$dbs = wfGetDB( DB_MASTER );
		$res = $dbs->selectRow( 'revision', array( 'rev_user' ), array( 'rev_page' => $title->getArticleID() ), __METHOD__, array( 'ORDER BY' => 'rev_timestamp ASC', 'LIMIT' => '1' ) );
		return !empty($res->rev_user) ? $res->rev_user : 0;
	}

	private function getContribsEntry($userId, $editsNum, $userName = '') {
		return array( 'user_id' => $userId, 'user_name' => (($userId != 0) ? $userName : 'helper'), 'edits' => $editsNum );
	}

	/**
	 * sort contribs array by number of edits
	 */
	private function sortContribs(Array $contribs) {
		if(count($contribs) == 0) {
			return $contribs;
		}

		$helpersContrib = null;
		if($contribs[count($contribs)-1]['user_id'] == 0) {
			// copy helper's entry
			$helpersContrib = $contribs[count($contribs)-1];
			unset($contribs[count($contribs)-1]);
		}

		$tmpSorted = array();
		$tmpUserNames = array();

		foreach($contribs as $contrib) {
			$tmpSorted[$contrib['user_id']] = $contrib['edits'];
			$tmpUserNames[$contrib['user_id']] = $contrib['user_name'];
		}

		arsort($tmpSorted);
		$sortedContribs = array();
		foreach($tmpSorted as $userId => $editsNum) {
			$sortedContribs[] = $this->getContribsEntry($userId, $editsNum, $tmpUserNames[$userId]);
		}

		if(is_array($helpersContrib)) {
			// put helper's entry at the end
			$sortedContribs[] = $helpersContrib;
		}

		return $sortedContribs;
	}

	/**
	 * rebuild and cache edit points for user
	 * @param int $userId user id
	 * @param int $pageId page id for calculating edits per article
	 */
	private function rebuildUserEditPoints($userId, $pageId = 0) {
		global $wgAnswerHelperIDs, $wgMemc;
		wfProfileIn(__METHOD__);

		$dbs = wfGetDB( DB_MASTER );
		$tables = array( 'revision' );
		$conditions = array( 'rev_user' => $userId );
		if(!empty($pageId)) {
			$tables[] = 'page';
			$conditions[] = 'page_id=rev_page';
			$conditions['page_id'] = $pageId;
		}
		/* @TODO FIXME: respect your DB resources, never count on MASTER */
		$edits = $dbs->selectRow( $tables, array( 'min(rev_timestamp) AS date, count(rev_id) AS count' ), $conditions, __METHOD__ );

		$editCount = !empty($edits->count) ? $edits->count : 0;
		$firstEditDate = !empty($edits->date) ? $edits->date : null;

		if(empty($pageId)) {
			$this->setUserEditPointsToCache($userId, $editCount, $firstEditDate);
		}

		wfProfileOut(__METHOD__);
		return $editCount;
	}

	/**
	 * update article contribs cache if available (without reading data from db)
	 */
	public function updateArticleContribs(Title $title, User $user) {
		global $wgAnswerHelperIDs;

		if(in_array($user->getId(), $wgAnswerHelperIDs)) {
			// edit made by anonymous "helper"
			$userId = 0;
		}
		else {
			// edit made by regular user, update edit points cache as well
			$userId = $user->getId();

			$editPoints = $this->getUserEditPointsFromCache($userId);
			if(!empty($editPoints)) {
				$editPoints++;
				$this->setUserEditPointsToCache($userId, $editPoints, $this->getUserFirstEditDateFromCache($userId));
			}
			else {
				// no edit points in cache, get value from db
				$editPoints = $this->rebuildUserEditPoints($userId);
			}
		}

		$contribs = $this->getArticleContribsFromCache($title->getArticleID());

		if(!empty($contribs)) {
			$userExists = false;
			foreach($contribs as &$contribData) {
				if($contribData['user_id'] == $userId) {
					$contribData['edits'] = ($userId == 0) ? ($contribData['edits'] + 1) : $editPoints;
					$userExists = true;
					break;
				}
			}

			if(!$userExists) {
				// add new entry and cache
				$newEntry = $this->getContribsEntry($userId, ( ($userId == 0) ? 1 : $editPoints ), $user->getName());
				array_unshift($contribs, $newEntry);
			}

			$this->setArticleContribsToCache($title->getArticleID(), $contribs);
		}
		else {
			$this->rebuildArticleContribs($title);
		}
	}

	/**
	 * @param $title Title
	 * @param $user User
	 */
	public function purge( $title, $user ) {
		global $wgScript, $wgServer;
		AttributionCache::getInstance()->updateArticleContribs( $title, $user );

		// invalidate varnish cache
		if($user->getId() != 0) {
			SquidUpdate::purge( array( "{$wgServer}{$wgScript}?action=ajax&rs=wfAnswersGetEditPointsAjax&userId={$user->getId()}" ) );
		}
	}

	/**
	 * hook: ArticleSaveComplete
	 *
	 * @param Article $article
	 */
	public static function purgeArticleContribs(&$article, &$user, $text, $summary, $minoredit, $watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId) {
		if(count($status->errors) == 0) {
			AttributionCache::getInstance()->purge($article->getTitle(), $user);
		}
		return true;
	}

	/**
	 * hook: TitleMoveComplete
	 */
	public static function purgeArticleContribsAfterMove($oldTitle, $newTitle, $user) {
		AttributionCache::getInstance()->purge($oldTitle, $user);
		//AttributionCache::getInstance()->purge($newTitle, $user);
		return true;
	}

        function getFirstContributor($page_title_id){
                global $wgMemc;

                $key = wfMemcKey('first_contributor', $page_title_id, 3);
                $data = $wgMemc->get( $key );

                $contributor = array();
                if (empty($data)) {
                        wfDebug( "loading first contributor for {$page_title_id} from db\n" );
                        $dbr =& wfGetDB( DB_SLAVE );

                        $params['ORDER BY'] = "rev_id  ASC";
                        $params['LIMIT'] = 1;
                        $row = $dbr->selectRow( 'revision',
                                        array( 'rev_user','rev_user_text'),
                                        array( 'rev_page' =>  $page_title_id )
                                        , __METHOD__,
                                        $params
                        );
                        // set to 1 if anon, as only one person can actually "ask" the question..
                        $editsNum = !empty($s->rev_user) ? $this->getUserEditPoints($s->rev_user) : 1;
                        if ( $row->rev_user > 0 ) {
                                $userName = User::newFromId( $row->rev_user )->getName();
                        } else {
                                $userName = $row->rev_user_text;
                        }
                        $contributor = $this->getContribsEntry( $row->rev_user, $editsNum, $userName );
                        $wgMemc->set( $key, $num1, 60 * 60 );
                }
                else {
                        wfDebug( "loading first contributor for page {$page_title_id} from cache\n" );
                        $contributor = $data;
                }
                return $contributor;
        }

}
