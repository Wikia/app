<?php
/**
 * WikiaHomePage special page aka Staff Tool
 * @author Andrzej 'nAndy' Łukaszewski
 */
class WikiaHomePageSpecialController extends WikiaSpecialPageController {
	protected $helper;

	public function __construct() {
		parent::__construct('WikiaHomePage', false);
		$this->helper = F::build('WikiaHomePageHelper');
	}

	public function init() {
	}

	public function index() {
		$this->wf->ProfileIn(__METHOD__);
		$this->wg->Out->setPageTitle(wfMsg('wikia-home-page-special-title'));

		if (!$this->wg->User->isLoggedIn() || !$this->wg->User->isAllowed('wikiahomepagestafftool')) {
			$this->forward('WikiaHomePageSpecial', 'onWrongRights');
			$this->wf->ProfileOut(__METHOD__);
			return;
		}

		$this->setVal('slotsInTotal', WikiaHomePageHelper::SLOTS_IN_TOTAL);
		/* @var $this->helper WikiaHomePageHelper */

		$videoGamesAmount = $this->request->getVal('video-games-amount', $this->helper->getNumberOfVideoGamesSlots());
		$entertainmentAmount = $this->request->getVal('entertainment-amount', $this->helper->getNumberOfEntertainmentSlots());
		$lifestyleAmount = $this->request->getVal('lifestyle-amount', $this->helper->getNumberOfLifestyleSlots());
		$hotWikisAmount = $this->request->getVal('hot-wikis-amount', $this->helper->getNumberOfHotWikiSlots());
		$newWikisAmount = $this->request->getVal('new-wikis-amount', $this->helper->getNumberOfNewWikiSlots());

		if ($this->request->wasPosted()) {
			$changeType = $this->request->getVal('change-type', null);

			switch ($changeType) {
				case 'hot-new-slots':
					$total = intval($hotWikisAmount) + intval($newWikisAmount);

					if ($this->isHotOrNewSlotNumberTooBig($hotWikisAmount, $newWikisAmount)) {
						$this->setVal('errorMsg', wfMsg('wikia-home-page-special-error-exceeded-total-no-of-slots', array(WikiaHomePageHelper::SLOTS_IN_TOTAL)));
					} elseif ($this->isHotOrNewSlotNumberNegative($hotWikisAmount, $newWikisAmount)) {
						$this->setVal('errorMsg', wfMsg('wikia-home-page-special-error-negative-slots-number-not-allowed'));
					} else {
						$this->saveSlotsConfigInWikiFactory(array(
							WikiaHomePageHelper::HOT_WIKI_SLOTS_VAR_NAME => $hotWikisAmount,
							WikiaHomePageHelper::NEW_WIKI_SLOTS_VAR_NAME => $newWikisAmount,
						));
					}
					break;
				case 'vertical-slots':
				default:
					$total = intval($videoGamesAmount) + intval($entertainmentAmount) + intval($lifestyleAmount);

					if ($total !== WikiaHomePageHelper::SLOTS_IN_TOTAL) {
						$this->setVal('errorMsg', wfMsg('wikia-home-page-special-error-invalid-total-no-of-slots', array($total, WikiaHomePageHelper::SLOTS_IN_TOTAL)));
					} elseif (
						$this->isAnySlotNumberNegative($videoGamesAmount, $entertainmentAmount, $lifestyleAmount)
					) {
						$this->setVal('errorMsg', wfMsg('wikia-home-page-special-error-negative-slots-number-not-allowed'));
					} else {
						$this->saveSlotsConfigInWikiFactory(array(
							WikiaHomePageHelper::VIDEO_GAMES_SLOTS_VAR_NAME => $videoGamesAmount,
							WikiaHomePageHelper::ENTERTAINMENT_SLOTS_VAR_NAME => $entertainmentAmount,
							WikiaHomePageHelper::LIFESTYLE_SLOTS_VAR_NAME => $lifestyleAmount,
						));
					}
					break;
			}
		}

		$this->setVal('videoGamesAmount', $videoGamesAmount);
		$this->setVal('entertainmentAmount', $entertainmentAmount);
		$this->setVal('lifestyleAmount', $lifestyleAmount);
		$this->setVal('hotWikisAmount', $hotWikisAmount);
		$this->setVal('newWikisAmount', $newWikisAmount);

		$this->response->addAsset('/extensions/wikia/WikiaHomePage/css/WikiaHomePageSpecial.scss');

		$this->wf->ProfileOut(__METHOD__);
	}

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

	public
	function onWrongRights() {
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
	private
	function saveSlotsConfigInWikiFactory($slotsCfgArr) {
		$this->wf->ProfileIn(__METHOD__);

		if (is_array($slotsCfgArr)) {
			$statusArr = array();
			foreach ($slotsCfgArr as $wfVar => $wfVarValue) {
				$status = $this->helper->setWikiFactoryVar($wfVar, $wfVarValue);
				$statusArr[$wfVar] = $status;
			}
		}

		if (in_array(false, $statusArr)) {
			Wikia::log(__METHOD__, false, "A problem with saving WikiFactory variable(s) occured. Status array: " . print_r($statusArr, true));
			$this->setVal('errorMsg', wfMsg('wikia-home-page-special-error-wikifactory-failure'));

			$this->wf->ProfileOut(__METHOD__);
			return false;
		}

		$this->setVal('infoMsg', wfMsg('wikia-home-page-special-wikis-in-slots-success'));
		$this->wf->ProfileOut(__METHOD__);
		return true;
	}
}