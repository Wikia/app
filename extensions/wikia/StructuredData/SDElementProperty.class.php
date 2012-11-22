<?php
/**
 * @author ADi
 */
class SDElementProperty extends SDRenderableObject implements SplObserver {
	/**
	 * @var SDElementPropertyType
	 */
	protected $type = null;
	protected $name = null;
	protected $value = null;
	protected $label = '';
	private $_value = null; // cached SDElementPropertyValue object(s)

	function __construct($name, $value, SDElementPropertyType $type = null) {
		$this->name = $name;
		$nameParts = explode( ':', $name );
		$this->label = count($nameParts) > 1 ? $nameParts[1] : $name;
		$this->value = $value;

		if($type instanceof SDElementPropertyType) {
			$this->type = $type;
		}
		else {
			$this->type = F::build( 'SDElementPropertyType' );
		}
	}

	/**
	 * set property type
	 * @param SDElementPropertyType $type
	 */
	public function setType( SDElementPropertyType $type ) {
		$this->type = $type;
	}

	/**
	 * get property type
	 * @return SDElementPropertyType
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * used by toSDSJson to convert a single value
	 * @return string
	 */
	protected function convertValueToSDSJson($value) {
		if ( is_object($value) ) {
			$valueObject = new stdClass();
			if(isset($value->id)) {
				$valueObject->id = $value->id;
			}
			return $valueObject;
		}
		return $value;
	}

	/**
	 * get SDS compatible json representation of this object
	 * @return string
	 */
	public function toSDSJson() {
		$value = $this->getValue();
		if ( $this->isCollection() ) {
			$values = array();
			foreach($value as $v) {
				$values[] = $this->convertValueToSDSJson($v);
			}
			$value = $values;
		} else {
			$value = $this->convertValueToSDSJson($value);
		}
		return $value;
	}

	/**
	 * Parses a single value posted by a user
	 * @param $value from the request
	 * @return anyType
	 */
	protected function parseRequestValue( $value ) {
		$range = $this->getType()->getRange();
		$rangeClasses = ($range) ? $this->getType()->getRange()->getClasses() : array('rdfs:Literal');
		if ( $range && $range->isEnum() ) {
			if ( empty($value) ) return null;
			return $value;
		}
		if ( in_array('rdfs:Literal', $rangeClasses) || in_array('xsd:anyURI', $rangeClasses)  ) {
			return $value;
		}
		elseif ( in_array('xsd:boolean', $rangeClasses) ) {
			return ($value == -1) ? null : ( (bool) $value );
		}
		else {
			$valueObject = new stdClass();
			$valueObject->id = $value;
			$valueObject->object = null;
			return $valueObject;

		}
		return $value;
	}

	/**
	 * Set a field value based on request values
	 * @param $value single value or an array of values
	 */
	public function setValueFromRequest($value) {
		if ( $this->isCollection() ) {
			$parsedValue = array();
			if (empty($value)) $value = array();
			foreach($value as $v) {
				$parsedValue[] = $this->parseRequestValue($v);
			}
		} else {
			$parsedValue = $this->parseRequestValue($value);
		}
		$this->setValue( $parsedValue );
	}

	public function setValue($value) {
		$this->value = $value;
		$this->_value = null;
	}

	public function isCollection() {
		return $this->getType()->isCollection();
	}

	public function getValue() {
		if ( is_null( $this->_value ) ) {
			if ( !$this->isCollection()) {
				$this->_value = F::build( 'SDElementPropertyValue', array( 'type' => $this->getType(), 'value' => $this->value, 'propertyName' => $this->getName() ) );

			} else {
				$this->_value = array();
				if ( is_array( $this->value ) ) {
					if ((count($this->value) == 1) && (empty($this->value[0]))) $values = array();
					else $values = $this->value;
				} else {
					$values = ( empty( $this->value ) ) ? array() : array( $this->value );
				}
				foreach($values as $value) {
					$this->_value[] = F::build( 'SDElementPropertyValue', array( 'type' => $this->getType(), 'value' => $value, 'propertyName' => $this->getName() ) );
				}
			}
		}
		return $this->_value;
	}

	public function hasNoValue() {
		$value = $this->getValue();
		return ( empty($value) ) ? true : false;
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
			$this->type = F::build( 'SDElementPropertyType', array( 'name' => $type['name'], 'range' => $type['range'] ) );
			$guessType = false;
		}

		if(!$this->getType()->hasRange()) {
			$propertyDescription = $subject->getContext()->getPropertyDescription( $subject->getType(), $this->name );
			if(is_object($propertyDescription) && isset($propertyDescription->range) && (count($propertyDescription->range) > 0)) {
				//
				// schema:name
				if ( $guessType && (count($propertyDescription->range) == 1) ) {
					if ( ( $propertyDescription->range[0]->id == "rdfs:Literal" ) &&
						in_array( $this->getName(), array('schema:description', 'schema:name' ) ) ) {

						$this->getType()->setName( $propertyDescription->range[0]->id );
					}
				}
				$this->getType()->setRange( F::build( 'SDElementPropertyTypeRange', array( 'data' => $propertyDescription->range ) ) );
			} else {
				if ($guessType) $this->getType()->setName('rdfs:Literal');
			}
		}
	}

	public function getTypeName() {
		return $this->getType()->getName();
	}

	public function getRendererNames() {
		return array( $this->getName(), $this->getTypeName() );
	}
}
