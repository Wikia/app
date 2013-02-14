<?php

/**
 * Controller to pull WAM data
 *
 * @author Sebastian Marzjan
 */

class WAMApiController extends WikiaApiController {
	const DEFAULT_PAGE_SIZE = 20;
	const MAX_PAGE_SIZE = 20;
	const DEFAULT_AVATAR_SIZE = 28;
	const DEFAULT_WIKI_IMAGE_SIZE = 150;
	const DEFAULT_WIKI_ADMINS_LIMIT = 5;

	/**
	 * A method to get WAM index (list of wikis with their WAM ranks)
	 *
	 * @requestParam integer $wam_day [OPTIONAL] day for which the WAM scores are displayed. Defaults to yesterday
	 * @requestParam integer $wam_previous_day [OPTIONAL] day from which the difference in WAM scores is calculated.
	 *                             Defaults to day before yesterday
	 * @requestParam integer $vertical_id [OPTIONAL] vertical for which wiki list is to be pulled. By default pulls
	 *                             major verticals (2,3,9 - Gaming, Entertainment, Lifestyle)
	 * @requestParam integer $wiki_lang [OPTIONAL] Language code if narrowing the results to specific language. Defaults to null
	 * @requestParam integer $wiki_id [OPTIONAL] Id of specific wiki to pull. Defaults to null
	 * @requestParam string $wiki_word [OPTIONAL] Fragment of url or name to search for amongst wikis. Defaults to null
	 * @requestParam boolean $fetch_admins [OPTIONAL] Determines if admins of each wiki are to be returned. Defaults to false
	 * @requestParam integer $avatar_size [OPTIONAL] Size of admin avatars in pixels if fetch_admins is enabled
	 * @requestParam boolean $fetch_wiki_images [OPTIONAL] Determines if image of each wiki isto be returned. Defaults to false
	 * @requestParam integer $wiki_image_size [OPTIONAL] Width of wiki image in pixels if fetch_wiki_images is enabled
	 * @requestParam string $sort_column [OPTIONAL] Column by which to sort. Allowed values: wam_rank, wam_change. Defaults to WAM score (wam)
	 * @requestParam string $sort_direction [OPTIONAL] Either ASC or DESC. Defaults to ASC
	 * @requestParam integer $offset [OPTIONAL] offset from the beginning of data. Defaults to 0
	 * @requestParam integer $limit [OPTIONAL] limit on fetched number of wikis. Defaults to 20, max 20
	 *
	 * @responseParam array $wam_index The result list of wikis
	 * @responseParam array $wam_results_total The total count of wikis available for provided params
	 */
	public function getWAMIndex () {
		$currentTimestamp = $this->request->getVal('wam_day', strtotime('00:00 -2 day'));
		$previousTimestamp = $this->request->getVal('wam_previous_day', strtotime('00:00 -3 day'));
		$verticalId = $this->request->getVal('vertical_id', null);
		$wikiLang = $this->request->getVal('wiki_lang', null);
		$wikiId = $this->request->getVal('wiki_id', null);
		$wikiWord = $this->request->getVal('wiki_word', null);
		$fetchAdmins = $this->request->getVal('fetch_admins', false);
		$avatarSize = $this->request->getVal('avatar_size', self::DEFAULT_AVATAR_SIZE);
		$fetchWikiImages = $this->request->getVal('fetch_wiki_images', false);
		$wikiImageSize = $this->request->getVal('wiki_image_size', self::DEFAULT_WIKI_IMAGE_SIZE);
		$sortColumn = $this->request->getVal('sort_column', 'wam_rank');
		$sortDirection = $this->request->getVal('sort_direction', 'ASC');
		$offset = $this->request->getVal('offset', 0);
		$limit = min(self::MAX_PAGE_SIZE, $this->request->getVal('limit', self::DEFAULT_PAGE_SIZE));

		$wamIndex = WikiaDataAccess::cacheWithLock(
			F::app()->wf->SharedMemcKey('wam_index_table', $currentTimestamp, $previousTimestamp, $verticalId, $wikiLang, $wikiId, $wikiWord, $fetchAdmins, $avatarSize, $fetchWikiImages, $wikiImageSize, $sortColumn, $sortDirection, $offset, $limit),
			6 * 60 * 60,
			function () use ($currentTimestamp, $previousTimestamp, $verticalId, $wikiLang, $wikiId, $wikiWord, $fetchAdmins, $avatarSize, $fetchWikiImages, $wikiImageSize, $sortColumn, $sortDirection, $offset, $limit) {
				$wamService = new WAMService();

				$wamIndex = $wamService->getWamIndex($currentTimestamp, $previousTimestamp, $verticalId, $wikiLang, $wikiId, $wikiWord, $sortColumn, $sortDirection, $offset, $limit);

				if ($fetchAdmins) {
					if (empty($wikiService)) {
						$wikiService = new WikiService();
					}
					foreach ($wamIndex['wam_index'] as &$row) {
						$row['admins'] = $wikiService->getWikiAdmins($row['wiki_id'], $avatarSize, self::DEFAULT_WIKI_ADMINS_LIMIT);
					}
				}
				if ($fetchWikiImages) {
					if (empty($wikiService)) {
						$wikiService = new WikiService();
					}
					$images = $wikiService->getWikiImages(array_keys($wamIndex), $wikiImageSize);
					foreach ($wamIndex['wam_index'] as $wiki_id => &$wiki) {
						$wiki['wiki_image'] = (!empty($images[$wiki_id])) ? $images[$wiki_id] : $this->wg->blankImgUrl;
					}
				}

				return $wamIndex;
			}
		);

		$this->response->setVal('wam_index', $wamIndex['wam_index']);
		$this->response->setVal('wam_results_total', $wamIndex['wam_results_total']);
		$this->response->setCacheValidity(
			6 * 60 * 60 /* 6h */,
			6 * 60 * 60 /* 6h */,
			array(
				WikiaResponse::CACHE_TARGET_BROWSER,
				WikiaResponse::CACHE_TARGET_VARNISH
			)
		);

	}
}