<?php

class Attribute {
	public $id = null;	
	public $name = "";
	public $type = "";

	/**
	 * @param $id   (String) or null if 
 	 * @param $name (String) 
	 * @param $type (String or Structure) 
	 *  If String, can be "language", "spelling", "boolean",
         *  "defined-meaning", "defining-expression", "relation-type", "attribute",
	 *  "collection", "short-text", "text"
	 *
	 *  If Structure, see below.
 	 */
	public function __construct($id, $name, $type) {
		$this->id = $id;
		$this->name = $name;
		$this->setAttributeType($type);
	}

	public function setAttributeType($type) {
		# Copy the structure since we might modify it
		if($type instanceof Structure) {
			$this->type=clone $type;
		} else {
			$this->type=$type;
		}

		// Since the attribute is a structure and unnamed, we use 
		// the default label associated with it.
		if(is_null($this->id) && ($this->type instanceof Structure)) {
			$this->id = $this->type->getStructureType();
		// Override structure label with a more specific one
		} elseif(!is_null($this->id) && ($this->type instanceof Structure)) {
			$this->type->setStructureType($this->id);
		}
	}
	
	public function getId() {
		return $this->id;
	}

	public function __tostring() {
		$id=$this->id;
		$name=$this->name;
		$type=$this->type;
		return "Attribute($id, $name, $type)";
	}
}

class Structure {
	private $attributes; 
	private $type; 
	
	public function getAttributes() {
		return $this->attributes;
	}

	public function addAttribute(Attribute $attribute) {
		$this->attributes[] = $attribute;
	}

	public function getStructureType() {
		return $this->type;
	}

	public function setStructureType($type) {
		$this->type = $type;
	}


	/**
	 * Construct named Structure which contains Attribute objects
	 *
	 * @param $type (String)  Identifying string that describes the structure.
	 *                        Optional; if not specified, will be considered
	 *                        'anonymous-structure' unless there is only a
	 *                        a single Attribute object, in which case the structure
	 *                        will inherit its ID. Do not pass null.
	 * @param $structure (Array or Parameter list) One or more Attribute objects. 
	 *
	 */
	public function __construct($argumentList) {

		# We're trying to be clever.
		$args=func_get_args();
		$this->attributes=null;
		
		if($args[0] instanceof Attribute) {
			$this->attributes=$args; 
		} elseif(is_array($args[0])) {
			$this->attributes=$args[0];
		}

		if(is_array($this->attributes)) {
			# We don't know what to call an unnamed
			# structure with multiple attributes.
			if(sizeof($this->attributes) > 1) {
				$this->type='anonymous-structure';			
			# Meh, just one Attribute. Let's eat it.
			} elseif(sizeof($this->attributes)==1) {
				$this->type=$this->attributes[0]->id;
			} else {
				$this->type='empty-structure';
			}

		# First parameter is the structure's name.
		} elseif(is_string($args[0]) && !empty($args[0])) {
			$this->type=$args[0];
			if(is_array($args[1])) {
				$this->attributes = $args[1];
			} else {
				array_shift($args);
				$this->attributes = $args;
			}
		} else {
			# WTF?
			throw new Exception("Invalid structure constructor: ".print_r($args,true));
		}
	}

	public function supportsAttributeId($attributeId) {
//		$result = false;
//		$i = 0;
//		
//		while (!$result && $i < count($this->attributes)) {
//			$result = $this->attributes[$i]->id == $attributeId;
//			$i++;
//		}
//			
//		return $result;
		return true;
	}
	
	public function supportsAttribute(Attribute $attribute) {
		return $this->supportsAttributeId($attribute->id);
	}
	
	public function __tostring() {
		$result = "{";

		if (count($this->attributes) > 0) {
			$result .= $this->attributes[0]->id;
			
			for ($i = 1; $i < count($this->attributes); $i++)
				$result .= ", " . $this->attributes[$i]->id;
		}	

		$result .= "}";
		
		return $result;
	}
}


