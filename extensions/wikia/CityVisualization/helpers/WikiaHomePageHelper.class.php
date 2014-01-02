<?php

/**
 * WikiaHomePage Helper
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Hyun Lim
 * @author Marcin Maciejewski
 * @author Saipetch Kongkatong
 * @author Sebastian Marzjan
 *
 */
class WikiaHomePageHelper extends WikiaModel {

	const VIDEO_GAMES_SLOTS_VAR_NAME = 'wgWikiaHomePageVideoGamesSlots';
	const ENTERTAINMENT_SLOTS_VAR_NAME = 'wgWikiaHomePageEntertainmentSlots';
	const LIFESTYLE_SLOTS_VAR_NAME = 'wgWikiaHomePageLifestyleSlots';
	const HOT_WIKI_SLOTS_VAR_NAME = 'wgWikiaHomePageHotWikiSlots';
	const NEW_WIKI_SLOTS_VAR_NAME = 'wgWikiaHomePageNewWikiSlots';
	const SLOTS_IN_TOTAL = 17;

	const SLOTS_BIG = 2;
	const SLOTS_MEDIUM = 1;
	const SLOTS_SMALL = 14;

	const SLOTS_BIG_ARRAY_KEY = 'bigslots';
	const SLOTS_MEDIUM_ARRAY_KEY = 'mediumslots';
	const SLOTS_SMALL_ARRAY_KEY = 'smallslots';

	const LIMIT_ADMIN_AVATARS = 3;
	const LIMIT_TOP_EDITOR_AVATARS = 7;

	const AVATAR_SIZE = 28;
	const ADMIN_UPLOAD_IMAGE_WIDTH = 320;
	const ADMIN_UPLOAD_IMAGE_HEIGHT = 320;
	const INTERSTITIAL_LARGE_IMAGE_WIDTH = 480;
	const INTERSTITIAL_LARGE_IMAGE_HEIGHT = 320;
	const INTERSTITIAL_SMALL_IMAGE_WIDTH = 115;
	const INTERSTITIAL_SMALL_IMAGE_HEIGHT = 65;

	const FAILSAFE_COMMUNITIES_COUNT = 280000;
	const FAILSAFE_NEW_COMMUNITIES_COUNT = 200;

	const WAM_SCORE_ROUND_PRECISION = 2;

	const SLIDER_IMAGES_KEY = 'SliderImagesKey';
	const WIKIA_HOME_PAGE_HELPER_MEMC_VERSION = 'v0.7';

	protected $visualizationModel = null;
	protected $collectionsModel;

	public function getNumberOfEntertainmentSlots($lang) {
		return $this->getVarFromWikiFactory($this->getCorpWikiIdByLang($lang), self::ENTERTAINMENT_SLOTS_VAR_NAME);
	}

	public function getNumberOfLifestyleSlots($lang) {
		return $this->getVarFromWikiFactory($this->getCorpWikiIdByLang($lang), self::LIFESTYLE_SLOTS_VAR_NAME);
	}

	public function getNumberOfVideoGamesSlots($lang) {
		return $this->getVarFromWikiFactory($this->getCorpWikiIdByLang($lang), self::VIDEO_GAMES_SLOTS_VAR_NAME);
	}

	public function getNumberOfHotWikiSlots($lang) {
		return $this->getVarFromWikiFactory($this->getCorpWikiIdByLang($lang), self::HOT_WIKI_SLOTS_VAR_NAME);
	}

	public function getNumberOfNewWikiSlots($lang) {
		return $this->getVarFromWikiFactory($this->getCorpWikiIdByLang($lang), self::NEW_WIKI_SLOTS_VAR_NAME);
	}

	public function getNumberOfSlotsForType($wikiId, $slotTypeName) {
		switch ($slotTypeName) {
			case 'entertainment':
				$slots = $this->getNumberOfEntertainmentSlots($wikiId);
				break;
			case 'video games':
				$slots = $this->getNumberOfVideoGamesSlots($wikiId);
				break;
			case 'lifestyle':
				$slots = $this->getNumberOfLifestyleSlots($wikiId);
				break;
			case 'hot':
				$slots = $this->getNumberOfHotWikiSlots($wikiId);
				break;
			case 'new':
				$slots = $this->getNumberOfNewWikiSlots($wikiId);
				break;
			default:
				$slots = 0;
				break;
		}

		return $slots;
	}

