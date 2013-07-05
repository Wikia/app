<?php

class UIStyleguideComponents
{
	/**
	 * @desc Component's example file suffix
	 *
	 * @var String
	 */
	const EXAMPLE_FILE_SUFFIX = '_example.json';

	private $uiFactory;

	public function __construct() {
		$this->uiFactory = new UIFactory();
	}

	/**
	 * @desc Returns an array with all available components configuration
	 *
	 * @return array
	 */
	public function getAllComponents() {
		global $wgMemc;

		$memcKey = wfMemcKey( __CLASS__, 'all_components' );
		$wgMemc->get( $memcKey );
		if ( !empty($data) ) {
			return $data;
		} else {
			$components = [];
			$k = 0;
			$directory = new DirectoryIterator( $this->uiFactory->getComponentsDir() );
			while( $directory->valid() ) {
				if( !$directory->isDot() && $directory->isDir() ) {
					$filename = $directory->getFilename();
					$components[$k] = $this->uiFactory->loadComponentConfigFromFile( $this->uiFactory->getComponentConfigFileFullPath( $filename ) );
					if ( isset($components[$k]['templateVars']) ) {
						$components[$k]['mustacheVars'] = $this->prepareComponents($components[$k]['templateVars'], $filename);
					}
					$k++;
				}
				$directory->next();
			}

			$wgMemc->set( $memcKey, $components, UIFactory::MEMCACHE_EXPIRATION );

			return $components;
		}
	}

	/**
	 * @desc Returns array to render component information and examples on style guide page
	 *
	 * @param Array $templateVars
	 * @param String $filename
	 * @return Array
	 */
	private function prepareComponents($templateVars, $filename) {
		$mustacheVars = [];

		$example = $this->loadExampleFile($filename);

		foreach ( $templateVars as $name => $var ) {
			$renderedExample = isset($example[$name]) ? UIFactory::getInstance()->init($filename)->render($example[$name]) : '';
			$mustacheVars[] = [
				'type' => $name,
				'fields' => $var,
				'example' => $renderedExample
			];
		}

		return $mustacheVars;
	}

	/**
	 * @desc Checks if example file exists and returns array with example attributes or empty array
	 *
	 * @param $filename example json file name
	 * @return Array
	 */
	private function loadExampleFile($filename) {
		$example = [];
		if ( file_exists($this->getComponentExampleFileFullPath( $filename ))) {
			$example = $this->loadComponentExampleFromFile($this->getComponentExampleFileFullPath( $filename ));
		}
		return $example;
	}

	/**
	 * @desc Returns decoded json file with components examples values
	 *
	 * @param String $exampleFilePath path to example json file
	 * @return Array
	 */
	private function loadComponentExampleFromFile( $exampleFilePath ) {
		if ( false === $exampleString = file_get_contents( $exampleFilePath ) ) {
			return false;
		} else {
			return json_decode( $exampleString, true );
		}
	}

	/**
	 * @desc Returns path to example json file
	 *
	 * @param String $name
	 * @return string
	 */
	private function getComponentExampleFileFullPath( $name ) {
		return $this->uiFactory->getComponentsDir() . $name . '/' . $name . self::EXAMPLE_FILE_SUFFIX;
	}
}
