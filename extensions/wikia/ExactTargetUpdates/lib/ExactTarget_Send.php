<?php
class ExactTarget_Send {
	public $Email; // ExactTarget_Email
	public $List; // ExactTarget_List
	public $SendDate; // dateTime
	public $FromAddress; // string
	public $FromName; // string
	public $Duplicates; // int
	public $InvalidAddresses; // int
	public $ExistingUndeliverables; // int
	public $ExistingUnsubscribes; // int
	public $HardBounces; // int
	public $SoftBounces; // int
	public $OtherBounces; // int
	public $ForwardedEmails; // int
	public $UniqueClicks; // int
	public $UniqueOpens; // int
	public $NumberSent; // int
	public $NumberDelivered; // int
	public $Unsubscribes; // int
	public $MissingAddresses; // int
	public $Subject; // string
	public $PreviewURL; // string
	public $Links; // ExactTarget_Link
	public $Events; // ExactTarget_TrackingEvent
	public $SentDate; // dateTime
	public $EmailName; // string
	public $Status; // string
	public $IsMultipart; // boolean
	public $SendLimit; // int
	public $SendWindowOpen; // time
	public $SendWindowClose; // time
	public $IsAlwaysOn; // boolean
}