	/**
	 * @param string $lang corporate page language
	 * @return int
	 */
	protected function getCorpWikiIdByLang($lang) {
		return $this->getVisualization()->getTargetWikiId($lang);
	}

	/**
	 * @return CityVisualization
	 */
	protected function getVisualization() {
		if (empty($this->visualizationModel)) {
			$this->visualizationModel = new CityVisualization();
		}
		return $this->visualizationModel;
	}

	/**
	 * @return WikiaCollectionsModel
	 */
	protected function getCollectionsModel() {
		if (empty($this->collectionsModel)) {
			$this->collectionsModel = new WikiaCollectionsModel();
		}
		return $this->collectionsModel;
	}


	/**
	 * @desc Returns WikiFactory variable's value if not found returns 0 and adds information to logs
	 *
	 * @param String $varName variable name in WikiFactory
	 * @return int
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function getVarFromWikiFactory($wikiId, $varName) {
		wfProfileIn(__METHOD__);
		$value = WikiFactory::getVarValueByName($varName, $wikiId);

		if (is_null($value) || $value === false) {
			Wikia::log(__METHOD__, false, "Variable's value not found in WikiFactory returning 0");
			wfProfileOut(__METHOD__);
			return 0;
		}

		wfProfileOut(__METHOD__);
		return $value;
	}

	public function setWikiFactoryVar($wikiId, $wfVar, $wfVarValue) {
		return WikiFactory::setVarByName($wfVar, $wikiId, $wfVarValue, wfMsg('wikia-hone-page-special-wikis-in-slots-change-reason'));
	}

	/**
	 * get unique visitors last 30 days (exclude today)
	 * @return integer edits
	 */
	public function getVisitors() {
		wfProfileIn(__METHOD__);

		$visitors = 0;
		$dates = array(date('Y-m-01', strtotime('-1 month')), date('Y-m-01', strtotime('now')));
		$pageviews = DataMartService::getSumPageviewsMonthly($dates);
		if (empty($pageviews)) {
			foreach ($pageviews as $date => $pviews) {
				$visitors += $pviews;
			}
		}

		wfProfileOut(__METHOD__);

		return $visitors;
	}

	/**
	 * get number of edits made the day before yesterday
	 * @return integer edits
	 */
	public function getEdits() {
		wfProfileIn(__METHOD__);

		$edits = 0;
		if (!empty($this->wg->StatsDBEnabled)) {
			$db = wfGetDB(DB_SLAVE, array(), $this->wg->StatsDB);

			$row = $db->selectRow(
				array('events'),
				array('count(*) cnt'),
				array('event_date between curdate() - interval 2 day and curdate() - interval 1 day'),
				__METHOD__
			);

			if ($row) {
				$edits = intval($row->cnt);
			}
		}

		wfProfileOut(__METHOD__);

		return $edits;
	}

	public function getTotalCommunities() {
		return WikiaDataAccess::cache(
			wfMemcKey('total_communities_count', self::WIKIA_HOME_PAGE_HELPER_MEMC_VERSION, __METHOD__),
			24 * 60 * 60,
			array($this, 'getTotalCommunitiesFromDB')
		);
	}


	public function getTotalCommunitiesFromDB() {
		wfProfileIn(__METHOD__);
		$db = wfGetDB(DB_SLAVE, array(), $this->wg->externalSharedDB);
		$row = $db->selectRow(
			array('city_list'),
			array('count(1) cnt'),
			array('city_public = 1 AND city_created < DATE(NOW())'),
			__METHOD__
		);

		$communities = self::FAILSAFE_COMMUNITIES_COUNT;
		if ($row) {
			$communities = intval($row->cnt);
		}
		wfProfileOut(__METHOD__);
		return $communities;
	}

