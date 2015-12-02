<?php 
require('soap-wsse.php');

class ExactTargetSoapClient extends SoapClient {
	public $username = NULL;
	public $password = NULL;

	/**
	 * @param bool $retryAttempt Is this call a repeated attempt to send data. Needs to be available for warning
	 * handler that decides whether to requeue request.
	 */
	function __doRequest($request, $location, $saction, $version, $one_way = 0, $retryAttempt = false) {
		$doc = new DOMDocument();
		$doc->loadXML($request);

		$objWSSE = new WSSESoap($doc);

		$objWSSE->addUserToken($this->username, $this->password, FALSE);
		set_error_handler('\Wikia\ExactTarget\ExactTargetSoapErrorHandler::requeueConnectionResetWarning', E_USER_WARNING);
		$response = parent::__doRequest($objWSSE->saveXML(), $location, $saction, $version);
		restore_error_handler();

		return $response;
	 }

}

class ExactTarget_APIObject {
	public $Client; // ExactTarget_ClientID
	public $PartnerKey; // string
	public $PartnerProperties; // ExactTarget_APIProperty
	public $CreatedDate; // dateTime
	public $ModifiedDate; // dateTime
	public $ID; // int
	public $ObjectID; // string
	public $CustomerKey; // string
	public $Owner; // ExactTarget_Owner
	public $CorrelationID; // string
}

class ExactTarget_ClientID {
	public $ClientID; // int
	public $ID; // int
	public $PartnerClientKey; // string
	public $UserID; // int
	public $PartnerUserKey; // string
	public $CreatedBy; // int
	public $ModifiedBy; // int
}

class ExactTarget_APIProperty {
	public $Name; // string
	public $Value; // string
}

class ExactTarget_Owner {
	public $Client; // ExactTarget_ClientID
	public $FromName; // string
	public $FromAddress; // string
}

class ExactTarget_AsyncResponseType {
	const None='None';
	const email='email';
	const FTP='FTP';
	const HTTPPost='HTTPPost';
}

class ExactTarget_AsyncResponse {
	public $ResponseType; // ExactTarget_AsyncResponseType
	public $ResponseAddress; // string
	public $RespondWhen; // ExactTarget_RespondWhen
	public $IncludeResults; // boolean
	public $IncludeObjects; // boolean
	public $OnlyIncludeBase; // boolean
}

class ExactTarget_ContainerID {
	public $APIObject; // ExactTarget_APIObject
}

class ExactTarget_Request {
}

class ExactTarget_Result {
	public $StatusCode; // string
	public $StatusMessage; // string
	public $OrdinalID; // int
	public $ErrorCode; // int
	public $RequestID; // string
	public $ConversationID; // string
	public $OverallStatusCode; // string
	public $RequestType; // ExactTarget_RequestType
	public $ResultType; // string
	public $ResultDetailXML; // string
}

class ExactTarget_Options {
	public $Client; // ExactTarget_ClientID
	public $SendResponseTo; // ExactTarget_AsyncResponse
	public $SaveOptions; // ExactTarget_SaveOptions
	public $Priority; // byte
	public $ConversationID; // string
	public $SequenceCode; // int
	public $CallsInConversation; // int
	public $ScheduledTime; // dateTime
	public $RequestType; // ExactTarget_RequestType
	public $QueuePriority; // ExactTarget_Priority
}

class ExactTarget_SaveOptions {
	public $SaveOption; // ExactTarget_SaveOption
}

class ExactTarget_TaskResult {
	public $StatusCode; // string
	public $StatusMessage; // string
	public $OrdinalID; // int
	public $ErrorCode; // int
	public $ID; // string
	public $InteractionObjectID; // string
}

class ExactTarget_SaveOption {
	public $PropertyName; // string
	public $SaveAction; // ExactTarget_SaveAction
}

class ExactTarget_SaveAction {
	const AddOnly='AddOnly';
	const _Default='Default';
	const Nothing='Nothing';
	const UpdateAdd='UpdateAdd';
	const UpdateOnly='UpdateOnly';
}

class ExactTarget_NullAPIProperty {
}

class ExactTarget_ResultMessage {
	public $RequestID; // string
	public $ConversationID; // string
	public $OverallStatusCode; // string
	public $StatusCode; // string
	public $StatusMessage; // string
	public $ErrorCode; // int
	public $RequestType; // ExactTarget_RequestType
	public $ResultType; // string
	public $ResultDetailXML; // string
	public $SequenceCode; // int
	public $CallsInConversation; // int
}

class ExactTarget_ResultItem {
	public $RequestID; // string
	public $ConversationID; // string
	public $StatusCode; // string
	public $StatusMessage; // string
	public $OrdinalID; // int
	public $ErrorCode; // int
	public $RequestType; // ExactTarget_RequestType
	public $RequestObjectType; // string
}

class ExactTarget_Priority {
	const Low='Low';
	const Medium='Medium';
	const High='High';
}

class ExactTarget_RequestType {
	const Synchronous='Synchronous';
	const Asynchronous='Asynchronous';
}

class ExactTarget_RespondWhen {
	const Never='Never';
	const OnError='OnError';
	const Always='Always';
	const OnConversationError='OnConversationError';
	const OnConversationComplete='OnConversationComplete';
	const OnCallComplete='OnCallComplete';
}

class ExactTarget_CreateRequest {
	public $Options; // ExactTarget_CreateOptions
	public $Objects; // ExactTarget_APIObject
}

class ExactTarget_CreateResult {
	public $NewID; // int
	public $NewObjectID; // string
	public $PartnerKey; // string
	public $Object; // ExactTarget_APIObject
	public $CreateResults; // ExactTarget_CreateResult
	public $ParentPropertyName; // string
}

class ExactTarget_CreateResponse {
	public $Results; // ExactTarget_CreateResult
	public $RequestID; // string
	public $OverallStatus; // string
}

class ExactTarget_CreateOptions {
	public $Container; // ExactTarget_ContainerID
}

