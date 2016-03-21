<?php

class PortableInfoboxBuilderHelper {
	const QUERYSTRING_EDITOR_KEY = 'useeditor';
	const QUERYSTRING_SOURCE_MODE = 'source';
	const QUERYSTRING_ACTION_KEY = 'action';
	const QUERYSTRING_SUBMIT_ACTION = 'submit';

	/**
	 * Checks if template is classified as an infobox
	 *
	 * @param $title Title
	 * @return bool
	 */
	public static function isInfoboxTemplate( $title ) {
		if ( $title->getNamespace() === NS_TEMPLATE ) {
			return self::isTemplateClassifiedAsInfobox( $title );
		} else {
			return false;
		}
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


	/**
	 * Checks if request is a submit action
	 *
	 * @param $request WebRequest
	 * @return bool
	 */
	public static function isSubmitAction( $request ) {
		return ( $request->getVal( self::QUERYSTRING_ACTION_KEY ) === self::QUERYSTRING_SUBMIT_ACTION );
	}

	/**
	 * @param $title
	 * @return bool
	 */
	private static function isTemplateClassifiedAsInfobox( $title ) {
		try {
			$tc = new TemplateClassificationService();
			$type = $tc->getType( F::app()->wg->CityId, $title->getArticleID() );
			return ( $type === TemplateClassificationService::TEMPLATE_INFOBOX );
		} catch ( Swagger\Client\ApiException $e ) {
			// If we cannot reach the service assume the default (false) to avoid overwriting data
			return false;
		}
	}
}
