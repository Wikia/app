<?php




class WikiaBarMessageDataValidator implements WikiaBarDataValidator {
	const MAX_BUTTON_COPY_LENGTH = 15;
	const MAX_MESSAGE_LENGTH = 120;

	/**
	 * @param $value string
	 * @return bool
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
			$valid = false;
		}

		if (
			$this->isMessageLineKey($key)
			&& !$this->isMessageLineValid($val)
		) {
			$valid = false;
		}

		return $valid;
	}

	protected function isMessageLineKey($key) {
		return in_array($key, array(WikiaBarModel::LINE_1_TEXT, WikiaBarModel::LINE_2_TEXT, WikiaBarModel::LINE_3_TEXT, WikiaBarModel::LINE_4_TEXT, WikiaBarModel::LINE_5_TEXT));
	}

	protected function isButtonCopyKey($key) {
		return in_array($key, array(WikiaBarModel::BUTTON_1_TEXT, WikiaBarModel::BUTTON_2_TEXT, WikiaBarModel::BUTTON_3_TEXT));
	}

	protected function isButtonCopyValid($value) {
		$valid = false;
		if (mb_strlen($value) > self::MAX_BUTTON_COPY_LENGTH) {
			$valid = false;
		}
		return $valid;
	}

	protected function isMessageLineValid($value) {
		$valid = false;
		if (mb_strlen($value) > self::MAX_MESSAGE_LENGTH) {
			$valid = false;
		}
		return $valid;
	}
}