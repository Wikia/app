<?php

/**
 * UIFactory handles building component which means loading
 * assets and component configuration file
 *
 * @author Andrzej Łukaszewski <nandy@wikia-inc.com>
 * @author Bartosz Bentkowski <bartosz.bentkowski@wikia-inc.com>
 *
 */

class UIFactory {
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
	 * @desc How long are components memcached? Both specific and all (different memc keys)
	 */
	const MEMCACHE_EXPIRATION = 900; // 15 minutes
	
	/**
	 * @var UIFactory
	 */
	private static $instance = null;
	
	/**
	 * @desc AssetsManager/ResourceLoader
	 * @var Loader
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

		$this->loaderService = AssetsManager::getInstance();
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
	 * @return UIFactory
	 */
	static public function getInstance() {
		if( is_null(static::$instance) ) {
			static::$instance = new self();
		}
		
		return static::$instance;
	}

	/**
	 * @desc Returns an array with all available components configuration
	 * 
	 * @return array
	 */
	public function getAllComponents() {
		global $wgMemc;

		$memcKey = wfMemcKey( __CLASS__, 'all_components' );
		$data = $wgMemc->get( $memcKey );

		if ( !empty($data) ) {

			return $data;

		} else {

			$components = [];

			try {
				$directory = new DirectoryIterator( $this->getComponentsDir() );

				while( $directory->valid() ) {
					if( !$directory->isDot() && $directory->isDir() ) {
						$componentName = $directory->getFilename();
						$componentCfg = $this->loadComponentConfig( $componentName );
					
						if( !empty($componentCfg) ) {
							$components[] = $componentCfg;
						} else {
							wfDebugLog( __CLASS__, 'Component config unavailable: ' . $componentName );
						}
					}
					$directory->next();
				}
			} catch( Exception $e ) {
				wfDebugLog( __CLASS__, 'Invalid Styleguide components\' directory: (' . $e->getCode() . ') ' . $e->getMessage() . ' [check $wgSpecialStyleguideUiCompontentsPath variable]');
			}

			$wgMemc->set( $memcKey, $components, self::MEMCACHE_EXPIRATION );

			return $components;
		}
	}

	/**
	 * @desc Gets configuration file contents, decodes it to array and returns it
	 * 
	 * @todo add caching layer: planned and will be done in DAR-809
	 * 
	 * @param String $componentName
	 * @return array|null
	 */
	private function loadComponentConfig( $componentName ) {
		wfProfileIn( __METHOD__ );

		global $wgMemc;
		
		$memcKey = wfMemcKey( __CLASS__, 'component', $componentName);
		$data = $wgMemc->get( $memcKey );

		if ( !empty($data) ) {

			return $data;

		} else {

			$configPath = $this->getComponentsDir() . $componentName . '/' . $componentName . self::CONFIG_FILE_SUFFIX;
			$config = null;

			if( file_exists( $configPath ) && ( $configContent = file_get_contents( $configPath ) ) ) {
				$config = json_decode( $configContent, true );

				if( !is_null( $config )) {
					$config = $this->addComponentsId( $config );
				} else {
					wfDebugLog( __CLASS__, "Invalid JSON in config file: " . $configPath );
					$config = [];
				}

			} else {
				wfDebugLog( __CLASS__, "Invalid component's config file: " . $configPath );
				$config = [];
			}

			$wgMemc->set( $memcKey, $components, self::MEMCACHE_EXPIRATION );

			wfProfileOut( __METHOD__ );

			return $config;
		}
	}

	/**
	 * @desc Adds id element to the component's config array
	 * 
	 * @param Array $componentCfg
	 * @return array
	 */
	private function addComponentsId( $componentCfg ) {
		$componentCfg['id'] = mb_strtolower( str_replace( ' ', '_', $componentCfg['name'] ) );
		return $componentCfg;
	}

	/**
	 * @desc Adds asset to load
	 *
	 * @param $assetName
	 */
	private function addAsset( $assetName ) {
		wfProfileIn( __METHOD__ );

		$app = F::app();
		$jsMimeType = $app->wg->JsMimeType;

		$type = false;

		$sources = $this->loaderService->getURL( $fullName, $type, false );

		foreach ( $sources as $source ) {
			switch ( $type ) {
				case AssetsManager::TYPE_CSS:
				case AssetsManager::TYPE_SCSS:
					$app->wg->Out->AddStyle( $source );
					break;
				case AssetsManager::TYPE_JS:
					$app->wg->Out->AddScript( "<script src=\"{$jsMimeType}\" src=\"{$source}\"></script>" );
					break;
			}
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * @desc Loads JS/CSS dependencies, creates and configurates an instance of UIComponent object which is returned
	 *
	 * @param string|array
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
			if ( !empty( $componentsConfig['dependencies'] ) ) {
				if ( !empty( $componentsConfig['dependencies']['js'] ) ) {
					$assets = array_merge( $assets, $componentsConfig['dependencies']['js'] );
				}
				if ( !empty( $componentsConfig['dependencies']['css'] ) ) {
					$assets = array_merge( $assets, $componentsConfig['dependencies']['css'] );
				}
			}

			// init component and put config inside
			$component = new UIComponent();
			if ( !empty($componentConfig['templateVars']) ) {
				$component->setTemplateVarsConfig($componentConfig['templateVars']);
			}

			//
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
	 * @throws Exception
	 */
	public function __clone() {
		throw new Exception( 'Cloning instances of this class is forbidden.' );
	}

	/**
	 * @throws Exception
	 */
	public function __wakeup() {
		throw new Exception( 'Unserializing instances of this class is forbidden.' );
	}
}

