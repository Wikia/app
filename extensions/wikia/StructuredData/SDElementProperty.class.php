<?php
/**
 * @author ADi
 */
class SDElementProperty extends SDObject implements SplObserver {
	protected $type = array( 'name' => '@set', 'range' => null );
	protected $name = null;
	protected $label = '';
	protected $value = null;

	function __construct($name, $value, $type = false) {
		$this->name = $name;

		$nameParts = explode( ':', $name );
		$this->label = count($nameParts) > 1 ? $nameParts[1] : $name;

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

	//public function getValue() {
	//	return ( in_array( $this->getTypeName(), array( '@set', '@list' ) ) && !is_array( $this->value ) ) ? array( $this->value ) : $this->value;
	//}

	public function getValue( $index = 0 ) {
		$value = null;
		$values = $this->getValues();

		if(is_array( $values ) && isset($values[$index])) {
			$value = $values[$index];
		}
		elseif(!is_array( $values )) {
			$value = $values;
		}

		return $value;
	}

	public function getValues() {
		return ( in_array( $this->getTypeName(), array( '@set', '@list' ) ) && !is_array( $this->value ) ) ? array( $this->value ) : $this->value;
	}


	public function expandValue(StructuredData $structuredData, $elementDepth) {
		$value = $this->value;
		if(is_object($value) && isset($value->id)) {
			$value = array( $value );
		}

		if(is_array($value)) {
			foreach($value as $v) {
				if(isset($v->id)) {
					try {
						$SDElement = $structuredData->getSDElementById($v->id, $elementDepth+1);
						$v->object = $SDElement;
					}
					catch(WikiaException $e) {
						$v->object = null;
					}
				}
			}
		}
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function getName() {
		return $this->name;
	}

	public function setLabel($label) {
		$this->label = $label;
	}

	public function getLabel() {
		return $this->label;
	}

	public function toArray() {
		if($this->value instanceof SDElement) {
			$array = $this->value->toArray();
		}
		else {
			$array = array(
				'type' => $this->type,
				'name' => $this->name,
				'label' => $this->label,
				'value' => $this->value //$this->getValues()
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
		$type = $subject->getContext()->getType( $this->name );
		if($type) {
			$this->type = $type;
		}
	}

	public function getTypeName() {
		return $this->type['name'];
	}

	/*
	public function render( $context = SD_CONTEXT_DEFAULT ) {
		$result = parent::render( $context );
		return ( $result !== false ) ? $result : $this->getValue();
	}
	*/
}