	public function getLastDaysNewCommunities() {
		return WikiaDataAccess::cache(
			wfMemcKey('communities_created_in_range', self::WIKIA_HOME_PAGE_HELPER_MEMC_VERSION, __METHOD__),
			24 * 60 * 60,
			array($this, 'getLastDaysNewCommunitiesFromDB')
		);
	}

	public function getLastDaysNewCommunitiesFromDB() {
		$today = strtotime('00:00:00');
		$yesterday = strtotime('-1 day', $today);
		return $this->getNewCommunitiesInRangeFromDB($yesterday, $today);
	}

	protected function getNewCommunitiesInRangeFromDB($starttimestamp, $endtimestamp) {
		wfProfileIn(__METHOD__);
		$db = wfGetDB(DB_SLAVE, array(), $this->wg->externalSharedDB);
		$row = $db->selectRow(
			array('city_list'),
			array('count(1) cnt'),
			array(
				'city_public' => 1,
				'city_created >= FROM_UNIXTIME(' . $starttimestamp . ')',
				'city_created < FROM_UNIXTIME(' . $endtimestamp . ')'
			),
			__METHOD__
		);

		$newCommunities = 0;
		if ($row) {
			$newCommunities = intval($row->cnt);
		}
		if ($newCommunities < self::FAILSAFE_NEW_COMMUNITIES_COUNT) {
			$newCommunities = self::FAILSAFE_NEW_COMMUNITIES_COUNT;
		}
		wfProfileOut(__METHOD__);
		return $newCommunities;
	}


	/**
	 * get stats from article
	 * @param string $articleName
	 * @return integer stats
	 */
	public function getStatsFromArticle($articleName) {
		wfProfileIn(__METHOD__);

		$title = Title::newFromText($articleName);
		$article = new Article($title);
		$content = $article->getRawText();
		$stats = (empty($content)) ? 0 : $content;

		wfProfileOut(__METHOD__);

		return intval($stats);
	}

	/**
	 * get total number of pages across Wikia
	 * @return integer totalPages
	 */
	public function getTotalPages() {
		wfProfileIn(__METHOD__);

		$totalPages = 0;
		if (!empty($this->wg->StatsDBEnabled)) {
			$db = wfGetDB(DB_SLAVE, array(), $this->wg->StatsDB);

			$row = $db->selectRow(
				array('wikia_monthly_stats'),
				array('sum(articles) cnt'),
				array("stats_date = date_format(curdate(),'%Y%m')"),
				__METHOD__
			);

			if ($row) {
				$totalPages = $row->cnt;
			}
		}

		wfProfileOut(__METHOD__);

		return $totalPages;
	}

	/**
	 * get wiki stats ( pages, images, videos, users )
	 * @param integer $wikiId
	 * @return array wikiStats
	 */
	public function getWikiStats($wikiId) {
		$wikiStats = array();

		if (!empty($wikiId)) {
			$wikiService = new WikiService();

			try {
				//this try-catch block is here because of devbox environments
				//where we don't have all wikis imported
				$sitestats = $wikiService->getSiteStats($wikiId);
				$videos = $wikiService->getTotalVideos($wikiId);
			} catch (Exception $e) {
				$sitestats = array(
					'articles' => 0,
					'pages' => 0,
					'images' => 0,
					'users' => 0,
				);
				$videos = 0;
			}

			$wikiStats = array(
				'articles' => intval($sitestats['articles']),
				'pages' => intval($sitestats['pages']),
				'images' => intval($sitestats['images']),
				'videos' => $videos,
				'users' => intval($sitestats['users']),
			);
		}

		return $wikiStats;
	}

	/**
	 * get avatars for wiki admins
	 * @param integer $wikiId
	 * @return array wikiAdminAvatars
	 */
	public function getWikiAdminAvatars($wikiId) {
		$adminAvatars = array();
		if (!empty($wikiId)) {
			$wikiService = new WikiService();
			try {
				//this try-catch block is here because of devbox environments
				//where we don't have all wikis imported
				$adminAvatars = $wikiService->getMostActiveAdmins($wikiId, self::AVATAR_SIZE);
				if( count($adminAvatars) > self::LIMIT_ADMIN_AVATARS ) {
					$adminAvatars = array_slice( $adminAvatars, 0, self::LIMIT_ADMIN_AVATARS );
				}
				foreach( $adminAvatars as &$admin ) {
					$userStatService = new UserStatsService($admin['userId']);
					$admin['edits'] = $userStatService->getEditCountWiki($wikiId);
				}
			} catch (Exception $e) {
				$adminAvatars = array();
			}
		}

		return $adminAvatars;
	}

