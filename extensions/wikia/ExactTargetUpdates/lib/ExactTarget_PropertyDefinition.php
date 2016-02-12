<?php
class ExactTarget_PropertyDefinition {
	public $Name; // string
	public $DataType; // string
	public $ValueType; // ExactTarget_SoapType
	public $PropertyType; // ExactTarget_PropertyType
	public $IsCreatable; // boolean
	public $IsUpdatable; // boolean
	public $IsRetrievable; // boolean
	public $IsQueryable; // boolean
	public $IsFilterable; // boolean
	public $IsPartnerProperty; // boolean
	public $IsAccountProperty; // boolean
	public $PartnerMap; // string
	public $AttributeMaps; // ExactTarget_AttributeMap
	public $Markups; // ExactTarget_APIProperty
	public $Precision; // int
	public $Scale; // int
	public $Label; // string
	public $Description; // string
	public $DefaultValue; // string
	public $MinLength; // int
	public $MaxLength; // int
	public $MinValue; // string
	public $MaxValue; // string
	public $IsRequired; // boolean
	public $IsViewable; // boolean
	public $IsEditable; // boolean
	public $IsNillable; // boolean
	public $IsRestrictedPicklist; // boolean
	public $PicklistItems; // ExactTarget_PicklistItems
	public $IsSendTime; // boolean
	public $DisplayOrder; // int
	public $References; // ExactTarget_References
	public $RelationshipName; // string
	public $Status; // string
	public $IsContextSpecific; // boolean
}
