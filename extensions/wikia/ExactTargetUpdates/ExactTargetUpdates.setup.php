<?php

/**
 * Sends push updates to ExactTarget.com on various hooks.
 * The goal is to keep the data in ExactTarget mailing tool fresh.
 *
 * @package Wikia\extensions\ExactTargetUpdates
 *
 * @version 0.1
 *
 * @author Kamil Koterba <kamil@wikia-inc.com>
 * @author Adam Karmiński <adamk@wikia-inc.com>
 *
 * @see https://github.com/Wikia/app/tree/dev/extensions/wikia/ExactTargetUpdates/
 */


// Terminate the script when called out of MediaWiki context.
if ( !defined( 'MEDIAWIKI' ) ) {
	echo 'Invalid entry point. '
		 . 'This code is a MediaWiki extension and is not meant to be executed standalone. '
		 . 'Try vising the main page: /index.php or running a different script.';
	exit( 1 );
}

$dir = __DIR__;

/**
 * @global Array The list of extension credits.
 * @see http://www.mediawiki.org/wiki/Manual:$wgExtensionCredits
 */
$wgExtensionCredits[ 'other' ][] = array(
	'path' => __FILE__,
	'name' => 'ExactTargetUpdates',
	'descriptionmsg' => 'exacttarget-updates-description',
	'version' => '2.0',
	'author' => array(
		'Kamil Koterba <kamil@wikia-inc.com>',
		'Adam Karminski <adamk@wikia-inc.com>',
		'Adam Robak <adamr@wikia-inc.com>',
	),
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/ExactTargetUpdates/'
);

$wgExtensionMessagesFiles[ 'ExactTargetUpdates' ] = $dir . '/ExactTargetUpdates.i18n.php';

/**
 * Load classes
 */

/* Add hooks classes */
$wgAutoloadClasses[ 'Wikia\ExactTarget\ExactTargetSetupHooks' ] = $dir . '/hooks/ExactTargetSetup.hooks.php';
$wgAutoloadClasses[ 'Wikia\ExactTarget\ExactTargetUserHooks' ] = $dir . '/hooks/ExactTargetUser.hooks.php';
$wgAutoloadClasses[ 'Wikia\ExactTarget\ExactTargetUserHooksHelper' ] = $dir . '/hooks/ExactTargetUserHooksHelper.php';
$wgAutoloadClasses[ 'Wikia\ExactTarget\ExactTargetWikiHooks' ] = $dir . '/hooks/ExactTargetWiki.hooks.php';
$wgAutoloadClasses[ 'Wikia\ExactTarget\ExactTargetWikiHooksHelper' ] = $dir . '/hooks/ExactTargetWikiHooksHelper.php';
/* Add user-related tasks classes */
$wgAutoloadClasses[ 'Wikia\ExactTarget\ExactTargetUserUpdateDriver' ] = $dir . '/tasks/ExactTargetUserUpdateDriver.php';
/* Refactored tasks that are to replace old ones */
$wgAutoloadClasses[ 'Wikia\ExactTarget\ExactTargetUserTask' ] = $dir . '/tasks/ExactTargetUserTask.class.php';
$wgAutoloadClasses[ 'Wikia\ExactTarget\ExactTargetWikiTask' ] = $dir . '/tasks/ExactTargetWikiTask.class.php';

/* Client classes */
$wgAutoloadClasses[ 'ExactTargetSoapClient' ] = $dir . '/lib/exacttarget_soap_client.php';
$wgAutoloadClasses[ 'Wikia\ExactTarget\ExactTargetClient' ] = $dir . '/client/ExactTargetClient.class.php';
$wgAutoloadClasses[ 'Wikia\ExactTarget\ExactTargetRequestBuilder' ] = $dir . '/client/ExactTargetRequestBuilder.class.php';
/* Client builders */
$wgAutoloadClasses[ 'Wikia\ExactTarget\Builders\BaseRequestBuilder' ] = $dir . '/client/builders/BaseRequestBuilder.class.php';
$wgAutoloadClasses[ 'Wikia\ExactTarget\Builders\CreateRequestBuilder' ] = $dir . '/client/builders/CreateRequestBuilder.class.php';
$wgAutoloadClasses[ 'Wikia\ExactTarget\Builders\DeleteRequestBuilder' ] = $dir . '/client/builders/DeleteRequestBuilder.class.php';
$wgAutoloadClasses[ 'Wikia\ExactTarget\Builders\RetrieveRequestBuilder' ] = $dir . '/client/builders/RetrieveRequestBuilder.class.php';
$wgAutoloadClasses[ 'Wikia\ExactTarget\Builders\UpdateRequestBuilder' ] = $dir . '/client/builders/UpdateRequestBuilder.class.php';

/* Enum classes */
$wgAutoloadClasses[ 'Wikia\ExactTarget\ResourceEnum' ] = $dir . '/client/ExactTargetResourceEnum.php';

/* Data Adapters */
$wgAutoloadClasses[ 'Wikia\ExactTarget\BaseAdapter' ] = $dir . '/client/adapters/BaseAdapter.class.php';
$wgAutoloadClasses[ 'Wikia\ExactTarget\UserEmailAdapter' ] = $dir . '/client/adapters/UserEmailAdapter.class.php';
$wgAutoloadClasses[ 'Wikia\ExactTarget\UserEditsAdapter' ] = $dir . '/client/adapters/UserEditsAdapter.class.php';
$wgAutoloadClasses[ 'Wikia\ExactTarget\UserIdsAdapter' ] = $dir . '/client/adapters/UserIdsAdapter.class.php';
$wgAutoloadClasses[ 'Wikia\ExactTarget\WikiCategoriesAdapter' ] = $dir . '/client/adapters/WikiCategoriesAdapter.class.php';

