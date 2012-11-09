<?php
/**
 * @author ADi
 */
class SDElementProperty extends SDRenderableObject implements SDObject, SplObserver {
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

	public function getValue() {
		if ( $this->isCollection()) {
			if (!is_array( $this->value )) {
				if ( empty( $this->value ) ) return array();
				return array( $this->value );
			} else {
				if ((count($this->value) == 1) && (empty($this->value[0]))) return array();
			}
		}



		return $this->value;
	}

	public function isCollection() {
		return in_array( $this->getTypeName(), array( '@set', '@list' ) );
	}

	public function getValueObject() {
		$value = $this->getValue();
		$type = $this->getType();
		if ( !$this->isCollection()) {
			return F::build('SDValueObject', array( 'object' => $this, 'value' => $value, 'range' => $type['range'] ) );
		}
		$result = array();
		foreach($value as $v) {
			return F::build('SDValueObject', array( 'object' => $this, 'value' => $v, 'range' => $type['range'] ) );
		}
		return $result;

	}

	public function hasNoValue() {
		$value = $this->getValue();
		return ( empty($value) ) ? true : false;
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
		$guessType = true;
		if($type) {
			$this->type = $type;
			//echo "Setting type ".$this->type['name']." for property ".$this->name."<br/>\n";
			$guessType = false;
		}

		if(empty($this->type['range'])) {
			$propertyDescription = $subject->getContext()->getPropertyDescription( $subject->getType(), $this->name );
			if(is_object($propertyDescription) && isset($propertyDescription->range)) {
				//echo "Setting range".json_encode($propertyDescription->range)." for property ".$this->name."<br/>\n";
				if ( $guessType && (count($propertyDescription->range) == 1) ) {
					if ($propertyDescription->range[0]->id == "rdfs:Literal") {
						$this->type['name'] = $propertyDescription->range[0]->id;
						//echo "FORCING type ".$this->type['name']." for property ".$this->name."<br/>\n";
					}
					//$this->type['name'] = isset($propertyDescription->range[0]->type) ? $propertyDescription->range[0]->type : $propertyDescription->range[0]->id;
				}
				$this->type['range'] = $propertyDescription->range;
			}
		}
	}

	public function getTypeName() {
		return $this->type['name'];
	}

	public function getRendererNames() {
		return array($this->getName(), $this->getTypeName());
	}
	/*
	public function render( $context = SD_CONTEXT_DEFAULT ) {
		$result = parent::render( $context );
		return ( $result !== false ) ? $result : $this->getValue();
	}
	*/
}
