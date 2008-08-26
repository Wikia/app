<?php

/**
 * Interface ContextFetcher is used to look upwards in a keyPath in 
 * search for a specific attribute value. This attribute value establishes a 
 * context for an operation that works within a hierarchy of Records (like an Editor does).
 * 
 * It might be better to adopt another strategy that pushes the desired context
 * down the hierarchy of Editors instead of letting an Editor look up the hierarchy.
 * We possibly can extend/replace the IdStack to store context during rendering.
 */

interface ContextFetcher {
	public function fetch($keyPath);	
}

/** 
 * Class DefaultContextFetcher implements ContextFetcher by looking up a specified number of levels 
 * in the keypath and returning the value for the specified attribute.
 */

class DefaultContextFetcher implements ContextFetcher {
	protected $levelsToLookUp;
	protected $attribute;
	
	public function __construct($levelsToLookUp, $attribute) {
		$this->levelsToLookUp = $levelsToLookUp;
		$this->attribute = $attribute;
	}

	public function fetch($keyPath) {
		if ($keyPath->peek($this->levelsToLookUp)->getStructure()->supportsAttribute($this->attribute))
			return $keyPath->peek($this->levelsToLookUp)->getAttributeValue($this->attribute); 
		else
			return null; # FIXME: Should not happen, check should leave	when the reason of the attribute not being support by the record is determined 		
	}	
}

class ObjectIdFetcher extends DefaultContextFetcher {
	function __tostring(){
		$levelsToLookUp = $this->attributeLevel;
		$attribute = $this->attribute;
		
		return "ObjectIdFetcher($levelsToLookUp, $attribute)";
	}
}

class DefinitionObjectIdFetcher extends DefaultContextFetcher {
	public function fetch($keyPath) {
		$definedMeaningId = $keyPath->peek($this->levelsToLookUp)->getAttributeValue($this->attribute);
		return getDefinedMeaningDefinitionId($definedMeaningId);
	}	

	function __tostring(){
		$levelsToLookUp = $this->attributeLevel;
		$attribute = $this->attribute;
		return "DefinitionObjectIdFetcher($levelsToLookUp, $attribute)";
	}
} 


