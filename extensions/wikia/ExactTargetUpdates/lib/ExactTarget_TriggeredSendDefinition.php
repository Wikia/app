<?php
class ExactTarget_TriggeredSendDefinition {
	public $TriggeredSendType; // ExactTarget_TriggeredSendTypeEnum
	public $TriggeredSendStatus; // ExactTarget_TriggeredSendStatusEnum
	public $Email; // ExactTarget_Email
	public $List; // ExactTarget_List
	public $AutoAddSubscribers; // boolean
	public $AutoUpdateSubscribers; // boolean
	public $BatchInterval; // int
	public $BccEmail; // string
	public $EmailSubject; // string
	public $DynamicEmailSubject; // string
	public $IsMultipart; // boolean
	public $IsWrapped; // boolean
	public $AllowedSlots; // short
	public $NewSlotTrigger; // int
	public $SendLimit; // int
	public $SendWindowOpen; // time
	public $SendWindowClose; // time
	public $SendWindowDelete; // boolean
	public $RefreshContent; // boolean
	public $ExclusionFilter; // string
	public $Priority; // string
	public $SendSourceCustomerKey; // string
	public $ExclusionListCollection; // ExactTarget_TriggeredSendExclusionList
	public $CCEmail; // string
	public $SendSourceDataExtension; // ExactTarget_DataExtension
	public $IsAlwaysOn; // boolean
}
