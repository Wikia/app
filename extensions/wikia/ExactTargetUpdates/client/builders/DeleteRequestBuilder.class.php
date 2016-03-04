<?php
namespace Wikia\ExactTarget\Builders;

use Wikia\ExactTarget\ResourceEnum as Enum;

class DeleteRequestBuilder extends BaseRequestBuilder {
	protected $wikiId;

	private static $supportedTypes = [
		self::GROUP_TYPE,
		self::USER_TYPE,
		self::SUBSCRIBER_TYPE,
		self::PROPERTIES_TYPE,
		self::WIKI_TYPE,
		self::WIKI_CAT_TYPE
	];

	public function withWikiId( $wikiId ) {
		$this->wikiId = $wikiId;
		return $this;
	}

	public function build() {
		$soapType = self::DATA_EXTENSION_OBJECT_TYPE;

		switch ( $this->type ) {
			case self::GROUP_TYPE:
				$objects = [ $this->prepareDataObject( Enum::CUSTOMER_KEY_USER_GROUPS,
					[ Enum::USER_GROUP_USER => $this->userId, Enum::USER_GROUP_GROUP => $this->group ] ) ];
				break;
			case self::SUBSCRIBER_TYPE:
				$objects = [ $this->prepareSubscriber( $this->email ) ];
				$soapType = self::SUBSCRIBER_OBJECT_TYPE;
				break;
			case self::USER_TYPE:
				$objects = [ $this->prepareDataObject( Enum::CUSTOMER_KEY_USER, [ Enum::USER_ID => $this->userId ] ) ];
				break;
			case self::PROPERTIES_TYPE:
				$objects = [ ];
				foreach ( $this->properties as $property ) {
					$objects[ ] = $this->prepareDataObject( Enum::CUSTOMER_KEY_USER_PROPERTIES,
						[ Enum::USER_PROPERTIES_USER => $this->userId, Enum::USER_PROPERTIES_PROPERTY => $property ] );
				}
				break;
			case self::WIKI_TYPE:
				$objects = [ $this->prepareDataObject( Enum::CUSTOMER_KEY_WIKI_LIST,
					[ Enum::WIKI_ID => $this->wikiId ] ) ];
				break;
			case self::WIKI_CAT_TYPE:
				$objects = [ ];
				foreach ( $this->wikiCategories as $category ) {
					$wikiId = $category[ Enum::WIKI_ID ];
					$categoryId = $category[ Enum::WIKI_CAT_ID ];
					$objects[ ] = $this->prepareDataObject( Enum::CUSTOMER_KEY_WIKI_CAT_MAPPING,
						[ Enum::WIKI_ID => $wikiId, Enum::WIKI_CAT_ID => $categoryId ] );
				}
				break;
		}
		$aSoapVars = $this->prepareSoapVars( $objects, $soapType );

		$oDeleteRequest = new \ExactTarget_DeleteRequest();
		$oDeleteRequest->Objects = $aSoapVars;
		$oDeleteRequest->Options = new \ExactTarget_DeleteOptions();

		return $oDeleteRequest;
	}

	protected function getSupportedTypes() {
		return self::$supportedTypes;
	}
}
