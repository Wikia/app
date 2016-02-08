<?php
class ExactTarget_SenderProfile {
	public $Name; // string
	public $Description; // string
	public $FromName; // string
	public $FromAddress; // string
	public $UseDefaultRMMRules; // boolean
	public $AutoForwardToEmailAddress; // string
	public $AutoForwardToName; // string
	public $DirectForward; // boolean
	public $AutoForwardTriggeredSend; // ExactTarget_TriggeredSendDefinition
	public $AutoReply; // boolean
	public $AutoReplyTriggeredSend; // ExactTarget_TriggeredSendDefinition
	public $SenderHeaderEmailAddress; // string
	public $SenderHeaderName; // string
	public $DataRetentionPeriodLength; // short
	public $DataRetentionPeriodUnitOfMeasure; // ExactTarget_RecurrenceTypeEnum
}
