<?php

/**
 * Data Model for WikiaBar - Meebo replacement
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 */

class WikiaBarModel extends WikiaBarModelBase {
	const WIKIA_BAR_TYPE_DATA_MODEL = 1;
	const WIKIA_BAR_TYPE_DATA_FAILSAFE_MODEL = 2;
	
	
	public function getBarContents() {
		$message = $this->getRegularMessage();
		$parseResult = $this->parseBarConfigurationMessage($message);

		if(!$parseResult) {
			Wikia::log(__METHOD__, null, 'WikiaBar message ' . implode('',array($this->getVertical(),'/',$this->getLang())) . ' falling back to failsafe');
			$message = $this->getFailsafeMessage();
			$parseResult = $this->parseBarConfigurationMessage($message);
		}

		return $parseResult;
	}

	protected function getRegularMessage() {
		$model = $this->getModel(self::WIKIA_BAR_TYPE_DATA_MODEL);
		return $this->getMessageFromModel($model);
	}

	protected function getFailsafeMessage() {
		$model = $this->getModel(self::WIKIA_BAR_TYPE_DATA_FAILSAFE_MODEL);
		return $this->getMessageFromModel($model);
	}

	/**
	 * @param WikiaBarModelBase $model
	 * @return string
	 */
	protected function getMessageFromModel(WikiaBarModelBase $model) {
		$model->setLang($this->getLang());
		$model->setVertical($this->getVertical());

		return $model->getData();
	}

	/**
	 * @param int $modelType
	 * @return bool|WikiaBarModelBase
	 */
	protected function getModel($modelType) {
		switch($modelType) {
			case self::WIKIA_BAR_TYPE_DATA_MODEL:
				$model = F::build('WikiaBarDataModel');
				break;
			case self::WIKIA_BAR_TYPE_DATA_FAILSAFE_MODEL:
				$model = F::build('WikiaBarDataFailsafeModel');
				break;
			default:
				$model = false;
		}
		return $model;
	}

	/**
	 * @param string $message
	 * @return bool|array
	 */
	protected function parseBarConfigurationMessage($message) {

	}
}