class ExactTarget_UpdateOptions {
	public $Container; // ExactTarget_ContainerID
	public $Action; // string
}

class ExactTarget_UpdateRequest {
	public $Options; // ExactTarget_UpdateOptions
	public $Objects; // ExactTarget_APIObject
}

class ExactTarget_UpdateResult {
	public $Object; // ExactTarget_APIObject
	public $UpdateResults; // ExactTarget_UpdateResult
	public $ParentPropertyName; // string
}

class ExactTarget_UpdateResponse {
	public $Results; // ExactTarget_UpdateResult
	public $RequestID; // string
	public $OverallStatus; // string
}

class ExactTarget_DeleteOptions {
}

class ExactTarget_DeleteRequest {
	public $Options; // ExactTarget_DeleteOptions
	public $Objects; // ExactTarget_APIObject
}

class ExactTarget_DeleteResult {
	public $Object; // ExactTarget_APIObject
}

class ExactTarget_DeleteResponse {
	public $Results; // ExactTarget_DeleteResult
	public $RequestID; // string
	public $OverallStatus; // string
}

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

class ExactTarget_Retrieves {
	public $Request; // ExactTarget_Request
}

class ExactTarget_RetrieveRequestMsg {
	public $RetrieveRequest; // ExactTarget_RetrieveRequest
}

class ExactTarget_RetrieveResponseMsg {
	public $OverallStatus; // string
	public $RequestID; // string
	public $Results; // ExactTarget_APIObject
}

class ExactTarget_RetrieveSingleRequest {
	public $RequestedObject; // ExactTarget_APIObject
	public $RetrieveOption; // ExactTarget_Options
}

class ExactTarget_Parameters {
	public $Parameter; // ExactTarget_APIProperty
}

class ExactTarget_RetrieveSingleOptions {
	public $Parameters; // ExactTarget_Parameters
}

class ExactTarget_RetrieveOptions {
	public $BatchSize; // int
}

class ExactTarget_QueryRequest {
	public $ClientIDs; // ExactTarget_ClientID
	public $Query; // ExactTarget_Query
	public $RespondTo; // ExactTarget_AsyncResponse
	public $PartnerProperties; // ExactTarget_APIProperty
	public $ContinueRequest; // string
	public $QueryAllAccounts; // boolean
	public $RetrieveAllSinceLastBatch; // boolean
}

class ExactTarget_QueryRequestMsg {
	public $QueryRequest; // ExactTarget_QueryRequest
}

class ExactTarget_QueryResponseMsg {
	public $OverallStatus; // string
	public $RequestID; // string
	public $Results; // ExactTarget_APIObject
}

class ExactTarget_QueryObject {
	public $ObjectType; // string
	public $Properties; // string
	public $Objects; // ExactTarget_QueryObject
}

class ExactTarget_Query {
	public $Object; // ExactTarget_QueryObject
	public $Filter; // ExactTarget_FilterPart
}

class ExactTarget_FilterPart {
}

class ExactTarget_SimpleFilterPart {
	public $Property; // string
	public $SimpleOperator; // ExactTarget_SimpleOperators
	public $Value; // string
	public $DateValue; // dateTime
}

class ExactTarget_TagFilterPart {
	public $Tags; // ExactTarget_Tags
}

class ExactTarget_Tags {
	public $Tag; // string
}

class ExactTarget_ComplexFilterPart {
	public $LeftOperand; // ExactTarget_FilterPart
	public $LogicalOperator; // ExactTarget_LogicalOperators
	public $RightOperand; // ExactTarget_FilterPart
}

class ExactTarget_SimpleOperators {
	const equals='equals';
	const notEquals='notEquals';
	const greaterThan='greaterThan';
	const lessThan='lessThan';
	const isNull='isNull';
	const isNotNull='isNotNull';
	const greaterThanOrEqual='greaterThanOrEqual';
	const lessThanOrEqual='lessThanOrEqual';
	const between='between';
	const IN='IN';
	const like='like';
}

class ExactTarget_LogicalOperators {
	const _OR='OR';
	const _AND='AND';
}

class ExactTarget_DefinitionRequestMsg {
	public $DescribeRequests; // ExactTarget_ArrayOfObjectDefinitionRequest
}

class ExactTarget_ArrayOfObjectDefinitionRequest {
	public $ObjectDefinitionRequest; // ExactTarget_ObjectDefinitionRequest
}

class ExactTarget_ObjectDefinitionRequest {
	public $Client; // ExactTarget_ClientID
	public $ObjectType; // string
}

class ExactTarget_DefinitionResponseMsg {
	public $ObjectDefinition; // ExactTarget_ObjectDefinition
	public $RequestID; // string
}

class ExactTarget_PropertyDefinition {
	public $Name; // string
	public $DataType; // string
	public $ValueType; // ExactTarget_SoapType
	public $PropertyType; // ExactTarget_PropertyType
	public $IsCreatable; // boolean
	public $IsUpdatable; // boolean
	public $IsRetrievable; // boolean
	public $IsQueryable; // boolean
	public $IsFilterable; // boolean
	public $IsPartnerProperty; // boolean
	public $IsAccountProperty; // boolean
	public $PartnerMap; // string
	public $AttributeMaps; // ExactTarget_AttributeMap
	public $Markups; // ExactTarget_APIProperty
	public $Precision; // int
	public $Scale; // int
	public $Label; // string
	public $Description; // string
	public $DefaultValue; // string
	public $MinLength; // int
	public $MaxLength; // int
	public $MinValue; // string
	public $MaxValue; // string
	public $IsRequired; // boolean
	public $IsViewable; // boolean
	public $IsEditable; // boolean
	public $IsNillable; // boolean
	public $IsRestrictedPicklist; // boolean
	public $PicklistItems; // ExactTarget_PicklistItems
	public $IsSendTime; // boolean
	public $DisplayOrder; // int
	public $References; // ExactTarget_References
	public $RelationshipName; // string
	public $Status; // string
	public $IsContextSpecific; // boolean
}

