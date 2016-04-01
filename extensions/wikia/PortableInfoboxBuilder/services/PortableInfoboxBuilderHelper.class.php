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
		return $title->inNamespace( NS_TEMPLATE ) && self::isTemplateClassifiedAsInfobox( $title );
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
	 * @param \User $user
	 * @param \Title $title
	 * @return bool
	 */
	public static function canUseInfoboxBuilder( $title, $user ) {
		$infoboxes = \PortableInfoboxDataService::newFromTitle( $title )->getInfoboxes();

		return PortableInfoboxBuilderHelper::isInfoboxTemplate( $title )
			   && ( $title->isKnown() && !empty( $infoboxes ) )
			   && ( new \PortableInfoboxBuilderService() )->isValidInfoboxArray( $infoboxes )
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
	 * For given title string create urls to template page and source editor
	 * @param $titleString string
	 * @return array with key value url pairs or empty array
	 * if invalid string passed
	 */
	public static function createRedirectUrls( $titleString ) {
		$status = new Status();
		$title = self::getTitle( $titleString, $status );

		if ( $status->isGood() ) {
			return [
				'templatePageUrl' => $title->getFullUrl(),
				'sourceEditorUrl' => $title->getFullUrl( [
					'action' => 'edit',
					'useeditor' => 'source'
				] )
			];
		}

		return [ ];
	}


	/**
	 * creates Title object from provided title string.
	 * If Title object can not be created then status is updated
	 * @param $titleParam
	 * @param $status
	 * @return Title or false if invalid data passed
	 * @throws MWException
	 */
	public static function getTitle( $titleParam, &$status ) {
		if ( !$titleParam ) {
			$status->fatal( 'no-title-provided' );
		}

		$title = $status->isGood() ? Title::newFromText( $titleParam, NS_TEMPLATE ) : false;
		// check if title object created
		if ( $status->isGood() && !$title ) {
			$status->fatal( 'bad-title' );
		}

		return $title;
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
