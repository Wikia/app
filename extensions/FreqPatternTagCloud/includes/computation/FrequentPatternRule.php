<?php

/**
 * Frequent Pattern Tag Cloud Plug-in
 * Frequent pattern rule
 * 
 * @author Tobias Beck, University of Heidelberg
 * @author Andreas Fay, University of Heidelberg
 * @version 1.0
 */

include_once("exceptions/InvalidItemCollectionException.php");

class FrequentPatternRule {
	/**
	 * Assumption of rule
	 *
	 * @var array 
	 */
	private $_assumption;
	
	/**
	 * Conclusion of rule
	 *
	 * @var array 
	 */
	private $_conclusion;
	
	/**
	 * Confidence
	 *
	 * @var float 
	 */
	private $_confidence;
	
	/**
	 * Support
	 *
	 * @var float 
	 *
	 */
	private $_support;
	
	
	/**
	 * Constructor
	 *
	 * @param array $assumption 
	 * @param array $conclusion 
	 * @param float $support 
	 * @param float $confidence 
	 * @return FrequentPatternRule
	 * @throws InvalidItemCollectionException If assumption and/or conclusion are empty
	 */
	public function __construct(array $assumption, array $conclusion, $support, $confidence = 0) {
		// Check whether assumption and/or conclusion contain >= 1 items
		if (count($assumption) == 0 || count($conclusion) == 0) {
			throw new InvalidItemCollectionException();
		}
		
		$this->_assumption = $assumption;
		$this->_conclusion = $conclusion;
		$this->_confidence = $confidence;
		$this->_support = $support;
	}
	
	/**
	 * Gets assumption
	 *
	 * @return array 
	 */
	public function getAssumption() {
		return $this->_assumption;
	}
	
	/**
	 * Gets conclusion
	 *
	 * @return array 
	 */
	public function getConclusion() {
		return $this->_conclusion;
	}
	
	/**
	 * Gets confidence
	 *
	 * @return float 
	 */
	public function getConfidence() {
		return $this->_confidence;
	}
	
	/**
	 * Gets support
	 *
	 * @return float 
	 */
	public function getSupport() {
		return $this->_support;
	}
	
	/**
	 * Sets confidence
	 *
	 * @param float $confidence 
	 * @return void 
	 */
	public function setConfidence($confidence) {
		$this->_confidence = $confidence;
	}
}