class ExactTarget_PicklistItems {
	public $PicklistItem; // ExactTarget_PicklistItem
}

class ExactTarget_References {
	public $Reference; // ExactTarget_APIObject
}

class ExactTarget_ObjectDefinition {
	public $ObjectType; // string
	public $Name; // string
	public $IsCreatable; // boolean
	public $IsUpdatable; // boolean
	public $IsRetrievable; // boolean
	public $IsQueryable; // boolean
	public $IsReference; // boolean
	public $ReferencedType; // string
	public $IsPropertyCollection; // string
	public $IsObjectCollection; // boolean
	public $Properties; // ExactTarget_PropertyDefinition
	public $ExtendedProperties; // ExactTarget_ExtendedProperties
	public $ChildObjects; // ExactTarget_ObjectDefinition
}

class ExactTarget_ExtendedProperties {
	public $ExtendedProperty; // ExactTarget_PropertyDefinition
}

class ExactTarget_AttributeMap {
	public $EntityName; // string
	public $ColumnName; // string
	public $ColumnNameMappedTo; // string
	public $EntityNameMappedTo; // string
	public $AdditionalData; // ExactTarget_APIProperty
}

class ExactTarget_PicklistItem {
	public $IsDefaultValue; // boolean
	public $Label; // string
	public $Value; // string
}


class ExactTarget_SoapType {
	const xsd_string='xsd:string';
	const xsd_boolean='xsd:boolean';
	const xsd_double='xsd:double';
	const xsd_dateTime='xsd:dateTime';
}

class ExactTarget_PropertyType {
	const string='string';
	const boolean='boolean';
	const double='double';
	const datetime='datetime';
}

class ExactTarget_ExecuteRequest {
	public $Client; // ExactTarget_ClientID
	public $Name; // string
	public $Parameters; // ExactTarget_APIProperty
}

class ExactTarget_ExecuteResponse {
	public $StatusCode; // string
	public $StatusMessage; // string
	public $OrdinalID; // int
	public $Results; // ExactTarget_APIProperty
	public $ErrorCode; // int
}

class ExactTarget_ExecuteRequestMsg {
	public $Requests; // ExactTarget_ExecuteRequest
}

class ExactTarget_ExecuteResponseMsg {
	public $OverallStatus; // string
	public $RequestID; // string
	public $Results; // ExactTarget_ExecuteResponse
}

class ExactTarget_InteractionDefinition {
	public $InteractionObjectID; // string
}

class ExactTarget_InteractionBaseObject {
	public $Name; // string
	public $Description; // string
	public $Keyword; // string
}

class ExactTarget_PerformOptions {
}

class ExactTarget_CampaignPerformOptions {
	public $OccurrenceIDs; // string
	public $OccurrenceIDsIndex; // int
}

class ExactTarget_PerformRequest {
	public $Client; // ExactTarget_ClientID
	public $Action; // string
	public $Definitions; // ExactTarget_Definitions
}

class ExactTarget_Definitions {
	public $Definition; // ExactTarget_InteractionBaseObject
}

class ExactTarget_PerformResponse {
	public $StatusCode; // string
	public $StatusMessage; // string
	public $OrdinalID; // int
	public $Results; // ExactTarget_Results
	public $ErrorCode; // int
}

class ExactTarget_Results {
	public $Result; // ExactTarget_APIProperty
}

class ExactTarget_PerformResult {
	public $Object; // ExactTarget_InteractionBaseObject
	public $Task; // ExactTarget_TaskResult
}

class ExactTarget_PerformRequestMsg {
	public $Options; // ExactTarget_PerformOptions
	public $Action; // string
	public $Definitions; // ExactTarget_Definitions
}



class ExactTarget_PerformResponseMsg {
	public $Results; // ExactTarget_Results
	public $OverallStatus; // string
	public $OverallStatusMessage; // string
	public $RequestID; // string
}



class ExactTarget_ConfigureOptions {
}

class ExactTarget_ConfigureResult {
	public $Object; // ExactTarget_APIObject
}

class ExactTarget_ConfigureRequestMsg {
	public $Options; // ExactTarget_ConfigureOptions
	public $Action; // string
	public $Configurations; // ExactTarget_Configurations
}

class ExactTarget_Configurations {
	public $Configuration; // ExactTarget_APIObject
}

class ExactTarget_ConfigureResponseMsg {
	public $Results; // ExactTarget_Results
	public $OverallStatus; // string
	public $OverallStatusMessage; // string
	public $RequestID; // string
}



class ExactTarget_ScheduleDefinition {
	public $Name; // string
	public $Description; // string
	public $Recurrence; // ExactTarget_Recurrence
	public $RecurrenceType; // ExactTarget_RecurrenceTypeEnum
	public $RecurrenceRangeType; // ExactTarget_RecurrenceRangeTypeEnum
	public $StartDateTime; // dateTime
	public $EndDateTime; // dateTime
	public $Occurrences; // int
	public $Keyword; // string
}

class ExactTarget_ScheduleOptions {
}

class ExactTarget_ScheduleResponse {
	public $StatusCode; // string
	public $StatusMessage; // string
	public $OrdinalID; // int
	public $Results; // ExactTarget_Results
	public $ErrorCode; // int
}



class ExactTarget_ScheduleResult {
	public $Object; // ExactTarget_ScheduleDefinition
	public $Task; // ExactTarget_TaskResult
}

class ExactTarget_ScheduleRequestMsg {
	public $Options; // ExactTarget_ScheduleOptions
	public $Action; // string
	public $Schedule; // ExactTarget_ScheduleDefinition
	public $Interactions; // ExactTarget_Interactions
}

class ExactTarget_Interactions {
	public $Interaction; // ExactTarget_InteractionBaseObject
}

class ExactTarget_ScheduleResponseMsg {
	public $Results; // ExactTarget_Results
	public $OverallStatus; // string
	public $OverallStatusMessage; // string
	public $RequestID; // string
}



