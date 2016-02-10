<?php
class ExactTarget_ListSend {
	public $SendID; // int
	public $List; // ExactTarget_List
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
	public $PreviewURL; // string
	public $Links; // ExactTarget_Link
	public $Events; // ExactTarget_TrackingEvent
}
