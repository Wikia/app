<?php

use Swagger\Client\ApiException;

class UserTemplateClassificationService extends TemplateClassificationService {

	const USER_PROVIDER = 'user';
	const CLASSIFY_TEMPLATE_EXCEPTION_MESSAGE = 'Bad request. Wrong template type value.';
	const CLASSIFY_TEMPLATE_EXCEPTION_CODE = 400;

	/**
	 * Allowed types of templates stored in an array to make a validation process easier.
	 *
	 * The order of types in this array determines the order of the types displayed in the
	 * classification dialog.
	 *
	 * @var array
	 */
	static $templateTypes = [
		self::TEMPLATE_INFOBOX,
		self::TEMPLATE_QUOTE,
		self::TEMPLATE_NAVBOX,
		self::TEMPLATE_FLAG,
		self::TEMPLATE_CONTEXT_LINK,
		self::TEMPLATE_REFERENCES,
		self::TEMPLATE_MEDIA,
		self::TEMPLATE_DATA,
		self::TEMPLATE_DESIGN,
		self::TEMPLATE_NAV,
		self::TEMPLATE_NOT_ART,
		self::TEMPLATE_UNKNOWN,
	];

	/**
	 * Types mapped as infobox ones
	 * @var array
	 */
	static $infoboxTypes = [
		self::TEMPLATE_INFOBOX,
		self::TEMPLATE_CUSTOM_INFOBOX,
	];

	/**
	 * Fallback to the Unclassified string if a received type is not supported by
	 * the user-facing tools.
	 *
	 * @param $wikiId
	 * @param $pageId
	 * @return string template type
	 * @throws Exception
	 * @throws \Swagger\Client\ApiException
	 */
	public function getType( $wikiId, $pageId ) {
		return $this->mapType( parent::getType( $wikiId, $pageId ) );
	}

	/**
	 * Check if a given type is mapped as an infobox one.
	 * @param string $type
	 * @return bool
	 */
	public function isInfoboxType( $type ) {
		return in_array( $type, self::$infoboxTypes );
	}

	protected function prepareTypes( $types ) {
		$templateTypes = [];

		foreach ( $types as $type ) {
			$templateTypes[$type->getPageId()] = $this->mapType( $type->getType() );
		}

		return $templateTypes;
	}

	private function mapType( $type ) {
		if ( $this->isInfoboxType( $type ) ) {
			return self::TEMPLATE_INFOBOX;
		}

		if ( !in_array( $type, self::$templateTypes ) ) {
			return self::TEMPLATE_UNCLASSIFIED;
		}

		return $type;
	}

	/**
	 * Verify template type before user classification
	 *
	 * @param int $wikiId
	 * @param int $pageId
	 * @param string $templateType
	 * @param string $origin
	 * @throws BadRequestApiException
	 */
	public function classifyTemplate( $wikiId, $pageId, $templateType, $origin ) {
		if ( !in_array( $templateType, self::$templateTypes ) ) {
			throw new ApiException( self::CLASSIFY_TEMPLATE_EXCEPTION_MESSAGE, self::CLASSIFY_TEMPLATE_EXCEPTION_CODE );
		}

		parent::classifyTemplate( $wikiId, $pageId, $templateType, self::USER_PROVIDER, $origin );

		wfRunHooks( 'UserTemplateClassification::TemplateClassified', [ $wikiId, $pageId, $templateType ] );
	}
}
