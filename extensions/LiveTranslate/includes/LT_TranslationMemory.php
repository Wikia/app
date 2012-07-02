<?php

/**
 * Class describing a translation memory.
 *
 * @since 0.4
 *
 * @file LT_TranslationMemory.php
 * @ingroup LiveTranslate
 *
 * @licence GNU GPL v3
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class LTTranslationMemory {
	
	/**
	 * List of translation units in the translation memory.
	 * 
	 * @since 0.4
	 * 
	 * @var array of LTTMUnit
	 */
	protected $translationUnits = array();
	
	/**
	 * Constructor for a new translation memory object.
	 * 
	 * @since 0.4
	 */	
	public function __construct() {
		
	}
	
	/**
	 * Adds a single LTTMUnit to the translation memory.
	 * 
	 * @since 0.4
	 * 
	 * @param LTTMUnit $tu
	 */		
	public function addTranslationUnit( LTTMUnit $tu ) {
		$this->translationUnits[] = $tu;
	}
	
	/**
	 * Constructor for a new translation memory object.
	 * 
	 * @since 0.4
	 */			
	public function getTranslationUnits() {
		return $this->translationUnits;
	}
	
	/**
	 * Returns the max amount of languages (variants) in a single translation unit.
	 * Note: this might not be the total amount of unique languages!
	 * 
	 * @since 0.4
	 * 
	 * @return integer
	 */	
	public function getLanguageAmount() {
		$maxAmount = 0;
		
		foreach ( $this->translationUnits as $tu ) {
			$amount = $tu->getLanguageAmount();
			
			if ( $amount > $maxAmount ) {
				$maxAmount = $amount;
			}
		}
		
		return $maxAmount;
	}
	
}