	/**
	 * get list of top editor info ( name, avatarUrl, userPageUrl, edits )
	 * @param integer $wikiId
	 * @return array $topEditorAvatars
	 */
	public function getWikiTopEditorAvatars($wikiId) {
		$topEditorAvatars = array();

		if (!empty($wikiId)) {
			$wikiService = new WikiService();
			try {
				//this try-catch block is here because of devbox environments
				//where we don't have all wikis imported
				$topEditors = $wikiService->getTopEditors($wikiId, 100, true);
			} catch (Exception $e) {
				$topEditors = array();
			}

			foreach ($topEditors as $userId => $edits) {
				$userInfo = $wikiService->getUserInfo($userId, $wikiId, self::AVATAR_SIZE, array($this,'isValidUserForInterstitial'));

				if (!empty($userInfo)) {
					$userInfo['edits'] = $edits;
					if (!empty($topEditorAvatars[$userInfo['name']])) {
						$userInfo['edits'] += $topEditorAvatars[$userInfo['name']]['edits'];
					}

					$topEditorAvatars[$userInfo['name']] = $userInfo;
					if (count($topEditorAvatars) >= self::LIMIT_TOP_EDITOR_AVATARS) {
						break;
					}
				}
			}
		}

		return $topEditorAvatars;
	}



	/**
	 * @desc Returns true if user isn't: an IP address, excluded from interstitial, bot, blocked locally and globally
	 *
	 * @param User $user
	 * @return bool
	 */
	public function isValidUserForInterstitial(User $user) {
		$userId = $user->getId();
		$userName = $user->getName();

		return (
			!$user->isIP($userName)
				&& !in_array($userId, WikiService::$excludedWikiaUsers)
				&& !in_array('bot', $user->getRights())
				&& !$user->isBlocked()
				&& !$user->isBlockedGlobally()
		);
	}

	public function getWikiInfoForSpecialPromote($wikiId, $langCode) {
		wfProfileIn(__METHOD__);

		$dataGetter = new WikiDataGetterForSpecialPromote();
		$wikiInfo = $this->getWikiInfo($wikiId, $langCode, $dataGetter);

		wfProfileOut(__METHOD__);
		return $wikiInfo;
	}

	public function getWikiInfoForVisualization($wikiId, $langCode) {
		wfProfileIn(__METHOD__);

		$dataGetter = new WikiDataGetterForVisualization();
		$wikiInfo = $this->getWikiInfo($wikiId, $langCode, $dataGetter);

		wfProfileOut(__METHOD__);

		return $wikiInfo;
	}


	/**
	 * get wiki info ( wikiname, description, url, status, images )
	 * @param integer $wikiId
	 * @param string $langCode
	 * @param WikiDataGetter $dataGetter
	 * @return array wikiInfo
	 */
	public function getWikiInfo($wikiId, $langCode, WikiDataGetter $dataGetter) {
		wfProfileIn(__METHOD__);

		$wikiInfo = array(
			'name' => '',
			'headline' => '',
			'description' => '',
			'url' => '',
			'new' => 0,
			'hot' => 0,
			'official' => 0,
			'promoted' => 0,
			'blocked' => 0,
			'images' => array(),
		);

		if (!empty($wikiId)) {
			$wiki = WikiFactory::getWikiById($wikiId);
			if (!empty($wiki)) {
				$wikiInfo['url'] = $wiki->city_url . '?redirect=no';
			}

			$wikiData = $dataGetter->getWikiData($wikiId, $langCode);

			if (!empty($wikiData)) {
				$wikiInfo['name'] = $wikiData['name'];
				$wikiInfo['headline'] = $wikiData['headline'];
				$wikiInfo['description'] = $wikiData['description'];

				// wiki status
				$wikiInfo['new'] = intval(CityVisualization::isNewWiki($wikiData['flags']));
				$wikiInfo['hot'] = intval(CityVisualization::isHotWiki($wikiData['flags']));
				$wikiInfo['official'] = intval(CityVisualization::isOfficialWiki($wikiData['flags']));
				$wikiInfo['promoted'] = intval(CityVisualization::isPromotedWiki($wikiData['flags']));
				$wikiInfo['blocked'] = intval(CityVisualization::isBlockedWiki($wikiData['flags']));

				$wikiInfo['images'] = array();
				if (!empty($wikiData['main_image'])) {
					$wikiInfo['images'][] = $wikiData['main_image'];
				}

				$wikiData['images'] = (!empty($wikiData['images'])) ? ((array)$wikiData['images']) : array();

				// wiki images
				if (!empty($wikiData['images'])) {
					$wikiInfo['images'] = array_merge($wikiInfo['images'], $wikiData['images']);
				}
			}
		}

		wfProfileOut(__METHOD__);

		return $wikiInfo;
	}

