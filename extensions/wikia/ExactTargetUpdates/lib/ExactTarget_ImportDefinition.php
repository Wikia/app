<?php
class ExactTarget_ImportDefinition {
	public $AllowErrors; // boolean
	public $DestinationObject; // ExactTarget_APIObject
	public $FieldMappingType; // ExactTarget_ImportDefinitionFieldMappingType
	public $FieldMaps; // ExactTarget_FieldMaps
	public $FileSpec; // string
	public $FileType; // ExactTarget_FileType
	public $Notification; // ExactTarget_AsyncResponse
	public $RetrieveFileTransferLocation; // ExactTarget_FileTransferLocation
	public $SubscriberImportType; // ExactTarget_ImportDefinitionSubscriberImportType
	public $UpdateType; // ExactTarget_ImportDefinitionUpdateType
	public $MaxFileAge; // int
	public $MaxFileAgeScheduleOffset; // int
	public $MaxImportFrequency; // int
	public $Delimiter; // string
	public $HeaderLines; // int
}