class ExactTarget_RecurrenceTypeEnum {
	const Secondly='Secondly';
	const Minutely='Minutely';
	const Hourly='Hourly';
	const Daily='Daily';
	const Weekly='Weekly';
	const Monthly='Monthly';
	const Yearly='Yearly';
}

class ExactTarget_RecurrenceRangeTypeEnum {
	const EndAfter='EndAfter';
	const EndOn='EndOn';
}

class ExactTarget_Recurrence {
}

class ExactTarget_HourlyRecurrencePatternTypeEnum {
	const Interval='Interval';
}

class ExactTarget_DailyRecurrencePatternTypeEnum {
	const Interval='Interval';
	const EveryWeekDay='EveryWeekDay';
}

class ExactTarget_WeeklyRecurrencePatternTypeEnum {
	const ByDay='ByDay';
}

class ExactTarget_MonthlyRecurrencePatternTypeEnum {
	const ByDay='ByDay';
	const ByWeek='ByWeek';
}

class ExactTarget_WeekOfMonthEnum {
	const first='first';
	const second='second';
	const third='third';
	const fourth='fourth';
	const last='last';
}

class ExactTarget_DayOfWeekEnum {
	const Sunday='Sunday';
	const Monday='Monday';
	const Tuesday='Tuesday';
	const Wednesday='Wednesday';
	const Thursday='Thursday';
	const Friday='Friday';
	const Saturday='Saturday';
}

class ExactTarget_YearlyRecurrencePatternTypeEnum {
	const ByDay='ByDay';
	const ByWeek='ByWeek';
	const ByMonth='ByMonth';
}

class ExactTarget_MonthOfYearEnum {
	const January='January';
	const February='February';
	const March='March';
	const April='April';
	const May='May';
	const June='June';
	const July='July';
	const August='August';
	const September='September';
	const October='October';
	const November='November';
	const December='December';
}

class ExactTarget_HourlyRecurrence {
	public $HourlyRecurrencePatternType; // ExactTarget_HourlyRecurrencePatternTypeEnum
	public $HourInterval; // int
}

class ExactTarget_DailyRecurrence {
	public $DailyRecurrencePatternType; // ExactTarget_DailyRecurrencePatternTypeEnum
	public $DayInterval; // int
}

class ExactTarget_WeeklyRecurrence {
	public $WeeklyRecurrencePatternType; // ExactTarget_WeeklyRecurrencePatternTypeEnum
	public $WeekInterval; // int
	public $Sunday; // boolean
	public $Monday; // boolean
	public $Tuesday; // boolean
	public $Wednesday; // boolean
	public $Thursday; // boolean
	public $Friday; // boolean
	public $Saturday; // boolean
}

class ExactTarget_MonthlyRecurrence {
	public $MonthlyRecurrencePatternType; // ExactTarget_MonthlyRecurrencePatternTypeEnum
	public $MonthlyInterval; // int
	public $ScheduledDay; // int
	public $ScheduledWeek; // ExactTarget_WeekOfMonthEnum
	public $ScheduledDayOfWeek; // ExactTarget_DayOfWeekEnum
}

class ExactTarget_YearlyRecurrence {
	public $YearlyRecurrencePatternType; // ExactTarget_YearlyRecurrencePatternTypeEnum
	public $ScheduledDay; // int
	public $ScheduledWeek; // ExactTarget_WeekOfMonthEnum
	public $ScheduledMonth; // ExactTarget_MonthOfYearEnum
	public $ScheduledDayOfWeek; // ExactTarget_DayOfWeekEnum
}

class ExactTarget_ExtractRequest {
	public $Client; // ExactTarget_ClientID
	public $ID; // string
	public $Options; // ExactTarget_ExtractOptions
	public $Parameters; // ExactTarget_Parameters
	public $Description; // ExactTarget_ExtractDescription
	public $Definition; // ExactTarget_ExtractDefinition
}



class ExactTarget_ExtractResult {
	public $Request; // ExactTarget_ExtractRequest
}

class ExactTarget_ExtractRequestMsg {
	public $Requests; // ExactTarget_ExtractRequest
}

class ExactTarget_ExtractResponseMsg {
	public $OverallStatus; // string
	public $RequestID; // string
	public $Results; // ExactTarget_ExtractResult
}

class ExactTarget_ExtractOptions {
}

class ExactTarget_ExtractParameter {
}

class ExactTarget_ExtractTemplate {
	public $Name; // string
	public $ConfigurationPage; // string
}

class ExactTarget_ExtractDescription {
	public $Parameters; // ExactTarget_Parameters
}



class ExactTarget_ExtractDefinition {
	public $Parameters; // ExactTarget_Parameters
}



class ExactTarget_ExtractParameterDataType {
	const datetime='datetime';
	const bool='bool';
	const string='string';
	const integer='integer';
}

class ExactTarget_ParameterDescription {
}

class ExactTarget_ExtractParameterDescription {
	public $Name; // string
	public $DataType; // ExactTarget_ExtractParameterDataType
	public $DefaultValue; // string
	public $IsOptional; // boolean
}

class ExactTarget_VersionInfoResponse {
	public $Version; // string
	public $VersionDate; // dateTime
	public $Notes; // string
	public $VersionHistory; // ExactTarget_VersionInfoResponse
}

class ExactTarget_VersionInfoRequestMsg {
	public $IncludeVersionHistory; // boolean
}

class ExactTarget_VersionInfoResponseMsg {
	public $VersionInfo; // ExactTarget_VersionInfoResponse
	public $RequestID; // string
}

