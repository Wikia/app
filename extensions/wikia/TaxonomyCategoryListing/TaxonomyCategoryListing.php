<?php

class TaxonomyCategoryListing {

	const NO_MIN_PAGES = 0;
	const NO_LIMIT = 0;

	public function getCategoryListing($minRequiredPages = self::NO_MIN_PAGES, $maxResult = self::NO_LIMIT) {
		global $wgCityId;

		$minRequiredPages = intval($minRequiredPages);
		$maxResult = intval($maxResult);
		$memcacheKey = wfMemcKey(__METHOD__, $wgCityId, $minRequiredPages, $maxResult);

		$options = [
			'ORDER BY' => 'num_pages desc',
			'GROUP BY' => 'category'
		];
		if ($maxResult !== self::NO_LIMIT && $maxResult > 0) {
			$options['LIMIT'] = $maxResult;
		}
		if ($minRequiredPages !== self::NO_MIN_PAGES && $minRequiredPages > 0) {
			$options['HAVING'] = "num_pages >= ${minRequiredPages}";
		}

		return WikiaDataAccess::cache(
			$memcacheKey,
			WikiaResponse::CACHE_STANDARD,
			function() use ($options) {
				$db = wfGetDB(DB_SLAVE);
				$res = $db->select(
					['categorylinks', 'page'],
					['cl_to as category', 'count(*) as num_pages'],
					[
						'page_namespace' => 0,
						'page_is_redirect' => 0,
					],
					__METHOD__,
					$options,
					['page' => ['join', ['cl_from=page_id']]]
				);

				$categories = [];
				foreach ($res as $row) {
					$categories[$row->category] = intval($row->num_pages);
				}

				return $categories;
			},
			WikiaDataAccess::REFRESH_CACHE
		);
	}
}
