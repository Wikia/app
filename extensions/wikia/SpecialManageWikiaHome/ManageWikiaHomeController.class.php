<?php
class ManageWikiaHomeController extends WikiaSpecialPageController {
	const WHST_VISUALIZATION_LANG_VAR_NAME = 'vl';
	const WHST_WIKIS_PER_PAGE = 25;

	const FLAG_TYPE_BLOCK = 'block';
	const FLAG_TYPE_UNBLOCK = 'unblock';
	const FLAG_TYPE_PROMOTE = 'promote';
	const FLAG_TYPE_DEMOTE = 'remove-promote';

	/**
	 * @var WikiaHomePageHelper $helper
	 */
	protected $helper;

	public function __construct() {
		parent::__construct('ManageWikiaHome', 'managewikiahome', true);
		$this->helper = F::build('WikiaHomePageHelper');
	}

	public function isRestricted() {
		return true;
	}

	public function init() {
	}

	protected function checkAccess() {
		$this->wf->ProfileIn(__METHOD__);

		if( !$this->wg->User->isLoggedIn() || !$this->wg->User->isAllowed('managewikiahome') ) {
			$this->wf->ProfileOut(__METHOD__);
			return false;
		}

		$this->wf->ProfileOut(__METHOD__);
		return true;
	}

	public function index() {
		$this->wf->ProfileIn(__METHOD__);
		$this->wg->Out->setPageTitle(wfMsg('managewikiahome'));

		if( !$this->checkAccess() ) {
			$this->wf->ProfileOut(__METHOD__);
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

		if( $this->request->wasPosted() ) {
		//todo: separate post request handling
		//todo: move validation from saveSlotsConfigInWikiFactory() to helper
			$total = intval($videoGamesAmount) + intval($entertainmentAmount) + intval($lifestyleAmount);

			if ($total !== WikiaHomePageHelper::SLOTS_IN_TOTAL) {
				$this->setVal('errorMsg', wfMsg('manage-wikia-home-error-invalid-total-no-of-slots', array($total, WikiaHomePageHelper::SLOTS_IN_TOTAL)));
			} elseif ( $this->isAnySlotNumberNegative($videoGamesAmount, $entertainmentAmount, $lifestyleAmount) ) {
				$this->setVal('errorMsg', wfMsg('manage-wikia-home-error-negative-slots-number-not-allowed'));
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
		}

		$this->setVal('videoGamesAmount', $videoGamesAmount);
		$this->setVal('entertainmentAmount', $entertainmentAmount);
		$this->setVal('lifestyleAmount', $lifestyleAmount);
		$this->setVal('hotWikisAmount', $hotWikisAmount);
		$this->setVal('newWikisAmount', $newWikisAmount);

		$this->response->addAsset('/extensions/wikia/SpecialManageWikiaHome/css/ManageWikiaHome.scss');
		$this->response->addAsset('/extensions/wikia/SpecialManageWikiaHome/js/ManageWikiaHome.js');

		F::build('JSMessages')->enqueuePackage('ManageWikiaHome', JSMessages::EXTERNAL);

		$this->wf->ProfileOut(__METHOD__);
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
		$this->wf->ProfileIn(__METHOD__);

		if( !$this->checkAccess() ) {
			$this->wf->ProfileOut(__METHOD__);
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

		$this->wf->ProfileOut(__METHOD__);
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
		$this->wf->ProfileIn(__METHOD__);

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
			$this->setVal('errorMsg', wfMsg('manage-wikia-home-error-wikifactory-failure'));
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

			$this->setVal('infoMsg', wfMsg('manage-wikia-home-wikis-in-slots-success'));

			$result = true;
		}

		$this->wf->ProfileOut(__METHOD__);
		return $result;
	}

	/**
	 * @desc A public alias of changeFlag() setting wiki as blocked
	 */
	public function setWikiAsBlocked() {
		if( !$this->checkAccess() ) {
			$this->status = false;
		}

		$this->status = $this->changeFlag('block');
	}

	/**
	 * @desc A public alias of changeFlag() setting wiki as unblocked
	 */
	public function removeWikiFromBlocked() {
		if( !$this->checkAccess() ) {
			$this->status = false;
		}

		$this->status = $this->changeFlag('unblock');
	}

	/**
	 * @desc A public alias of changeFlag() setting wiki as promoted
	 */
	public function setWikiAsPromoted() {
		if( !$this->checkAccess() ) {
			$this->status = false;
		}

		$this->status = $this->changeFlag('promote');
	}

	/**
	 * @desc A public alias of changeFlag() setting wiki as not promoted
	 */
	public function removeWikiFromPromoted() {
		if( !$this->checkAccess() ) {
			$this->status = false;
		}

		$this->status = $this->changeFlag('remove-promote');
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
		$this->wf->ProfileIn(__METHOD__);

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

		$this->wf->ProfileOut(__METHOD__);
		return $result;
	}

}
