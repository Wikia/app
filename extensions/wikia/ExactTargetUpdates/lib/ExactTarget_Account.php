<?php
class ExactTarget_Account {
	public $AccountType; // ExactTarget_AccountTypeEnum
	public $ParentID; // int
	public $BrandID; // int
	public $PrivateLabelID; // int
	public $ReportingParentID; // int
	public $Name; // string
	public $Email; // string
	public $FromName; // string
	public $BusinessName; // string
	public $Phone; // string
	public $Address; // string
	public $Fax; // string
	public $City; // string
	public $State; // string
	public $Zip; // string
	public $Country; // string
	public $IsActive; // int
	public $IsTestAccount; // boolean
	public $OrgID; // int
	public $DBID; // int
	public $ParentName; // string
	public $CustomerID; // long
	public $DeletedDate; // dateTime
	public $EditionID; // int
	public $Children; // ExactTarget_AccountDataItem
	public $Subscription; // ExactTarget_Subscription
	public $PrivateLabels; // ExactTarget_PrivateLabel
	public $BusinessRules; // ExactTarget_BusinessRule
	public $AccountUsers; // ExactTarget_AccountUser
	public $InheritAddress; // boolean
}
