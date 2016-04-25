<?php
class ManageWikiaHomeController extends WikiaSpecialPageController {
	const WHST_VISUALIZATION_LANG_VAR_NAME = 'vl';
	const WHST_WIKIS_PER_PAGE = 25;

	const HUB_SLOTS_COUNT = 7;
	const MARKETING_SLOTS_COUNT = 3;

	const CHANGE_FLAG_ADD = 'add';
	const CHANGE_FLAG_REMOVE = 'remove';

	/**
	 * @var WikiaHomePageHelper $helper
	 */
	protected $helper;

	/**
	 * @var WikiaCollectionsModel
	 */
	private $wikiaCollectionsModel;

	public function __construct() {
		parent::__construct('ManageWikiaHome', 'managewikiahome', true);
		$this->helper = new WikiaHomePageHelper();
	}

	public function isRestricted() {
		return true;
	}

	public function init() {
		$this->wg->Out->addJsConfigVars([
			'CHANGE_FLAG_ADD' => self::CHANGE_FLAG_ADD,
			'CHANGE_FLAG_REMOVE' => self::CHANGE_FLAG_REMOVE,
			'FLAG_PROMOTED' => WikisModel::FLAG_PROMOTED,
			'FLAG_BLOCKED' => WikisModel::FLAG_BLOCKED,
			'FLAG_OFFICIAL' => WikisModel::FLAG_OFFICIAL,
		]);
	}

