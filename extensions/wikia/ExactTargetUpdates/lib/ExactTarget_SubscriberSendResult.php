<?php
class ExactTarget_SubscriberSendResult {
	public $Send; // ExactTarget_Send
	public $Email; // ExactTarget_Email
	public $Subscriber; // ExactTarget_Subscriber
	public $ClickDate; // dateTime
	public $BounceDate; // dateTime
	public $OpenDate; // dateTime
	public $SentDate; // dateTime
	public $LastAction; // string
	public $UnsubscribeDate; // dateTime
	public $FromAddress; // string
	public $FromName; // string
	public $TotalClicks; // int
	public $UniqueClicks; // int
	public $Subject; // string
	public $ViewSentEmailURL; // string
}
