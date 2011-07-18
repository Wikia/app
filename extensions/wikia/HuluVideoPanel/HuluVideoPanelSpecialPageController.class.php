<?php

/**
 * HuluVideoPanel Special Page
 * @author William Lee
 */
class HuluVideoPanelSpecialPageController extends WikiaSpecialPageController {
	
	private static $PARTNER_ID = 'Wikia';

	public function __construct() {
		parent::__construct('HuluVideoPanel', '', false);
	}

	/**
	 * @brief Displays the Hulu Video Panel page
	 * 
	 */
	public function index() {
		global $wgHuluVideoPanelShow, $wgHuluVideoPanelAttributes;

		F::app()->wg->Out->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/HuluVideoPanel/css/HuluVideoPanel.scss'));
		F::app()->wg->Out->setPageTitle(wfMsg('huluvideopanel-title'));
		
		$this->response->setVal('panelAttributes', $wgHuluVideoPanelAttributes);
		$this->response->setVal('panelShow', $wgHuluVideoPanelShow);
		$this->response->setVal('partnerId', self::$PARTNER_ID);
	}
	
}