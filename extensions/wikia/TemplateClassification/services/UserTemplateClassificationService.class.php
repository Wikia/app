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
		$templateType = parent::getType( $wikiId, $pageId );

		if ( !in_array( $templateType, self::$templateTypes ) ) {
			$templateType = self::TEMPLATE_UNCLASSIFIED;
		}

		return $templateType;
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
