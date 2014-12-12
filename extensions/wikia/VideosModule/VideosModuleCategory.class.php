<?php

namespace VideosModule;

/**
 * Class VideosModuleCategory
 *
 * Get videos from the Video wiki that are in categories listed in wgVideosModuleCategories
 */
class Category extends Base {

	const SOURCE = 'wiki-categories';
	const LIMIT = 40;

	public function __construct( array $params ) {
		parent::__construct( $params );

		$this->initCategories();
	}

	protected function initCategories() {
		$categories = $this->wg->VideosModuleCategories;

		if ( empty( $categories ) ) {
			return;
		}

		if ( !is_array( $categories ) ) {
			$categories = [ $categories ];
		}

		$this->categories = $this->transformCatNames( $categories );
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

		$params['sort'] = $this->sort;
		$params['category'] = $this->categories;

		return $params;
	}

	public function getCacheKey() {
		$cacheKey = parent::getCacheKey();

		$category = $this->categories;

		sort( $category );
		$hashCategory = md5( json_encode( $category ) );

		return implode( ':', $cacheKey, $hashCategory, $this->sort );
	}

	/**
	 * Get the list of category based videos
	 * @return array
	 */
	public function getModuleVideos() {
		$this->addVideosFromVideoWiki( $this->categories, $this->limit, $this->sort );

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