<?php

namespace VideosModule;

/**
 * Class VideosModuleVertical
 * category.
 */
class Vertical extends Base {

	const SOURCE = 'wiki-vertical';

	// list of page categories for premium videos [ array( categoryId => name ) ]
	protected static $pageCategories = [
		\WikiFactoryHub::CATEGORY_ID_GAMING        => 'Games',
		\WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT => 'Entertainment',
		\WikiFactoryHub::CATEGORY_ID_LIFESTYLE     => 'Lifestyle',
	];

	public function __construct( $userRegion, $sort = '' ) {
		parent::__construct( $userRegion, $sort );

		$this->initCategories();
	}

	/**
	 * Get wiki vertical
	 *
	 * @return string - wiki vertical
	 */
	protected function initCategories() {
		$name = '';

		$categoryId = \WikiFactoryHub::getInstance()->getCategoryId( $this->wg->CityId );
		if ( !empty( $categoryId ) ) {
			// get vertical id
			$verticalId = \HubService::getCanonicalCategoryId( $categoryId );

			if ( array_key_exists( $verticalId, self::$pageCategories ) ) {
				$name = self::$pageCategories[$verticalId];
			}
		}

		$this->categories = $name;
	}

	public function getCacheKey() {
		$cacheKey = parent::getCacheKey();

		$category = $this->categories;

		sort( $category );
		$hashCategory = md5( json_encode( $category ) );

		return implode( ':', $cacheKey, $hashCategory, $this->sort );
	}

	/**
	 * Get videos from the Video wiki that are in this wiki's vertical category
	 *
	 * @return array - list of vertical videos (premium videos)
	 */
	public function getModuleVideos() {
		$videos = $this->getVideoListFromVideoWiki( $this->categories, $this->limit, $this->sort );

		return $videos;
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
