<?php
namespace Wikia\ExactTarget\Builders;

use Wikia\Util\Assert;
use Wikia\ExactTarget\ResourceEnum as Enum;

class UpdateRequestBuilder extends BaseRequestBuilder {
	const SAVE_OPTION_TYPE = 'SaveOption';

	private $userData;
	private $edits;
	private $wikiData;

	private static $supportedTypes = [
		self::PROPERTIES_TYPE,
		self::EDITS_TYPE,
		self::USER_TYPE,
		self::WIKI_TYPE,
		self::WIKI_CAT_TYPE
	];

	public function withWikiData( $wikiId, array $wikiData ) {
		$this->wikiData = $wikiData;
		$this->wikiId = $wikiId;
		return $this;
	}

	public function withUserData( array $userData ) {
		$this->userData = $userData;
		return $this;
	}

	public function withEdits( $edits ) {
		$this->edits = $edits;
		return $this;
	}

	public function build() {
		$oRequest = new \ExactTarget_UpdateRequest();
		$oRequest->Options = $this->prepareUpdateCreateOptions();

		// prepare exact target structure
		switch ( $this->type ) {
			case self::PROPERTIES_TYPE:
				$objects = $this->prepareUserPreferencesParams( $this->userId, $this->properties );
				break;
			case self::USER_TYPE:
				$objects = $this->prepareUsersUpdateParams( $this->userData );
				break;
			case self::EDITS_TYPE:
				$objects = $this->prepareUserEditsParams( $this->edits );
				break;
			case self::WIKI_TYPE:
				$objects = $this->prepareWikiParams( $this->wikiData );
				break;
			case self::WIKI_CAT_TYPE:
				$objects = $this->prepareWikiCategoriesMapping();
				break;
		}
		// make it soap vars
		$oRequest->Objects = $this->prepareSoapVars( $objects, self::DATA_EXTENSION_OBJECT_TYPE );

		return $oRequest;
	}

	protected function getSupportedTypes() {
		return self::$supportedTypes;
	}

	private function prepareUserPreferencesParams( $id, $properties ) {
		Assert::true( isset( $this->userId ) );
		$objects = [ ];
		foreach ( $properties as $sProperty => $sValue ) {
			$objects[] = $this->prepareDataObject( Enum::CUSTOMER_KEY_USER_PROPERTIES,
				[ Enum::USER_PROPERTIES_USER => $id, Enum::USER_PROPERTIES_PROPERTY => $sProperty ],
				[ Enum::USER_PROPERTIES_VALUE => $sValue ]
			);
		}
		return $objects;
	}

	private function prepareUsersUpdateParams( array $usersData ) {
		$aDataExtension = [ ];
		foreach ( $usersData as $aUserData ) {
			$userId = $aUserData[ Enum::USER_ID ];
			// remove userId as its handled differently
			unset( $aUserData[ Enum::USER_ID ] );
			Assert::true( !empty( $userId ) );

			$aDataExtension[] = $this->prepareDataObject( Enum::CUSTOMER_KEY_USER,
				[ Enum::USER_ID => $userId ], $aUserData );
		}
		return $aDataExtension;
	}

	private function prepareUpdateCreateOptions() {
		$updateOptions = new \ExactTarget_UpdateOptions();

		$saveOption = new \ExactTarget_SaveOption();
		$saveOption->PropertyName = self::DATA_EXTENSION_OBJECT_TYPE;
		$saveOption->SaveAction = \ExactTarget_SaveAction::UpdateAdd;

		$updateOptions->SaveOptions = [ $this->wrapToSoapVar( $saveOption, self::SAVE_OPTION_TYPE ) ];
		return $updateOptions;
	}

	private function prepareUserEditsParams( $edits ) {
		$result = [ ];
		foreach ( $edits as $userId => $contributions ) {
			foreach ( $contributions as $wikiId => $number ) {
				$result[] = $this->prepareDataObject( Enum::CUSTOMER_KEY_USER_ID_WIKI_ID,
					[ Enum::USER_ID => $userId, Enum::USER_WIKI_ID => $wikiId ],
					[ Enum::USER_WIKI_FIELD_CONTRIBUTIONS => $number ]
				);
			}
		}

		return $result;
	}

	private function prepareWikiParams( $wikiData ) {
		return [ $this->prepareDataObject( Enum::CUSTOMER_KEY_WIKI_LIST,
			[ Enum::WIKI_ID => $this->wikiId ], $wikiData ) ];
	}

	private function prepareWikiCategoriesMapping() {
		$objects = [ ];
		foreach ($this->wikiCategories as $category ) {
			$objects[] = $this->prepareDataObject( Enum::CUSTOMER_KEY_WIKI_CAT_MAPPING,
				[ ], [ Enum::WIKI_ID => $category[ 'city_id' ], Enum::WIKI_CAT_ID => $category[ 'cat_id' ] ] );
		}

		return $objects;
	}

}
