<?php

namespace VideosModule\Modules;

/**
 * Class Staff
 *
 * Look for 'Staff Picks' on the video wiki.  These are videos that have been added to the
 * "Staff Pick DBNAME" category (where DBNAME is this wiki's DB NAME) or the "Staff Pick Global"
 * category.
 *
 * @package VideosModule\Modules
 */
class Staff extends Base {

	const STAFF_PICK_PREFIX = 'Staff_Pick_';
	const STAFF_PICK_GLOBAL_CATEGORY = 'Staff_Pick_Global';
	const LIMIT = 5;

	public function __construct( $userRegion ) {
		parent::__construct( $userRegion );

		$this->categories = [
			self::STAFF_PICK_PREFIX.$this->wg->DBname,
			self::STAFF_PICK_GLOBAL_CATEGORY,
		];
	}

	public function getSource() {
		return 'staff-picks';
	}

	public function getCacheKey() {
		$cacheKey = parent::getCacheKey();

		$category = $this->categories;

		sort( $category );
		$hashCategory = md5( json_encode( $category ) );

		return implode( ':', [ $cacheKey, $hashCategory ] );
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
