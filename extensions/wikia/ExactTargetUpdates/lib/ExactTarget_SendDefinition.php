<?php
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
