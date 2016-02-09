<?php
class ExactTarget_QueryRequest {
	public $ClientIDs; // ExactTarget_ClientID
	public $Query; // ExactTarget_Query
	public $RespondTo; // ExactTarget_AsyncResponse
	public $PartnerProperties; // ExactTarget_APIProperty
	public $ContinueRequest; // string
	public $QueryAllAccounts; // boolean
	public $RetrieveAllSinceLastBatch; // boolean
}