	protected function checkAccess() {
		wfProfileIn(__METHOD__);

		if( !$this->wg->User->isLoggedIn() || !$this->wg->User->isAllowed('managewikiahome') ) {
			wfProfileOut(__METHOD__);
			return false;
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	public function index() {
		wfProfileIn(__METHOD__);
		$this->wg->Out->setPageTitle(wfMsg('managewikiahome'));

		if( !$this->checkAccess() ) {
			wfProfileOut(__METHOD__);
			$this->forward('ManageWikiaHome', 'onWrongRights');
			return false;
		}

		$this->setVal('slotsInTotal', WikiaHomePageHelper::SLOTS_IN_TOTAL);
		$this->infoMsg = FlashMessages::pop();

		//wikis with visualization selectbox
		$visualizationLang = $this->wg->request->getVal(self::WHST_VISUALIZATION_LANG_VAR_NAME, $this->wg->contLang->getCode());
		$visualizationLang = substr( strtolower($visualizationLang), 0, 2);
		$this->visualizationLang = $visualizationLang;
		$this->visualizationWikisData = $this->helper->getVisualizationWikisData();

		$this->currentPage = $this->request->getVal('page', 1);
		$this->corpWikiId = $this->visualizationWikisData[$this->visualizationLang]['wikiId'];

		$this->filterOptions = array_merge($this->initFilterOptions(), $this->request->getParams());

		$this->exportListAsCSVUri = $this->getExportListAsCSVUri();

		//verticals slots' configuration
		/* @var $this->helper WikiaHomePageHelper */
		$videoGamesAmount = $this->request->getVal('video-games-amount', $this->helper->getNumberOfVideoGamesSlots($this->visualizationLang));
		$entertainmentAmount = $this->request->getVal('entertainment-amount', $this->helper->getNumberOfEntertainmentSlots($this->visualizationLang));
		$lifestyleAmount = $this->request->getVal('lifestyle-amount', $this->helper->getNumberOfLifestyleSlots($this->visualizationLang));

		$this->form = new CollectionsForm();
		$this->statsForm = new StatsForm();
		$this->hubsForm = new HubsSlotsForm();
		$savedSlotsValues = $this->helper->getHubSlotsFromWF($this->corpWikiId, $visualizationLang);
		$homePageSlotsValues = $this->prepareSlots($savedSlotsValues);
		$collectionsModel = $this->getWikiaCollectionsModel();
		$this->collectionsList = $collectionsModel->getList($this->visualizationLang);
		$collectionValues = $this->prepareArrayFieldsToShow($this->collectionsList);
		$wikisPerCollection = $this->getWikisPerCollection($this->collectionsList);

		$statsValues = $this->app->sendRequest('WikiaStatsController', 'getWikiaStatsFromWF')->getData();

		if( $this->request->wasPosted() ) {
			if ( $this->request->getVal('wikis-in-slots',false) ) {
				//todo: separate post request handling
				//todo: move validation from saveSlotsConfigInWikiFactory() to helper
				$total = intval($videoGamesAmount) + intval($entertainmentAmount) + intval($lifestyleAmount);

				if ($total !== WikiaHomePageHelper::SLOTS_IN_TOTAL) {
					$this->errorMsg = wfMessage('manage-wikia-home-error-invalid-total-no-of-slots')->params(array($total, WikiaHomePageHelper::SLOTS_IN_TOTAL))->text();
				} elseif ( $this->isAnySlotNumberNegative($videoGamesAmount, $entertainmentAmount, $lifestyleAmount) ) {
					$this->errorMsg = wfMessage('manage-wikia-home-error-negative-slots-number-not-allowed')->text();
				} else {
					$this->saveSlotsConfigInWikiFactory($this->corpWikiId,
						$visualizationLang,
						array(
							WikiaHomePageHelper::VIDEO_GAMES_SLOTS_VAR_NAME => $videoGamesAmount,
							WikiaHomePageHelper::ENTERTAINMENT_SLOTS_VAR_NAME => $entertainmentAmount,
							WikiaHomePageHelper::LIFESTYLE_SLOTS_VAR_NAME => $lifestyleAmount,
						)
					);
				}
			} elseif ( $this->request->getVal('collections',false) ) {
				$collectionValues = $this->request->getParams();
				$collectionValues = $this->form->filterData($collectionValues);
				$isValid = $this->form->validate($collectionValues);

				if ($isValid) {
					$collectionSavedValues = $this->prepareArrayFieldsForSave($collectionValues);
					$collectionsModel->saveAll($this->visualizationLang, $collectionSavedValues);

					FlashMessages::put(wfMessage('manage-wikia-home-collections-success')->text());
					$this->response->redirect($_SERVER['REQUEST_URI']);
				} else {
					$this->errorMsg = wfMessage('manage-wikia-home-collections-failure')->text();
				}
			} elseif ( $this->request->getVal('stats',false) ) {
				$statsValues = $this->request->getParams();
				$statsValues = $this->statsForm->filterData($statsValues);
				$isValid = $this->statsForm->validate($statsValues);

				if ($isValid) {
					$isAllowed = true;
					try {
						$this->app->sendRequest(
							'WikiaStatsController', 'saveWikiaStatsInWF',
							array('statsValues' => $statsValues)
						);
					} catch (PermissionsException $ex) {
						$isAllowed = false;
					}
					if ($isAllowed) {
						FlashMessages::put(wfMessage('manage-wikia-home-stats-success')->text());
						$this->response->redirect($_SERVER['REQUEST_URI']);
					} else {
						$this->errorMsg = wfMessage('manage-wikia-home-stats-permissions-error')->text();
					}
				} else {
					$this->errorMsg = wfMessage('manage-wikia-home-stats-failure')->text();
				}
			} elseif ( $this->request->getVal('hubs-slots', false)) {
				$homePageSlotsValues = $this->request->getParams();
				$homePageSlotsValues = $this->hubsForm->filterData($homePageSlotsValues);
				$homePageSlotsValues = $this->filterUrls($homePageSlotsValues);
				$hubSavedSlotsValues = $homePageSlotsValues['hub_slot'];
				$marketingSlotsValues = $this->getMarketingSlotsValues($homePageSlotsValues);
				$marketingSavedSlotsValues = $this->prepareArrayFieldsForSave($marketingSlotsValues);
				$isValid = $this->hubsForm->validate($homePageSlotsValues);
				$isValid &= $this->validateMarketingSlots($marketingSavedSlotsValues);
				if ( $isValid ) {
					$savedSlotsValues = [
						'hub_slot' => $hubSavedSlotsValues,
						'marketing_slot' => $marketingSavedSlotsValues
					];
					$status = $this->helper->saveHubSlotsToWF(
						$savedSlotsValues,
						$this->corpWikiId,
						$this->visualizationLang,
						'wgWikiaHomePageHubsSlotsV2'
					);
					if ( $status ) {
						$this->infoMsg = wfMessage('manage-wikia-home-hubs-slot-success')->text();
					} else {
						$this->errorMsg = wfMessage('manage-wikia-home-hubs-slot-error')->text();
					}
				}
			}
		}

		$this->form->setFieldsValues($collectionValues);
		$this->statsForm->setFieldsValues($statsValues);
		$this->verticals = $this->helper->getWikiVerticals();
		$this->marketingImages = [];
		if (array_key_exists('marketing_slots', $savedSlotsValues)) {
			$this->marketingImages = $this->prepareMarketingSlotImages($savedSlotsValues['marketing_slot']);
		}
		$this->prepareHubsForm($homePageSlotsValues);

		$this->setVal('videoGamesAmount', $videoGamesAmount);
		$this->setVal('entertainmentAmount', $entertainmentAmount);
		$this->setVal('lifestyleAmount', $lifestyleAmount);
		$this->setVal('wikisPerCollection', $wikisPerCollection);

		$this->response->addAsset('/extensions/wikia/SpecialManageWikiaHome/css/ManageWikiaHome.scss');
		$this->response->addAsset('manage_wikia_home_js');

		JSMessages::enqueuePackage('ManageWikiaHome', JSMessages::EXTERNAL);

		$this->wg->Out->addJsConfigVars([
			'wgWikisPerCollection' => $wikisPerCollection,
			'wgSlotsInTotal' => WikiaHomePageHelper::SLOTS_IN_TOTAL,
		]);

		wfProfileOut(__METHOD__);
	}

	/**
	 * @desc Renders a table with wikis in visualization on corporate page plus pagination if needed
	 *
	 * @requestParam string $visualizationLang language code of wikis
	 * @requestParam integer $page page number
	 * @requestParam string $wikiHeadline a string filtering the list
	 *
	 * @return false if user does not have permissions
	 */
	public function renderWikiListPage() {
		wfProfileIn(__METHOD__);

		if( !$this->checkAccess() ) {
			wfProfileOut(__METHOD__);
			return false;
		}

		//todo: move to __construct() the same in index()
		if( empty($this->visualizationLang) ) {
			$visualizationLang = $this->request->getVal('visualizationLang', $this->wg->contLang->getCode());
		} else {
			$visualizationLang = $this->visualizationLang;
		}

		$filterOptions = $this->request->getVal('filterOptions', []);

		//todo: new class for options
		$currentPage = $this->request->getVal('page', 1);
		$options = $this->prepareFilterOptions($visualizationLang, $filterOptions, $currentPage);

		$count = $this->helper->getWikisCountForStaffTool($options);

		$options->limit = self::WHST_WIKIS_PER_PAGE;
		$options->offset = (($currentPage - 1) * self::WHST_WIKIS_PER_PAGE);

		$this->list = $this->helper->getWikisForStaffTool($options);
		$this->collections = $this->getWikiaCollectionsModel()->getList($visualizationLang);
		$this->verticals = $this->helper->getWikiVerticals();

		if( $count > self::WHST_WIKIS_PER_PAGE ) {
			/** @var $paginator Paginator */
			$paginator = Paginator::newFromCount( $count, self::WHST_WIKIS_PER_PAGE );

			$paginator->setActivePage($currentPage);

			$url = $this->getUrlWithAllParams($visualizationLang, $filterOptions);
			$this->setVal('pagination', $paginator->getBarHTML($url));
		}

		wfProfileOut(__METHOD__);
	}

	protected function isAnySlotNumberNegative($videoGamesAmount, $entertainmentAmount, $lifestyleAmount) {
		return intval($videoGamesAmount) < 0
			|| intval($entertainmentAmount) < 0
			|| intval($lifestyleAmount) < 0;
	}

	public function onWrongRights() {
		//we use only its template here...
	}

	/**
	 * @desc Used by WMU to get the image url
	 */
	public function getImageDetails() {
		if (!$this->checkAccess()) {
			return false;
		}

		wfProfileIn(__METHOD__);

		$fileName = $this->getVal('fileHandler', false);
		if ($fileName) {
			$imageData = ImagesService::getLocalFileThumbUrlAndSizes($fileName, 149, ImagesService::EXT_JPG);
			$this->fileUrl = $imageData->url;
			$this->imageWidth = $imageData->width;
			$this->imageHeight = $imageData->height;
			$this->fileTitle = $imageData->title;
		}

		wfProfileOut(__METHOD__);
	}

	/**
	 * @desc Sets the variables values in WikiFactory and returns true if all ends good; otherwise returns false and add information to logs
	 *
	 * @param Array $slotsCfgArr an array where elements are new values of WikiFactory variables and keys of those elements are names of those variables
	 * @return bool
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	private function saveSlotsConfigInWikiFactory($corpWikiId, $corpWikiLang, $slotsCfgArr) {
		wfProfileIn(__METHOD__);

		$statusArr = array();
		$result = false;

		if (is_array($slotsCfgArr)) {
			foreach ($slotsCfgArr as $wfVar => $wfVarValue) {
				$status = $this->helper->setWikiFactoryVar($corpWikiId, $wfVar, $wfVarValue);
				$statusArr[$wfVar] = $status;
			}
		}

		if( in_array(false, $statusArr) ) {
			Wikia::log(__METHOD__, false, "A problem with saving WikiFactory variable(s) occured. Status array: " . print_r($statusArr, true));
			$this->errorMsg = wfMessage('manage-wikia-home-error-wikifactory-failure')->text();
		} else {
			$visualization = new CityVisualization();
			//todo: put purging those caches to CityVisualization class and fire here only one its method here
			//purge verticals cache
			foreach($visualization->getVerticalsIds() as $verticalId) {
				$memcKey = $visualization->getVisualizationVerticalWikisListDataCacheKey($verticalId, $corpWikiId, $corpWikiLang);
				$this->wg->Memc->set($memcKey, null);
			}

			//purge visualization list cache
			$visualization->purgeVisualizationWikisListCache($corpWikiId, $corpWikiLang);

			$this->infoMsg = wfMessage('manage-wikia-home-wikis-in-slots-success')->text();

			$result = true;
		}

		wfProfileOut(__METHOD__);
		return $result;
	}

	public function getWikisInVisualisationAsCSV() {
		wfProfileIn(__METHOD__);
		global $wgOut;

		if (!$this->checkAccess()) {
			wfProfileOut(__METHOD__);
			$this->response->setHeader('Cache-Control', 'no-cache');
			throw new PermissionsException('managewikiahome');
		}

		// get data
		$visualizationLang = $this->request->getVal('lang', $this->wg->contLang->getCode());
		$list = $this->helper->getWikisForStaffTool($this->prepareFilterOptions($visualizationLang, []));
		$collections = $this->getWikiaCollectionsModel()->getList($visualizationLang);
		$verticals = $this->helper->getWikiVerticals();

		// output data in csv format
		$out = fopen('php://memory', 'w');

		// header
		$outHeader = ['ID','Vertical','Title','Is blocked?','Is promoted?','Is official?'];
		foreach ($collections as $collection) {
			$outHeader[] = 'In collection: '.$collection['name']. '?';
		}
		fputcsv($out, $outHeader);

		foreach ($list as $wiki) {
			$outLine = [
				$wiki->city_id,
				$verticals[$wiki->city_vertical],
				$wiki->city_title,
				CityVisualization::isBlockedWiki($wiki->city_flags) ? 1 : 0,
				CityVisualization::isPromotedWiki($wiki->city_flags) ? 1 : 0,
				CityVisualization::isOfficialWiki($wiki->city_flags) ? 1 : 0,
			];
			foreach ($collections as $collection) {
				$outLine[] = in_array($collection['id'], $wiki->collections) ? 1 : 0;
			}
			fputcsv($out, $outLine);
		}
		fseek($out, 0);
		$csv = stream_get_contents($out);
		fclose($out);

		// turn off usual rendering
		$wgOut->disable();

		// set up headers
		$this->response->setFormat(WikiaResponse::FORMAT_RAW);
		$this->response->setHeader('Cache-Control', 'private');
		$this->response->setHeader('Content-Description', 'File Transfer');
		$this->response->setHeader('Content-Disposition', 'attachment; filename=ManageWikiaHomeWikisList-'.$visualizationLang.'.csv');
		$this->response->setHeader('Content-Transfer-Encoding', 'binary');

		$this->response->setContentType( 'application/octet-stream' );
		$this->response->setBody( $csv );

		wfProfileOut(__METHOD__);
	}

	private function getExportListAsCSVUri() {
		global $wgServer, $wgScriptPath;

		$params = [
			'controller' => 'ManageWikiaHome',
			'method' => 'getWikisInVisualisationAsCSV',
			'lang' => $this->visualizationLang
		];

		return $wgServer . $wgScriptPath . '/wikia.php?' . http_build_query( $params );
	}

	public function isWikiBlocked() {
		wfProfileIn(__METHOD__);

		if( !$this->checkAccess() ) {
			$this->status = false;
		} else {
			$wikiId = $this->request->getInt('wikiId', 0);
			$langCode = $this->request->getVal('lang', 'en');

			$this->status = $this->helper->isWikiBlocked($wikiId, $langCode);
		}

		wfProfileOut(__METHOD__);
	}

	public function isWikiInCollection() {
		wfProfileIn(__METHOD__);

		if( !$this->checkAccess() ) {
			$this->status = false;
		} else {
			$wikiId = $this->request->getInt('wikiId', 0);

			$this->status = $this->getWikiaCollectionsModel()->isWikiInCollection($wikiId);
		}

		wfProfileOut(__METHOD__);
	}

	/**
	 * @desc Changes city_flags field in city_visualization table
	 *
	 * @requestParam string $type one of: self::CHANGE_FLAG_ADD or self::CHANGE_FLAG_REMOVE
	 * @requestParam integer $flag from WikisModel which should be changed
	 * @requestParam integer $wikiId id of wiki that flags we want to change
	 * @requestParam integer $corpWikiId id of wiki which "hosts" visualization
	 * @requestParam string $lang language code of wiki which "hosts" visualization
	 *
	 * @return bool
	 */
	public function changeFlag() {
		wfProfileIn(__METHOD__);

		$this->checkWriteRequest();

		if( !$this->checkAccess() ) {
			$this->status = false;
		} else {
			$type = $this->request->getVal('type');
			$flag = $this->request->getInt('flag');
			$wikiId = $this->request->getInt('wikiId', 0);
			$corpWikiId = $this->request->getInt('corpWikiId', 0);
			$langCode = $this->request->getVal('lang', 'en');

			if ($type == self::CHANGE_FLAG_ADD) {
				$this->status = $this->helper->setFlag($wikiId, $flag, $corpWikiId, $langCode);
			} else {
				$this->status = $this->helper->removeFlag($wikiId, $flag, $corpWikiId, $langCode);
			}

		}
		wfProfileOut(__METHOD__);
	}

	public function switchCollection() {
		if( !$this->checkAccess() ) {
			$status = [
				'value' => false,
				'message' => wfMessage('manage-wikia-home-wrong-rights')->plain()
			];
		} else {
			$wikiId = $this->request->getInt('wikiId', 0);
			$collectionId = $this->request->getVal('collectionId', 0);
			$type = $this->request->getVal('switchType', self::CHANGE_FLAG_ADD);

			$collectionsModel = $this->getWikiaCollectionsModel();
			switch($type) {
				case self::CHANGE_FLAG_ADD:
					$status = $collectionsModel->addWikiToCollection($collectionId, $wikiId);
					break;
				case self::CHANGE_FLAG_REMOVE:
					$status = $collectionsModel->removeWikiFromCollection($collectionId, $wikiId);
					break;
				default:
					$status = [
						'value' => false,
						'message' => wfMessage('manage-wikia-home-collections-invalid-action')->plain()
					];
					break;
			}
		}
		$this->status = $status['value'];
		$this->message = $status['message'];
	}

	/**
	 * Get data about marketing slots
	 *
	 * @param $homePageSlotsValues
	 * @return mixed
	 */
	private function getMarketingSlotsValues($homePageSlotsValues) {
		unset($homePageSlotsValues['hub_slot']);
		return $homePageSlotsValues;
	}

	/**
	 * Preparing data received from form to array, which could be easily use to insert data
	 * to database or update already existing data.
	 *
	 * Example:
	 *
	 * We get array(
	 * 			'fieldName1' => array(value1, value2, ... ),
	 * 			'fieldName2' => array(value1, value2, ... )
	 * 		  )
	 *
	 * We want array(
	 * 			array('fieldName1' => value1, 'fieldName2' => value1),
	 * 			array('fieldName1' => value2, 'fieldName2' => value2)
	 * 		  )
	 *
	 * @param array $formValues data from form collection's form
	 * @return array $values data to save
	 */
	private function prepareArrayFieldsForSave($formValues) {
		$values = [];

		foreach($formValues as $name => $fields) {
			foreach($fields as $key => $field) {
				$values[$key][$name] = trim($field);
			}
		}

		return $values;
	}

	/**
	 * Preparing data received from database to array, which could be easily use to display
	 * values in form
	 *
	 * Example
	 *
	 * We get array(
	 * 			array('fieldName1' => value1, 'fieldName2' => value1),
	 * 			array('fieldName1' => value2, 'fieldName2' => value2)
	 * 		  )
	 *
	 * We want array(
	 * 			'fieldName1' => array(value1, value2, ... ),
	 * 			'fieldName2' => array(value1, value2, ... )
	 * 		  )
	 *
	 * @param array $values data from database
	 * @return array $formValues data to display
	 */
	private function prepareArrayFieldsToShow($values) {
		$dataValues = [];

		foreach($values as $key => $field) {
			foreach($field as $name => $value) {
				$dataValues[$name][$key] = $value;
			}
		}

		return $dataValues;
	}

	private function getWikisPerCollection($collections, $useMaster = false) {
		$wikisPerCollections = [];

		foreach($collections as $key => $collection) {
			$collectionId = $collection['id'];
			$wikis = $this->getWikiaCollectionsModel()->getCountWikisFromCollection($collectionId, $useMaster);
			$wikisPerCollections[$collectionId] = $wikis;
		}

		return $wikisPerCollections;
	}

	private function getWikiaCollectionsModel() {
		if( !isset($this->wikiaCollectionsModel) ) {
			$this->wikiaCollectionsModel = new WikiaCollectionsModel();
		}

		return $this->wikiaCollectionsModel;
	}

	private function prepareFilterOptions($visualizationLang, $filterOptions) {
		$options = new stdClass();
		$options->lang = $visualizationLang;
		$options->wikiHeadline = !empty($filterOptions['wiki-name-filer-input']) ? $filterOptions['wiki-name-filer-input'] : $this->request->getVal('wikiHeadline', '');
		$options->verticalId = !empty($filterOptions['vertical-filter']) ? $filterOptions['vertical-filter'] : 0;
		$options->blockedFlag = isset($filterOptions['wiki-blocked-filter']) ? $filterOptions['wiki-blocked-filter'] : false;
		$options->promotedFlag = isset($filterOptions['wiki-promoted-filter']) ? $filterOptions['wiki-promoted-filter'] : false;
		$options->officialFlag = isset($filterOptions['wiki-official-filter']) ? $filterOptions['wiki-official-filter'] : false;
		$options->collectionId = !empty($filterOptions['collections-filter']) ? $filterOptions['collections-filter'] : 0;

		return $options;
	}

	private function initFilterOptions() {
		return [
			'vertical-filter' => 0,
			'wiki-blocked-filter' => 0,
			'wiki-promoted-filter' => 0,
			'wiki-official-filter' => 0,
			'collections-filter' => 0,
			'wiki-name-filer-input' => ''
		];
	}

	private function getUrlWithAllParams($lang, $filterParams) {
		$url = '#';
		$specialPage = Title::newFromText('ManageWikiaHome', NS_SPECIAL);
		if( $specialPage instanceof Title ) {
			$params = [
				'wiki-name-filer-input' => isset($filterParams['wiki-name-filer-input']) ? $filterParams['wiki-name-filer-input'] : '',
				'collections-filter' => isset($filterParams['collections-filter']) ? $filterParams['collections-filter'] : 0,
				'vertical-filter' => isset($filterParams['vertical-filter']) ? $filterParams['vertical-filter'] : 0,
				'wiki-blocked-filter' => isset($filterParams['wiki-blocked-filter']) ? $filterParams['wiki-blocked-filter'] : 0,
				'wiki-promoted-filter' => isset($filterParams['wiki-promoted-filter']) ? $filterParams['wiki-promoted-filter'] : 0,
				'wiki-official-filter' => isset($filterParams['wiki-official-filter']) ? $filterParams['wiki-official-filter'] : 0,
				'page' => '%s',
				'vl' => $lang
			];

			$url = $specialPage->getLocalURL($params);
			$url = urldecode($url);
		}

		return $url;
	}

	/**
	 * Prepare hub and marketing slots to display in slots setup form
	 *
	 * @param $savedSlotsValues
	 * @return array
	 */
	private function prepareSlots( $savedSlotsValues ) {
		$marketingSavedSlotsValues = $this->getMarketingSlotsValues($savedSlotsValues);
		if( isset( $marketingSavedSlotsValues['marketing_slot'] ) ) {
			$marketingSavedSlotsValues = $marketingSavedSlotsValues['marketing_slot'];
			$marketingSavedSlotsValues = $this->prepareArrayFieldsToShow($marketingSavedSlotsValues);
		} else {
			$marketingSavedSlotsValues = [];
		}
		$homePageSlotsValues = [
			'hub_slot' => $savedSlotsValues['hub_slot']
		];
		return array_merge($homePageSlotsValues, $marketingSavedSlotsValues);
	}

	/**
	 * Get saved images for marketing slots
	 *
	 * @param $marketingSlots
	 * @return array
	 */
	private function prepareMarketingSlotImages( $marketingSlots ) {
		$marketingImages = [];
		if (!empty($marketingSlots)) {
			foreach ($marketingSlots as $key => $slot) {
				if (!empty($slot['marketing_slot_image'])) {
					$photo = ImagesService::getLocalFileThumbUrlAndSizes($slot['marketing_slot_image'], 149, ImagesService::EXT_JPG);
					$marketingImages[$key] = $photo->url;
				}
			}
		}
		return $marketingImages;
	}

	/**
	 * Filter urls and add protocol if it is missed
	 *
	 * @param $homePageSlotsValues
	 * @return mixed
	 */
	private function filterUrls(  $homePageSlotsValues ) {
		foreach( $homePageSlotsValues['marketing_slot_link'] as &$url ) {
			if (!empty($url) && strpos($url, 'http://') === false && strpos($url, 'https://') === false) {
				$url = 'http://' . $url;
			}
		}

		return $homePageSlotsValues;
	}

	/**
	 * To use marketing slot, all fields should be filled
	 *
	 * @param $slots
	 * @return bool
	 */
	private function validateMarketingSlots( $slots ) {
		$isValid = true;

		foreach( $slots as $slot ) {
			if( !empty( $slot['marketing_slot_image'] )
				|| !empty( $slot['marketing_slot_title'] )
				|| !empty( $slot['marketing_slot_link'] )
			) {
				$isValid &=	!empty( $slot['marketing_slot_image'] )
					&& !empty( $slot['marketing_slot_title'] )
					&& !empty( $slot['marketing_slot_link'] );
			}
		}

		if( !$isValid ) {
			$this->errorMsg = wfMessage('manage-wikia-home-marketing-not-complete')->text();
		}

		return $isValid;
	}

	/**
	 * Prepare hubs slots setup form in manage wikia home extension
	 *
	 * @param $hubSlotsValues
	 */
	private function prepareHubsForm( $hubSlotsValues ) {
		$this->hubsForm->setFieldsValues($hubSlotsValues);

		$response = $this->app->sendRequest(
			'WikiaHubsApiController',
			'getHubsV3List',
			[ 'lang' => $this->visualizationLang ]
		);

		$wikis = $response->getVal('list', []);
		$fields = $this->hubsForm->getFields();
		$hubValues = $fields['hub_slot']['value'];

		foreach ($wikis as $wiki) {
			$choices[] = [
				'value' => sprintf($wiki['id']),
				'option' => $wiki['name']
			];
		}

		$choices[] = [
			'value' => '',
			'option' => wfMessage('manage-wikia-home-hubs-slot-empty-option')->plain()
		];

		$this->hubsForm->setFieldProperty('hub_slot', 'choices', $choices);
		$this->hubsForm->setFieldProperty('hub_slot', 'value', $hubValues);
	}
}
