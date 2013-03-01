<?php

class WikiService extends WikiaModel {

	static $botGroups = array('bot', 'bot-global');

	/**
	 * get list of wiki founder/admin/bureaucrat id
	 * Note: also called from maintenance script.
	 *
	 * @param integer $wikiId
	 * @param bool    $useMaster
	 * @param bool    $excludeBots
	 *
	 * @return array of $userIds
	 */
	public function getWikiAdminIds( $wikiId = 0, $useMaster = false, $excludeBots = false ) {
		$this->wf->ProfileIn( __METHOD__ );

		$userIds = array();
		if ( empty($this->wg->FounderEmailsDebugUserId) ) {
			// get founder
			$wikiId = ( empty($wikiId) ) ? $this->wg->CityId : $wikiId ;
			$wiki = WikiFactory::getWikiById($wikiId);
			if ( !empty($wiki) && $wiki->city_public == 1 ) {
				$userIds[] = $wiki->city_founding_user;

				// get admin and bureaucrat
				if ( empty($this->wg->EnableAnswers) ) {
					$memKey = $this->getMemKeyAdminIds( $wikiId, $excludeBots );

					$adminIds = WikiaDataAccess::cache(
						$memKey,
						60 * 60 * 3,
						function() use ($wiki, $useMaster, $excludeBots) {
							$dbname = $wiki->city_dbname;
							$dbType = ( $useMaster ) ? DB_MASTER : DB_SLAVE;
							$db = $this->wf->GetDB( $dbType, array(), $dbname );

							$conditions = array("ug_group in ('sysop','bureaucrat')");

							if ($excludeBots) {
								$conditions[] = "ug_group not in (" .
									$db->makeList(self::$botGroups) .
									")";
							}

							$result = $db->select(
								'user_groups',
								'distinct ug_user',
								array ("ug_group in ('sysop','bureaucrat')"),
								__METHOD__
							);

							$adminIds = array();
							while ( $row = $db->fetchObject($result) ) {
								$adminIds[] = $row->ug_user;
							}
							$db->freeResult( $result );
							return $adminIds;
						}
					);

					$userIds = array_unique( array_merge($userIds, $adminIds) );
				}
			}
		} else {
			$userIds[] = $this->wg->FounderEmailsDebugUserId;
		}

		$this->wf->ProfileOut( __METHOD__ );
		return $userIds;
	}

	/**
	 * Get memcache key for list of admin_ids
	 *
	 * @param integer $wikiId
	 * @param bool    $excludeBots
	 *
	 * @return string memcache key
	 */
	public function getMemKeyAdminIds( $wikiId, $excludeBots = false ) {
		return $this->wf->SharedMemcKey( 'wiki_admin_ids', $wikiId, $excludeBots );
	}

	/**
	 * get number of videos on the wiki
	 * @return integer totalVideos
	 */
	public function getTotalVideos( $wikiId = 0 ) {
		$this->wf->ProfileIn( __METHOD__ );

		$wikiId = ( empty($wikiId) ) ? $this->wg->CityId : $wikiId ;
		$memKey = $this->wf->SharedMemcKey( 'wiki_total_videos', $wikiId );
		$totalVideos = $this->wg->Memc->get( $memKey );
		if ( $totalVideos === false ) {
			$totalVideos = 0;
			$dbname = WikiFactory::IDtoDB( $wikiId );
			if ( !empty($dbname) ) {
				$db = $this->wf->GetDB( DB_SLAVE, array(), $dbname );

				$row = $db->selectRow(
					array( 'image' ), 
					array( 'count(*) cnt' ),
					array( 'img_media_type' => 'VIDEO' ),
					__METHOD__
				);

				if ( $row ) {
					$totalVideos = intval( $row->cnt );
				}

				$this->wg->Memc->set( $memKey, $totalVideos, 60*60*3 );
			}
		}

		$this->wf->ProfileOut( __METHOD__ );

		return $totalVideos;
	}

	/**
	 * get site stats
	 * @return array $sitestats
	 */
	public function getSiteStats( $wikiId = 0 ) {
		$this->wf->ProfileIn( __METHOD__ );

		$wikiId = ( empty($wikiId) ) ? $this->wg->CityId : $wikiId ;
		$memKey = $this->wf->SharedMemcKey( 'wiki_sitestats', $wikiId );
		$sitestats = $this->wg->Memc->get( $memKey );
		if ( !is_array($sitestats) ) {
			$sitestats = array(
				'views' => 0,
				'edits' => 0,
				'articles' => 0,
				'pages' => 0,
				'users' => 0,
				'activeUsers' => 0,
				'images' => 0,
			);

			$dbname = WikiFactory::IDtoDB( $wikiId );
			if ( !empty($dbname) ) {
				$db = $this->wf->GetDB( DB_SLAVE, 'vslow', $dbname );

				$row = $db->selectRow( 
					array( 'site_stats' ), 
					array( '*' ),
					array(),
					__METHOD__
				);

				if ( $row ) {
					$sitestats = array(
						'views' => $row->ss_total_views,
						'edits' => $row->ss_total_edits,
						'articles' => $row->ss_good_articles,
						'pages' => $row->ss_total_pages,
						'users' => $row->ss_users,
						'activeUsers' => $row->ss_active_users,
						'images' => $row->ss_images,
					);
				}

				$this->wg->Memc->set( $memKey, $sitestats, 60*60*3 );
			}
		}

		$this->wf->ProfileOut( __METHOD__ );

		return $sitestats;
	}

