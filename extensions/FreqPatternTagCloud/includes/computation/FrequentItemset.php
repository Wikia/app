<?php

/**
 * Frequent Pattern Tag Cloud Plug-in
 * Frequent itemset
 * 
 * @author Tobias Beck, University of Heidelberg
 * @author Andreas Fay, University of Heidelberg
 * @version 1.0
 */

class FrequentItemset {
	/**
	 * Items
	 *
	 * @var array 
	 */
	private $_items;
	
	/**
	 * Support
	 *
	 * @var float 
	 */
	private $_support;
	
	
	/**
	 * Constructor. Sorts $items.
	 *
	 * @param array $items 
	 * @param float $support 
	 * @return FrequentItemset 
	 */
	public function __construct(array $items, $support) {
		sort($items);
		$this->_items = $items;
		$this->_support = $support;
	}
	
	/**
	 * Gets items
	 *
	 * @return array Items
	 */
	public function getItems() {
		return $this->_items;
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
	 * Sets support
	 *
	 * @param float $support 
	 * @return void 
	 */
	public function setSupport($support) {
		$this->_support = $support;
	}
}
