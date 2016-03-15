<?php

class PortableInfoboxBuilderHelper {
	const QUERYSTRING_EDITOR_KEY = 'useeditor';
	const QUERYSTRING_SOURCE_MODE = 'source';

	/**
	 * Checks if template is classified as an infobox
	 *
	 * @param $title
	 * @return bool
	 */
	public static function isInfoboxTemplate( $title ) {
		$tc = new TemplateClassificationService();
		$isInfobox = false;

		try {
			$type = $tc->getType( F::app()->wg->CityId, $title->getArticleID() );
			$isInfobox = ( $type === TemplateClassificationService::TEMPLATE_INFOBOX );
		} catch ( Swagger\Client\ApiException $e ) {
			// If we cannot reach the service assume the default (false) to avoid overwriting data
		}
		return $isInfobox;
	}

	/**
	 * Checks if request explicitly forces source mode
	 *
	 * @param $request WebRequest
	 * @return bool
	 */
	public static function isForcedSourceMode( $request ) {
		return ( $request->getVal( self::QUERYSTRING_EDITOR_KEY ) === self::QUERYSTRING_SOURCE_MODE );
	}

	/**
	 * remove the special page name from the title and return name of the template
	 * passed after the slash without the namespace, i.e.
	 * Special:InfoboxBuilder/TemplateName/Subpage => TemplateName/Subpage
	 * @param $titleText
	 * @return string
	 */
	public static function getUrlPath( $titleText ) {
		return implode( '/', array_slice( explode( '/', $titleText ), 1 ) );
	}

	/**
	 * Checks whether the template is a valid infobox-builder compliant Infobox template
	 * editable by the given user
	 *
	 * @param $user
	 * @param $title
	 * @return bool
	 */
	public static function canUseInfoboxBuilder( $title, $user ) {
		return PortableInfoboxBuilderHelper::isInfoboxTemplate( $title )
		&& ( new \PortableInfoboxBuilderService() )->isValidInfoboxArray(
			\PortableInfoboxDataService::newFromTitle( $title )->getInfoboxes()
		)
		&& ( new \Wikia\TemplateClassification\Permissions() )->userCanChangeType( $user, $title );
	}
}
