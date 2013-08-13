<?php

namespace Wikia\UI;

/**
 * Wikia\UI\UIFactoryController contains entry point for UI Styleguide ajax calls
 *
 * @author mech <mech@wikia-inc.com>
 */


class UIFactoryController extends \WikiaController {

	/**
	 * Return configuration of UI Styleguide components
	 *
	 * @param components Array list of component names
	 */
	public function getComponentsConfig() {
		$this->setVal( 'status', 1);
		//$this->setVal('errorMessage', 'xxx'); // @todo - error support
		$componentNames = $this->request->getArray( 'components', [] );
		$factory = Factory::getInstance();
		$result = [];
		$components = $factory->init( $componentNames );
		if ( !is_array( $components ) ) {
			$components = array( $components );
		}
		foreach( $components as $component ) {
			$cResult = [];

			$cResult['templateVarsConfig'] = $component->getTemplateVarsConfig();
			$cResult['templates'] = array();
			foreach($cResult['templateVarsConfig'] as $subtype => $foo) {
				$cResult['templates'][ $subtype ] = $factory->loadComponentTemplateContent( $component, $subtype );
			}
			$cResult[ 'assets' ] = $factory->getComponentAssetsUrls( $component );
			$result[] = $cResult;
		}
		$this->setVal( 'components', $result );
	}

}