class ExactTarget_Account {
	public $AccountType; // ExactTarget_AccountTypeEnum
	public $ParentID; // int
	public $BrandID; // int
	public $PrivateLabelID; // int
	public $ReportingParentID; // int
	public $Name; // string
	public $Email; // string
	public $FromName; // string
	public $BusinessName; // string
	public $Phone; // string
	public $Address; // string
	public $Fax; // string
	public $City; // string
	public $State; // string
	public $Zip; // string
	public $Country; // string
	public $IsActive; // int
	public $IsTestAccount; // boolean
	public $OrgID; // int
	public $DBID; // int
	public $ParentName; // string
	public $CustomerID; // long
	public $DeletedDate; // dateTime
	public $EditionID; // int
	public $Children; // ExactTarget_AccountDataItem
	public $Subscription; // ExactTarget_Subscription
	public $PrivateLabels; // ExactTarget_PrivateLabel
	public $BusinessRules; // ExactTarget_BusinessRule
	public $AccountUsers; // ExactTarget_AccountUser
	public $InheritAddress; // boolean
}

class ExactTarget_AccountTypeEnum {
	const None='None';
	const EXACTTARGET='EXACTTARGET';
	const PRO_CONNECT='PRO_CONNECT';
	const CHANNEL_CONNECT='CHANNEL_CONNECT';
	const CONNECT='CONNECT';
	const PRO_CONNECT_CLIENT='PRO_CONNECT_CLIENT';
	const LP_MEMBER='LP_MEMBER';
	const DOTO_MEMBER='DOTO_MEMBER';
	const ENTERPRISE_2='ENTERPRISE_2';
	const BUSINESS_UNIT='BUSINESS_UNIT';
}

class ExactTarget_AccountDataItem {
	public $ChildAccountID; // int
	public $BrandID; // int
	public $PrivateLabelID; // int
	public $AccountType; // int
}

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

class ExactTarget_PrivateLabel {
	public $ID; // int
	public $Name; // string
	public $ColorPaletteXML; // string
	public $LogoFile; // string
	public $Delete; // int
	public $SetActive; // boolean
}

class ExactTarget_AccountPrivateLabel {
	public $Name; // string
	public $OwnerMemberID; // int
	public $ColorPaletteXML; // string
}

class ExactTarget_BusinessRule {
	public $MemberBusinessRuleID; // int
	public $BusinessRuleID; // int
	public $Data; // int
	public $Quality; // string
	public $Name; // string
	public $Type; // string
	public $Description; // string
	public $IsViewable; // boolean
	public $IsInheritedFromParent; // boolean
	public $DisplayName; // string
	public $ProductCode; // string
}

class ExactTarget_AccountUser {
	public $AccountUserID; // int
	public $UserID; // string
	public $Password; // string
	public $Name; // string
	public $Email; // string
	public $MustChangePassword; // boolean
	public $ActiveFlag; // boolean
	public $ChallengePhrase; // string
	public $ChallengeAnswer; // string
	public $UserPermissions; // ExactTarget_UserAccess
	public $Delete; // int
	public $LastSuccessfulLogin; // dateTime
	public $IsAPIUser; // boolean
	public $NotificationEmailAddress; // string
	public $IsLocked; // boolean
	public $Unlock; // boolean
	public $BusinessUnit; // int
	public $DefaultBusinessUnit; // int
}

class ExactTarget_UserAccess {
	public $Name; // string
	public $Value; // string
	public $Description; // string
	public $Delete; // int
}

class ExactTarget_Brand {
	public $BrandID; // int
	public $Label; // string
	public $Comment; // string
	public $BrandTags; // ExactTarget_BrandTag
}

class ExactTarget_BrandTag {
	public $BrandID; // int
	public $Label; // string
	public $Data; // string
}

class ExactTarget_Email {
	public $Name; // string
	public $Folder; // string
	public $CategoryID; // int
	public $HTMLBody; // string
	public $TextBody; // string
	public $ContentAreas; // ExactTarget_ContentArea
	public $Subject; // string
	public $IsActive; // boolean
	public $IsHTMLPaste; // boolean
	public $ClonedFromID; // int
	public $Status; // string
	public $EmailType; // string
	public $CharacterSet; // string
	public $HasDynamicSubjectLine; // boolean
	public $ContentCheckStatus; // string
}

class ExactTarget_ContentArea {
	public $Key; // string
	public $Content; // string
	public $IsBlank; // boolean
	public $CategoryID; // int
	public $Name; // string
	public $Layout; // ExactTarget_LayoutType
	public $IsDynamicContent; // boolean
	public $IsSurvey; // boolean
}

class ExactTarget_LayoutType {
	const HTMLWrapped='HTMLWrapped';
	const RawText='RawText';
	const SMS='SMS';
}

class ExactTarget_Message {
	public $TextBody; // string
}

class ExactTarget_TrackingEvent {
	public $SendID; // int
	public $SubscriberKey; // string
	public $EventDate; // dateTime
	public $EventType; // ExactTarget_EventType
	public $TriggeredSendDefinitionObjectID; // string
	public $BatchID; // int
}

class ExactTarget_EventType {
	const Open='Open';
	const Click='Click';
	const HardBounce='HardBounce';
	const SoftBounce='SoftBounce';
	const OtherBounce='OtherBounce';
	const Unsubscribe='Unsubscribe';
	const Sent='Sent';
	const NotSent='NotSent';
	const Survey='Survey';
	const ForwardedEmail='ForwardedEmail';
	const ForwardedEmailOptIn='ForwardedEmailOptIn';
}

class ExactTarget_OpenEvent {
}

class ExactTarget_BounceEvent {
	public $SMTPCode; // string
	public $BounceCategory; // string
	public $SMTPReason; // string
	public $BounceType; // string
}

class ExactTarget_UnsubEvent {
}

class ExactTarget_ClickEvent {
	public $URLID; // int
	public $URL; // string
}

class ExactTarget_SentEvent {
}

class ExactTarget_NotSentEvent {
}

class ExactTarget_SurveyEvent {
	public $Question; // string
	public $Answer; // string
}

class ExactTarget_ForwardedEmailEvent {
}

class ExactTarget_ForwardedEmailOptInEvent {
	public $OptInSubscriberKey; // string
}

