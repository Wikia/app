<?php
class ExactTarget_DataExtension {
	public $Name; // string
	public $Description; // string
	public $IsSendable; // boolean
	public $IsTestable; // boolean
	public $SendableDataExtensionField; // ExactTarget_DataExtensionField
	public $SendableSubscriberField; // ExactTarget_Attribute
	public $Template; // ExactTarget_DataExtensionTemplate
	public $DataRetentionPeriodLength; // int
	public $DataRetentionPeriodUnitOfMeasure; // int
	public $RowBasedRetention; // boolean
	public $ResetRetentionPeriodOnImport; // boolean
	public $DeleteAtEndOfRetentionPeriod; // boolean
	public $RetainUntil; // string
	public $Fields; // ExactTarget_Fields
	public $DataRetentionPeriod; // ExactTarget_DateTimeUnitOfMeasure
}
