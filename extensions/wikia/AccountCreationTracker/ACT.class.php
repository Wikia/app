<?php

class AccountCreationTracker extends WikiaObject {
	const TRACKING_USER_CREATION = 0;
	const TRACKING_USER_LOGIN = 1;

	protected function getDb( $type = DB_SLAVE ) {
		return $this->wf->getDb( $type, array(), $this->wg->ExternalDatawareDB );
	}

	static function getTrackingDisplay( $tracking_const ) {
		switch( $tracking_const ) {
			case AccountCreationTracker::TRACKING_USER_CREATION:
				return "Created";
			case AccountCreationTracker::TRACKING_USER_LOGIN:
				return "Login";
			default:
				return "Unknown";
		}
	}

	public function trackAccount( User $user, $hash ) {
		wfProfileIn( __METHOD__ );
		if( !empty( $hash ) ) {
			$dbw = $this->getDb( DB_MASTER );

			$dbw->insert( 'user_tracker',
				array(
					'utr_user_id' => $user->getId(),
					'utr_user_hash' => $hash,
					'utr_source' => AccountCreationTracker::TRACKING_USER_CREATION
				),
				__METHOD__
			);
			$dbw->commit(__METHOD__);
		}
		wfProfileOut( __METHOD__ );
	}

	public function trackLogin( User $user, $hash ) {
		wfProfileIn( __METHOD__ );
		if( !empty( $hash ) ) {
			$dbw = $this->getDb( DB_MASTER );

			$dbw->insert( 'user_tracker',
				array(
					'utr_user_id' => $user->getId(),
					'utr_user_hash' => $hash,
					'utr_source' => AccountCreationTracker::TRACKING_USER_LOGIN
				),
				__METHOD__);
			$dbw->commit(__METHOD__);
		}
		wfProfileOut( __METHOD__ );
	}


	public function getAccountsByUser( User $user ) {
		wfProfileIn( __METHOD__ );
		$results = array();
		$results_user_set = array();
		$results_hash_set = array();

		$dbr = $this->getDb( DB_SLAVE );
		$res = $dbr->query( "SELECT utr_user_id, utr_user_hash, utr_source FROM user_tracker WHERE utr_user_hash IN ( SELECT utr_user_hash FROM user_tracker WHERE utr_user_id = '" . $user->getId() . "' )", __METHOD__);


		while( $row = $dbr->fetchObject($res) ) {
			$nuser = User::newFromId( $row->utr_user_id );
			if( $nuser->getId() && !isset($results_user_set[ $nuser->getId() ]) ) {
				$results_user_set[ $nuser->getId() ] = true;
				$results_hash_set[ $row->utr_user_hash ] = true;
				$connection = 90;
				$reason = self::getTrackingDisplay($row->utr_source);
				if( $nuser->getId() == $user->getId() ) {
					$connection = 100;
					$reason = 'Search';
				}
				$results[] = array(
					'user'=>$nuser,
					'reason'=>$reason,
					'from'=>$user,
					'connection'=>$connection
				);
			}
		}

		if(count($results_user_set) > 0) {

			$new_hashes = array();

			$table = array( 'user_tracker' );
			$vars = array( 'utr_user_id', 'utr_user_hash' );
			$conds = array( 'utr_user_id' => array_keys($results_user_set) );
			$options = array();
			$res = $dbr->select( $table, $vars, $conds, __METHOD__, $options);
			while( $row = $dbr->fetchObject($res) ) {
				if( !isset($results_hash_set[ $row->utr_user_hash ]) ) {
					$results_hash_set[ $row->utr_user_hash ] = $row->utr_user_id;
					$new_hashes[] = $row->utr_user_hash;
				}
			}

			if(count($new_hashes)>0) {
				$vars = array( 'utr_user_id', 'utr_source', 'utr_user_hash' );
				$conds = array( 'utr_user_hash' => $new_hashes );
				$res = $dbr->select( $table, $vars, $conds, __METHOD__, $options);
				while( $row = $dbr->fetchObject($res) ) {
					$nuser = User::newFromId( $row->utr_user_id );
					if( $nuser->getId() && !isset($results_user_set[ $nuser->getId() ]) ) {
						$results_user_set[ $nuser->getId() ] = true;
						$fuser = User::newFromId( $results_hash_set[ $row->utr_user_hash ] );
						$results[] = array(
							'user'=>$nuser,
							'reason'=>self::getTrackingDisplay($row->utr_source),
							'from'=>$fuser,
							'connection'=>60
						);
					}
				}
			}

		}

		if( count($results) == 0) {
			$results[] = array(
				'user'=>$user,
				'reason'=>"Search",
				'from'=>$user,
				'connection'=>100
			);
		}

		wfProfileOut( __METHOD__ );
		return $results;
	}

