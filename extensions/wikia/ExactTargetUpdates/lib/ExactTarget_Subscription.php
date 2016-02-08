<?php
class ExactTarget_Subscription {
	public $SubscriptionID; // int
	public $EmailsPurchased; // int
	public $AccountsPurchased; // int
	public $AdvAccountsPurchased; // int
	public $LPAccountsPurchased; // int
	public $DOTOAccountsPurchased; // int
	public $BUAccountsPurchased; // int
	public $BeginDate; // dateTime
	public $EndDate; // dateTime
	public $Notes; // string
	public $Period; // string
	public $NotificationTitle; // string
	public $NotificationMessage; // string
	public $NotificationFlag; // string
	public $NotificationExpDate; // dateTime
	public $ForAccounting; // string
	public $HasPurchasedEmails; // boolean
}