	public function isWikiBlocked($wikiId, $langCode) {
		$visualization = $this->getVisualization();
		$flags = $this->getFlag($wikiId, $langCode);
		return $visualization->isBlockedWiki($flags);
	}

	public function getImageDataForSlider($wikiId, $imageName) {
		$newFilesUrl = $this->getNewFilesUrl($wikiId);
		$imageData = $this->getImageData($imageName);
		$imageData['href'] = $newFilesUrl;

		return $imageData;
	}

	protected function getNewFilesUrl($wikiId) {
		$globalNewFilesTitle = GlobalTitle::newFromText('NewFiles', NS_SPECIAL, $wikiId);
		if ($globalNewFilesTitle instanceof Title) {
			$newFilesUrl = $globalNewFilesTitle->getFullURL();
			return $newFilesUrl;
		} else {
			$newFilesUrl = '#';
			return $newFilesUrl;
		}
	}

	public function getImageData($imageName, $width = null, $height = null, $thumbWidth = null, $thumbHeight = null) {
		$requestedWidth = !empty($width) ? $width : self::INTERSTITIAL_LARGE_IMAGE_WIDTH;
		$requestedHeight = !empty($height) ? $height : self::INTERSTITIAL_LARGE_IMAGE_HEIGHT;
		$requestedThumbWidth = !empty($thumbWidth) ? $thumbWidth : self::INTERSTITIAL_SMALL_IMAGE_WIDTH;
		$requestedThumbHeight = !empty($thumbHeight) ? $thumbHeight : self::INTERSTITIAL_SMALL_IMAGE_HEIGHT;

		$imageUrl = $this->getImageUrl($imageName, $requestedWidth, $requestedHeight);
		$thumbImageUrl = $this->getImageUrl($imageName, $requestedThumbWidth, $requestedThumbHeight);

		$imageId = $this->getImagesArticleId($imageName);
		$reviewStatus = $this->getImageReviewStatus($imageId);

		return array(
			'href' => '',
			'image_url' => $imageUrl,
			'thumb_url' => $thumbImageUrl,
			'image_filename' => $imageName,
			'review_status' => $reviewStatus,
			'user_href' => '',
			'links' => array(),
			'isVideoThumb' => false,
			'date' => '',
		);
	}

	public function getImageUrl($imageName, $requestedWidth, $requestedHeight) {
		wfProfileIn(__METHOD__);
		$imageUrl = '';

		if (!empty($imageName)) {
			if (strpos($imageName, '%') !== false) {
				$imageName = urldecode($imageName);
			}

			$title = Title::newFromText($imageName, NS_IMAGE);
			$file = wfFindFile($title);

			$imageUrl = ImagesService::overrideThumbnailFormat(
				$this->getImageUrlFromFile($file, $requestedWidth, $requestedHeight),
				ImagesService::EXT_JPG
			);
		}

		wfProfileOut(__METHOD__);
		return $imageUrl;
	}

