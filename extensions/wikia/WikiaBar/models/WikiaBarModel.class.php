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
	const WIKIA_BAR_MCACHE_VERSION = '0.20.1333';
	const WIKIA_BAR_DEFAULT_LANG_CODE = 'en';

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
		wfProfileIn(__METHOD__);

		$dataMemcKey = $this->getMemcKey();
		Wikia::log(__METHOD__, '', 'Reading ' . $dataMemcKey);
		$data = $this->wg->memc->get($dataMemcKey);

		if (!$data) {
			Wikia::log(__METHOD__, '', 'Memcache entry ' . $dataMemcKey . ' empty');
			$data = $this->getParsedBarConfiguration();
			$this->wg->memc->set($dataMemcKey, $data);
		}

		$data['data'] = $this->structuredData($data['data']);

		wfProfileOut(__METHOD__);
		return $data;
	}

	protected function getParsedBarConfiguration() {
		$message = $this->getRegularMessage();

		/** @var $validator WikiaBarMessageDataValidator */
		$validator = new WikiaBarMessageDataValidator();
		$parseResult = $this->parseBarConfigurationMessage($message, $validator);
		$status = true;

		// Result from message is empty. Trying to get failsafe
		if (!$parseResult) {
			$parseResult = $this->getParsedFailsafeResult();
			$status = false;
		}

		// Result from failsafe is empty. Trying to get from english message
		if (!$parseResult && $this->getLang() != self:: WIKIA_BAR_DEFAULT_LANG_CODE) {
			$parseResult = $this->getParsedMessageFromDefaultLang();
			$status = false;
		}

		// Result from english message is empty. Trying to get from english failsafe
		if (!$parseResult && $this->getLang() != self:: WIKIA_BAR_DEFAULT_LANG_CODE) {
			$parseResult = $this->getParsedFailsafeMessageFromDefaultLang();
			$status = false;
		}

		$data = array(
			'data' => $parseResult,
			'status' => $status
		);
		return $data;
	}

	protected function getParsedFailsafeMessageFromDefaultLang() {
		$tmpLang = $this->getLang();
		$this->setLang(self::WIKIA_BAR_DEFAULT_LANG_CODE);
		$dataMemcKey = $this->getMemcKey();
		Wikia::log(__METHOD__, null, 'WikiaBar configured en message ' . $dataMemcKey . ' empty, trying en failsafe');
		$message = $this->getFailsafeMessage();
		/** @var $validator WikiaBarFailsafeDataValidator */
		$validator = new WikiaBarFailsafeDataValidator();
		$parseResult = $this->parseBarConfigurationMessage($message, $validator);
		$this->setLang($tmpLang);
		return $parseResult;
	}

	protected function getParsedMessageFromDefaultLang() {
		$tmpLang = $this->getLang();
		$this->setLang(self::WIKIA_BAR_DEFAULT_LANG_CODE);
		$dataMemcKey = $this->getMemcKey();
		Wikia::log(__METHOD__, null, 'WikiaBar failsafe message ' . $dataMemcKey . ' empty, trying configured en');
		$message = $this->getRegularMessage();
		/** @var $validator WikiaBarMessageDataValidator */
		$validator = new WikiaBarMessageDataValidator();
		$parseResult = $this->parseBarConfigurationMessage($message, $validator);
		$this->setLang($tmpLang);
		return $parseResult;
	}

	protected function getParsedFailsafeResult() {
		$dataMemcKey = $this->getMemcKey();
		Wikia::log(__METHOD__, null, 'WikiaBar message ' . $dataMemcKey . ' falling back to failsafe');
		$message = $this->getFailsafeMessage();
		/** @var $validator WikiaBarFailsafeDataValidator */
		$validator = new WikiaBarFailsafeDataValidator();
		$parseResult = $this->parseBarConfigurationMessage($message, $validator);
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
	 * @todo: fatal error if $model = false
	 */
	protected function getMessageFromModel($model) {
		wfProfileIn(__METHOD__);
		if ($model instanceof WikiaBarModelBase) {
			$model->setLang($this->getLang());
			$model->setVertical($this->getVertical());
			$data = $model->getData();
		} else {
			$data = false;
		}
		wfProfileOut(__METHOD__);
		return $data;
	}

	/**
	 * @param int $modelType
	 * @return bool|WikiaBarModelBase
	 */
	protected
	function getModel($modelType) {
		switch ($modelType) {
			case self::WIKIA_BAR_TYPE_DATA_MODEL:
				$model = new WikiaBarDataModel();
				break;
			case self::WIKIA_BAR_TYPE_DATA_FAILSAFE_MODEL:
				$model = new WikiaBarDataFailsafeModel();
				break;
			default:
				$model = false;
		}
		return $model;
	}

	/**
	 * @param string $message
	 * @param WikiaBarDataValidator $validator
	 * @return bool|array
	 */
	public
	function parseBarConfigurationMessage($message, WikiaBarDataValidator &$validator) {
		wfProfileIn(__METHOD__);
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
			$line = trim($line);
			if (stripos($line, '=') === false) {
				$valid = false;
			}

			if (!$validator->validateLine($line)) {
				$valid = false;
			}

			list($key, $val) = explode('=', $line, 2);
			$data[$key] = trim($val);
		}

		if (!$validator->isArrayASuperArrayOf(array_keys($data), $this->requiredFields)) {
			$valid = false;
		}

		wfProfileOut(__METHOD__);
		if ($valid) {
			return $data;
		} else {
			return $valid;
		}
	}

	protected
	function structuredData($data) {
		$structuredData = array(
			'buttons' => array(),
			'messages' => array()
		);

		if (
			!empty($data[self::BUTTON_1_CLASS])
			&& !empty($data[self::BUTTON_1_TEXT])
			&& !empty($data[self::BUTTON_1_HREF])
		) {
			$structuredData['buttons'] [] =
				array(
					'class' => $data[self::BUTTON_1_CLASS],
					'text' => $data[self::BUTTON_1_TEXT],
					'href' => $data[self::BUTTON_1_HREF]
				);
		}

		if (
			!empty($data[self::BUTTON_2_CLASS])
			&& !empty($data[self::BUTTON_2_TEXT])
			&& !empty($data[self::BUTTON_2_HREF])
		) {
			$structuredData['buttons'] [] =
				array(
					'class' => $data[self::BUTTON_2_CLASS],
					'text' => $data[self::BUTTON_2_TEXT],
					'href' => $data[self::BUTTON_2_HREF]
				);
		}

		if (
			!empty($data[self::BUTTON_3_CLASS])
			&& !empty($data[self::BUTTON_3_TEXT])
			&& !empty($data[self::BUTTON_3_HREF])
		) {
			$structuredData['buttons'] [] =
				array(
					'class' => $data[self::BUTTON_3_CLASS],
					'text' => $data[self::BUTTON_3_TEXT],
					'href' => $data[self::BUTTON_3_HREF]
				);
		}

		if (
			!empty($data[self::LINE_1_TEXT])
			&& !empty($data[self::LINE_1_HREF])
		) {
			$structuredData['messages'] [] =
				array(
					'text' => $data[self::LINE_1_TEXT],
					'href' => $data[self::LINE_1_HREF],
				);
		}

		if (
			!empty($data[self::LINE_2_TEXT])
			&& !empty($data[self::LINE_2_HREF])
		) {
			$structuredData['messages'] [] =
				array(
					'text' => $data[self::LINE_2_TEXT],
					'href' => $data[self::LINE_2_HREF],
				);
		}

		if (
			!empty($data[self::LINE_3_TEXT])
			&& !empty($data[self::LINE_3_HREF])
		) {
			$structuredData['messages'] [] =
				array(
					'text' => $data[self::LINE_3_TEXT],
					'href' => $data[self::LINE_3_HREF],
				);
		}

		if (
			!empty($data[self::LINE_4_TEXT])
			&& !empty($data[self::LINE_4_HREF])
		) {
			$structuredData['messages'] [] =
				array(
					'text' => $data[self::LINE_4_TEXT],
					'href' => $data[self::LINE_4_HREF],
				);
		}

		if (
			!empty($data[self::LINE_5_TEXT])
			&& !empty($data[self::LINE_5_HREF])
		) {
			$structuredData['messages'] [] =
				array(
					'text' => $data[self::LINE_5_TEXT],
					'href' => $data[self::LINE_5_HREF],
				);
		}

		return $structuredData;
	}

	public
	function getData() {
		return $this->getBarContents();
	}

	protected
	function getMemcKey() {
		return wfSharedMemcKey('WikiaBarContents', $this->getVertical(), $this->getLang(), self::WIKIA_BAR_MCACHE_VERSION);
	}
}
