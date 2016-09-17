<?php

class AchUser {

	protected $userId;

	protected $badgesCount;
	protected $allBadges;
	protected $badges = array();
	protected $badgesByType;
	protected $counters;

	public function __construct( $user ) {
		if( $user instanceof User ) {
			$userId = $user->getId();
		} elseif( is_numeric( $user ) ) {
			$userId = intval( $user );
		} else {
			$userId = 0;
		}
		$this->userId = $userId;

		if( $this->userId == 0 ) {
			$this->loadAnonData();
		}
	}

	protected function loadAnonData() {
		$this->badgesCount = 0;
		$this->allBadges = array();
		$this->badges = array();
		$this->badgesByType = array();
		$this->counters = array();
	}

	public function getId() {
		return $this->userId;
	}

	protected function loadBadgesFromDb( $limit = null, $offset = null ) {
		wfProfileIn( __METHOD__ );

		// build a WHERE conditions
		$where = array( 'user_id' => $this->getId() );
		$dbr = wfGetDB( DB_SLAVE );

		// build query options
		$opts = array(
			'ORDER BY' => 'date DESC, badge_lap DESC'
		);
		if( isset( $limit ) ) {
			$opts[ 'LIMIT' ] = $limit;
			if( isset( $offset ) ) {
				$opts[ 'OFFSET' ] = $offset;
			}
		}

		// execute a query
		$res = $dbr->select(
			'ach_user_badges',
			'badge_type_id, badge_lap',
			$where,
			__METHOD__,
			$opts
		);

		$badges = array();
		foreach( $res as $row ) {
			$badges[] = new AchBadge( $row->badge_type_id, $row->badge_lap );
		}

		wfProfileOut( __METHOD__ );
		return $badges;
	}

	protected function loadBadgesCountFromDb() {
		wfProfileIn( __METHOD__ );

		$where = array( 'user_id' => $this->getId() );
		$dbr = wfGetDB( DB_SLAVE );

		$count = $dbr->selectField(
			'ach_user_badges',
			array( 'COUNT(*) AS count' ),
			$where,
			__METHOD__
		);

		wfProfileOut( __METHOD__ );
		return intval( $count );
	}

	protected function loadBadgesByTypeFromDb() {
		wfProfileIn( __METHOD__ );

		// build a WHERE conditions
		$where = array( 'user_id' => $this->getId() );
		$dbr = wfGetDB( DB_SLAVE );

		// execute a query
		$res = $dbr->select(
			'ach_user_badges',
			'badge_type_id, count(*) as count, max(badge_lap) as max_lap',
			$where,
			__METHOD__,
			array(
				'GROUP BY' => 'badge_type_id',
			)
		);

		$badgesByType = array();
		foreach( $res as $row ) {
			$badgesByType[ $row->badge_type_id ] = array(
				'count' => $row->count,
				'max_lap' => $row->max_lap,
			);
		}

		wfProfileOut( __METHOD__ );
		return $badgesByType;
	}

	protected function loadBadgesByTypeFromAllBadges() {
		wfProfileIn( __METHOD__ );
		$badgesByType = array();
		/** @var $badge AchBadge */
		foreach( $this->allBadges as $badge ) {
			$typeId = $badge->getTypeId();
			$lap = $badge->getLap();
			if( !isset( $badgesByType[ $typeId ] ) ) {
				$badgesByType[ $typeId ] = array(
					'count' => 1,
					'max_lap' => $lap,
				);
			} else {
				$item = &$badgesByType[ $typeId ];
				$item[ 'count' ]++;
				if( $item[ 'max_lap' ] < $lap ) {
					$item[ 'max_lap' ] = $lap;
				}
				unset( $item );
			}
		}
		wfProfileOut( __METHOD__ );
		return $badgesByType;
	}

	public function getBadgesCount() {
		if( !isset( $this->badgesCount ) ) {
			$this->badgesCount = $this->loadBadgesCountFromDb();
		}

		return $this->badgesCount;
	}

	public function getAllBadges() {
		if( !isset( $this->allBadges ) ) {
			$this->allBadges = $this->loadBadgesFromDb();
			$this->badgesCount = count( $this->allBadges );
		}

		return $this->allBadges;
	}

	public function getBadges( $start, $count ) {
		// if we've loaded all badges, just return a slice of that list
		if( isset( $this->allBadges ) ) {
			return array_slice( $this->allBadges, $start, $count );
		}

		$cacheKey = sprintf( "%d:%d", intval( $start ), intval( $count ) );
		if( !isset( $this->badges[ $cacheKey ] ) ) {
			$this->badges[ $cacheKey ] = $this->loadBadgesFromDb( $count, $start );
		}

		return $this->badges[ $cacheKey ];
	}

	public function getBadgesByType() {
		if( !isset( $this->badgesByType ) ) {
			if( isset( $this->allBadges ) ) {
				$this->badgesByType = $this->loadBadgesByTypeFromAllBadges();
			} else {
				$this->badgesByType = $this->loadBadgesByTypeFromDb();
			}
		}
		return $this->badgesByType;
	}

	public function getCounters() {
		if( !isset( $this->counters ) ) {
			$countersService = new AchUserCountersService( $this->getId() );
			$this->counters = $countersService->getCounters();
		}
		return $this->counters;
	}

}