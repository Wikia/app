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
	const WIKIA_COM_ID = 80433;

	const LIMIT_ADMIN_AVATARS = 3;
	const LIMIT_TOP_EDITOR_AVATARS = 7;

	const AVATAR_SIZE = 28;
	const ADMIN_UPLOAD_IMAGE_WIDTH = 320;
	const ADMIN_UPLOAD_IMAGE_HEIGHT = 320;
	const INTERSTITIAL_LARGE_IMAGE_WIDTH = 480;
	const INTERSTITIAL_LARGE_IMAGE_HEIGHT = 320;
	const INTERSTITIAL_SMALL_IMAGE_WIDTH = 115;
	const INTERSTITIAL_SMALL_IMAGE_HEIGHT = 65;

	const SLIDER_IMAGES_KEY = 'SliderImagesKey';

	const WIKIA_HOME_PAGE_HELPER_MEMC_VERSION = 'v0.5.010.005';

	protected $excludeUsersFromInterstitial = array(
		'Wikia' => true,
	);

	public function getNumberOfEntertainmentSlots() {
		return $this->getVarFromWikiFactory(self::ENTERTAINMENT_SLOTS_VAR_NAME);
	}

	public function getNumberOfLifestyleSlots() {
		return $this->getVarFromWikiFactory(self::LIFESTYLE_SLOTS_VAR_NAME);
	}

	public function getNumberOfVideoGamesSlots() {
		return $this->getVarFromWikiFactory(self::VIDEO_GAMES_SLOTS_VAR_NAME);
	}

	public function getNumberOfHotWikiSlots() {
		return $this->getVarFromWikiFactory(self::HOT_WIKI_SLOTS_VAR_NAME);
	}

	public function getNumberOfNewWikiSlots() {
		return $this->getVarFromWikiFactory(self::NEW_WIKI_SLOTS_VAR_NAME);
	}

	public function getNumberOfSlotsForType($slotTypeName) {
		switch ($slotTypeName) {
			case 'entertainment':
				$slots = $this->getNumberOfEntertainmentSlots();
				break;
			case 'video games':
				$slots = $this->getNumberOfVideoGamesSlots();
				break;
			case 'lifestyle':
				$slots = $this->getNumberOfLifestyleSlots();
				break;
			case 'hot':
				$slots = $this->getNumberOfHotWikiSlots();
				break;
			case 'new':
				$slots = $this->getNumberOfNewWikiSlots();
				break;
			default:
				$slots = 0;
				break;
		}

		return $slots;
	}

	/**
	 * @desc Returns WikiFactory variable's value if not found returns 0 and adds information to logs
	 *
	 * @param String $varName variable name in WikiFactory
	 * @return int
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function getVarFromWikiFactory($varName) {
		$this->wf->ProfileIn(__METHOD__);
		$value = WikiFactory::getVarValueByName($varName, self::WIKIA_COM_ID);

		if (is_null($value) || $value === false) {
			Wikia::log(__METHOD__, false, "Variable's value not found in WikiFactory returning 0");
			$this->wf->ProfileOut(__METHOD__);
			return 0;
		}

		$this->wf->ProfileOut(__METHOD__);
		return $value;
	}

	public function setWikiFactoryVar($wfVar, $wfVarValue) {
		return WikiFactory::setVarByName($wfVar, self::WIKIA_COM_ID, $wfVarValue, wfMsg('wikia-hone-page-special-wikis-in-slots-change-reason'));
	}

	/**
	 * get unique visitors last 30 days (exclude today)
	 * @return integer edits
	 */
	public function getVisitors() {
		$this->wf->ProfileIn(__METHOD__);

		$visitors = 0;
		if (!empty($this->wg->StatsDBEnabled)) {
			$db = $this->wf->GetDB(DB_SLAVE, array(), $this->wg->StatsDB);

			// for testing
			if ($this->wg->DevelEnvironment) {
				$row = $db->selectRow(
					array('page_views'),
					array('sum(pv_views) cnt'),
					array("pv_use_date between date_format(curdate() - interval 30 day,'%Y%m%d') and date_format(curdate(),'%Y%m%d')"),
					__METHOD__
				);
			} else {
				$row = $db->selectRow(
					array('google_analytics.pageviews'),
					array('sum(pageviews) cnt'),
					array("date between curdate() - interval 30 day and curdate()"),
					__METHOD__
				);
			}

			if ($row) {
				$visitors = intval($row->cnt);
			}
		}

		$this->wf->ProfileOut(__METHOD__);

		return $visitors;
	}

	/**
	 * get number of edits made the day before yesterday
	 * @return integer edits
	 */
	public function getEdits() {
		$this->wf->ProfileIn(__METHOD__);

		$edits = 0;
		if (!empty($this->wg->StatsDBEnabled)) {
			$db = $this->wf->GetDB(DB_SLAVE, array(), $this->wg->StatsDB);

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

		$this->wf->ProfileOut(__METHOD__);

		return $edits;
	}

	/**
	 * get stats from article
	 * @param string articleName
	 * @return integer stats
	 */
	public function getStatsFromArticle($articleName) {
		$this->wf->ProfileIn(__METHOD__);

		$title = Title::newFromText($articleName);
		$article = new Article($title);
		$content = $article->getRawText();
		$stats = (empty($content)) ? 0 : $content;

		$this->wf->ProfileOut(__METHOD__);

		return intval($stats);
	}

	/**
	 * get total number of pages across Wikia
	 * @return integer totalPages
	 */
	public function getTotalPages() {
		$this->wf->ProfileIn(__METHOD__);

		$totalPages = 0;
		if (!empty($this->wg->StatsDBEnabled)) {
			$db = $this->wf->GetDB(DB_SLAVE, array(), $this->wg->StatsDB);

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

		$this->wf->ProfileOut(__METHOD__);

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
			$wikiService = F::build('WikiService');

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
			$wikiService = F::build('WikiService');
			try {
				//this try-catch block is here because of devbox environments
				//where we don't have all wikis imported
				$admins = $wikiService->getWikiAdminIds($wikiId);
				shuffle($admins);
			} catch (Exception $e) {
				$admins = array();
			}

			foreach ($admins as $userId) {
				$userInfo = $this->getUserInfo($userId, $wikiId);

				if (!empty($userInfo)) {
					$userInfo['edits'] = $wikiService->getUserEdits($userId, $wikiId);
					if (!empty($adminAvatars[$userInfo['name']])) {
						$userInfo['edits'] += $adminAvatars[$userInfo['name']]['edits'];
					}

					$adminAvatars[$userInfo['name']] = $userInfo;

					if (count($adminAvatars) >= self::LIMIT_ADMIN_AVATARS) {
						break;
					}
				}
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
			$wikiService = F::build('WikiService');
			try {
				//this try-catch block is here because of devbox environments
				//where we don't have all wikis imported
				$topEditors = $wikiService->getTopEditors($wikiId, 100);
			} catch (Exception $e) {
				$topEditors = array();
			}

			foreach ($topEditors as $userId => $edits) {
				$userInfo = $this->getUserInfo($userId, $wikiId);

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
	 * get user info ( user name, avatar url, user page url ) if the user has avatar
	 * @param integer $userId
	 * @return array userInfo
	 */
	public function getUserInfo($userId, $wikiId) {
		$userInfo = array();
		$user = F::build('User', array($userId), 'newFromId');


		if ($user instanceof User) {
			$username = $user->getName();

			if (!$user->isIP($username)
				&& empty($this->excludeUsersFromInterstitial[$username])
				&& !in_array('bot', $user->getRights())
			) {
				$userInfo['avatarUrl'] = F::build('AvatarService', array($user, self::AVATAR_SIZE), 'getAvatarUrl');
				$userInfo['edits'] = 0;
				$userInfo['name'] = $username;
				$userProfileTitle = F::build('GlobalTitle', array($username, NS_USER, $wikiId), 'newFromText');
				$userInfo['userPageUrl'] = ($userProfileTitle instanceof Title) ? $userProfileTitle->getFullURL() : '#';
				$userContributionsTitle = F::build('GlobalTitle', array('Contributions/' . $username, NS_SPECIAL, $wikiId), 'newFromText');
				$userInfo['userContributionsUrl'] = ($userContributionsTitle instanceof Title) ? $userContributionsTitle->getFullURL() : '#';

				$userStatsService = F::build('UserStatsService', array($userId));
				$stats = $userStatsService->getStats();

				$date = getdate(strtotime($stats['date']));
				$userInfo['since'] = F::App()->wg->Lang->getMonthAbbreviation($date['mon']) . ' ' . $date['year'];
			}
		}

		return $userInfo;
	}

	public function getWikiInfoForSpecialPromote($wikiId, $langCode) {
		$this->wf->ProfileIn(__METHOD__);

		$dataGetter = F::build('WikiDataGetterForSpecialPromote');
		return $this->getWikiInfo($wikiId,$langCode,$dataGetter);

		$this->wf->ProfileOut(__METHOD__);
	}

	public function getWikiInfoForVisualization($wikiId, $langCode) {
		$this->wf->ProfileIn(__METHOD__);

		$dataGetter = F::build('WikiDataGetterForVisualization');
		return $this->getWikiInfo($wikiId,$langCode,$dataGetter);

		$this->wf->ProfileOut(__METHOD__);
	}


	/**
	 * get wiki info ( wikiname, description, url, status, images )
	 * @param integer $wikiId
	 * @param string $langCode
	 * @param WikiDataGetter $dataGetter
	 * @return array wikiInfo
	 */
	public function getWikiInfo($wikiId, $langCode, WikiDataGetter $dataGetter) {
		$this->wf->ProfileIn(__METHOD__);


		$wikiInfo = array(
			'name' => '',
			'description' => '',
			'url' => '',
			'new' => 0,
			'hot' => 0,
			'promoted' => 0,
			'blocked' => 0,
			'images' => array(),
		);

		if (!empty($wikiId)) {
			$wiki = F::build('WikiFactory', array($wikiId), 'getWikiById');
			if (!empty($wiki)) {
				$wikiInfo['url'] = $wiki->city_url . '?redirect=no';
			}

			$wikiData = $dataGetter->getWikiData($wikiId, $langCode);

			if (!empty($wikiData)) {
				$wikiInfo['name'] = $wikiData['headline'];
				$wikiInfo['description'] = $wikiData['description'];

				// wiki status
				$wikiInfo['new'] = intval(CityVisualization::isNewWiki($wikiData['flags']));
				$wikiInfo['hot'] = intval(CityVisualization::isHotWiki($wikiData['flags']));
				$wikiInfo['promoted'] = intval(CityVisualization::isPromotedWiki($wikiData['flags']));
				$wikiInfo['blocked'] = intval(CityVisualization::isBlockedWiki($wikiData['flags']));

				$wikiInfo['images'] = array();
				if (!empty($wikiData['main_image'])) {
					$wikiInfo['images'][] = $wikiData['main_image'];
				}

				// wiki images
				if (!empty($wikiData['images'])) {
					$wikiInfo['images'] = array_merge($wikiInfo['images'], $wikiData['images']);
				}
			}
		}

		$this->wf->ProfileOut(__METHOD__);

		return $wikiInfo;
	}

	public function getImageDataForSlider($wikiId, $imageName) {
		$newFilesUrl = $this->getNewFilesUrl($wikiId);
		$imageData = $this->getImageData($imageName);
		$imageData['href'] = $newFilesUrl;

		return $imageData;
	}

	protected function getNewFilesUrl($wikiId) {
		$globalNewFilesTitle = F::build('GlobalTitle', array('NewFiles', NS_SPECIAL, $wikiId), 'newFromText');
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

		return array(
			'href' => '',
			'image_url' => $imageUrl,
			'thumb_url' => $thumbImageUrl,
			'image_filename' => $imageName,
			'user_href' => '',
			'links' => array(),
			'isVideoThumb' => false,
			'date' => '',
		);
	}

	public function getImageUrl($imageName, $requestedWidth, $requestedHeight) {
		$this->wf->ProfileIn(__METHOD__);
		$imageUrl = '';

		if (!empty($imageName)) {
			if (strpos($imageName, '%') !== false) {
				$imageName = urldecode($imageName);
			}

			$title = F::build('Title', array($imageName, NS_IMAGE), 'newFromText');
			$file = $this->wf->FindFile($title);

			if ($file instanceof File && $file->exists()) {
				$originalWidth = $file->getWidth();
				$originalHeight = $file->getHeight();
			}

			if (!empty($originalHeight) && !empty($originalWidth)) {
				$imageServingParams = $this->getImageServingParamsForResize($requestedWidth, $requestedHeight, $originalWidth, $originalHeight);
				$imageServing = F::build('ImageServing', $imageServingParams);
				$imageUrl = $imageServing->getUrl($file, $originalWidth, $originalHeight);
			} else {
				$imageUrl = $this->wg->blankImgUrl;
			}
		}

		$this->wf->ProfileOut(__METHOD__);
		return $imageUrl;
	}

	protected function getImageServingParamsForResize($requestedWidth, $requestedHeight, $originalWidth, $originalHeight) {
		$requestedRatio = $requestedWidth / $requestedHeight;
		$originalRatio = $originalWidth / $originalHeight;

		if ($originalHeight < $requestedHeight || $originalWidth < $requestedWidth) {
			// we will be unable to extend image, so we will just crop it to fit requested ratio
			if ($originalRatio > $requestedRatio) {
				$requestedWidth = $originalWidth / $requestedRatio;
				$requestedHeight = $originalHeight;
			} else {
				$requestedHeight = $originalHeight / $requestedRatio;
				$requestedWidth = $originalWidth;
			}
		}

		$imageServingParams = array(
			null,
			floor($requestedWidth),
			array(
				'h' => floor($requestedHeight),
				'w' => floor($requestedWidth)
			)
		);
		return $imageServingParams;
	}

	public function getWikisList($contLang) {
		$this->wf->ProfileIn(__METHOD__);

		if (empty($this->wg->ReadOnly)) {
			$cityVisualization = F::build('CityVisualization', array());
			$wikisPerVertical = $cityVisualization->getList($contLang);

			if (empty($wikisPerVertical)) {
				throw new Exception(wfMsg('wikia-home-parse-exception-empty-data-from-database'));
			}

			$wikis = array();
			$i = 0;
			$verticalNameTmp = null;
			foreach ($wikisPerVertical as $verticalName => $vertical) {
				if (is_null($verticalNameTmp)) {
					$verticalNameTmp = $verticalName;
				}
				if ($verticalName !== $verticalNameTmp && !is_null($verticalNameTmp)) {
					$i++;
				}

				$wikis[$i]['vertical'] = $verticalName;
				$wikis[$i]['slots'] = $this->getNumberOfSlotsForType($verticalName);

				$wikilist = array();
				foreach ($vertical as $wikiKey => $wiki) {
					$wikiMainImgName = $wiki['main_image'];
					$wikiMainImg = $this->wf->FindFile($wikiMainImgName);
					unset($wikisPerVertical[$verticalName][$wikiKey]['main_image']);

					$wiki['imagesmall'] = $this->getImageUrl($wikiMainImgName, WikiaHomePageController::REMIX_IMG_SMALL_WIDTH, WikiaHomePageController::REMIX_IMG_SMALL_HEIGHT);
					$wiki['imagemedium'] = $this->getImageUrl($wikiMainImgName, WikiaHomePageController::REMIX_IMG_MEDIUM_WIDTH, WikiaHomePageController::REMIX_IMG_MEDIUM_HEIGHT);
					if ($wikiMainImg instanceof File && $wikiMainImg->exists()) {
						$wiki['imagebig'] = $this->getImageUrl($wikiMainImgName, WikiaHomePageController::REMIX_IMG_BIG_WIDTH, WikiaHomePageController::REMIX_IMG_BIG_HEIGHT);
					} else {
						$wiki['imagebig'] = $this->wg->blankImgUrl;
					}

					$wikilist[] = $wiki;
				}

				$wikis[$i]['wikilist'] = $wikilist;
			}

			$this->wf->ProfileOut(__METHOD__);
			return $wikis;
		} else {
			$this->wf->ProfileOut(__METHOD__);
			throw new Exception(wfMsg('wikia-home-parse-exception-read-only'));
		}
	}

	public function getData($contLang) {
		$slots = array(
			'hotwikis' => $this->getVarFromWikiFactory(self::HOT_WIKI_SLOTS_VAR_NAME),
			'newwikis' => $this->getVarFromWikiFactory(self::NEW_WIKI_SLOTS_VAR_NAME),
		);

		$wikisPerVertical = $this->getWikisList($contLang);

		return array(
			'slots' => $slots,
			'wikis' => $wikisPerVertical,
		);
	}
}

interface WikiDataGetter {
	public function getWikiData($wikiId, $langCode);
}

class WikiDataGetterForVisualization implements WikiDataGetter {
	public function    getWikiData($wikiId, $langCode) {
		$visualization = F::build('CityVisualization');
		$wikiData = $visualization->getWikiDataForVisualization($wikiId, $langCode);
		if(empty($wikiData['flags'])) {
			$wikiData['flags'] = null;
		}
		return $wikiData;
	}
}

class WikiDataGetterForSpecialPromote implements WikiDataGetter {
	public function  getWikiData($wikiId, $langCode) {
		$visualization = F::build('CityVisualization');
		$wikiData = $visualization->getWikiDataForPromote($wikiId, $langCode);
		if(empty($wikiData['flags'])) {
			$wikiData['flags'] = null;
		}
		return $wikiData;
	}
}