/* Exceptions*/
$wgAutoloadClasses[ 'Wikia\ExactTarget\ExactTargetException' ] = $dir . '/client/ExactTargetException.php';

/* ExactTarget_* classes */

$wgAutoloadClasses[ 'ExactTarget_AccountDataItem' ] = $dir . '/lib/ExactTarget_AccountDataItem.php';
$wgAutoloadClasses[ 'ExactTarget_Account' ] = $dir . '/lib/ExactTarget_Account.php';
$wgAutoloadClasses[ 'ExactTarget_AccountPrivateLabel' ] = $dir . '/lib/ExactTarget_AccountPrivateLabel.php';
$wgAutoloadClasses[ 'ExactTarget_AccountTypeEnum' ] = $dir . '/lib/ExactTarget_AccountTypeEnum.php';
$wgAutoloadClasses[ 'ExactTarget_AccountUser' ] = $dir . '/lib/ExactTarget_AccountUser.php';
$wgAutoloadClasses[ 'ExactTarget_APIObject' ] = $dir . '/lib/ExactTarget_APIObject.php';
$wgAutoloadClasses[ 'ExactTarget_APIProperty' ] = $dir . '/lib/ExactTarget_APIProperty.php';
$wgAutoloadClasses[ 'ExactTarget_ArrayOfObjectDefinitionRequest' ] = $dir . '/lib/ExactTarget_ArrayOfObjectDefinitionRequest.php';
$wgAutoloadClasses[ 'ExactTarget_AsyncRequestResult' ] = $dir . '/lib/ExactTarget_AsyncRequestResult.php';
$wgAutoloadClasses[ 'ExactTarget_AsyncResponse' ] = $dir . '/lib/ExactTarget_AsyncResponse.php';
$wgAutoloadClasses[ 'ExactTarget_AsyncResponseType' ] = $dir . '/lib/ExactTarget_AsyncResponseType.php';
$wgAutoloadClasses[ 'ExactTarget_AttributeMap' ] = $dir . '/lib/ExactTarget_AttributeMap.php';
$wgAutoloadClasses[ 'ExactTarget_Attribute' ] = $dir . '/lib/ExactTarget_Attribute.php';
$wgAutoloadClasses[ 'ExactTarget_AudienceItem' ] = $dir . '/lib/ExactTarget_AudienceItem.php';
$wgAutoloadClasses[ 'ExactTarget_Authentication' ] = $dir . '/lib/ExactTarget_Authentication.php';
$wgAutoloadClasses[ 'ExactTarget_BounceEvent' ] = $dir . '/lib/ExactTarget_BounceEvent.php';
$wgAutoloadClasses[ 'ExactTarget_Brand' ] = $dir . '/lib/ExactTarget_Brand.php';
$wgAutoloadClasses[ 'ExactTarget_BrandTag' ] = $dir . '/lib/ExactTarget_BrandTag.php';
$wgAutoloadClasses[ 'ExactTarget_BusinessRule' ] = $dir . '/lib/ExactTarget_BusinessRule.php';
$wgAutoloadClasses[ 'ExactTarget_CampaignPerformOptions' ] = $dir . '/lib/ExactTarget_CampaignPerformOptions.php';
$wgAutoloadClasses[ 'ExactTarget_Campaign' ] = $dir . '/lib/ExactTarget_Campaign.php';
$wgAutoloadClasses[ 'ExactTarget_ClickEvent' ] = $dir . '/lib/ExactTarget_ClickEvent.php';
$wgAutoloadClasses[ 'ExactTarget_ClientID' ] = $dir . '/lib/ExactTarget_ClientID.php';
$wgAutoloadClasses[ 'ExactTarget_ComplexFilterPart' ] = $dir . '/lib/ExactTarget_ComplexFilterPart.php';
$wgAutoloadClasses[ 'ExactTarget_Configurations' ] = $dir . '/lib/ExactTarget_Configurations.php';
$wgAutoloadClasses[ 'ExactTarget_ConfigureOptions' ] = $dir . '/lib/ExactTarget_ConfigureOptions.php';
$wgAutoloadClasses[ 'ExactTarget_ConfigureRequestMsg' ] = $dir . '/lib/ExactTarget_ConfigureRequestMsg.php';
$wgAutoloadClasses[ 'ExactTarget_ConfigureResponseMsg' ] = $dir . '/lib/ExactTarget_ConfigureResponseMsg.php';
$wgAutoloadClasses[ 'ExactTarget_ConfigureResult' ] = $dir . '/lib/ExactTarget_ConfigureResult.php';
$wgAutoloadClasses[ 'ExactTarget_ContainerID' ] = $dir . '/lib/ExactTarget_ContainerID.php';
$wgAutoloadClasses[ 'ExactTarget_ContentArea' ] = $dir . '/lib/ExactTarget_ContentArea.php';
$wgAutoloadClasses[ 'ExactTarget_CreateOptions' ] = $dir . '/lib/ExactTarget_CreateOptions.php';
$wgAutoloadClasses[ 'ExactTarget_CreateRequest' ] = $dir . '/lib/ExactTarget_CreateRequest.php';
$wgAutoloadClasses[ 'ExactTarget_CreateResponse' ] = $dir . '/lib/ExactTarget_CreateResponse.php';
$wgAutoloadClasses[ 'ExactTarget_CreateResult' ] = $dir . '/lib/ExactTarget_CreateResult.php';
$wgAutoloadClasses[ 'ExactTarget_DailyRecurrencePatternTypeEnum' ] = $dir . '/lib/ExactTarget_DailyRecurrencePatternTypeEnum.php';
$wgAutoloadClasses[ 'ExactTarget_DailyRecurrence' ] = $dir . '/lib/ExactTarget_DailyRecurrence.php';
$wgAutoloadClasses[ 'ExactTarget_DataExtensionCreateResult' ] = $dir . '/lib/ExactTarget_DataExtensionCreateResult.php';
$wgAutoloadClasses[ 'ExactTarget_DataExtensionDeleteResult' ] = $dir . '/lib/ExactTarget_DataExtensionDeleteResult.php';
$wgAutoloadClasses[ 'ExactTarget_DataExtensionError' ] = $dir . '/lib/ExactTarget_DataExtensionError.php';
$wgAutoloadClasses[ 'ExactTarget_DataExtensionField' ] = $dir . '/lib/ExactTarget_DataExtensionField.php';
$wgAutoloadClasses[ 'ExactTarget_DataExtensionFieldType' ] = $dir . '/lib/ExactTarget_DataExtensionFieldType.php';
$wgAutoloadClasses[ 'ExactTarget_DataExtensionObject' ] = $dir . '/lib/ExactTarget_DataExtensionObject.php';
$wgAutoloadClasses[ 'ExactTarget_DataExtension' ] = $dir . '/lib/ExactTarget_DataExtension.php';
$wgAutoloadClasses[ 'ExactTarget_DataExtensionTemplate' ] = $dir . '/lib/ExactTarget_DataExtensionTemplate.php';
$wgAutoloadClasses[ 'ExactTarget_DataExtensionUpdateResult' ] = $dir . '/lib/ExactTarget_DataExtensionUpdateResult.php';
$wgAutoloadClasses[ 'ExactTarget_DataExtractActivity' ] = $dir . '/lib/ExactTarget_DataExtractActivity.php';
$wgAutoloadClasses[ 'ExactTarget_DataSourceTypeEnum' ] = $dir . '/lib/ExactTarget_DataSourceTypeEnum.php';
$wgAutoloadClasses[ 'ExactTarget_DateTimeUnitOfMeasure' ] = $dir . '/lib/ExactTarget_DateTimeUnitOfMeasure.php';
$wgAutoloadClasses[ 'ExactTarget_DayOfWeekEnum' ] = $dir . '/lib/ExactTarget_DayOfWeekEnum.php';
$wgAutoloadClasses[ 'ExactTarget_DefinitionRequestMsg' ] = $dir . '/lib/ExactTarget_DefinitionRequestMsg.php';
$wgAutoloadClasses[ 'ExactTarget_DefinitionResponseMsg' ] = $dir . '/lib/ExactTarget_DefinitionResponseMsg.php';
$wgAutoloadClasses[ 'ExactTarget_Definitions' ] = $dir . '/lib/ExactTarget_Definitions.php';
$wgAutoloadClasses[ 'ExactTarget_DeleteOptions' ] = $dir . '/lib/ExactTarget_DeleteOptions.php';
$wgAutoloadClasses[ 'ExactTarget_DeleteRequest' ] = $dir . '/lib/ExactTarget_DeleteRequest.php';
$wgAutoloadClasses[ 'ExactTarget_DeleteResponse' ] = $dir . '/lib/ExactTarget_DeleteResponse.php';
$wgAutoloadClasses[ 'ExactTarget_DeleteResult' ] = $dir . '/lib/ExactTarget_DeleteResult.php';
$wgAutoloadClasses[ 'ExactTarget_DeliveryProfileDomainTypeEnum' ] = $dir . '/lib/ExactTarget_DeliveryProfileDomainTypeEnum.php';
$wgAutoloadClasses[ 'ExactTarget_DeliveryProfile' ] = $dir . '/lib/ExactTarget_DeliveryProfile.php';
$wgAutoloadClasses[ 'ExactTarget_DeliveryProfileSourceAddressTypeEnum' ] = $dir . '/lib/ExactTarget_DeliveryProfileSourceAddressTypeEnum.php';
$wgAutoloadClasses[ 'ExactTarget_Email' ] = $dir . '/lib/ExactTarget_Email.php';
$wgAutoloadClasses[ 'ExactTarget_EmailSendDefinition' ] = $dir . '/lib/ExactTarget_EmailSendDefinition.php';
$wgAutoloadClasses[ 'ExactTarget_EmailType' ] = $dir . '/lib/ExactTarget_EmailType.php';
$wgAutoloadClasses[ 'ExactTarget_EventType' ] = $dir . '/lib/ExactTarget_EventType.php';
$wgAutoloadClasses[ 'ExactTarget_ExecuteRequestMsg' ] = $dir . '/lib/ExactTarget_ExecuteRequestMsg.php';
$wgAutoloadClasses[ 'ExactTarget_ExecuteRequest' ] = $dir . '/lib/ExactTarget_ExecuteRequest.php';
$wgAutoloadClasses[ 'ExactTarget_ExecuteResponseMsg' ] = $dir . '/lib/ExactTarget_ExecuteResponseMsg.php';
$wgAutoloadClasses[ 'ExactTarget_ExecuteResponse' ] = $dir . '/lib/ExactTarget_ExecuteResponse.php';
$wgAutoloadClasses[ 'ExactTarget_ExtendedProperties' ] = $dir . '/lib/ExactTarget_ExtendedProperties.php';
$wgAutoloadClasses[ 'ExactTarget_ExtractDefinition' ] = $dir . '/lib/ExactTarget_ExtractDefinition.php';
$wgAutoloadClasses[ 'ExactTarget_ExtractDescription' ] = $dir . '/lib/ExactTarget_ExtractDescription.php';
$wgAutoloadClasses[ 'ExactTarget_ExtractOptions' ] = $dir . '/lib/ExactTarget_ExtractOptions.php';
$wgAutoloadClasses[ 'ExactTarget_ExtractParameterDataType' ] = $dir . '/lib/ExactTarget_ExtractParameterDataType.php';
$wgAutoloadClasses[ 'ExactTarget_ExtractParameterDescription' ] = $dir . '/lib/ExactTarget_ExtractParameterDescription.php';
$wgAutoloadClasses[ 'ExactTarget_ExtractParameter' ] = $dir . '/lib/ExactTarget_ExtractParameter.php';
$wgAutoloadClasses[ 'ExactTarget_ExtractRequestMsg' ] = $dir . '/lib/ExactTarget_ExtractRequestMsg.php';
$wgAutoloadClasses[ 'ExactTarget_ExtractRequest' ] = $dir . '/lib/ExactTarget_ExtractRequest.php';
$wgAutoloadClasses[ 'ExactTarget_ExtractResponseMsg' ] = $dir . '/lib/ExactTarget_ExtractResponseMsg.php';
$wgAutoloadClasses[ 'ExactTarget_ExtractResult' ] = $dir . '/lib/ExactTarget_ExtractResult.php';
$wgAutoloadClasses[ 'ExactTarget_ExtractTemplate' ] = $dir . '/lib/ExactTarget_ExtractTemplate.php';
$wgAutoloadClasses[ 'ExactTarget_FieldMap' ] = $dir . '/lib/ExactTarget_FieldMap.php';
$wgAutoloadClasses[ 'ExactTarget_FieldMaps' ] = $dir . '/lib/ExactTarget_FieldMaps.php';
$wgAutoloadClasses[ 'ExactTarget_Fields' ] = $dir . '/lib/ExactTarget_Fields.php';
$wgAutoloadClasses[ 'ExactTarget_FileTransferActivity' ] = $dir . '/lib/ExactTarget_FileTransferActivity.php';
$wgAutoloadClasses[ 'ExactTarget_FileTransferLocation' ] = $dir . '/lib/ExactTarget_FileTransferLocation.php';
$wgAutoloadClasses[ 'ExactTarget_FileType' ] = $dir . '/lib/ExactTarget_FileType.php';
$wgAutoloadClasses[ 'ExactTarget_FilterDefinition' ] = $dir . '/lib/ExactTarget_FilterDefinition.php';
$wgAutoloadClasses[ 'ExactTarget_FilterPart' ] = $dir . '/lib/ExactTarget_FilterPart.php';
$wgAutoloadClasses[ 'ExactTarget_Folder' ] = $dir . '/lib/ExactTarget_Folder.php';
$wgAutoloadClasses[ 'ExactTarget_ForwardedEmailEvent' ] = $dir . '/lib/ExactTarget_ForwardedEmailEvent.php';
$wgAutoloadClasses[ 'ExactTarget_ForwardedEmailOptInEvent' ] = $dir . '/lib/ExactTarget_ForwardedEmailOptInEvent.php';
$wgAutoloadClasses[ 'ExactTarget_GlobalUnsubscribeCategory' ] = $dir . '/lib/ExactTarget_GlobalUnsubscribeCategory.php';
$wgAutoloadClasses[ 'ExactTarget_GroupDefinition' ] = $dir . '/lib/ExactTarget_GroupDefinition.php';
$wgAutoloadClasses[ 'ExactTarget_Group' ] = $dir . '/lib/ExactTarget_Group.php';
$wgAutoloadClasses[ 'ExactTarget_HourlyRecurrencePatternTypeEnum' ] = $dir . '/lib/ExactTarget_HourlyRecurrencePatternTypeEnum.php';
$wgAutoloadClasses[ 'ExactTarget_HourlyRecurrence' ] = $dir . '/lib/ExactTarget_HourlyRecurrence.php';
$wgAutoloadClasses[ 'ExactTarget_ImportDefinitionFieldMap' ] = $dir . '/lib/ExactTarget_ImportDefinitionFieldMap.php';
$wgAutoloadClasses[ 'ExactTarget_ImportDefinitionFieldMappingType' ] = $dir . '/lib/ExactTarget_ImportDefinitionFieldMappingType.php';
$wgAutoloadClasses[ 'ExactTarget_ImportDefinition' ] = $dir . '/lib/ExactTarget_ImportDefinition.php';
$wgAutoloadClasses[ 'ExactTarget_ImportDefinitionSubscriberImportType' ] = $dir . '/lib/ExactTarget_ImportDefinitionSubscriberImportType.php';
$wgAutoloadClasses[ 'ExactTarget_ImportDefinitionUpdateType' ] = $dir . '/lib/ExactTarget_ImportDefinitionUpdateType.php';
$wgAutoloadClasses[ 'ExactTarget_ImportResultsSummary' ] = $dir . '/lib/ExactTarget_ImportResultsSummary.php';
$wgAutoloadClasses[ 'ExactTarget_InteractionBaseObject' ] = $dir . '/lib/ExactTarget_InteractionBaseObject.php';
$wgAutoloadClasses[ 'ExactTarget_InteractionDefinition' ] = $dir . '/lib/ExactTarget_InteractionDefinition.php';
$wgAutoloadClasses[ 'ExactTarget_Interactions' ] = $dir . '/lib/ExactTarget_Interactions.php';
$wgAutoloadClasses[ 'ExactTarget_KeyErrors' ] = $dir . '/lib/ExactTarget_KeyErrors.php';
$wgAutoloadClasses[ 'ExactTarget_Keys' ] = $dir . '/lib/ExactTarget_Keys.php';
$wgAutoloadClasses[ 'ExactTarget_LayoutType' ] = $dir . '/lib/ExactTarget_LayoutType.php';
$wgAutoloadClasses[ 'ExactTarget_Link' ] = $dir . '/lib/ExactTarget_Link.php';
$wgAutoloadClasses[ 'ExactTarget_LinkSend' ] = $dir . '/lib/ExactTarget_LinkSend.php';
$wgAutoloadClasses[ 'ExactTarget_List' ] = $dir . '/lib/ExactTarget_List.php';
$wgAutoloadClasses[ 'ExactTarget_ListSend' ] = $dir . '/lib/ExactTarget_ListSend.php';
$wgAutoloadClasses[ 'ExactTarget_ListSubscriber' ] = $dir . '/lib/ExactTarget_ListSubscriber.php';
$wgAutoloadClasses[ 'ExactTarget_ListTypeEnum' ] = $dir . '/lib/ExactTarget_ListTypeEnum.php';
$wgAutoloadClasses[ 'ExactTarget_LogicalOperators' ] = $dir . '/lib/ExactTarget_LogicalOperators.php';
$wgAutoloadClasses[ 'ExactTarget_Message' ] = $dir . '/lib/ExactTarget_Message.php';
$wgAutoloadClasses[ 'ExactTarget_MessageSendActivity' ] = $dir . '/lib/ExactTarget_MessageSendActivity.php';
$wgAutoloadClasses[ 'ExactTarget_MessagingConfiguration' ] = $dir . '/lib/ExactTarget_MessagingConfiguration.php';
$wgAutoloadClasses[ 'ExactTarget_MessagingVendorKind' ] = $dir . '/lib/ExactTarget_MessagingVendorKind.php';
$wgAutoloadClasses[ 'ExactTarget_MonthlyRecurrencePatternTypeEnum' ] = $dir . '/lib/ExactTarget_MonthlyRecurrencePatternTypeEnum.php';
$wgAutoloadClasses[ 'ExactTarget_MonthlyRecurrence' ] = $dir . '/lib/ExactTarget_MonthlyRecurrence.php';
$wgAutoloadClasses[ 'ExactTarget_MonthOfYearEnum' ] = $dir . '/lib/ExactTarget_MonthOfYearEnum.php';
$wgAutoloadClasses[ 'ExactTarget_NotSentEvent' ] = $dir . '/lib/ExactTarget_NotSentEvent.php';
$wgAutoloadClasses[ 'ExactTarget_NullAPIProperty' ] = $dir . '/lib/ExactTarget_NullAPIProperty.php';
$wgAutoloadClasses[ 'ExactTarget_ObjectDefinition' ] = $dir . '/lib/ExactTarget_ObjectDefinition.php';
$wgAutoloadClasses[ 'ExactTarget_ObjectDefinitionRequest' ] = $dir . '/lib/ExactTarget_ObjectDefinitionRequest.php';
$wgAutoloadClasses[ 'ExactTarget_ObjectExtension' ] = $dir . '/lib/ExactTarget_ObjectExtension.php';
$wgAutoloadClasses[ 'ExactTarget_OpenEvent' ] = $dir . '/lib/ExactTarget_OpenEvent.php';
$wgAutoloadClasses[ 'ExactTarget_Options' ] = $dir . '/lib/ExactTarget_Options.php';
$wgAutoloadClasses[ 'ExactTarget_Outages' ] = $dir . '/lib/ExactTarget_Outages.php';
$wgAutoloadClasses[ 'ExactTarget_Owner' ] = $dir . '/lib/ExactTarget_Owner.php';
$wgAutoloadClasses[ 'ExactTarget_ParameterDescription' ] = $dir . '/lib/ExactTarget_ParameterDescription.php';
$wgAutoloadClasses[ 'ExactTarget_Parameters' ] = $dir . '/lib/ExactTarget_Parameters.php';
$wgAutoloadClasses[ 'ExactTarget_PerformOptions' ] = $dir . '/lib/ExactTarget_PerformOptions.php';
$wgAutoloadClasses[ 'ExactTarget_PerformRequestMsg' ] = $dir . '/lib/ExactTarget_PerformRequestMsg.php';
$wgAutoloadClasses[ 'ExactTarget_PerformRequest' ] = $dir . '/lib/ExactTarget_PerformRequest.php';
$wgAutoloadClasses[ 'ExactTarget_PerformResponseMsg' ] = $dir . '/lib/ExactTarget_PerformResponseMsg.php';
$wgAutoloadClasses[ 'ExactTarget_PerformResponse' ] = $dir . '/lib/ExactTarget_PerformResponse.php';
$wgAutoloadClasses[ 'ExactTarget_PerformResult' ] = $dir . '/lib/ExactTarget_PerformResult.php';
$wgAutoloadClasses[ 'ExactTarget_PicklistItem' ] = $dir . '/lib/ExactTarget_PicklistItem.php';
$wgAutoloadClasses[ 'ExactTarget_PicklistItems' ] = $dir . '/lib/ExactTarget_PicklistItems.php';
$wgAutoloadClasses[ 'ExactTarget_Portfolio' ] = $dir . '/lib/ExactTarget_Portfolio.php';
$wgAutoloadClasses[ 'ExactTarget_Priority' ] = $dir . '/lib/ExactTarget_Priority.php';
$wgAutoloadClasses[ 'ExactTarget_PrivateDomain' ] = $dir . '/lib/ExactTarget_PrivateDomain.php';
$wgAutoloadClasses[ 'ExactTarget_PrivateIP' ] = $dir . '/lib/ExactTarget_PrivateIP.php';
$wgAutoloadClasses[ 'ExactTarget_PrivateLabel' ] = $dir . '/lib/ExactTarget_PrivateLabel.php';
$wgAutoloadClasses[ 'ExactTarget_Properties' ] = $dir . '/lib/ExactTarget_Properties.php';
$wgAutoloadClasses[ 'ExactTarget_PropertyDefinition' ] = $dir . '/lib/ExactTarget_PropertyDefinition.php';
$wgAutoloadClasses[ 'ExactTarget_PropertyType' ] = $dir . '/lib/ExactTarget_PropertyType.php';
$wgAutoloadClasses[ 'ExactTarget_PublicKeyManagement' ] = $dir . '/lib/ExactTarget_PublicKeyManagement.php';
$wgAutoloadClasses[ 'ExactTarget_QueryDefinition' ] = $dir . '/lib/ExactTarget_QueryDefinition.php';
$wgAutoloadClasses[ 'ExactTarget_QueryObject' ] = $dir . '/lib/ExactTarget_QueryObject.php';
$wgAutoloadClasses[ 'ExactTarget_Query' ] = $dir . '/lib/ExactTarget_Query.php';
$wgAutoloadClasses[ 'ExactTarget_QueryRequestMsg' ] = $dir . '/lib/ExactTarget_QueryRequestMsg.php';
$wgAutoloadClasses[ 'ExactTarget_QueryRequest' ] = $dir . '/lib/ExactTarget_QueryRequest.php';
$wgAutoloadClasses[ 'ExactTarget_QueryResponseMsg' ] = $dir . '/lib/ExactTarget_QueryResponseMsg.php';
$wgAutoloadClasses[ 'ExactTarget_Recurrence' ] = $dir . '/lib/ExactTarget_Recurrence.php';
$wgAutoloadClasses[ 'ExactTarget_RecurrenceRangeTypeEnum' ] = $dir . '/lib/ExactTarget_RecurrenceRangeTypeEnum.php';
$wgAutoloadClasses[ 'ExactTarget_RecurrenceTypeEnum' ] = $dir . '/lib/ExactTarget_RecurrenceTypeEnum.php';
$wgAutoloadClasses[ 'ExactTarget_References' ] = $dir . '/lib/ExactTarget_References.php';
$wgAutoloadClasses[ 'ExactTarget_ReportActivity' ] = $dir . '/lib/ExactTarget_ReportActivity.php';
$wgAutoloadClasses[ 'ExactTarget_Request' ] = $dir . '/lib/ExactTarget_Request.php';
$wgAutoloadClasses[ 'ExactTarget_RequestType' ] = $dir . '/lib/ExactTarget_RequestType.php';
$wgAutoloadClasses[ 'ExactTarget_ResourceSpecification' ] = $dir . '/lib/ExactTarget_ResourceSpecification.php';
$wgAutoloadClasses[ 'ExactTarget_RespondWhen' ] = $dir . '/lib/ExactTarget_RespondWhen.php';
$wgAutoloadClasses[ 'ExactTarget_ResultItem' ] = $dir . '/lib/ExactTarget_ResultItem.php';
$wgAutoloadClasses[ 'ExactTarget_ResultMessage' ] = $dir . '/lib/ExactTarget_ResultMessage.php';
$wgAutoloadClasses[ 'ExactTarget_Result' ] = $dir . '/lib/ExactTarget_Result.php';
$wgAutoloadClasses[ 'ExactTarget_Results' ] = $dir . '/lib/ExactTarget_Results.php';
$wgAutoloadClasses[ 'ExactTarget_RetrieveOptions' ] = $dir . '/lib/ExactTarget_RetrieveOptions.php';
$wgAutoloadClasses[ 'ExactTarget_RetrieveRequestMsg' ] = $dir . '/lib/ExactTarget_RetrieveRequestMsg.php';
$wgAutoloadClasses[ 'ExactTarget_RetrieveRequest' ] = $dir . '/lib/ExactTarget_RetrieveRequest.php';
$wgAutoloadClasses[ 'ExactTarget_RetrieveResponseMsg' ] = $dir . '/lib/ExactTarget_RetrieveResponseMsg.php';
$wgAutoloadClasses[ 'ExactTarget_RetrieveSingleOptions' ] = $dir . '/lib/ExactTarget_RetrieveSingleOptions.php';
$wgAutoloadClasses[ 'ExactTarget_RetrieveSingleRequest' ] = $dir . '/lib/ExactTarget_RetrieveSingleRequest.php';
$wgAutoloadClasses[ 'ExactTarget_Retrieves' ] = $dir . '/lib/ExactTarget_Retrieves.php';
$wgAutoloadClasses[ 'ExactTarget_SalutationSourceEnum' ] = $dir . '/lib/ExactTarget_SalutationSourceEnum.php';
$wgAutoloadClasses[ 'ExactTarget_SaveAction' ] = $dir . '/lib/ExactTarget_SaveAction.php';
$wgAutoloadClasses[ 'ExactTarget_SaveOption' ] = $dir . '/lib/ExactTarget_SaveOption.php';
$wgAutoloadClasses[ 'ExactTarget_SaveOptions' ] = $dir . '/lib/ExactTarget_SaveOptions.php';
$wgAutoloadClasses[ 'ExactTarget_ScheduleDefinition' ] = $dir . '/lib/ExactTarget_ScheduleDefinition.php';
$wgAutoloadClasses[ 'ExactTarget_ScheduleOptions' ] = $dir . '/lib/ExactTarget_ScheduleOptions.php';
$wgAutoloadClasses[ 'ExactTarget_ScheduleRequestMsg' ] = $dir . '/lib/ExactTarget_ScheduleRequestMsg.php';
$wgAutoloadClasses[ 'ExactTarget_ScheduleResponseMsg' ] = $dir . '/lib/ExactTarget_ScheduleResponseMsg.php';
$wgAutoloadClasses[ 'ExactTarget_ScheduleResponse' ] = $dir . '/lib/ExactTarget_ScheduleResponse.php';
$wgAutoloadClasses[ 'ExactTarget_ScheduleResult' ] = $dir . '/lib/ExactTarget_ScheduleResult.php';
$wgAutoloadClasses[ 'ExactTarget_SendClassification' ] = $dir . '/lib/ExactTarget_SendClassification.php';
$wgAutoloadClasses[ 'ExactTarget_SendClassificationTypeEnum' ] = $dir . '/lib/ExactTarget_SendClassificationTypeEnum.php';
$wgAutoloadClasses[ 'ExactTarget_SendDefinitionList' ] = $dir . '/lib/ExactTarget_SendDefinitionList.php';
$wgAutoloadClasses[ 'ExactTarget_SendDefinitionListTypeEnum' ] = $dir . '/lib/ExactTarget_SendDefinitionListTypeEnum.php';
$wgAutoloadClasses[ 'ExactTarget_SendDefinition' ] = $dir . '/lib/ExactTarget_SendDefinition.php';
$wgAutoloadClasses[ 'ExactTarget_SendDefinitionStatusEnum' ] = $dir . '/lib/ExactTarget_SendDefinitionStatusEnum.php';
$wgAutoloadClasses[ 'ExactTarget_SenderProfile' ] = $dir . '/lib/ExactTarget_SenderProfile.php';
$wgAutoloadClasses[ 'ExactTarget_Send' ] = $dir . '/lib/ExactTarget_Send.php';
$wgAutoloadClasses[ 'ExactTarget_SendSummary' ] = $dir . '/lib/ExactTarget_SendSummary.php';
$wgAutoloadClasses[ 'ExactTarget_SentEvent' ] = $dir . '/lib/ExactTarget_SentEvent.php';
$wgAutoloadClasses[ 'ExactTarget_SimpleFilterPart' ] = $dir . '/lib/ExactTarget_SimpleFilterPart.php';
$wgAutoloadClasses[ 'ExactTarget_SimpleOperators' ] = $dir . '/lib/ExactTarget_SimpleOperators.php';
$wgAutoloadClasses[ 'ExactTarget_SmsSendActivity' ] = $dir . '/lib/ExactTarget_SmsSendActivity.php';
$wgAutoloadClasses[ 'ExactTarget_SMSTriggeredSendDefinition' ] = $dir . '/lib/ExactTarget_SMSTriggeredSendDefinition.php';
$wgAutoloadClasses[ 'ExactTarget_SMSTriggeredSend' ] = $dir . '/lib/ExactTarget_SMSTriggeredSend.php';
$wgAutoloadClasses[ 'ExactTarget_SoapType' ] = $dir . '/lib/ExactTarget_SoapType.php';
$wgAutoloadClasses[ 'ExactTarget_SubscriberList' ] = $dir . '/lib/ExactTarget_SubscriberList.php';
$wgAutoloadClasses[ 'ExactTarget_Subscriber' ] = $dir . '/lib/ExactTarget_Subscriber.php';
$wgAutoloadClasses[ 'ExactTarget_SubscriberResult' ] = $dir . '/lib/ExactTarget_SubscriberResult.php';
$wgAutoloadClasses[ 'ExactTarget_SubscriberSendResult' ] = $dir . '/lib/ExactTarget_SubscriberSendResult.php';
$wgAutoloadClasses[ 'ExactTarget_SubscriberStatus' ] = $dir . '/lib/ExactTarget_SubscriberStatus.php';
$wgAutoloadClasses[ 'ExactTarget_SubscriberTypeDefinition' ] = $dir . '/lib/ExactTarget_SubscriberTypeDefinition.php';
$wgAutoloadClasses[ 'ExactTarget_Subscription' ] = $dir . '/lib/ExactTarget_Subscription.php';
$wgAutoloadClasses[ 'ExactTarget_SurveyEvent' ] = $dir . '/lib/ExactTarget_SurveyEvent.php';
$wgAutoloadClasses[ 'ExactTarget_SystemOutage' ] = $dir . '/lib/ExactTarget_SystemOutage.php';
$wgAutoloadClasses[ 'ExactTarget_SystemStatusOptions' ] = $dir . '/lib/ExactTarget_SystemStatusOptions.php';
$wgAutoloadClasses[ 'ExactTarget_SystemStatusRequestMsg' ] = $dir . '/lib/ExactTarget_SystemStatusRequestMsg.php';
$wgAutoloadClasses[ 'ExactTarget_SystemStatusResponseMsg' ] = $dir . '/lib/ExactTarget_SystemStatusResponseMsg.php';
$wgAutoloadClasses[ 'ExactTarget_SystemStatusResult' ] = $dir . '/lib/ExactTarget_SystemStatusResult.php';
$wgAutoloadClasses[ 'ExactTarget_SystemStatusType' ] = $dir . '/lib/ExactTarget_SystemStatusType.php';
$wgAutoloadClasses[ 'ExactTarget_TagFilterPart' ] = $dir . '/lib/ExactTarget_TagFilterPart.php';
$wgAutoloadClasses[ 'ExactTarget_Tags' ] = $dir . '/lib/ExactTarget_Tags.php';
$wgAutoloadClasses[ 'ExactTarget_TaskResult' ] = $dir . '/lib/ExactTarget_TaskResult.php';
$wgAutoloadClasses[ 'ExactTarget_TrackingEvent' ] = $dir . '/lib/ExactTarget_TrackingEvent.php';
$wgAutoloadClasses[ 'ExactTarget_TrackingUser' ] = $dir . '/lib/ExactTarget_TrackingUser.php';
$wgAutoloadClasses[ 'ExactTarget_TrackingUsers' ] = $dir . '/lib/ExactTarget_TrackingUsers.php';
$wgAutoloadClasses[ 'ExactTarget_TriggeredSendCreateResult' ] = $dir . '/lib/ExactTarget_TriggeredSendCreateResult.php';
$wgAutoloadClasses[ 'ExactTarget_TriggeredSendDefinition' ] = $dir . '/lib/ExactTarget_TriggeredSendDefinition.php';
$wgAutoloadClasses[ 'ExactTarget_TriggeredSendExclusionList' ] = $dir . '/lib/ExactTarget_TriggeredSendExclusionList.php';
$wgAutoloadClasses[ 'ExactTarget_TriggeredSend' ] = $dir . '/lib/ExactTarget_TriggeredSend.php';
$wgAutoloadClasses[ 'ExactTarget_TriggeredSendStatusEnum' ] = $dir . '/lib/ExactTarget_TriggeredSendStatusEnum.php';
$wgAutoloadClasses[ 'ExactTarget_TriggeredSendSummary' ] = $dir . '/lib/ExactTarget_TriggeredSendSummary.php';
$wgAutoloadClasses[ 'ExactTarget_TriggeredSendTypeEnum' ] = $dir . '/lib/ExactTarget_TriggeredSendTypeEnum.php';
$wgAutoloadClasses[ 'ExactTarget_UnsubEvent' ] = $dir . '/lib/ExactTarget_UnsubEvent.php';
$wgAutoloadClasses[ 'ExactTarget_UpdateOptions' ] = $dir . '/lib/ExactTarget_UpdateOptions.php';
$wgAutoloadClasses[ 'ExactTarget_UpdateRequest' ] = $dir . '/lib/ExactTarget_UpdateRequest.php';
$wgAutoloadClasses[ 'ExactTarget_UpdateResponse' ] = $dir . '/lib/ExactTarget_UpdateResponse.php';
$wgAutoloadClasses[ 'ExactTarget_UpdateResult' ] = $dir . '/lib/ExactTarget_UpdateResult.php';
$wgAutoloadClasses[ 'ExactTarget_UserAccess' ] = $dir . '/lib/ExactTarget_UserAccess.php';
$wgAutoloadClasses[ 'ExactTarget_UserMap' ] = $dir . '/lib/ExactTarget_UserMap.php';
$wgAutoloadClasses[ 'ExactTarget_UsernameAuthentication' ] = $dir . '/lib/ExactTarget_UsernameAuthentication.php';
$wgAutoloadClasses[ 'ExactTarget_ValueErrors' ] = $dir . '/lib/ExactTarget_ValueErrors.php';
$wgAutoloadClasses[ 'ExactTarget_VersionInfoRequestMsg' ] = $dir . '/lib/ExactTarget_VersionInfoRequestMsg.php';
$wgAutoloadClasses[ 'ExactTarget_VersionInfoResponseMsg' ] = $dir . '/lib/ExactTarget_VersionInfoResponseMsg.php';
$wgAutoloadClasses[ 'ExactTarget_VersionInfoResponse' ] = $dir . '/lib/ExactTarget_VersionInfoResponse.php';
$wgAutoloadClasses[ 'ExactTarget_VoiceTriggeredSendDefinition' ] = $dir . '/lib/ExactTarget_VoiceTriggeredSendDefinition.php';
$wgAutoloadClasses[ 'ExactTarget_VoiceTriggeredSend' ] = $dir . '/lib/ExactTarget_VoiceTriggeredSend.php';
$wgAutoloadClasses[ 'ExactTarget_WeeklyRecurrencePatternTypeEnum' ] = $dir . '/lib/ExactTarget_WeeklyRecurrencePatternTypeEnum.php';
$wgAutoloadClasses[ 'ExactTarget_WeeklyRecurrence' ] = $dir . '/lib/ExactTarget_WeeklyRecurrence.php';
$wgAutoloadClasses[ 'ExactTarget_WeekOfMonthEnum' ] = $dir . '/lib/ExactTarget_WeekOfMonthEnum.php';
$wgAutoloadClasses[ 'ExactTarget_YearlyRecurrencePatternTypeEnum' ] = $dir . '/lib/ExactTarget_YearlyRecurrencePatternTypeEnum.php';
$wgAutoloadClasses[ 'ExactTarget_YearlyRecurrence' ] = $dir . '/lib/ExactTarget_YearlyRecurrence.php';

/**
 * Registering hooks
 */
$wgExtensionFunctions[] = 'Wikia\ExactTarget\ExactTargetSetupHooks::setupHooks';
