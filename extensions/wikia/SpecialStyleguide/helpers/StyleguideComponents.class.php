<?php

class StyleguideComponents {
	/**
	 * @desc Component's example file suffix
	 * Example: button component example file should be named button_example.json
	 *
	 * @var String
	 */
	const EXAMPLE_FILE_SUFFIX = '_example.json';

	/**
	 * @desc Component's documentation file suffix
	 * Example: button component documentation file should be named button_doc.json
	 *
	 * @var String
	 */
	const DOCUMENTATION_FILE_SUFFIX = '_doc.json';

	/**
	 * @desc Component's messages/i18n file suffix
	 * Example: button i18n file should be named button.i18n.php
	 *
	 * @var String
	 */
	const MESSAGES_FILE_SUFFIX = 'i18n.php';

	/**
	 * @var Array|null
	 */
	private $componentsNames = null;

	/**
	 * @var Wikia\UI\Factory
	 */
	private $uiFactory;

	public function __construct() {
		$this->uiFactory = Wikia\UI\Factory::getInstance();

		$this->componentsNames = WikiaDataAccess::cache(
			wfSharedMemcKey( __CLASS__, 'components_names_list' ),
			\Wikia\UI\Factory::MEMCACHE_EXPIRATION,
			[$this, 'loadComponentsFromFileSystem']
		);
	}

	/**
	 * @desc Returns an array with all available components configuration
	 *
	 * @return array
	 */
	public function getAllComponents() {
		$components = WikiaDataAccess::cache(
			wfSharedMemcKey( __CLASS__, 'all_components_list_with_details' ),
			Wikia\UI\Factory::MEMCACHE_EXPIRATION,
			[ $this, 'getAllComponentsFromDirectories' ]
		);

		return $components;
	}

	/**
	 * @desc Iterates the components directory and returns list of it subdirectories
	 *
	 * @return array
	 */
	public function loadComponentsFromFileSystem() {
		$componentsNames = [];
		$directory = new DirectoryIterator( $this->uiFactory->getComponentsDir() );

		while( $directory->valid() ) {
			if( !$directory->isDot() && $directory->isDir() ) {
				$componentName = $directory->getFilename();
				$componentsNames[] = $componentName;
			}

			$directory->next();
		}

		return $componentsNames;
	}

	/**
	 * @desc Returns path to example json file
	 *
	 * @param String $name
	 * @return string
	 */
	private function getComponentExampleFileFullPath( $name ) {
		return $this->uiFactory->getComponentsDir() .
		$name .
		DIRECTORY_SEPARATOR .
		$name .
		self::EXAMPLE_FILE_SUFFIX;
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

	/**
	 * @desc
	 *
	 * @param String $componentName
	 * @return Array
	 */
	private function loadComponentDocumentationAsArray( $componentName ) {
		wfProfileIn( __METHOD__ );

		$docFile = $this->getComponentDocumentationFileFullPath( $componentName );
		$docFileContent = $this->uiFactory->loadFileContent( $docFile );
		$docInArray = $this->uiFactory->loadFromJSON( $docFileContent );

		wfProfileOut( __METHOD__ );
		return $docInArray;
	}

	/**
	 * @desc
	 *
	 * @param String $componentName
	 * @return Array
	 */
	private function loadExampleFileAsArray( $componentName ) {
		wfProfileIn( __METHOD__ );

		$exampleFile = $this->getComponentExampleFileFullPath( $componentName );
		$exampleFileContent = $this->uiFactory->loadFileContent( $exampleFile );
		$exampleInArray = $this->uiFactory->loadFromJSON( $exampleFileContent );

		wfProfileOut( __METHOD__ );
		return $exampleInArray;
	}

	/**
	 * @desc Returns full documentation file's path
	 *
	 * @param string $name component's name
	 *
	 * @return string full file path
	 */
	public function getComponentMessagesFileFullPath( $name ) {
		return $this->uiFactory->getComponentsDir() .
		$name .
		DIRECTORY_SEPARATOR .
		$name .
		self::MESSAGES_FILE_SUFFIX;
	}

	/**
	 * @desc Returns all components by iterating on components directory
	 *
	 * @return array
	 */
	public function getAllComponentsFromDirectories() {
		$components = [];

		foreach( $this->componentsNames as $componentName ) {
			$componentConfig = $this->uiFactory->loadComponentConfigAsArray( $componentName );
			$componentDocumentation = $this->loadComponentDocumentationAsArray( $componentName );
			$componentConfig = $this->prepareMessages( $componentConfig, $componentDocumentation );
			// add unique id so after clicking on the components list's link page jumps to the right anchor
			$componentConfig['id'] = Sanitizer::escapeId( $componentName, ['noninitial'] );

			if ( isset( $componentConfig['templateVars'] ) ) {
				$componentConfig['mustacheVars'] = $this->prepareComponents( $componentConfig['templateVars'], $componentName );
			}

			$components[] = $componentConfig;
		}

		return $components;
	}

	/**
	 * @desc Returns array to render component information and examples on style guide page
	 *
	 * @param Array $templateVars
	 * @param String $componentName
	 * @return Array
	 */
	private function prepareComponents( $templateVars, $componentName ) {
		$mustacheVars = [];

		$exampleData = $this->loadExampleFileAsArray( $componentName );

		foreach ( $templateVars as $name => $var ) {
			/** @var \Wikia\UI\Component $component */
			$component = Wikia\UI\Factory::getInstance()->init( $componentName );
			$renderedExample = isset( $exampleData[$name] )
								? $component->render( $exampleData[$name] )
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
	 * @param Array $component
	 * @param Array $messages
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
}