	/**
	 * get list of top editors
	 *
	 * @param integer $wikiId
	 * @param integer $limit
	 * @param bool    $excludeBots
	 *
	 * @return array topEditors [ array( user_id => edits ) ]
	 */
	public function getTopEditors( $wikiId = 0, $limit = 30, $excludeBots = false ) {
		$this->wf->ProfileIn( __METHOD__ );

		$wikiId = ( empty($wikiId) ) ? $this->wg->CityId : $wikiId ;

		$topEditors = WikiaDataAccess::cache(
			$this->wf->SharedMemcKey( 'wiki_top_editors', $wikiId, $excludeBots ),
			60 * 60 * 3,
			function() use ($wikiId, $limit, $excludeBots) {
				$topEditors = array();

				$db = $this->wf->GetDB( DB_SLAVE, array(), 'specials' );

				$result = $db->select(
					array( 'events_local_users' ),
					array( 'user_id', 'edits', 'all_groups' ),
					array( 'wiki_id' => $wikiId, 'edits != 0' ),
					__METHOD__,
					array( 'ORDER BY' => 'edits desc', 'LIMIT' => $limit )
				);

				while( $row = $db->fetchObject($result) ) {
					if (!($excludeBots && $this->isBotGroup($row->all_groups))) {
						$topEditors[$row->user_id] = intval( $row->edits );
					}
				}

				return $topEditors;
			}
		);

		$this->wf->ProfileOut( __METHOD__ );

		return $topEditors;
	}

	public function isBotGroup($groups) {
		$isBot = false;
		$groups = explode(';', $groups);
		foreach (self::$botGroups as $botGroup) {
			if (in_array($botGroup, $groups)) {
				$isBot = true;
				break;
			}
		}
		return $isBot;
	}

	/**
	 * get user edits
	 * @param type $userId
	 * @param type $wikiId
	 * @return integer $userEdits
	 */
	public function getUserEdits( $userId, $wikiId = 0 ) {
		$this->wf->ProfileIn( __METHOD__ );

		$wikiId = ( empty($wikiId) ) ? $this->wg->CityId : $wikiId ;
		$memKey = $this->wf->SharedMemcKey( 'wiki_user_edits', $wikiId, $userId );
		$userEdits = $this->wg->Memc->get( $memKey );
		if ( $userEdits === false ) {
			$userEdits = 0;
			$dbname = WikiFactory::IDtoDB( $wikiId );
			if ( !empty($dbname) ) {
				$db = $this->wf->GetDB( DB_SLAVE, array(), $dbname );

				$row = $db->selectRow(
					'revision',
					array('count(*) cnt'),
					array('rev_user' => $userId),
					__METHOD__
				);

				if ( $row ) {
					$userEdits = intval( $row->cnt );
				}

				$this->wg->Memc->set( $memKey, $userEdits, 60*60*3 );
			}
		}

		$this->wf->ProfileOut( __METHOD__ );

		return $userEdits;
	}

	/**
	 * get number of images on the wiki
	 * @return integer totalImages
	 */
	public function getTotalImages( $wikiId = 0 ) {
		$this->wf->ProfileIn( __METHOD__ );

		$wikiId = ( empty($wikiId) ) ? $this->wg->CityId : $wikiId ;
		$memKey = $this->getMemcKeyTotalImages( $wikiId );
		$totalImages = $this->wg->Memc->get( $memKey );
		if ( $totalImages === false ) {
			$totalImages = 0;
			$dbname = WikiFactory::IDtoDB( $wikiId );
			if ( !empty($dbname) ) {
				$db = $this->wf->GetDB( DB_SLAVE, array(), $dbname );
			} else {
				$db = $this->wf->GetDB( DB_SLAVE );
			}

			$row = $db->selectRow(
				array( 'image' ),
				array( 'count(*) cnt' ),
				array( "img_media_type in ('".MEDIATYPE_BITMAP."', '".MEDIATYPE_DRAWING."')" ),
				__METHOD__
			);

			if ( $row ) {
				$totalImages = intval( $row->cnt );
			}

			$this->wg->Memc->set( $memKey, $totalImages, 60*60*3 );
		}

		$this->wf->ProfileOut( __METHOD__ );

		return $totalImages;
	}

	protected function getMemcKeyTotalImages( $wikiId ) {
		return $this->wf->SharedMemcKey( 'wiki_total_images', $wikiId );
	}

	public function invalidateCacheTotalImages( $wikiId = 0 ) {
		$wikiId = ( empty($wikiId) ) ? $this->wg->CityId : $wikiId ;
		$memKey = $this->getMemcKeyTotalImages( $wikiId );
		$this->wg->Memc->delete( $memKey );
	}

}
