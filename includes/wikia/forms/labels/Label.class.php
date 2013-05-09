<?
class Label {
	protected $message;

	public function __construct(Message $message) {
		$this->setMessage($message);
	}

	public function setMessage(Message $message) {
		$this->message = $message;
	}

	public function render($fieldName) {
		// TODO icon - maybe we can extract it to separate class
	}
}