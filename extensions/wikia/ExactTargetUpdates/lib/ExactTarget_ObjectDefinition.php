<?php
class ExactTarget_ObjectDefinition {
	public $ObjectType; // string
	public $Name; // string
	public $IsCreatable; // boolean
	public $IsUpdatable; // boolean
	public $IsRetrievable; // boolean
	public $IsQueryable; // boolean
	public $IsReference; // boolean
	public $ReferencedType; // string
	public $IsPropertyCollection; // string
	public $IsObjectCollection; // boolean
	public $Properties; // ExactTarget_PropertyDefinition
	public $ExtendedProperties; // ExactTarget_ExtendedProperties
	public $ChildObjects; // ExactTarget_ObjectDefinition
}