	public function getHashesByUser( User $user ) {
		wfProfileIn( __METHOD__ );
		$results = array();

		$dbr = $this->getDb();

		$res = $dbr->query( "SELECT utr_user_hash FROM user_tracker WHERE utr_user_id = '" . $user->getId() . "'", __METHOD__);

		while( $row = $dbr->fetchObject($res) ) {
			$results[ $row['utr_user_hash'] ] = true;
		}

		wfProfileOut( __METHOD__ );
		return array_keys($results);
	}

	public function getWikisCreatedByUsers( Array $users ) {
		wfProfileIn( __METHOD__ );
		$wikis = array();

		$dbr = $this->wf->getDB( DB_SLAVE, array(), $this->wg->ExternalSharedDB );
		$res = $dbr->select(
			'city_list',
			'city_id',
			array( $dbr->makeList( array( 'city_founding_user' => $users), LIST_OR ) ),
			__METHOD__
		);

		while ( $row = $dbr->fetchObject( $res ) ) {
			$wikis[] = $row->city_id;
		}

		wfProfileOut( __METHOD__ );
		return $wikis;
	}

	/**
	 * @param WikiPage $article
	 * @param $user_name
	 * @param $summary
	 * @param string $messages
	 * @return bool
	 */
	public function rollbackPage( $article, $user_name, $summary, &$messages = '' ) {
		wfProfileIn( __METHOD__ );

		// build article object and find article id
		$a = $article;
		$pageId = $a->getID();

		// check if article exists
		if ( $pageId <= 0 ) {
			$messages = 'page not found';
			wfProfileOut( __METHOD__ );
			return false;
		}

		// fetch revisions from this article
		$dbw = wfGetDB( DB_MASTER );
		$res = $dbw->select(
			'revision',
			array( 'rev_id', 'rev_user_text', 'rev_timestamp' ),
			array(
				'rev_page' => $pageId,
			),
			__METHOD__,
			array(
				'ORDER BY' => 'rev_id DESC',
			)
		);

		// find the newest edit done by other user
		$revertRevId = false;
		while ( $row = $dbw->fetchObject($res) ) {
			if ( $row->rev_user_text != $user_name ) {
				$revertRevId = $row->rev_id;
				break;
			}
		}
		$dbw->freeResult($res);


		if ($revertRevId) { // found an edit by other user - reverting
			$rev = Revision::newFromId($revertRevId);
			$text = $rev->getRawText();
			$status = $a->doEdit( $text, $summary, EDIT_UPDATE|EDIT_MINOR|EDIT_FORCE_BOT );
			if ($status->isOK()) {
				$messages = 'reverted';
				wfProfileOut( __METHOD__ );
				return true;
			} else {
				$messages = "edit errors: " . implode(', ',$status->getErrorsArray());
			}
		} else { // no edits by other users - deleting page
			$errorDelete = '';
			$status = $this->deleteArticle( $a, $summary, false, $errorDelete );
			if ($status) {
				$messages = 'deleted';
				wfProfileOut( __METHOD__ );
				return true;
			} else {
				$messages = "delete errors: " . $errorDelete;
			}
		}

		wfProfileOut( __METHOD__ );
		return false;
	}

	/**
	 * @param WikiPage $article
	 * @param $reason
	 * @param bool $suppress
	 * @param string $error
	 * @return bool
	 */
	private function deleteArticle( $article, $reason, $suppress = false, &$error = '' ) {
		wfProfileIn( __METHOD__ );

		global $wgUser;
		$id = $article->getTitle()->getArticleID( Title::GAID_FOR_UPDATE );

		if ( wfRunHooks( 'ArticleDelete', array( &$article, &$wgUser, &$reason, &$error ) ) ) {
			if ( $article->doDeleteArticle( $reason, $suppress, $id ) ) {
				wfRunHooks( 'ArticleDeleteComplete', array( &$article, &$wgUser, $reason, $id ) );
				wfProfileOut( __METHOD__ );
				return true;
			}
		}

		wfProfileOut( __METHOD__ );
		return false;
	}
}
