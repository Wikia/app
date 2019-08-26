<?php

class TaxonomyCategoryListing {

	public function getCategoryListing() {
		global $wgCityId;
		$memcacheKey = wfMemcKey(__METHOD__, $wgCityId);

		return WikiaDataAccess::cache(
			$memcacheKey,
			WikiaResponse::CACHE_STANDARD,
			function() {
				$db = wfGetDB(DB_SLAVE);
				$res = $db->select(
					['categorylinks', 'page'],
					['cl_to as category', 'count(*) as num_pages'],
					[
						'page_namespace' => 0,
						'page_is_redirect' => 0,
					],
					__METHOD__,
					[
						'ORDER BY' => 'num_pages desc',
						'GROUP BY' => 'category'
					],
					['page' => ['join', ['cl_from=page_id']]]
				);

				$categories = [];
				foreach ($res as $row) {
					$categories[$row->category] = $row->num_pages;
				}

				return $categories;
			}
		);
	}
}
