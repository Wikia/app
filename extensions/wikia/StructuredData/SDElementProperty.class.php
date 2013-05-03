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
	private $_value = null; // cached SDElementPropertyValue object(s), used by getWrappedValue
	protected $label = '';

	function __construct($name, $value, SDElementPropertyType $type = null) {
		$this->name = $name;
		$nameParts = explode( ':', $name );
		$this->label = count($nameParts) > 1 ? $nameParts[1] : $name;
		$this->value = $value;

		if($type instanceof SDElementPropertyType) {
			$this->type = $type;
		}
		else {
			$this->type = (new SDElementPropertyType);
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
	 * get SDS compatible json representation of this object
	 * @return string
	 */
	public function toSDSJson() {
		$value = $this->getWrappedValue();
		if ( $this->isCollection() ) {
			$values = array();
			foreach($value as $v) {
				$values[] = $v->convertValueToSDSJson();
			}
			$value = $values;
		} else {
			$value = $value->convertValueToSDSJson();
		}
		return $value;
	}

	/**
	 * Parses a single value posted by a user
	 * @param $value from the request
	 * @return anyType
	 */
	protected function parseRequestValue( $value ) {
		$value = trim( $value );
		$range = $this->getType()->getRange();
		$rangeClasses = ($range) ? $this->getType()->getRange()->getClasses() : array('rdfs:Literal');
		if ( $range && $range->isEnum() ) {
			if ( empty($value) ) return null;
			return $value;
		}
		if ( in_array('rdfs:Literal', $rangeClasses) || in_array('xsd:anyURI', $rangeClasses) || in_array('xsd:integer', $rangeClasses) ||  in_array('xsd:hexBinary', $rangeClasses) ) {
			return $value;
		}
		elseif ( in_array('xsd:boolean', $rangeClasses) ) {
			return ($value == -1) ? null : ( (bool) $value );
		}
		$valueObject = new stdClass();
		$valueObject->id = $value;
		$valueObject->object = null;
		return $valueObject;
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

	public function appendValue( $value ) {
		if($this->isCollection()) {
			$values = $this->getCurrentValue();
			$values[] = $value;
			$this->setValue( $values );
		}
		else {
			throw new WikiaException('appendValue called for non-collection property');
		}
	}

	private function getCurrentValue() {
		if($this->isCollection()) {
			if ( is_array( $this->value ) ) {
				if ((count($this->value) == 1) && (empty($this->value[0]))) $values = array();
				else $values = $this->value;
			} else {
				$values = ( empty( $this->value ) ) ? array() : array( $this->value );
			}
			return $values;
		}
		return $this->value;
	}

	public function isCollection() {
		return $this->getType()->isCollection();
	}

	/**
	 * Return property value(s) wrapped in SDElementPropertyValue instance(s)
	 * @return SDElementPropertyValue instance or array of SDElementPropertyValue instances in case of collection
	 */
	public function getWrappedValue() {
		if ( is_null( $this->_value ) ) {
			if ( !$this->isCollection()) {
				$this->_value = new SDElementPropertyValue( $this->getType(), $this->value, $this->getName() );

			} else {
				$this->_value = array();
				foreach($this->getCurrentValue() as $value) {
					$this->_value[] = new SDElementPropertyValue( $this->getType(), $value, $this->getName() );
				}
			}
		}
		return $this->_value;
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
			$this->type = new SDElementPropertyType( $type['name'], $type['range'] );
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
				$this->getType()->setRange( new SDElementPropertyTypeRange( $propertyDescription->range ) );
			} else {

				if ( $guessType && ( !in_array( $this->getName(), array( 'schema:relatedTo', 'callofduty:team', 'wikia:characterIn') ) ) )  {
					$this->getType()->setName('rdfs:Literal');
				}
			}
		}
	}

	public function getTypeName() {
		return $this->getType()->getName();
	}

	public function getRendererNames() {
		//echo "SDElementProperty - returning renderers ".json_encode(array($this->getName(), $this->getTypeName()))." for property " .$this->getName(). "<br/>\n";
		return array( $this->getName(), $this->getTypeName() );
	}
}
