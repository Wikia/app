<?
class Label extends FormElement {
	/**
	 * Message that should be render in label tag
	 * @var Message
	 */
	protected $message;

	/**
	 * Constructor
	 * @param Message $message
	 */
	public function __construct(Message $message) {
		$this->setMessage($message);

		parent::__construct();
	}

	/**
	 * Set label message
	 * @param Message $message
	 */
	public function setMessage(Message $message) {
		$this->message = $message;
	}

	/**
	 * Get message
	 * @return Message
	 */
	public function getMessage() {
		return $this->message;
	}

	/**
	 * Render label
	 *
	 * @param string $fieldId field id
	 * @param array $attributes html attributes
	 * @return string
	 */
	public function render($fieldId, $attributes = []) {
		$data = [
			'fieldId' => $fieldId,
			'message' => $this->getMessage()->text(),
			'attributes' => $this->prepareHtmlAttributes($attributes)
		];
		return $this->renderView(__CLASS__, 'render', $data);
	}

	/**
	 * @see FormElement
	 */
	protected function getDirectory() {
		return dirname(__FILE__);
	}
}