<?php

namespace VideosModule\Modules;

/**
 * Class VideosModuleStaff
 *
 * Look for 'Staff Picks' on the video wiki.  These are videos that have been added to the
 * "Staff Pick DBNAME" category (where DBNAME is this wiki's DB NAME) or the "Staff Pick Global"
 * category.
 */
class Staff extends Base {
	const SOURCE = 'staff-picks';

	const STAFF_PICK_PREFIX = 'Staff_Pick_';
	const STAFF_PICK_GLOBAL_CATEGORY = 'Staff_Pick_Global';
	const LIMIT = 5;

	public function __construct( array $params ) {
		parent::__construct( $params );

		$this->categories = [
			self::STAFF_PICK_PREFIX.$this->wg->DBname,
			self::STAFF_PICK_GLOBAL_CATEGORY,
		];
	}

	public function getCacheKey() {
		$cacheKey = parent::getCacheKey();

		$category = $this->categories;

		sort( $category );
		$hashCategory = md5( json_encode( $category ) );

		return implode( ':', $cacheKey, $hashCategory, $this->sort );
	}

	/**
	 * @return array
	 */
	public function getModuleVideos() {
		$this->addVideosFromVideoWiki();

		return $this->videos;
	}

	/**
	 * Clear the normal cache plus the cached list of videos on the video wiki
	 * @return bool|void
	 */
	public function clearCache() {
		parent::clearCache();
		$this->clearExternalVideoListCache();
	}
}
