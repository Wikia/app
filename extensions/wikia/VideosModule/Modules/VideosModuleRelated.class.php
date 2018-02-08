<?php

namespace VideosModule\Modules;

/**
 * Class Related
 *
 * Use WikiaSearchController to find premium videos related to the local wiki. (Search video content by wiki topics)
 *
 * @package VideosModule\Modules
 */
class Related extends Base {

	public function getSource() {
		return 'wiki-topics';
	}

	/**
	 * @return array - Premium videos related to the local wiki.
	 */
	public function getModuleVideos() {
		return [];
	}

	public function getCacheKey() {
		$cacheKey = parent::getCacheKey();

		return $cacheKey . ':' . $this->wg->DBname;
	}
}

