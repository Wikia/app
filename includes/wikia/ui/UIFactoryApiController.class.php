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
	 * Prepare JSON description of the UI Styleguide component
	 *
	 * @param \Wikia\UI\Component $component
	 * @param \Wikia\UI\Factory $factory
	 * @return dictionary describing the component
	 */
	private function getComponentConfig( $component, $factory ) {
		$componentResult = [];

		$componentResult[ 'templateVarsConfig' ] = $component->getTemplateVarsConfig();
		$componentResult[ 'templates' ] = [];
		$componentResult[ 'name' ] = $component->getName();
		$componentResult[ 'dependencies' ] = $component->getComponentDependencies();
		foreach( array_keys( $componentResult[ 'templateVarsConfig' ] ) as $type ) {
			$componentResult[ 'templates' ][ $type ] = $factory->loadComponentTemplateContent( $component, $type );
		}
		$componentResult[ 'assets' ] = $factory->getComponentAssetsUrls( $component );
		$jsModule = $component->getJSWrapperModule();
		if ( !empty( $jsModule ) ) {
			$componentResult[ 'jsWrapperModule' ] = $jsModule;
		}
		return $componentResult;
	}

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
		$dependencies = [];
		try {
			$components = $factory->init( $componentNames, false, $dependencies );
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
			$result[] = $this->getComponentConfig( $component, $factory );
		}
		$this->setVal( 'components', $result );

		// add the dependencies to the response
		$result = [];
		foreach( $dependencies as $component ) {
			// @todo - do we want to include in the dependencies the components that are already returned in the 'components' array?
			/** @var $component \Wikia\UI\Component */
			$result[ $component->getName() ] = $this->getComponentConfig( $component, $factory );
		}
		$this->setVal( 'dependencies', $result );

		// set response caching
		$this->response->setCacheValidity(self::CLIENT_CACHE_VALIDITY);

		wfProfileOut( __METHOD__ );
	}

}
