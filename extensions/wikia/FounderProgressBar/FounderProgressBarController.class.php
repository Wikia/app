<?php

class FounderProgressBarController extends WikiaController {
	
	protected $actions;
	
	/**
	 * Initialize static data
	 */
	
	public function init() {
		// Messages defined in i18n file
		$this->messages = array ( 
				1 => "add_10_pages",
				2 => "do_something",
				10 => "advanced_thing"
			);


	}
	
	/**
	 * @desc Get the next 2 available founder actions
	 * 
	 * @responseParam array of Founder actions in the format:
	 */

	
	public function getShortList () {
		
	}

	/**
	 * @desc Get all founder actions with details (available, completed, skipped)
	 * 
	 * @responseParam array of Founder actions in the format:
	 */
	
	public function getLongList () {
		
	}
	
	/**
	 * @desc
	 * @requestParam type action_id The ID of the action to skip 
	 * @responseParam string OK or error
	 */
	
	public function skipAction() {
		
	}
	
	public function widget() {
		$this->wg->Out->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/FounderProgressBar/css/FounderProgressBar.scss'));
		$this->wg->Out->addScriptFile($this->wg->ExtensionsPath . '/wikia/FounderProgressBar/js/FounderProgressBar.js');
	}
	
}
