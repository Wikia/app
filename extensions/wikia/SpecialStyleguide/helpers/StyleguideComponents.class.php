<?php

class StyleguideComponents {
	/**
	 * @desc Component's example file suffix
	 *
	 * @var String
	 */
	const EXAMPLE_FILE_SUFFIX = '_example.json';

	/**
	 * @desc Component's documentation file suffix
	 * Example buttons component documentation file should be named buttons_doc.json
	 *
	 * @var String
	 */
	const DOCUMENTATION_FILE_SUFFIX = '_doc.json';

	private $uiFactory;

	public function __construct() {
		$this->uiFactory = Wikia\UI\Factory::getInstance();
	}

	/**
	 * @desc Returns an array with all available components configuration
	 *
	 * @return array
	 */
	public function getAllComponents() {
		$components = WikiaDataAccess::cache(
			wfSharedMemcKey( __CLASS__, 'all_components' ),
			Wikia\UI\Factory::MEMCACHE_EXPIRATION,
			[ $this, 'getAllComponentsFromDirectories' ]
		);

		return $components;
	}

	/**
	 * @desc Returns full documentation file's path
	 *
	 * @param string $name component's name
	 *
	 * @return string full file path
	 */
	public function getComponentDocumentationFileFullPath( $name ) {
		return $this->uiFactory->getComponentsDir() .
		$name .
		DIRECTORY_SEPARATOR .
		$name .
		self::DOCUMENTATION_FILE_SUFFIX;
	}

	private function loadComponentDocumentationAsArray( $componentName ) {
		wfProfileIn( __METHOD__ );

		$docFile = $this->getComponentDocumentationFileFullPath( $componentName );
		$docFileContent = $this->uiFactory->loadFileContent( $docFile );
		$docInArray = $this->uiFactory->loadFromJSON( $docFileContent );

		wfProfileOut( __METHOD__ );
		return $docInArray;
	}

	/**
	 * @desc Returns all components by iterating on components directory
	 *
	 * @return array
	 */
	public function getAllComponentsFromDirectories() {
		$components = [];

		$directory = new DirectoryIterator( $this->uiFactory->getComponentsDir() );
		while( $directory->valid() ) {
			if( !$directory->isDot() && $directory->isDir() ) {
				$filename = $directory->getFilename();

				$componentConfig = $this->uiFactory->loadComponentConfigAsArray( $filename );
				$messages = $this->loadComponentDocumentationAsArray( $filename );
				$componentConfig = $this->prepareMessages( $componentConfig, $messages );
				// add unique id so after clicking on the components list's link page jumps to the right anchor
				$componentConfig['id'] = Sanitizer::escapeId( $filename, ['noninitial'] );

				if ( isset( $componentConfig['templateVars'] ) ) {
					$componentConfig['mustacheVars'] = $this->prepareComponents( $componentConfig['templateVars'], $filename );
				}

				$components[] = $componentConfig;
			}

			$directory->next();
		}

		return $components;
	}

	/**
	 * @desc Returns array to render component information and examples on style guide page
	 *
	 * @param Array $templateVars
	 * @param String $filename
	 * @return Array
	 */
	private function prepareComponents( $templateVars, $filename ) {
		$mustacheVars = [];

		$exampleData = $this->loadExampleFile( $filename );

		foreach ( $templateVars as $name => $var ) {
			$renderedExample = isset( $exampleData[$name] )
								? Wikia\UI\Factory::getInstance()->init( $filename )->render( $exampleData[$name] )
								: null;

			if ( isset( $var['name-var-msg-key'] ) ) {
				$var['name'] = $this->prepareMessage( $var['name-var-msg-key'] );
			}

			$mustacheVars[] = [
				// component's type
				'type' => $name,
				// template variables
				'fields' => $var,
				// rendered example
				'example' => $renderedExample,
			];
		}

		return $mustacheVars;
	}

	/**
	 * @desc Return component with i18n name and description
	 *
	 * @param $component
	 * @return mixed
	 */
	private function prepareMessages( $component, $messages ) {
		$component['name'] = $this->prepareMessage( $messages['name-msg-key'] );
		$component['description'] = $this->prepareMessage( $messages['description-msg-key'] );

		return $component;
	}

	/**
	 * @desc Returns i18n message by key
	 *
	 * @param $key
	 * @return String
	 */
	private function prepareMessage($key) {
		return wfMessage($key)->plain();
	}

	/**
	 * @desc Checks if example file exists and returns array with example attributes or empty array
	 *
	 * @param String $filename example json file name
	 * @return Array
	 */
	private function loadExampleFile($filename) {
		$example = [];

		if ( file_exists($this->getComponentExampleFileFullPath( $filename ))) {
			$example = $this->loadComponentExampleFromFile( $this->getComponentExampleFileFullPath( $filename ) );
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
		$exampleString = file_get_contents( $exampleFilePath );
		if ( false === $exampleString ) {
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
		return $this->uiFactory->getComponentsDir() . $name . DIRECTORY_SEPARATOR . $name . self::EXAMPLE_FILE_SUFFIX;
	}
}
