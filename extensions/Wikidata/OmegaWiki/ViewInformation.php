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
	public $filterLanguageId;
	public $queryTransactionInformation;
	public $showRecordLifeSpan;
	public $viewOrEdit;
	
	protected $propertyToColumnFilters;
	
	public function __construct() {
		$this->filterLanguageId = 0;
		$this->queryTransactionInformation;
		$this->showRecordLifeSpan = false; 
		$this->propertyToColumnFilters = array();
		$this->viewOrEdit = "view";
	}
	
	public function hasMetaDataAttributes() {
		return $this->showRecordLifeSpan;
	}
	
	public function filterOnLanguage() {
		return $this->filterLanguageId != 0;
	}
	
	public function setPropertyToColumnFilters(array $propertyToColumnFilters) {
		$this->propertyToColumnFilters = $propertyToColumnFilters;
	}
	
	public function getPropertyToColumnFilters() {
		return $this->propertyToColumnFilters;
	}
	
	public function getLeftOverAttributeFilter() {
		$allFilteredAttributeIds = array();	
		
		foreach ($this->getPropertyToColumnFilters() as $propertyToColumnFilter)  
			$allFilteredAttributeIds = array_merge($allFilteredAttributeIds, $propertyToColumnFilter->attributeIDs);
		
		return new ExcludeAttributeIDsFilter($allFilteredAttributeIds);
	}

	/* make an attempt at a hashCode function.
	 * note that this function is imperfect..., I've left out
	 * some attributes because I am lazy. 
	 * please check and recheck when creating new viewinformation
	 * when using such viewinformation together with OmegaWikiAttributes.
	 */
	public function hashCode() {
		return
			$this->filterLanguageId.",".
			$this->showRecordLifeSpan.",".
			$this->viewOrEdit;
	}

	public function __tostring(){
		return "viewinformation object>";
	}
}

?>