	public function getImageUrlFromFile($file, $requestedWidth, $requestedHeight) {
		wfProfileIn(__METHOD__);
		if ($file instanceof File && $file->exists()) {
			$originalWidth = $file->getWidth();
			$originalHeight = $file->getHeight();
		}

		if (!empty($originalHeight) && !empty($originalWidth)) {
			$imageServing = $this->getImageServingForResize($requestedWidth, $requestedHeight, $originalWidth, $originalHeight);
			$imageUrl = $imageServing->getUrl($file, $originalWidth, $originalHeight);
		} else {
			$imageUrl = $this->wg->blankImgUrl;
		}
		wfProfileOut(__METHOD__);
		return $imageUrl;
	}

	protected function getImageReviewStatus($imageId) {
		wfProfileIn(__METHOD__);
		$reviewStatus = false;

		$rowAssigner = new WikiImageReviewStatusRowHelper();
		if ($imageId > 0) {
			$reviewStatus = $this->getVisualization()->getImageReviewStatus($this->wg->CityId, $imageId, $rowAssigner);
		}

		wfProfileOut(__METHOD__);
		return $reviewStatus;
	}

	/**
	 * @param string $imageName image name
	 *
	 * @return int page_id or 0 if fails
	 */
	protected function getImagesArticleId($imageName) {
		wfProfileIn(__METHOD__);
		$imageId = 0;

		$imageTitle = Title::newFromText($imageName, NS_FILE);
		if ($imageTitle instanceof Title) {
			$imageId = $imageTitle->getArticleID();
		}

		wfProfileOut(__METHOD__);
		return $imageId;
	}

	public function getImageServingForResize($requestedWidth, $requestedHeight, $originalWidth, $originalHeight) {
		$params = $this->getImageServingParamsForResize($requestedWidth, $requestedHeight, $originalWidth, $originalHeight);
		return new ImageServing($params[0], $params[1], $params[2]);
	}

	public function getImageServingParamsForResize($requestedWidth, $requestedHeight, $originalWidth, $originalHeight) {
		$requestedRatio = $requestedWidth / $requestedHeight;
		$originalRatio = $originalWidth / $originalHeight;

		$requestedCropHeight = $requestedHeight;
		$requestedCropWidth = $requestedWidth;

		if ($originalHeight < $requestedHeight && $originalRatio > $requestedRatio) {
			// result should have more 'vertical' orientation, cropping left and right from original image;
			$requestedCropHeight = $originalHeight;
			$requestedCropWidth = ceil($requestedCropHeight * $requestedRatio);
			if ($requestedWidth >= $originalWidth && $requestedCropHeight == $originalHeight && $requestedRatio >= 1) {
				$requestedWidth = $requestedCropWidth;
			}
		}

		if ($originalWidth < $requestedWidth && $originalRatio < $requestedRatio) {
			// result should have more 'horizontal' orientation, cropping top and bottom from original image;
			$requestedWidth = $originalWidth;
			$requestedCropWidth = $originalWidth;
			$requestedCropHeight = ceil($requestedCropWidth / $requestedRatio);
		}

		$imageServingParams = array(
			null,
			ceil(min($originalWidth, $requestedWidth)),
			array(
				'w' => floor($requestedCropWidth),
				'h' => floor($requestedCropHeight)
			)
		);

		return $imageServingParams;
	}

	public function getWikiBatches($wikiId, $langCode, $numberOfBatches) {
		wfProfileIn(__METHOD__);

		$visualization = new CityVisualization();
		$batches = $visualization->getWikiBatches($wikiId, $langCode, $numberOfBatches);

		$out = array();
		if (!empty($batches)) {
			$out = $this->prepareBatchesForVisualization($batches);
		}

		wfProfileOut(__METHOD__);
		return $out;
	}

