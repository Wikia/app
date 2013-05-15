<?php
class ManageWikiaHomeController extends WikiaSpecialPageController {
	const WHST_VISUALIZATION_LANG_VAR_NAME = 'vl';
	const WHST_WIKIS_PER_PAGE = 25;

	const FLAG_TYPE_BLOCK = 'block';
	const FLAG_TYPE_UNBLOCK = 'unblock';
	const FLAG_TYPE_PROMOTE = 'promote';
	const FLAG_TYPE_DEMOTE = 'remove-promote';

	const SWITCH_COLLECTION_TYPE_ADD = 'add';
	const SWITCH_COLLECTION_TYPE_REMOVE= 'remove';


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
		$this->helper = F::build('WikiaHomePageHelper');
	}

	public function isRestricted() {
		return true;
	}

	public function init() {
		$this->wg->Out->addJsConfigVars([
			'SWITCH_COLLECTION_TYPE_ADD' => self::SWITCH_COLLECTION_TYPE_ADD,
			'SWITCH_COLLECTION_TYPE_REMOVE' => self::SWITCH_COLLECTION_TYPE_REMOVE
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

		//wikis with visualization selectbox
		$visualizationLang = $this->wg->request->getVal(self::WHST_VISUALIZATION_LANG_VAR_NAME, $this->wg->contLang->getCode());
		$visualizationLang = substr( strtolower($visualizationLang), 0, 2);
		$this->visualizationLang = $visualizationLang;
		$this->visualizationWikisData = $this->helper->getVisualizationWikisData();

		$this->currentPage = $this->request->getVal('page', 1);
		$this->corpWikiId = $this->visualizationWikisData[$this->visualizationLang]['wikiId'];

		//verticals slots' configuration
		/* @var $this->helper WikiaHomePageHelper */
		$videoGamesAmount = $this->request->getVal('video-games-amount', $this->helper->getNumberOfVideoGamesSlots($this->visualizationLang));
		$entertainmentAmount = $this->request->getVal('entertainment-amount', $this->helper->getNumberOfEntertainmentSlots($this->visualizationLang));
		$lifestyleAmount = $this->request->getVal('lifestyle-amount', $this->helper->getNumberOfLifestyleSlots($this->visualizationLang));
		$hotWikisAmount = $this->request->getVal('hot-wikis-amount', $this->helper->getNumberOfHotWikiSlots($this->visualizationLang));
		$newWikisAmount = $this->request->getVal('new-wikis-amount', $this->helper->getNumberOfNewWikiSlots($this->visualizationLang));

		$this->form = new CollectionsForm();
		$collectionsModel = new WikiaCollectionsModel();
		$collectionsList = $collectionsModel->getList($this->visualizationLang);
		$collectionValues = $this->prepareCollectionToShow($collectionsList);
		$wikisPerCollection = $this->getWikisPerCollection($collectionsList);

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
					$collectionSavedValues = $this->prepareCollectionForSave($collectionValues);
					$collectionsModel->saveAll($this->visualizationLang, $collectionSavedValues);

					$collectionsList = $collectionsModel->getList($this->visualizationLang);
					$wikisPerCollection = $this->getWikisPerCollection($collectionsList, true);
					
					$this->infoMsg = wfMessage('manage-wikia-home-collections-success')->text();
				} else {
					$this->errorMsg = wfMessage('manage-wikia-home-collections-failure')->text();
				}
			}
		}

		$this->form->setFieldsValues($collectionValues);

		$this->setVal('videoGamesAmount', $videoGamesAmount);
		$this->setVal('entertainmentAmount', $entertainmentAmount);
		$this->setVal('lifestyleAmount', $lifestyleAmount);
		$this->setVal('hotWikisAmount', $hotWikisAmount);
		$this->setVal('newWikisAmount', $newWikisAmount);
		$this->setVal('wikisPerCollection', $wikisPerCollection);

		$this->response->addAsset('/extensions/wikia/SpecialManageWikiaHome/css/ManageWikiaHome.scss');
		$this->response->addAsset('manage_wikia_home_js');

		F::build('JSMessages')->enqueuePackage('ManageWikiaHome', JSMessages::EXTERNAL);

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

		$this->currentPage = $this->request->getVal('page', 1);

		//todo: new class for options
		$options = new stdClass();
		$options->lang = $visualizationLang;
		$options->wikiHeadline = $this->request->getVal('wikiHeadline', '');
		$count = $this->helper->getWikisCountForStaffTool($options);
		$options->limit = self::WHST_WIKIS_PER_PAGE;
		$options->offset = (($this->currentPage - 1) * self::WHST_WIKIS_PER_PAGE);
		// TODO
		$options->verticalId = 0;
		$options->blockedFlag = false;
		$options->officialFlag = false;
		$options->promotedFlag = false;
		$options->collectionId = 44;

		$specialPage = F::build('Title', array('ManageWikiaHome', NS_SPECIAL), 'newFromText');
		//todo: getLocalUrl(array('vl' => $visualizationLang, 'page' => '%s')) doesn't work here because % sign is being escaped
		$url = $specialPage->getLocalUrl() . '?vl=' . $visualizationLang . '&page=%s';

		if( $count > self::WHST_WIKIS_PER_PAGE ) {
			/** @var $paginator Paginator */
			$paginator = F::build('Paginator', array(array_fill(0, $count, ''), self::WHST_WIKIS_PER_PAGE), 'newFromArray');
			$paginator->setActivePage($this->currentPage - 1);
			$this->setVal('pagination', $paginator->getBarHTML($url));
		}

		$this->list = $this->helper->getWikisForStaffTool($options);
		$this->collections = $this->helper->getCollectionsList($visualizationLang);

		wfProfileOut(__METHOD__);
	}

	//todo: make from isAnySlotNumberNegative() and isHotOrNewSlotNumberNegative() one method
	protected function isAnySlotNumberNegative($videoGamesAmount, $entertainmentAmount, $lifestyleAmount) {
		return intval($videoGamesAmount) < 0
			|| intval($entertainmentAmount) < 0
			|| intval($lifestyleAmount) < 0;
	}

	protected function isHotOrNewSlotNumberNegative($hotWikisAmount, $newWikisAmount) {
		return intval($hotWikisAmount) < 0
			|| intval($newWikisAmount) < 0;
	}

	protected function isHotOrNewSlotNumberTooBig($hotWikisAmount, $newWikisAmount) {
		return intval($hotWikisAmount) > WikiaHomePageHelper::SLOTS_IN_TOTAL
			|| intval($newWikisAmount) > WikiaHomePageHelper::SLOTS_IN_TOTAL;
	}

	public function onWrongRights() {
		//we use only its template here...
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
			$visualization = F::build('CityVisualization'); /** @var $visualization CityVisualization */
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

	/**
	 * @desc A public alias of changeFlag() setting wiki as blocked
	 */
	public function setWikiAsBlocked() {
		$this->status = $this->changeFlag(self::FLAG_TYPE_BLOCK);
	}

	/**
	 * @desc A public alias of changeFlag() setting wiki as unblocked
	 */
	public function removeWikiFromBlocked() {
		$this->status = $this->changeFlag(self::FLAG_TYPE_UNBLOCK);
	}

	/**
	 * @desc A public alias of changeFlag() setting wiki as promoted
	 */
	public function setWikiAsPromoted() {
		$this->status = $this->changeFlag(self::FLAG_TYPE_PROMOTE);
	}

	/**
	 * @desc A public alias of changeFlag() setting wiki as not promoted
	 */
	public function removeWikiFromPromoted() {
		$this->status = $this->changeFlag(self::FLAG_TYPE_DEMOTE);
	}

	/**
	 * @desc Changes city_flags field in city_visualization table
	 *
	 * @param string $type one of: 'block', 'unblock', 'promote', 'remove-promote'
	 * @requestParam integer $wikiId id of wiki that flags we want to change
	 * @requestParam integer $corpWikiId id of wiki which "hosts" visualization
	 * @requestParam string $lang language code of wiki which "hosts" visualization
	 */
	protected function changeFlag($type) {
		wfProfileIn(__METHOD__);

		if( !$this->checkAccess() ) {
			$result = false;
		} else {
			$wikiId = $this->request->getInt('wikiId', 0);
			$corpWikiId = $this->request->getInt('corpWikiId', 0);
			$langCode = $this->request->getVal('lang', 'en');

			switch($type) {
				case self::FLAG_TYPE_BLOCK:
					$result = $this->helper->setFlag($wikiId, WikisModel::FLAG_BLOCKED, $corpWikiId, $langCode);
					break;
				case self::FLAG_TYPE_UNBLOCK:
					$result = $this->helper->removeFlag($wikiId, WikisModel::FLAG_BLOCKED, $corpWikiId, $langCode);
					break;
				case self::FLAG_TYPE_PROMOTE:
					$result = $this->helper->setFlag($wikiId, WikisModel::FLAG_PROMOTED, $corpWikiId, $langCode);
					break;
				case self::FLAG_TYPE_DEMOTE:
					$result = $this->helper->removeFlag($wikiId, WikisModel::FLAG_PROMOTED, $corpWikiId, $langCode);
					break;
				default:
					$result = false;
					break;
			}

		}
		wfProfileOut(__METHOD__);
		return $result;
	}

	public function switchCollection() {
		if( !$this->checkAccess() ) {
			$this->status = false;
		} else {
			$wikiId = $this->request->getInt('wikiId', 0);
			$collectionId = $this->request->getVal('collectionId', 0);
			$type = $this->request->getVal('switchType', self::SWITCH_COLLECTION_TYPE_ADD);

			$collectionsModel = new WikiaCollectionsModel();
			switch($type) {
				case self::SWITCH_COLLECTION_TYPE_ADD:
					$collectionsModel->addWikiToCollection($collectionId, $wikiId);
					$this->status = true;
					break;
				case self::SWITCH_COLLECTION_TYPE_REMOVE:
					$collectionsModel->removeWikiFromCollection($collectionId, $wikiId);
					$this->status = true;
					break;
				default:
					$this->status = false;
					break;
			}
		}
	}

	/**
	 * Preparing data received from collection's form to array, which could be easily use to insert data
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
	 * @param array $collectionValues data from form collection's form
	 * @return array $collections data to save
	 */
	private function prepareCollectionForSave($collectionValues) {
		$collections = [];

		foreach($collectionValues as $name => $collection) {
			foreach($collection as $key => $field) {
				$collections[$key][$name] = $field;
			}
		}

		return $collections;
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
	 * @param array $collections data from database
	 * @return array $collectionValues data to display
	 */
	private function prepareCollectionToShow($collections) {
		$collectionValues = [];

		foreach($collections as $key => $collection) {
			foreach($collection as $name => $value) {
				$collectionValues[$name][$key] = $value;
			}
		}
		
		return $collectionValues;
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

}
