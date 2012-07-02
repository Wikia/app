<?php

/**
 * ViewInformation is used to capture various settings that influence the way a page will be viewed
 * depending on different use case scenarios. For instance, by specifying a filterLanguageId, a page
 * will be filtered entirely on one language, collapsing record sets to records where appropiate.
 * 
 * A ViewInformation can be constructed based on various conditions. The language filtering for instance
 * could be an application wide setting, or a setting that can be controlled by the user. Functions that
 * use ViewInformation do not care about this. They are supposed to respect the settings provided wherever
 * possible.  
 */

class ViewInformation {
	/**
	* if != 0: shows only translations and definitions in this language
	* if = 0 : display all languages
	*/
	public $filterLanguageId;

	/**
	* The language of the expression being displayed in the Expression: namespace
	* i.e. the word being consulted
	*/
	public $expressionLanguageId;

	public $queryTransactionInformation;
	public $showRecordLifeSpan;
	public $viewOrEdit;                         ///< either "view" or "edit"
	
	protected $propertyToColumnFilters;
	
	/**
	 * Constructor
	 */
	public function __construct() {
		global $wgRequest ;

		$this->filterLanguageId = 0;
		$this->expressionLanguageId = $wgRequest->getVal( 'explang', 0 );
		$this->queryTransactionInformation = null;
		$this->showRecordLifeSpan = false;
		$this->propertyToColumnFilters = array();
		$this->viewOrEdit = "view";
	}
	
	public function hasMetaDataAttributes() {
		return $this->showRecordLifeSpan;
	}
	
	/**
	 * @return true if we are filtering according to a language
	 * @return false if all languages are displayed
	 */
	public function filterOnLanguage() {
		return $this->filterLanguageId != 0;
	}
	
	public function setPropertyToColumnFilters( array $propertyToColumnFilters ) {
		$this->propertyToColumnFilters = $propertyToColumnFilters;
	}
	
	public function getPropertyToColumnFilters() {
		return $this->propertyToColumnFilters;
	}
	
	public function getLeftOverAttributeFilter() {
		$allFilteredAttributeIds = array();
		
		foreach ( $this->getPropertyToColumnFilters() as $propertyToColumnFilter )
			$allFilteredAttributeIds = array_merge( $allFilteredAttributeIds, $propertyToColumnFilter->attributeIDs );
		
		return new ExcludeAttributeIDsFilter( $allFilteredAttributeIds );
	}

	/* make an attempt at a hashCode function.
	 * note that this function is imperfect..., I've left out
	 * some attributes because I am lazy. 
	 * please check and recheck when creating new viewinformation
	 * when using such viewinformation together with OmegaWikiAttributes.
	 */
	public function hashCode() {
		return
			$this->filterLanguageId . "," .
			$this->showRecordLifeSpan . "," .
			$this->viewOrEdit;
	}

	public function __tostring() {
		return "viewinformation object>";
	}
}

?>
