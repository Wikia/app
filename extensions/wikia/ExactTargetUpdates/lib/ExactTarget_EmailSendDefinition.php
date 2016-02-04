<?php
class ExactTarget_EmailSendDefinition {
	public $SendDefinitionList; // ExactTarget_SendDefinitionList
	public $Email; // ExactTarget_Email
	public $BccEmail; // string
	public $AutoBccEmail; // string
	public $TestEmailAddr; // string
	public $EmailSubject; // string
	public $DynamicEmailSubject; // string
	public $IsMultipart; // boolean
	public $IsWrapped; // boolean
	public $SendLimit; // int
	public $SendWindowOpen; // time
	public $SendWindowClose; // time
	public $SendWindowDelete; // boolean
	public $DeduplicateByEmail; // boolean
	public $ExclusionFilter; // string
	public $TrackingUsers; // ExactTarget_TrackingUsers
	public $Additional; // string
	public $CCEmail; // string
}
