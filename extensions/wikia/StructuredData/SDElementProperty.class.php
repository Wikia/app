<?php
/**
 * @author ADi
 */
class SDElementProperty implements SplObserver {
	protected $type = 'rdf:Literal';
	protected $name = null;
	protected $value = null;

	function __construct($name, $value, $type = false) {
		$this->name = $name;
		$this->value = $value;
		if($type !== false) {
			$this->type = $type;
		}
	}

	public function setType($type) {
		$this->type = $type;
	}

	public function getType() {
		return $this->type;
	}

	public function setValue($value) {
		$this->value = $value;
	}

	public function getValue() {
		return $this->value;
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function getName() {
		return $this->name;
	}

	public function toArray() {
		if($this->value instanceof SDElement) {
			$array = $this->value->toArray();
		}
		else {
			$array = array(
				'type' => $this->type,
				'name' => $this->name,
				'value' => $this->value
			);

		}

		return $array;
	}

	/**
	 * (PHP 5 &gt;= 5.1.0)<br/>
	 * Receive update from subject
	 * @link http://php.net/manual/en/splobserver.update.php
	 * @param SplSubject|SDElement $subject <p>
	 * The <b>SplSubject</b> notifying the observer of an update.
	 * </p>
	 * @return void
	 */
	public function update(SplSubject $subject) {
		$this->type = $subject->getContext()->getType( $this->name );
	}


}