class ExactTarget_Subscriber {
	public $EmailAddress; // string
	public $Attributes; // ExactTarget_Attribute
	public $SubscriberKey; // string
	public $UnsubscribedDate; // dateTime
	public $Status; // ExactTarget_SubscriberStatus
	public $PartnerType; // string
	public $EmailTypePreference; // ExactTarget_EmailType
	public $Lists; // ExactTarget_SubscriberList
	public $GlobalUnsubscribeCategory; // ExactTarget_GlobalUnsubscribeCategory
	public $SubscriberTypeDefinition; // ExactTarget_SubscriberTypeDefinition
}

class ExactTarget_Attribute {
	public $Name; // string
	public $Value; // string
}

class ExactTarget_SubscriberStatus {
	const Active='Active';
	const Bounced='Bounced';
	const Held='Held';
	const Unsubscribed='Unsubscribed';
	const Deleted='Deleted';
}

class ExactTarget_SubscriberTypeDefinition {
	public $SubscriberType; // string
}

class ExactTarget_EmailType {
	const Text='Text';
	const HTML='HTML';
}

class ExactTarget_ListSubscriber {
	public $Status; // ExactTarget_SubscriberStatus
	public $ListID; // int
	public $SubscriberKey; // string
}

class ExactTarget_SubscriberList {
	public $Status; // ExactTarget_SubscriberStatus
	public $List; // ExactTarget_List
	public $Action; // string
}

class ExactTarget_List {
	public $ListName; // string
	public $Category; // int
	public $Type; // ExactTarget_ListTypeEnum
	public $Description; // string
	public $Subscribers; // ExactTarget_Subscriber
}

class ExactTarget_ListTypeEnum {
	const _Public='Public';
	const _Private='Private';
	const SalesForce='SalesForce';
	const GlobalUnsubscribe='GlobalUnsubscribe';
	const Master='Master';
}

class ExactTarget_Group {
	public $Name; // string
	public $Category; // int
	public $Description; // string
	public $Subscribers; // ExactTarget_Subscriber
}

class ExactTarget_GlobalUnsubscribeCategory {
	public $Name; // string
	public $IgnorableByPartners; // boolean
	public $Ignore; // boolean
}

class ExactTarget_Campaign {
}

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

class ExactTarget_Link {
	public $LastClicked; // dateTime
	public $Alias; // string
	public $TotalClicks; // int
	public $UniqueClicks; // int
	public $URL; // string
	public $Subscribers; // ExactTarget_TrackingEvent
}

class ExactTarget_SendSummary {
	public $AccountID; // int
	public $AccountName; // string
	public $AccountEmail; // string
	public $IsTestAccount; // boolean
	public $SendID; // int
	public $DeliveredTime; // string
	public $TotalSent; // int
	public $Transactional; // int
	public $NonTransactional; // int
}

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

class ExactTarget_TriggeredSendExclusionList {
}

class ExactTarget_TriggeredSendTypeEnum {
	const Continuous='Continuous';
	const Batched='Batched';
	const Scheduled='Scheduled';
}

class ExactTarget_TriggeredSendStatusEnum {
	const _New='New';
	const Inactive='Inactive';
	const Active='Active';
	const Canceled='Canceled';
	const Deleted='Deleted';
}

class ExactTarget_TriggeredSend {
	public $TriggeredSendDefinition; // ExactTarget_TriggeredSendDefinition
	public $Subscribers; // ExactTarget_Subscriber
	public $Attributes; // ExactTarget_Attribute
}

class ExactTarget_TriggeredSendCreateResult {
	public $SubscriberFailures; // ExactTarget_SubscriberResult
}

class ExactTarget_SubscriberResult {
	public $Subscriber; // ExactTarget_Subscriber
	public $ErrorCode; // string
	public $ErrorDescription; // string
	public $Ordinal; // int
}

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

class ExactTarget_TriggeredSendSummary {
	public $TriggeredSendDefinition; // ExactTarget_TriggeredSendDefinition
	public $Sent; // long
	public $NotSentDueToOptOut; // long
	public $NotSentDueToUndeliverable; // long
	public $Bounces; // long
	public $Opens; // long
	public $Clicks; // long
	public $UniqueOpens; // long
	public $UniqueClicks; // long
	public $OptOuts; // long
	public $SurveyResponses; // long
	public $FTAFRequests; // long
	public $FTAFEmailsSent; // long
	public $FTAFOptIns; // long
	public $Conversions; // long
	public $UniqueConversions; // long
	public $InProcess; // long
	public $NotSentDueToError; // long
}

class ExactTarget_AsyncRequestResult {
	public $Status; // string
	public $CompleteDate; // dateTime
	public $CallStatus; // string
	public $CallMessage; // string
}

class ExactTarget_VoiceTriggeredSend {
	public $VoiceTriggeredSendDefinition; // ExactTarget_VoiceTriggeredSendDefinition
	public $Subscriber; // ExactTarget_Subscriber
	public $Message; // string
	public $Number; // string
}

class ExactTarget_VoiceTriggeredSendDefinition {
}

class ExactTarget_SMSTriggeredSend {
	public $SMSTriggeredSendDefinition; // ExactTarget_SMSTriggeredSendDefinition
	public $Subscriber; // ExactTarget_Subscriber
	public $Message; // string
	public $Number; // string
}

class ExactTarget_SMSTriggeredSendDefinition {
}

class ExactTarget_SendClassification {
	public $SendClassificationType; // ExactTarget_SendClassificationTypeEnum
	public $Name; // string
	public $Description; // string
	public $SenderProfile; // ExactTarget_SenderProfile
	public $DeliveryProfile; // ExactTarget_DeliveryProfile
}

class ExactTarget_SendClassificationTypeEnum {
	const Operational='Operational';
	const Marketing='Marketing';
}

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

