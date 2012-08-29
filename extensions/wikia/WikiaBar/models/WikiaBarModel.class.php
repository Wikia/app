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
	const WIKIABAR_MCACHE_VERSION = '0.01';

	protected $requiredFields = array(
		'button-1-class',
		'button-1-text',
		'button-1-href',
		'button-2-class',
		'button-2-text',
		'button-2-href',
		'button-3-class',
		'button-3-text',
		'button-3-href',
		'button-4-class',
		'button-4-text',
		'button-4-href',
		'line-1-text',
		'line-1-href',
		'line-2-text',
		'line-2-href',
		'line-3-text',
		'line-3-href',
		'line-4-text',
		'line-4-href',
		'line-5-text',
		'line-5-href'
	);


	public function getBarContents() {
		$this->wf->profileIn(__METHOD__);

		$dataMemcKey = $this->wf->SharedMemcKey('WikiaBar', $this->getLang(), $this->getVertical(), self::WIKIABAR_MCACHE_VERSION );
		$data = $this->wg->memc->get($dataMemcKey);

		if (!$data) {
			$data = $this->getParsedBarConfiguration();
			$this->wg->memc->set($dataMemcKey,$data);
		}

		$this->wf->profileOut(__METHOD__);
		return $data;
	}

	protected function getParsedBarConfiguration() {
		$message = $this->getRegularMessage();
		$parseResult = $this->parseBarConfigurationMessage($message);
		$status = true;

		if (!$parseResult) {
			Wikia::log(__METHOD__, null, 'WikiaBar message ' . implode('', array($this->getVertical(), '/', $this->getLang())) . ' falling back to failsafe');
			$message = $this->getFailsafeMessage();
			$parseResult = $this->parseBarConfigurationMessage($message);
			$status = false;
		}
		$data = array(
			'data' => $parseResult,
			'status' => $status
		);
		return $data;
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
		$this->wf->profileIn(__METHOD__);
		$model->setLang($this->getLang());
		$model->setVertical($this->getVertical());
		$data = $model->getData();
		$this->wf->profileOut(__METHOD__);
		return $data;
	}

	/**
	 * @param int $modelType
	 * @return bool|WikiaBarModelBase
	 */
	protected function getModel($modelType) {
		switch ($modelType) {
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
		$this->wf->profileIn(__METHOD__);
		$data = array();
		$valid = true;

		if (empty($message)) {
			$valid = false;
		}

		if ($valid) {
			$lines = explode("\n", $message);
		}

		if (!empty($lines)) {
			foreach ($lines as $line) {
				if (stripos($line, '=') !== false) {
					list($key, $val) = explode('=', $line, 2);
					$val = trim($val);
					if (empty($val)) {
						$valid = false;
					}
					$data[$key] = $val;
				}
			}
			if (count(array_intersect(array_keys($data), $this->requiredFields)) != count($this->requiredFields)) {
				$valid = false;
			}
		} else {
			$valid = false;
		}

		$this->wf->profileOut(__METHOD__);
		if ($valid) {
			return $data;
		} else {
			return $valid;
		}
	}

	public function getData() {
		return $this->getBarContents();
	}
}
