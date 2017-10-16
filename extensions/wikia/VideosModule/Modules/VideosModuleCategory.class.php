<?php

namespace VideosModule\Modules;

/**
 * Class Category
 *
 * Get videos from the Video wiki that are in categories listed in wgVideosModuleCategories
 *
 * @package VideosModule\Modules
 */
class Category extends Base {

	const LIMIT = 40;

	public function __construct( $userRegion ) {
		parent::__construct( $userRegion );

		$this->initCategories();
	}

	public function getSource() {
		return 'wiki-categories';
	}

	protected function initCategories() {
		$categories = $this->wg->VideosModuleCategories;

		if ( empty( $categories ) ) {
			return;
		}

		$this->categories = $this->transformCatNames( wfReturnArray( $categories ) );
	}

	/**
	 * Make sure categories used by videos module are using the database name as
	 * opposed to regular name (ie, use underscores instead of spaces)
	 * @param $categories
	 * @return array
	 */
	protected function transformCatNames( array $categories ) {
		$transformedCategories = [];
		foreach ( $categories as $category ) {
			$transformedCategories[] = str_replace( " ", "_", $category );
		}
		return $transformedCategories;
	}

	protected function getLogParams() {
		$params = parent::getLogParams();

		$params['category'] = $this->categories;

		return $params;
	}

	public function getCacheKey() {
		$cacheKey = parent::getCacheKey();

		$category = $this->categories;

		sort( $category );
		$hashCategory = md5( json_encode( $category ) );

		return implode( ':', [ $cacheKey, $hashCategory ] );
	}

	/**
	 * Get the list of category based videos
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