class ExactTarget_DeliveryProfile {
	public $Name; // string
	public $Description; // string
	public $SourceAddressType; // ExactTarget_DeliveryProfileSourceAddressTypeEnum
	public $PrivateIP; // ExactTarget_PrivateIP
	public $DomainType; // ExactTarget_DeliveryProfileDomainTypeEnum
	public $PrivateDomain; // ExactTarget_PrivateDomain
	public $HeaderSalutationSource; // ExactTarget_SalutationSourceEnum
	public $HeaderContentArea; // ExactTarget_ContentArea
	public $FooterSalutationSource; // ExactTarget_SalutationSourceEnum
	public $FooterContentArea; // ExactTarget_ContentArea
}

class ExactTarget_DeliveryProfileSourceAddressTypeEnum {
	const DefaultPrivateIPAddress='DefaultPrivateIPAddress';
	const CustomPrivateIPAddress='CustomPrivateIPAddress';
}

class ExactTarget_DeliveryProfileDomainTypeEnum {
	const DefaultDomain='DefaultDomain';
	const CustomDomain='CustomDomain';
}

class ExactTarget_SalutationSourceEnum {
	const _Default='Default';
	const ContentLibrary='ContentLibrary';
	const None='None';
}

class ExactTarget_PrivateDomain {
}

class ExactTarget_PrivateIP {
	public $Name; // string
	public $Description; // string
	public $IsActive; // boolean
	public $OrdinalID; // short
	public $IPAddress; // string
}

class ExactTarget_SendDefinition {
	public $CategoryID; // int
	public $SendClassification; // ExactTarget_SendClassification
	public $SenderProfile; // ExactTarget_SenderProfile
	public $FromName; // string
	public $FromAddress; // string
	public $DeliveryProfile; // ExactTarget_DeliveryProfile
	public $SourceAddressType; // ExactTarget_DeliveryProfileSourceAddressTypeEnum
	public $PrivateIP; // ExactTarget_PrivateIP
	public $DomainType; // ExactTarget_DeliveryProfileDomainTypeEnum
	public $PrivateDomain; // ExactTarget_PrivateDomain
	public $HeaderSalutationSource; // ExactTarget_SalutationSourceEnum
	public $HeaderContentArea; // ExactTarget_ContentArea
	public $FooterSalutationSource; // ExactTarget_SalutationSourceEnum
	public $FooterContentArea; // ExactTarget_ContentArea
	public $SuppressTracking; // boolean
	public $IsSendLogging; // boolean
}

class ExactTarget_AudienceItem {
	public $List; // ExactTarget_List
	public $SendDefinitionListType; // ExactTarget_SendDefinitionListTypeEnum
	public $CustomObjectID; // string
	public $DataSourceTypeID; // ExactTarget_DataSourceTypeEnum
}

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

class ExactTarget_TrackingUsers {
	public $TrackingUser; // ExactTarget_TrackingUser
}

class ExactTarget_SendDefinitionList {
	public $FilterDefinition; // ExactTarget_FilterDefinition
	public $IsTestObject; // boolean
	public $SalesForceObjectID; // string
	public $Name; // string
	public $Parameters; // ExactTarget_Parameters
}



class ExactTarget_SendDefinitionStatusEnum {
	const Active='Active';
	const Archived='Archived';
	const Deleted='Deleted';
}

class ExactTarget_SendDefinitionListTypeEnum {
	const SourceList='SourceList';
	const ExclusionList='ExclusionList';
	const DomainExclusion='DomainExclusion';
}

class ExactTarget_DataSourceTypeEnum {
	const _List='List';
	const CustomObject='CustomObject';
	const DomainExclusion='DomainExclusion';
	const SalesForceReport='SalesForceReport';
	const SalesForceCampaign='SalesForceCampaign';
	const FilterDefinition='FilterDefinition';
}

class ExactTarget_TrackingUser {
	public $IsActive; // boolean
	public $EmployeeID; // int
}

class ExactTarget_MessagingVendorKind {
	public $Vendor; // string
	public $Kind; // string
	public $IsUsernameRequired; // boolean
	public $IsPasswordRequired; // boolean
	public $IsProfileRequired; // boolean
}

class ExactTarget_MessagingConfiguration {
	public $Code; // string
	public $MessagingVendorKind; // ExactTarget_MessagingVendorKind
	public $IsActive; // boolean
	public $Url; // string
	public $UserName; // string
	public $Password; // string
	public $ProfileID; // string
	public $CallbackUrl; // string
	public $MediaTypes; // string
}

class ExactTarget_UserMap {
	public $ETAccountUser; // ExactTarget_AccountUser
	public $AdditionalData; // ExactTarget_APIProperty
}

class ExactTarget_Folder {
	public $ID; // int
	public $ParentID; // int
}

class ExactTarget_FileTransferLocation {
}

class ExactTarget_DataExtractActivity {
}

class ExactTarget_MessageSendActivity {
}

class ExactTarget_SmsSendActivity {
}

class ExactTarget_ReportActivity {
}

class ExactTarget_DataExtension {
	public $Name; // string
	public $Description; // string
	public $IsSendable; // boolean
	public $IsTestable; // boolean
	public $SendableDataExtensionField; // ExactTarget_DataExtensionField
	public $SendableSubscriberField; // ExactTarget_Attribute
	public $Template; // ExactTarget_DataExtensionTemplate
	public $DataRetentionPeriodLength; // int
	public $DataRetentionPeriodUnitOfMeasure; // int
	public $RowBasedRetention; // boolean
	public $ResetRetentionPeriodOnImport; // boolean
	public $DeleteAtEndOfRetentionPeriod; // boolean
	public $RetainUntil; // string
	public $Fields; // ExactTarget_Fields
	public $DataRetentionPeriod; // ExactTarget_DateTimeUnitOfMeasure
}

class ExactTarget_Fields {
	public $Field; // ExactTarget_DataExtensionField
}

class ExactTarget_DataExtensionField {
	public $Ordinal; // int
	public $IsPrimaryKey; // boolean
	public $FieldType; // ExactTarget_DataExtensionFieldType
	public $DataExtension; // ExactTarget_DataExtension
}

