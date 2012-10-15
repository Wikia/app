<?php




class WikiaBarMessageDataValidator implements WikiaBarDataValidator {
	const MAX_BUTTON_COPY_LENGTH = 15;
	const MAX_MESSAGE_LENGTH = 120;
	protected $errors = array();
	protected $errorcount = 0;

	/**
	 * @param $value string
	 * @return bool
	 * @todo include the possibility of '0' string
	 */
	public function isNotEmpty($value) {
		$trimmed = trim($value);
		return !empty($trimmed);
	}

	public function validateLine($line) {
		$valid = true;
		if (!$this->isNotEmpty($line)) {
			$valid = false;
		}

		list($key, $val) = explode('=', $line, 2);

		if (
			$this->isButtonCopyKey($key)
			&& !$this->isButtonCopyValid($val)
		) {
			$this->addError(wfMsg('wikiabar-validation-message-too-long',$key));
			$valid = false;
		}

		if (
			$this->isMessageLineKey($key)
			&& !$this->isMessageLineValid($val)
		) {
			$this->addError(wfMsg('wikiabar-validation-message-too-long',$key));
			$valid = false;
		}

		return $valid;
	}

	public function isArrayASuperArrayOf($array1, $array2) {
		$valid = true;
		if(count(array_intersect($array1, $array2)) != count($array2)) {
			$this->addError(wfMsg('wikiabar-validation-wrong-element-count'));
			$valid = false;
		}

		return $valid;
	}

	public function clearErrors() {
		$this->errors = array();
		$this->errorcount = 0;
	}

	public function getErrors() {
		return $this->errors;
	}

	public function getErrorCount() {
		return $this->errorcount;
	}

	protected function addError($errorMessage) {
		$this->errorcount++;
		if (!in_array($errorMessage, $this->errors)) {
			$this->errors [] = $errorMessage;
		}
	}

	protected function isMessageLineKey($key) {
		return in_array($key, array(WikiaBarModel::LINE_1_TEXT, WikiaBarModel::LINE_2_TEXT, WikiaBarModel::LINE_3_TEXT, WikiaBarModel::LINE_4_TEXT, WikiaBarModel::LINE_5_TEXT));
	}

	protected function isButtonCopyKey($key) {
		return in_array($key, array(WikiaBarModel::BUTTON_1_TEXT, WikiaBarModel::BUTTON_2_TEXT, WikiaBarModel::BUTTON_3_TEXT));
	}

	protected function isButtonCopyValid($value) {
		$valid = true;
		if (mb_strlen($value) > self::MAX_BUTTON_COPY_LENGTH) {
			$valid = false;
		}
		return $valid;
	}

	protected function isMessageLineValid($value) {
		$valid = true;
		if (mb_strlen($value) > self::MAX_MESSAGE_LENGTH) {
			$valid = false;
		}
		return $valid;
	}
}