	public function prepareBatchesForVisualization($batches) {
		wfProfileIn(__METHOD__);

		$processedBatches = array();
		foreach ($batches as $batch) {
			$processedBatch = array(
				self::SLOTS_BIG_ARRAY_KEY => array(),
				self::SLOTS_MEDIUM_ARRAY_KEY => array(),
				self::SLOTS_SMALL_ARRAY_KEY => array()
			);

			if (!empty($batch[CityVisualization::PROMOTED_ARRAY_KEY])) {
				//if there are any promoted wikis they should go firstly to big&medium slots
				$promotedBatch = $batch[CityVisualization::PROMOTED_ARRAY_KEY];
			} else {
				$promotedBatch = [];
			}


			if (empty($batch[CityVisualization::DEMOTED_ARRAY_KEY])) {
				continue;
			} else {
				shuffle($batch[CityVisualization::DEMOTED_ARRAY_KEY]);
			}

			$biggerSlotsWikis = array_slice($promotedBatch, 0, self::SLOTS_BIG + self::SLOTS_MEDIUM);
			$promotedCount = count($biggerSlotsWikis);
			if ($promotedCount < self::SLOTS_BIG + self::SLOTS_MEDIUM) {
				$biggerSlotsWikis = array_merge(
					$biggerSlotsWikis,
					array_splice(
						$batch[CityVisualization::DEMOTED_ARRAY_KEY],
						0,
						self::SLOTS_BIG + self::SLOTS_MEDIUM - $promotedCount
					)
				);
			}
			shuffle($biggerSlotsWikis);
			$processedBatch[self::SLOTS_BIG_ARRAY_KEY] = array_splice($biggerSlotsWikis, 0, self::SLOTS_BIG);
			$processedBatch[self::SLOTS_MEDIUM_ARRAY_KEY] = array_splice($biggerSlotsWikis, 0, self::SLOTS_MEDIUM);
			$processedBatch[self::SLOTS_SMALL_ARRAY_KEY] = $batch[CityVisualization::DEMOTED_ARRAY_KEY];

			$processedBatch = $this->prepareWikisForVisualization($processedBatch);
			$processedBatches[] = $processedBatch;
		}

		wfProfileOut(__METHOD__);
		return $processedBatches;
	}

	private function prepareWikisForVisualization($batch) {
		foreach($batch as $slotName => &$wikis) {
			$size = $this->getProcessedWikisImgSizes($slotName);
			foreach($wikis as &$wiki) {
				if (!empty($wiki['image'])) {
					$wiki['main_image'] = $wiki['image'];
				}
				$wiki['image'] = ImagesService::overrideThumbnailFormat(
					$this->getImageUrl($wiki['main_image'], $size->width, $size->height),
					ImagesService::EXT_JPG
				);
				unset($wiki['main_image']);
			}
		}
		return $batch;
	}

	/**
	 * @desc Depends on given slots limit recognize which size it should return
	 * @param integer $limit one of constants of this class reprezenting amount of slots
	 * @return StdClass with width&height fields
	 */
	public function getProcessedWikisImgSizes($slotName) {
		$result = new StdClass;
		switch ($slotName) {
			case self::SLOTS_SMALL_ARRAY_KEY:
				$result->width = $this->getRemixSmallImgWidth();
				$result->height = $this->getRemixSmallImgHeight();
				break;
			case self::SLOTS_MEDIUM_ARRAY_KEY:
				$result->width = $this->getRemixMediumImgWidth();
				$result->height = $this->getRemixMediumImgHeight();
				break;
			case self::SLOTS_BIG_ARRAY_KEY:
			default:
				$result->width = $this->getRemixBigImgWidth();
				$result->height = $this->getRemixBigImgHeight();
				break;
		}

		return $result;
	}

	public function getRemixBigImgHeight() {
		if (!empty($this->wg->OasisGrid)) {
			return WikiaHomePageController::REMIX_GRID_IMG_BIG_HEIGHT;
		} else {
			return WikiaHomePageController::REMIX_IMG_BIG_HEIGHT;
		}
	}

	public function getRemixBigImgWidth() {
		if (!empty($this->wg->OasisGrid)) {
			return WikiaHomePageController::REMIX_GRID_IMG_BIG_WIDTH;
		} else {
			return WikiaHomePageController::REMIX_IMG_BIG_WIDTH;
		}
	}

	public function getRemixMediumImgHeight() {
		if (!empty($this->wg->OasisGrid)) {
			return WikiaHomePageController::REMIX_GRID_IMG_MEDIUM_HEIGHT;
		} else {
			return WikiaHomePageController::REMIX_IMG_MEDIUM_HEIGHT;
		}
	}