class ExactTarget_DataExtensionFieldType {
	const Text='Text';
	const Number='Number';
	const Date='Date';
	const Boolean='Boolean';
	const EmailAddress='EmailAddress';
	const Phone='Phone';
}

class ExactTarget_DateTimeUnitOfMeasure {
	const Days='Days';
	const Weeks='Weeks';
	const Months='Months';
	const Years='Years';
}

class ExactTarget_DataExtensionTemplate {
	public $Name; // string
}

class ExactTarget_DataExtensionObject {
	public $Name; // string
	public $Keys; // ExactTarget_Keys
}

class ExactTarget_Keys {
	public $Key; // ExactTarget_APIProperty
}

class ExactTarget_DataExtensionError {
	public $Name; // string
	public $ErrorCode; // integer
	public $ErrorMessage; // string
}

class ExactTarget_DataExtensionCreateResult {
	public $ErrorMessage; // string
	public $KeyErrors; // ExactTarget_KeyErrors
	public $ValueErrors; // ExactTarget_ValueErrors
}

class ExactTarget_KeyErrors {
	public $KeyError; // ExactTarget_DataExtensionError
}

class ExactTarget_ValueErrors {
	public $ValueError; // ExactTarget_DataExtensionError
}

class ExactTarget_DataExtensionUpdateResult {
	public $ErrorMessage; // string
	public $KeyErrors; // ExactTarget_KeyErrors
	public $ValueErrors; // ExactTarget_ValueErrors
}



class ExactTarget_DataExtensionDeleteResult {
	public $ErrorMessage; // string
	public $KeyErrors; // ExactTarget_KeyErrors
}



class ExactTarget_FileType {
	const CSV='CSV';
	const TAB='TAB';
	const Other='Other';
}

class ExactTarget_ImportDefinitionSubscriberImportType {
	const Email='Email';
	const SMS='SMS';
}

class ExactTarget_ImportDefinitionUpdateType {
	const AddAndUpdate='AddAndUpdate';
	const AddAndDoNotUpdate='AddAndDoNotUpdate';
	const UpdateButDoNotAdd='UpdateButDoNotAdd';
	const Merge='Merge';
	const Overwrite='Overwrite';
}

class ExactTarget_ImportDefinitionFieldMappingType {
	const InferFromColumnHeadings='InferFromColumnHeadings';
	const MapByOrdinal='MapByOrdinal';
	const ManualMap='ManualMap';
}

class ExactTarget_FieldMap {
	public $SourceName; // string
	public $SourceOrdinal; // int
	public $DestinationName; // string
}

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

class ExactTarget_FieldMaps {
	public $FieldMap; // ExactTarget_FieldMap
}

class ExactTarget_ImportDefinitionFieldMap {
	public $SourceName; // string
	public $SourceOrdinal; // int
	public $DestinationName; // string
}

class ExactTarget_ImportResultsSummary {
	public $ImportDefinitionCustomerKey; // string
	public $StartDate; // string
	public $EndDate; // string
	public $DestinationID; // string
	public $NumberSuccessful; // int
	public $NumberDuplicated; // int
	public $NumberErrors; // int
	public $TotalRows; // int
	public $ImportType; // string
	public $ImportStatus; // string
	public $TaskResultID; // int
}

class ExactTarget_FilterDefinition {
}

class ExactTarget_GroupDefinition {
}

class ExactTarget_FileTransferActivity {
}

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

class ExactTarget_LinkSend {
	public $SendID; // int
	public $Link; // ExactTarget_Link
}

class ExactTarget_ObjectExtension {
	public $Type; // string
	public $Properties; // ExactTarget_Properties
}

class ExactTarget_Properties {
	public $Property; // ExactTarget_APIProperty
}

class ExactTarget_PublicKeyManagement {
	public $Name; // string
	public $Key; // base64Binary
}

class ExactTarget_SystemStatusOptions {
}

class ExactTarget_SystemStatusRequestMsg {
	public $Options; // ExactTarget_SystemStatusOptions
}

class ExactTarget_SystemStatusResult {
	public $SystemStatus; // ExactTarget_SystemStatusType
	public $Outages; // ExactTarget_Outages
}

class ExactTarget_Outages {
	public $Outage; // ExactTarget_SystemOutage
}

class ExactTarget_SystemStatusResponseMsg {
	public $Results; // ExactTarget_Results
	public $OverallStatus; // string
	public $OverallStatusMessage; // string
	public $RequestID; // string
}



class ExactTarget_SystemStatusType {
	const OK='OK';
	const UnplannedOutage='UnplannedOutage';
	const InMaintenance='InMaintenance';
}

class ExactTarget_SystemOutage {
}

class ExactTarget_Authentication {
}

class ExactTarget_UsernameAuthentication {
	public $UserName; // string
	public $PassWord; // string
}

class ExactTarget_ResourceSpecification {
	public $URN; // string
	public $Authentication; // ExactTarget_Authentication
}

class ExactTarget_Portfolio {
	public $Source; // ExactTarget_ResourceSpecification
	public $CategoryID; // int
	public $FileName; // string
	public $DisplayName; // string
	public $Description; // string
	public $TypeDescription; // string
	public $IsUploaded; // boolean
	public $IsActive; // boolean
	public $FileSizeKB; // int
	public $ThumbSizeKB; // int
	public $FileWidthPX; // int
	public $FileHeightPX; // int
	public $FileURL; // string
	public $ThumbURL; // string
	public $CacheClearTime; // dateTime
	public $CategoryType; // string
}

class ExactTarget_QueryDefinition {
	public $QueryText; // string
	public $TargetType; // string
	public $DataExtensionTarget; // ExactTarget_InteractionBaseObject
	public $TargetUpdateType; // string
	public $FileSpec; // string
	public $FileType; // string
	public $Status; // string
}

?> 
