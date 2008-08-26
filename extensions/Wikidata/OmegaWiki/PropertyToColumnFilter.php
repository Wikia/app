<?php

require_once('Attribute.php');

interface AttributeIDFilter {
	public function filter(array $attributeIDs);
	public function leavesOnlyOneOption();
}

class IncludeAttributeIDsFilter implements AttributeIDFilter {
	protected $attributeIDsToInclude;
	
	public function __construct($attributeIDsToInclude) {
		$this->attributeIDsToInclude = $attributeIDsToInclude;
	}

	public function filter(array $attributeIDs) {
		$result = array();
		
		foreach ($attributeIDs as $attributeID) 
			if (in_array($attributeID, $this->attributeIDsToInclude))
				$result[] = $attributeID;
			
		return $result;
	}

	public function leavesOnlyOneOption() {
		return count($this->attributeIDsToInclude) == 1;
	}
}

class ExcludeAttributeIDsFilter implements AttributeIDFilter {
	protected $attributeIDsToExclude;
	
	public function __construct($attributeIDsToExclude) {
		$this->attributeIDsToExclude = $attributeIDsToExclude;
	}

	public function filter(array $attributeIDs) {
		$result = array();
		
		foreach ($attributeIDs as $attributeID) 
			if (!in_array($attributeID, $this->attributeIDsToExclude))
				$result[] = $attributeID;
			
		return $result;
	}

	public function leavesOnlyOneOption() {
		return false;
	}
}

/**
 * Class PropertyToColumnFilter can be used to filter attribute values that are stored in a generic
 * three column table (object, attribute, value) into multiple tables with the same three column
 * structure. For every configured PropertyToColumnFilter a table will be created that contains the
 * values for the specified attributeIDs (i.e. the ids of the attributes, the second column).
 * 
 * The generated tables will appear in the user interface depending on the way the Editors are 
 * configured. Typically a two column table will be presented in a collapsable section or a popup. 
 * There are three captions that can be used to control the appearance of the table. 
 * 
 * 1) Section caption: will be used for the popup link or the section header
 * 2) Property caption: will be used as the caption of the first column
 * 3) Value caption: will be used as the caption of the second column
 * 
 * Example using 1) "References", 2) "Source" and 3) "Reference":
 * 
 * 	 References >>
 *   +--------------+---------------+
 *   | Source       | Reference     |
 *   +--------------+---------------+
 *   | Wikipedia    | ...           |
 *   | PubMed       | ...           |
 *   +--------------+---------------+
 */

class PropertyToColumnFilter {
	public $attributeIDs;   	// Array containing the defined meaning ids of the attributes that should be filtered
	protected $attribute;   	// Attribute
	protected $propertyCaption; // Caption of the first column
	protected $valueCaption; 	// Caption of the second column
	
	public function __construct($identifier, $sectionCaption, array $attributeIDs, $propertyCaption = "", $valueCaption = "") {
		$this->attributeIDs = $attributeIDs;
		$this->attribute = new Attribute($identifier, $sectionCaption, "will-be-specified-later");
		
		if ($propertyCaption != "")
			$this->propertyCaption = $propertyCaption;
		else
			$this->propertyCaption = "Property"; // wfMsgSc("Property"); does not work
			
		if ($valueCaption != "")
			$this->valueCaption = $valueCaption;
		else
			$this->valueCaption = "Value"; // wfMsgSc("Value"); does not work
	}                                                                
                                                                	
	public function getAttribute() {
		return $this->attribute;
	} 
	
	public function getAttributeIDs() {
		return $this->attributeIDs;
	}
	
	public function getPropertyCaption() {
		return $this->propertyCaption;
	}
	
	public function getValueCaption() {
		return $this->valueCaption;
	}
	
	public function getAttributeIDFilter() {
		return new IncludeAttributeIDsFilter($this->attributeIDs);
	}
}

?>
