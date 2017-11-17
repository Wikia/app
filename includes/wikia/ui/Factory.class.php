<?php
namespace Wikia\UI;

/**
 * Wikia\UI\Factory handles building component which means loading
 * assets and component configuration file
 *
 * @author Andrzej Łukaszewski <nandy@wikia-inc.com>
 * @author Bartosz Bentkowski <bartosz.bentkowski@wikia-inc.com>
 * @author mech <mech@wikia-inc.com>
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
	 * @desc css asset type
	 */
	const ASSET_TYPE_CSS = 'css';

	/**
	 * @desc js asset type
	 */
	const ASSET_TYPE_JS = 'js';

	/**
	 * @desc key in dependencies config indicating dependency on another component
	 */
	const COMPONENT_DEPENDENCY = 'components';

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
	 * @desc Private constructor because it's a singleton
	 */
	private function __construct() {
		$this->loaderService = \AssetsManager::getInstance();
	}

	/**
	 * @desc Returns the path to component's directory
	 *
	 * @return null|String
	 */
	public static function getComponentsDir() {
		global $IP;
		return $IP . self::DEFAULT_COMPONENTS_PATH;
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
		return static::getComponentsDir() .
			$name .
			DIRECTORY_SEPARATOR .
			$name .
			self::CONFIG_FILE_SUFFIX;
	}

	/**
	 * @desc Checks if a file exists, if true: loads its content and returns it
	 *
	 * @param string $path Path to file
	 *
	 * @return Array
	 * @throws \Exception
	 */
	public function loadFileContent( $path ) {
		if ( !is_readable( $path ) ) {
			throw new \Exception( 'Cannot read file (' . $path . ').' );
		}
		if ( false === $fileContent = file_get_contents( $path ) ) {
			throw new \Exception( 'Unexpected error while reading file (' . $path . ').' );
		} else {
			return $fileContent;
		}
	}

	/**
	 * @desc Loads data from JSON file content and returns in an array
	 *
	 * @param string $inputString JSON String
	 *
	 * @see Wikia\UI\Factory::loadComponentConfigFromFile() for example usage
	 * @see
	 *
	 * @return Array
	 * @throws \Exception
	 */
	public function loadFromJSON( $inputString ) {
		$outputJson = json_decode( $inputString, true );

		if ( !is_null( $outputJson ) ) {
			return $outputJson;
		} else {
			throw new \Exception( 'Invalid JSON.' );
		}
	}

	protected function loadComponentConfigAsArray( $componentName ) {
		wfProfileIn( __METHOD__ );

		$configFile = $this->getComponentConfigFileFullPath( $componentName );
		$configFileContent = $this->loadFileContent( $configFile );
		$configInArray = $this->loadFromJSON( $configFileContent );

		wfProfileOut( __METHOD__ );
		return $configInArray;
	}

	/**
	 * @desc Return memcache version
	 * As the ui components may change after each release, we would like to invalidate the cache immediately
	 *
	 * @return int cache version
	 */
	public function getCacheVersion() {
		global $wgStyleVersion;
		return $wgStyleVersion;
	}

	/**
	 * @desc Gets the raw template contents for a given component type
	 *
	 * @param $component Component
	 * @param $type String component type
	 * @return String
	 */
	public function loadComponentTemplateContent( $component, $type ) {
		wfProfileIn( __METHOD__ );
		$memcKey = wfMemcKey( __CLASS__, 'component', $component->getName(), $type, $this->getCacheVersion() );
		$content = \WikiaDataAccess::cache(
			$memcKey,
			self::MEMCACHE_EXPIRATION,
			function() use ( $component, $type ) {
				$component->setType( $type );
				return $this->loadFileContent( $component->getTemplatePath() );
			}
		);
		wfProfileOut( __METHOD__ );
		return $content;
	}

	/**
	 * Simple AssetsManager::getURL wrapper, mainly because AM returns type via reference, and this is not
	 * supported by PHPUnit, so we use this function, which is possible to mock.
	 * Return an array containing a list of URLs and asset type (Factory::ASSET_TYPE_*)
	 */
	protected function getAssetsURL( $assets ) {
		$type = false;
		$sources = \AssetsManager::getInstance()->getURL( $assets, $type );
		switch( $type ) {
			case \AssetsManager::TYPE_CSS:
			case \AssetsManager::TYPE_SCSS:
				$type = self::ASSET_TYPE_CSS;
				break;
			case \AssetsManager::TYPE_JS:
				$type = self::ASSET_TYPE_JS;
				break;
			default:
				$type = false;
				$sources = [];
		}
		return [ $sources, $type ];
	}

	/**
	 * Generate component assets url. The result is a dictionary containing ASSET_TYPE_JS and ASSET_TYPE_CSS keys,
	 * each of those pointing to array of urls.
	 *
	 * @param $component Component
	 * @return array assets links
	 */
	public function getComponentAssetsUrls( $component ) {
		wfProfileIn( __METHOD__ );
		$result =  [ self::ASSET_TYPE_JS => [], self::ASSET_TYPE_CSS => [] ];
		foreach( $component->getAssets() as $assets ) {
			foreach( $assets as $asset ) {
				list( $sources, $type ) = $this->getAssetsURL( $asset );
				if ( !empty( $sources ) ) {
					$result[ $type ] = array_merge( $result[ $type ], $sources );
				}
			}
		}
		wfProfileOut( __METHOD__ );
		return $result;
	}

	/**
	 * @desc Gets configuration file contents, decodes it to array and returns it; uses caching layer
	 * 
	 * @param String $componentName
	 * @return string
	 */
	public function loadComponentConfig( $componentName ) {
		wfProfileIn( __METHOD__ );

		$memcKey = wfMemcKey( __CLASS__, 'component', $componentName, $this->getCacheVersion() );
		$data = \WikiaDataAccess::cache(
			$memcKey,
			self::MEMCACHE_EXPIRATION,
			function() use ( $componentName ) {
				$configInArray = $this->loadComponentConfigAsArray( $componentName );

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
		return static::getComponentsDir() .
			$name .
			DIRECTORY_SEPARATOR .
			self::TEMPLATES_DIR_NAME .
			DIRECTORY_SEPARATOR .
			$name;
	}

	/**
	 * @desc returns configurated instance of \Wikia\UI\Component
	 *
	 * @param string $name name of the component to create
	 * @param array $assets component assets will be added to this array
	 * @throws DataException
	 */
	protected function initComponent( $name, &$assets ) {
		$componentConfig = $this->loadComponentConfig( $name );

		// if there are some components, put them in the $assets
		$assetsTypes = [ self::ASSET_TYPE_JS, self::ASSET_TYPE_CSS ];
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
		$component->setName( $name );
		if ( !empty( $componentConfig['templateVars'] ) ) {
			$component->setTemplateVarsConfig( $componentConfig['templateVars'] );
		}
		$component->setBaseTemplatePath( $this->getComponentsBaseTemplatePath( $name ) );

		if ( !empty( $componentConfig['dependencies'] ) ) {
			$component->setAssets( array_intersect_key( $componentConfig['dependencies'], array_flip( $assetsTypes ) ) );
		}

		if ( !empty( $componentConfig['dependencies'][self::COMPONENT_DEPENDENCY] ) ) {
			$component->setComponentDependencies( $componentConfig['dependencies'][self::COMPONENT_DEPENDENCY] );
		}

		if ( !empty( $componentConfig[ 'jsWrapperModule' ] ) ) {
			$component->setJSWrapperModule( $componentConfig[ 'jsWrapperModule' ] );
		}

		return $component;
	}

	/**
	 * @desc Loads JS/CSS dependencies, creates and configurates an instance of \Wikia\UI\Component object which is returned
	 *
	 * @param string|array $componentNames
	 * @param bool $loadAssets flag indicating if the component assets should be loaded - needed when we want to render components
	 * @param array|null optional array, when specified, the dependent components will be loaded and stored in it
	 *
	 * @throws \Wikia\UI\DataException
	 * @return array
	 */
	public function init( $componentNames, $loadAssets = true, &$dependencies = null ) {
		if ( !is_array( $componentNames ) ) {
			$componentNames = (array)$componentNames;
		}
		
		$components = [];
		$assets = [];
		$result = [];

		// iterate $componentNames, read configs, write down dependencies
		foreach ( $componentNames as $name ) {
			$components[$name] = $this->initComponent( $name, $assets );
			$result[] = $components[$name];
		}

		if ( is_array( $dependencies ) ) {
			// process the dependencies
			$dependenciesToLoad = [];
			foreach( $result as $component ) {
				$dependenciesToLoad = array_merge( $dependenciesToLoad, $component->getComponentDependencies() );
			}
			while( !empty( $dependenciesToLoad ) ) {
				$name = array_shift( $dependenciesToLoad );
				if ( !isset( $components[$name] ) ) {
					$components[$name] = $this->initComponent( $name, $assets );
					$dependenciesToLoad = array_merge( $dependenciesToLoad, $components[$name]->getComponentDependencies() );
				}
				if ( !isset( $dependencies[$name] ) ) {
					$dependencies[$name] = $components[$name];
				}
			}
		}

		if ( $loadAssets ) {
			// add merged assets
			foreach ( array_unique( $assets ) as $asset ) {
				$this->addAsset( $asset );
			}
		}

		// return components
		return ( sizeof( $result ) == 1 ) ? $result[0] : $result;
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
