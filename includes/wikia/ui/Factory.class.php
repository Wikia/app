<?php
namespace Wikia\UI;

/**
 * Wikia\UI\Factory handles building component which means loading
 * assets and component configuration file
 *
 * @author Andrzej Łukaszewski <nandy@wikia-inc.com>
 * @author Bartosz Bentkowski <bartosz.bentkowski@wikia-inc.com>
 */
class Factory {

	/**
	 * @desc Component's configuration file suffix
	 * Example buttons component config file should be named buttons_config.json
	 *
	 * @var String
	 */
	const CONFIG_FILE_SUFFIX = '_config.json';

	/**
	 * @desc Component's directory path from docroot
	 */
	const DEFAULT_COMPONENTS_PATH = "/resources/wikia/ui_components/";

	/**
	 * @desc Component's template directory's name
	 */
	const TEMPLATES_DIR_NAME = 'templates';

	/**
	 * @desc How long are components memcached? Both specific and all (different memc keys)
	 */
	const MEMCACHE_EXPIRATION = 900; // 15 minutes

	/**
	 * @desc Version passed to memcache key
	 */
	const MEMCACHE_VERSION = '1.0';
	
	/**
	 * @var \Wikia\UI\Factory
	 */
	private static $instance = null;

	/**
	 * @desc AssetsManager/ResourceLoader
	 * @var $loaderService
	 */
	private $loaderService;

	/**
	 * @desc Path to components directory
	 * @var String|null
	 */
	private $componentsDir = null;

	/**
	 * @desc Private constructor because it's a singleton
	 */
	private function __construct() {
		global $IP;
		$this->componentsDir = $IP . self::DEFAULT_COMPONENTS_PATH;
		$this->loaderService = \AssetsManager::getInstance();
	}

	/**
	 * @desc Sets the path to components' directory
	 *
	 * @param String $path
	 */
	public function setComponentsDir( $path ) {
		$this->componentsDir = $path;
	}

	/**
	 * @desc Returns the path to component's directory
	 *
	 * @return null|String
	 */
	public function getComponentsDir() {
		return $this->componentsDir;
	}

	/**
	 * @desc Returns the only instnace of the class; singleton
	 *
	 * @return \Wikia\UI\Factory
	 */
	static public function getInstance() {
		if( is_null(static::$instance) ) {
			static::$instance = new self();
		}
		
		return static::$instance;
	}

	/**
	 * @desc Returns full config file's path
	 *
	 * @param string $name component's name
	 *
	 * @return string full file path
	 */
	public function getComponentConfigFileFullPath( $name ) {
		return $this->getComponentsDir() .
			$name .
			DIRECTORY_SEPARATOR .
			$name .
			self::CONFIG_FILE_SUFFIX;
	}

	/**
	 * @desc Checks if config file exists, if true: loads the configuration from file and returns as array
	 *
	 * @param string $configFilePath Path to file
	 *
	 * @return Array
	 * @throws \Exception
	 */
	private function loadComponentConfigFromFile( $configFilePath ) {
		if ( false === $configString = file_get_contents( $configFilePath ) ) {
			throw new \Exception( 'Component\'s config file not found.' );
		} else {
			return $configString;
		}
	}

	/**
	 * @desc Loads component's config from JSON file content, adds component's unique id
	 *
	 * @param string $configContent JSON String
	 *
	 * @see Wikia\UI\Factory::loadComponentConfigFromFile() for example usage
	 * @return Array
	 * @throws \Exception
	 */
	private function loadComponentConfigFromJSON( $configContent ) {
		wfProfileIn( __METHOD__ );

		$config = json_decode( $configContent, true );

		if ( !is_null( $config ) ) {
			wfProfileOut( __METHOD__ );
			return $config;
		} else {
			wfProfileOut( __METHOD__ );
			throw new \Exception( 'Invalid JSON.' );
		}
	}

	public function loadComponentConfigAsArray( $componentName ) {
		$configFile = $this->getComponentConfigFileFullPath( $componentName );
		$configFileContent = $this->loadComponentConfigFromFile( $configFile );
		$configInArray = $this->loadComponentConfigFromJSON( $configFileContent );

		return $configInArray;
	}

