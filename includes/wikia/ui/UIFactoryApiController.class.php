<?php

namespace Wikia\UI;

/**
 * Wikia\UI\UIFactoryController contains entry point for UI Styleguide ajax calls
 *
 * @author mech <mech@wikia-inc.com>
 */


class UIFactoryApiController extends \WikiaApiController {

	/**
	 * @desc how long the response should be cached in varnish/browser
	 */
	const CLIENT_CACHE_VALIDITY = 86400; //24*60*60 = 24h

	/**
	 * @desc Name of the request parameter containing an array of component names
	 */
	const PARAMETER_COMPONENTS = 'components';

	/**
	 * Return configuration of UI Styleguide components
	 *
	 * @requestParam Array  $components list of component names
	 */
	public function getComponentsConfig() {
		wfProfileIn( __METHOD__ );

		$componentNames = $this->request->getArray( self::PARAMETER_COMPONENTS, [] );
		if ( empty( $componentNames ) || ( $componentNames == [ "" ] ) ) {
			wfProfileOut( __METHOD__ );
			throw new \MissingParameterApiException( self::PARAMETER_COMPONENTS );
		}


		// create the Component instances for names specified in request parameter
		$factory = Factory::getInstance();
		try {
			$components = $factory->init( $componentNames, false );
			if ( !is_array( $components ) ) {
				$components = [ $components ];
			}
		} catch( \Exception $e ) {
			wfProfileOut( __METHOD__ );
			throw new \NotFoundApiException( $e->getMessage() );
		}

		// build the response
		$result = [];
		foreach( $components as $component ) {
			$componentResult = [];

			$componentResult[ 'templateVarsConfig' ] = $component->getTemplateVarsConfig();
			$componentResult[ 'templates' ] = [];
			foreach( array_keys( $componentResult[ 'templateVarsConfig' ] ) as $type ) {
				$componentResult[ 'templates' ][ $type ] = $factory->loadComponentTemplateContent( $component, $type );
			}
			$componentResult[ 'assets' ] = $factory->getComponentAssetsUrls( $component );
			$result[] = $componentResult;
		}
		$this->setVal( 'components', $result );

		// set response caching
		$this->response->setCacheValidity(
			self::CLIENT_CACHE_VALIDITY,
			self::CLIENT_CACHE_VALIDITY,
			array(
				\WikiaResponse::CACHE_TARGET_BROWSER,
				\WikiaResponse::CACHE_TARGET_VARNISH
			)
		);

		wfProfileOut( __METHOD__ );
	}

}