	public function getRemixMediumImgWidth() {
		if (!empty($this->wg->OasisGrid)) {
			return WikiaHomePageController::REMIX_GRID_IMG_BIG_WIDTH;
		} else {
			return WikiaHomePageController::REMIX_IMG_BIG_WIDTH;
		}
	}

	public function getRemixSmallImgHeight() {
		if (!empty($this->wg->OasisGrid)) {
			return WikiaHomePageController::REMIX_GRID_IMG_SMALL_HEIGHT;
		} else {
			return WikiaHomePageController::REMIX_IMG_SMALL_HEIGHT;
		}
	}

	public function getRemixSmallImgWidth() {
		if (!empty($this->wg->OasisGrid)) {
			return WikiaHomePageController::REMIX_GRID_IMG_SMALL_WIDTH;
		} else {
			return WikiaHomePageController::REMIX_IMG_SMALL_WIDTH;
		}
	}

	public function setFlag($wikiId, $flag, $corpWikiId, $langCode) {
		wfProfileIn(__METHOD__);

		/* @var $visualization CityVisualization */
		$visualization = new CityVisualization();
		$result = $visualization->setFlag($wikiId, $langCode, $flag);

		if ($result === true) {
			//purge cache
			//wiki cache
			$visualization->getList($corpWikiId, $langCode, true);
			$memcKey = $visualization->getWikiDataCacheKey($visualization->getTargetWikiId($langCode), $wikiId, $langCode);
			$this->wg->Memc->set($memcKey, null);

			//visualization list cache
			$visualization->purgeVisualizationWikisListCache($corpWikiId, $langCode);

			wfProfileOut(__METHOD__);
			return true;
		}

		wfProfileOut(__METHOD__);
		return false;
	}

	public function getFlag($wikiId, $langCode) {
		$visualization = $this->getVisualization();
		$flags = $visualization->getFlag($wikiId, $langCode);
		return $flags;
	}

	public function removeFlag($wikiId, $flag, $corpWikiId, $langCode) {
		wfProfileIn(__METHOD__);

		/* @var $visualization CityVisualization */
		$visualization = new CityVisualization();
		$result = $visualization->removeFlag($wikiId, $langCode, $flag);

		if ($result === true) {
			//purge cache
			//wiki cache
			$visualization->getList($corpWikiId, $langCode, true);
			$memcKey = $visualization->getWikiDataCacheKey($visualization->getTargetWikiId($langCode), $wikiId, $langCode);
			$this->wg->Memc->set($memcKey, null);

			//visualization list cache
			$visualization->purgeVisualizationWikisListCache($corpWikiId, $langCode);

			wfProfileOut(__METHOD__);
			return true;
		}

		wfProfileOut(__METHOD__);
		return false;
	}

	public function getVisualizationWikisData() {
		return $this->getVisualization()->getVisualizationWikisData();
	}

	public function getWikisCountForStaffTool($options) {
		return $this->getVisualization()->getWikisCountForStaffTool($options);
	}

	public function getWikisForStaffTool($options) {
		$wikiList = $this->getVisualization()->getWikisForStaffTool($options);

		foreach ($wikiList as &$wiki) {
			$wiki->collections = $this->getCollectionsModel()->getCollectionsByCityId($wiki->city_id);
		}
		return $wikiList;
	}

	public function getWamScore($wikiId) {
		$wamScore = null;

		if( !empty($this->app->wg->DevelEnvironment) ) {
			$wamScore = $this->getMockedScoreForDev();
		} else {
			$wamData = $this->app->sendRequest('WAMApi', 'getWAMIndex', ['wiki_id' => $wikiId])->getData();
			if (!empty($wamData['wam_index'][$wikiId]['wam'])) {
				$wamScore = round($wamData['wam_index'][$wikiId]['wam'], self::WAM_SCORE_ROUND_PRECISION);
			}
		}
		return $wamScore;
	}

	private function getMockedScoreForDev() {
		if (rand(0, 3)) {
			$wam = rand(100, 9999) / 100;
		} else {
			$wam = null;
		}
		return $wam;
	}

}
