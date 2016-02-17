<?php
class ExactTarget_RetrieveRequest {
	public $ClientIDs; // ExactTarget_ClientID
	public $ObjectType; // string
	public $Properties; // string
	public $Filter; // ExactTarget_FilterPart
	public $RespondTo; // ExactTarget_AsyncResponse
	public $PartnerProperties; // ExactTarget_APIProperty
	public $ContinueRequest; // string
	public $QueryAllAccounts; // boolean
	public $RetrieveAllSinceLastBatch; // boolean
	public $RepeatLastResult; // boolean
	public $Retrieves; // ExactTarget_Retrieves
	public $Options; // ExactTarget_RetrieveOptions
}
