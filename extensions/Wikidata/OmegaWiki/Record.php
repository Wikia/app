<?php

require_once('Attribute.php');
require_once('OmegaWikiAttributes.php'); 

interface Record {
	public function getStructure();
	public function getAttributeValue($attribute);
	public function project(Structure $structure);
}

class ArrayRecord implements Record {
	protected $structure;
	protected $values = array();

	public function __construct(Structure $structure) {
		$this->structure = $structure;
	}
	
	public function getStructure() {
		return $this->structure;
	}
	
	protected function getAttributeValueForId($attributeId) {
		if ($this->structure->supportsAttributeId($attributeId)) {
			if (isset($this->values[$attributeId]))
				return $this->values[$attributeId];
			else
				return null;
		}
		else
			throw new Exception("Structure does not support attribute!\n  Structure: " . $this->structure . "\n  Attribute: " . $attributeId);
	}
	
	public function getAttributeValue($attribute) {
		return $this->getAttributeValueForId($attribute->id);
	}
	
	/**
	 * Look up the correct attribute using omegaWikiAttributes
	 * and return its value
 	 */
	public function __get($attributeName) {
		$o = OmegaWikiAttributes::getInstance();
		return $this->getAttributeValue($o->$attributeName);
	}
		
	/**
	 * Look up the correct attribute using omegaWikiAttributes
	 * and set its value
 	 */
	public function __set($attributeName, $value) {
		$o = OmegaWikiAttributes::getInstance();
		return $this->setAttributeValue($o->$attributeName, $value);
	}
	/** 
	 * Obtains a value based on the provided key.
	 * In future, this should check against an attributes global with string
	 * lookup, and might even be smart.
	 * For now, this just does a direct lookup.
	 *
	 * @deprecated use __get and __set instead now
	 */
	public function getValue($key) {
		return @$this->values[$key];	
	}

	public function project(Structure $structure) {
		$result = project($this, $structure);
		return $result;
	}

	public function setAttributeValueForId($attributeId, $value) {
		if ($this->structure->supportsAttributeId($attributeId))
			$this->values[$attributeId] = $value;
		else
			throw new Exception("Structure does not support attribute!\n  Structure: " . $this->structure. "\n  Attribute: " . $attributeId);
	}

	public function setAttributeValue(Attribute $attribute, $value) {
		$this->setAttributeValueForId($attribute->id, $value);
	}
	
	/**
	 *
	 * @param $values Array to write into the record, by order of the structure
	 *
	 */
	public function setAttributeValuesByOrder($values) {
		$atts=$this->structure->getAttributes();
		for ($i = 0; $i < count($atts); $i++)
			$this->values[$atts[$i]->id] = $values[$i];
	}
	
	/*
	 *
	 * @param $record Another record object whose values get written into this one
	 *
	 */
	public function setSubRecord(Record $record) {
		foreach($record->getStructure()->getAttributes() as $attribute)
			$this->values[$attribute->id] = $record->getAttributeValue($attribute);
	}

	/** 
	 * @return comma-separated values
	 */
	public function __tostring() {
		return $this->tostring_indent();
	}
	
	public function tostring_indent($depth=0,$key="") {
		$rv="\n".str_pad("",$depth*8);	
		$str=$this->getStructure();
		$type=$str->getStructureType();
		$rv.="$key:ArrayRecord(..., $type) {";
		$comma=$rv;
		foreach ($this->values as $key=>$value) {
			$rv=$comma;
			$repr="$key:$value";
			#Duck typing (should refactor this to a has_attr() function);
			# ( might be replacable by    property_exists() in php 5.1+  )
			$methods=get_class_methods(get_class($value));
			if (!is_null($methods)) {
				if (in_array("tostring_indent",$methods)) {
					$repr=$value->tostring_indent($depth+1,$key);
				} 
			}
			$rv.=$repr;

			$comma=$rv;
			$comma.=", ";
		}
		$rv.="}";
		return $rv;
	}

}

function project(Record $record, Structure $structure) {
	$result = new ArrayRecord($structure);
	
	foreach ($structure->getAttributes() as $attribute) {
		$type = $attribute->type;
		$value = $record->getAttributeValue($attribute);
		
		if ($type instanceof Structure)
			$result->setAttributeValue($attribute, project($record, $type->getStructure()));
		else
			$result->setAttributeValue($attribute, $value);
	}
		
	return $result;
}

function equalRecords(Structure $structure, Record $lhs, Record $rhs) {
	$result = true;
	$attributes = $structure->getAttributes();
	$i = 0;
	
	while ($result && $i < count($attributes)) {
		$attribute = $attributes[$i];
		$type = $attribute->type;
		$lhsValue = $lhs->getAttributeValue($attribute);
		$rhsValue = $rhs->getAttributeValue($attribute);
		
		if ($type instanceof Structure)
			$result = $lhsValue instanceof Record && $rhsValue instanceof Record && equalRecords($type, $lhsValue, $rhsValue);
		else
			$result = $lhsValue == $rhsValue;
			
		$i++;
	}
	
	return $result;
}

class RecordStack {
	protected $stack = array();
	
	public function push(Record $record) {
		$this->stack[] = $record;
	}
	
	public function pop() {
		return array_pop($this->stack);
	}
	
	public function peek($level) {
		return $this->stack[count($this->stack) - $level - 1];
	}
}


