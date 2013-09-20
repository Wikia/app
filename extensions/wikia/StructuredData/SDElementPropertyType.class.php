<?php
/**
 * @author ADi
 */
class SDElementPropertyType {
	protected $name;
	/**
	 * @var SDElementPropertyTypeRange
	 */
	protected $range;

	public function __construct($name = '@set', array $rawRange = null) {
		$this->name = $name;

		if( !empty($rawRange) ) {
			$this->range = new SDElementPropertyTypeRange( $rawRange );
		}
	}

	public function isCollection() {
		return in_array( $this->name, array( '@set', '@list' ) );
			}

	public function setName($name) {
		$this->name = $name;
	}

	public function getName() {
		return $this->name;
	}

	public function setRange(SDElementPropertyTypeRange $range) {
		if ($range->isEnum()) $this->name = 'enum';
		$this->range = $range;
	}

	/**
	 * @return SDElementPropertyTypeRange
	 */
	public function getRange() {
		return $this->range;
	}

	public function hasRange() {
		return ( !empty($this->range) ? true : false );
	}

	public function getAcceptedValues() {
		if($this->hasRange()) {
			return $this->getRange()->getAcceptedValues();
		}
		return array();
	}

}
