<?
class Label extends FormElement {
	protected $message;
	protected $fieldId;
	protected $templateEngine;

	public function __construct(Message $message) {
		$this->setMessage($message);

		parent::__construct();
	}

	public function setMessage(Message $message) {
		$this->message = $message;
	}

	public function getMessage() {
		return $this->message;
	}

	public function render($attributes = [], $fieldId) {
		// TODO icon - maybe we can extract it to separate class
		$data = [
			'icon' => 1,
			'fieldId' => $fieldId,
			'message' => $this->getMessage(),
			'attributes' => $this->prepareHtmlAttributes($attributes)
		];
		return $this->renderView(__CLASS__, 'render', $data);
	}

	protected function getDirectory() {
		return dirname(__FILE__);
	}
}