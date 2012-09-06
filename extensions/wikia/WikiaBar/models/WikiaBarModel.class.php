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

	const BUTTON_1_CLASS = 'button-1-class';
	const BUTTON_1_TEXT = 'button-1-text';
	const BUTTON_1_HREF = 'button-1-href';
	const BUTTON_2_CLASS = 'button-2-class';
	const BUTTON_2_TEXT = 'button-2-text';
	const BUTTON_2_HREF = 'button-2-href';
	const BUTTON_3_CLASS = 'button-3-class';
	const BUTTON_3_TEXT = 'button-3-text';
	const BUTTON_3_HREF = 'button-3-href';
	const LINE_1_TEXT = 'line-1-text';
	const LINE_1_HREF = 'line-1-href';
	const LINE_2_TEXT = 'line-2-text';
	const LINE_2_HREF = 'line-2-href';
	const LINE_3_TEXT = 'line-3-text';
	const LINE_3_HREF = 'line-3-href';
	const LINE_4_TEXT = 'line-4-text';
	const LINE_4_HREF = 'line-4-href';
	const LINE_5_TEXT = 'line-5-text';
	const LINE_5_HREF = 'line-5-href';

	protected $requiredFields = array(
		self::BUTTON_1_CLASS,
		self::BUTTON_1_TEXT,
		self::BUTTON_1_HREF,
		self::BUTTON_2_CLASS,
		self::BUTTON_2_TEXT,
		self::BUTTON_2_HREF,
		self::BUTTON_3_CLASS,
		self::BUTTON_3_TEXT,
		self::BUTTON_3_HREF,
		self::LINE_1_TEXT,
		self::LINE_1_HREF,
		self::LINE_2_TEXT,
		self::LINE_2_HREF,
		self::LINE_3_TEXT,
		self::LINE_3_HREF,
		self::LINE_4_TEXT,
		self::LINE_4_HREF,
		self::LINE_5_TEXT,
		self::LINE_5_HREF
	);


	public function getBarContents() {
		$this->wf->profileIn(__METHOD__);

		$dataMemcKey = $this->wf->SharedMemcKey('WikiaBar', $this->getLang(), $this->getVertical(), self::WIKIABAR_MCACHE_VERSION);
		$data = $this->wg->memc->get($dataMemcKey);

		if (!$data) {
			$data = $this->getParsedBarConfiguration();
			$this->wg->memc->set($dataMemcKey, $data);
		}

		$data['data'] = $this->structureData($data['data']);

		$this->wf->profileOut(__METHOD__);
		return $data;
	}

	protected function getParsedBarConfiguration() {
		$message = $this->getRegularMessage();
		$validator = F::build('WikiaBarMessageDataValidator');
		$parseResult = $this->parseBarConfigurationMessage($message, $validator);
		$status = true;

		if (!$parseResult) {
			Wikia::log(__METHOD__, null, 'WikiaBar message ' . implode('', array($this->getVertical(), '/', $this->getLang())) . ' falling back to failsafe');
			$message = $this->getFailsafeMessage();
			$validator = F::build('WikiaBarFailsafeDataValidator');
			$parseResult = $this->parseBarConfigurationMessage($message, $validator);
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
	protected function parseBarConfigurationMessage($message, WikiaBarDataValidator $validator) {
		$this->wf->profileIn(__METHOD__);
		$data = array();
		$valid = true;

		if (!$validator->isNotEmpty($message)) {
			$valid = false;
		} else {
			$lines = explode("\n", $message);
		}

		if (empty($lines)) {
			$lines = array();
			$valid = false;
		}

		foreach ($lines as $line) {
			if (stripos($line, '=') === false) {
				$valid = false;
				break;
			}

			if (!$validator->validateLine($line)) {
				$valid = false;
				break;
			}

			list($key, $val) = explode('=', $line, 2);
			$data[$key] = trim($val);
		}

		if (count(array_intersect(array_keys($data), $this->requiredFields)) != count($this->requiredFields)) {
			$valid = false;
		}

		$this->wf->profileOut(__METHOD__);
		if ($valid) {
			return $data;
		} else {
			return $valid;
		}
	}

	protected function structureData($data) {
		$data = array(
			'buttons' =>
			array(
				array(
					'class' => $data[self::BUTTON_1_CLASS],
					'text' => $data[self::BUTTON_1_TEXT],
					'href' => $data[self::BUTTON_1_HREF]
				),
				array(
					'class' => $data[self::BUTTON_2_CLASS],
					'text' => $data[self::BUTTON_2_TEXT],
					'href' => $data[self::BUTTON_2_HREF]
				),
				array(
					'class' => $data[self::BUTTON_3_CLASS],
					'text' => $data[self::BUTTON_3_TEXT],
					'href' => $data[self::BUTTON_3_HREF]
				)
			),
			'messages' =>
			array(
				array(
					'text' => $data[self::LINE_1_TEXT],
					'href' => $data[self::LINE_1_HREF],
				),
				array(
					'text' => $data[self::LINE_2_TEXT],
					'href' => $data[self::LINE_2_HREF],
				),
				array(
					'text' => $data[self::LINE_3_TEXT],
					'href' => $data[self::LINE_3_HREF],
				),
				array(
					'text' => $data[self::LINE_4_TEXT],
					'href' => $data[self::LINE_4_HREF],
				),
				array(
					'text' => $data[self::LINE_5_TEXT],
					'href' => $data[self::LINE_5_HREF],
				)
			)
		);
		return $data;
	}

	public function getData() {
		return $this->getBarContents();
	}
}
