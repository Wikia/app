<?php

/**
 * Frequent Pattern Tag Cloud Plug-in
 * Tag
 * 
 * @author Tobias Beck, University of Heidelberg
 * @author Andreas Fay, University of Heidelberg
 * @version 1.0
 */

class Tag {
	/**
	 * Id
	 * 
	 * @var int
	 */
	private $_id;
	
	/**
	 * Rate of tag in respect to all tags
	 *
	 * @var float 
	 *
	 */
	private $_rate;
	
	/**
	 * Value
	 *
	 * @var string 
	 */
	private $_value;
	
	
	/**
	 * Constructor
	 *
	 * @param int $id
	 * @param string $value 
	 * @param float $rate 
	 * @return Tag 
	 */
	public function __construct($id, $value, $rate) {
		$this->_id = $id;
		$this->_value = $value;
		$this->_rate = $rate;
	}
	
	/**
	 * Gets id
	 *
	 * @return int
	 *
	 */
	public function getId() {
		return $this->_id;
	}
	
	/**
	 * Gets rate
	 *
	 * @return float 
	 *
	 */
	public function getRate() {
		return $this->_rate;
	}
	
	/**
	 * Gets value
	 *
	 * @return string 
	 *
	 */
	public function getValue() {
		return $this->_value;
	}
}