	/**
	 * @desc Gets configuration file contents, decodes it to array and returns it; uses caching layer
	 * 
	 * @param String $componentName
	 * @return string
	 */
	protected function loadComponentConfig( $componentName ) {
		wfProfileIn( __METHOD__ );

		$app = \F::app();
		$wgMemc = $app->wg->Memc;
		$memcKey = wfMemcKey( __CLASS__, 'component', $componentName, static::MEMCACHE_VERSION );

		$data = \WikiaDataAccess::cache(
			$memcKey,
			self::MEMCACHE_EXPIRATION,
			function() use ($componentName, $wgMemc, $memcKey) {
				wfProfileIn( __METHOD__ );
				$configInArray = $this->loadComponentConfigAsArray( $componentName );

				wfProfileOut( __METHOD__ );
				return $configInArray;
			}
		);

		wfProfileOut( __METHOD__ );
		return $data;
	}

	/**
	 * @desc Adds asset to load
	 *
	 * @param $assetName
	 */
	private function addAsset( $assetName ) {
		wfProfileIn( __METHOD__ );

		\Wikia::addAssetsToOutput( $assetName );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * @desc It uses MW Sanitizer to remove unwanted characters, builds
	 * and returns the base path to a component's templates directory
	 *
	 * @param String $name component's name
	 * @return string
	 */
	public function getComponentsBaseTemplatePath( $name ) {
		$name = \Sanitizer::escapeId( $name, 'noninitial' );
		return $this->getComponentsDir() .
			$name .
			DIRECTORY_SEPARATOR .
			self::TEMPLATES_DIR_NAME .
			DIRECTORY_SEPARATOR .
			$name;
	}

	/**
	 * @desc Loads JS/CSS dependencies, creates and configurates an instance of \Wikia\UI\Component object which is returned
	 *
	 * @param string|array $componentNames
	 *
	 * @throws \Wikia\UI\DataException
	 * @return array
	 */
	public function init( $componentNames ) {
		if ( !is_array($componentNames ) ) {
			$componentNames = (array)$componentNames;
		}
		
		$components = [];
		$assets = [];

		// iterate $componentNames, read configs, write down dependencies
		foreach ( $componentNames as $name ) {
			$componentConfig = $this->loadComponentConfig( $name );

			// if there are some components, put them in the $assets
			$assetsTypes = [ 'js', 'css' ];
			foreach( $assetsTypes as $assetType ) {
				$dependenciesCfg = !empty( $componentConfig['dependencies'][$assetType] ) ? $componentConfig['dependencies'][$assetType] : [];
				if( is_array( $dependenciesCfg ) ) {
					$assets = array_merge( $assets, $dependenciesCfg );
				} else {
					$exceptionMessage = sprintf( DataException::EXCEPTION_MSG_INVALID_ASSETS_TYPE, $assetType );
					throw new DataException( $exceptionMessage );
				}
			}

			// init component, put config inside and set base template path
			$component = $this->getComponentInstance();
			if ( !empty($componentConfig['templateVars']) ) {
				$component->setTemplateVarsConfig( $componentConfig['templateVars'] );
			}
			$component->setBaseTemplatePath( $this->getComponentsBaseTemplatePath( $name ) );

			$components[] = $component;
		}

		// add merged assets
		foreach ( array_unique( $assets ) as $asset ) {
			$this->addAsset( $asset );
		}

		// return components
		return (sizeof($components) == 1) ? $components[0] : $components;
	}

	/**
	 * @return Component
	 */
	protected function getComponentInstance() {
		return new Component;
	}

	/**
	 * @throws \Exception
	 */
	public function __clone() {
		throw new \Exception( 'Cloning instances of this class is forbidden.' );
	}

	/**
	 * @throws \Exception
	 */
	public function __wakeup() {
		throw new \Exception( 'Unserializing instances of this class is forbidden.' );
	}
}

