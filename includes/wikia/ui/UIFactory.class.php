<?php
class UIFactory {
	/**
	 * @desc Component's configuration file suffix
	 * Example buttons component config file should be named buttons_config.json
	 * 
	 * @var String
	 */
	const CONFIG_FILE_SUFFIX = '_config.json';

	/**
	 * @desc Component's default templates' directory name
	 */
	const COMPONENT_DEFAULT_TPL_DIR_NAME = 'templates';

	/**
	 * @desc Component's directory path from docroot
	 */
	const DEFAULT_COMPONENTS_PATH = "/resources/wikia/ui_components/";
	
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
	}

	/**
	 * @desc Sets the path to components' directory
	 * @param String $path
	 */
	public function setComponentsDir( $path ) {
		$this->componentsDir = $path;
	}

	/**
	 * @desc Returns the path to component's directory
	 * @return null|String
	 */
	public function getComponentsDir() {
		return $this->componentsDir;
	}

	/**
	 * @desc Returns the only instnace of the class; singleton
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
						wfDebugLog( __CLASS__, 'Component unavailable: ' . $componentName );
					}
				}
				$directory->next();
			}
		} catch( Exception $e ) {
			wfDebugLog( __CLASS__, 'Invalid Styleguide components\' directory: (' . $e->getCode() . ') ' . $e->getMessage() . ' [check $wgSpecialStyleguideUiCompontentsPath variable]');
		}
		
		return $components;
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
		$configPath = $this->getComponentsDir() . $componentName . '/' . $componentName . self::CONFIG_FILE_SUFFIX;
		$config = null;
		
		if( file_exists( $configPath ) && ( $configContent = file_get_contents( $configPath ) ) ) {
			$config = json_decode( $configContent, true );
			
			if( !is_null( $config )) {
				$this->addComponentsId( $config );
				$this->addComponentsTplPath( $config );
			} else {
				wfDebugLog( __CLASS__, "Invalid JSON in config file: " . $configPath );
				$config = [];
			}
			
		} else {
			wfDebugLog( __CLASS__, "Invalid component's config file: " . $configPath );
			$config = [];
		}
		
		return $config;
	}

	/**
	 * @desc Adds id element to the component's config array
	 * 
	 * @param Array $componentCfg
	 * @return array
	 */
	private function addComponentsId( &$componentCfg ) {
		$componentCfg['id'] = mb_strtolower( str_replace( ' ', '_', $componentCfg['name'] ) );
	}

	/**
	 * @desc Adds template path the component's config array
	 *
	 * @param Array $componentCfg
	 * @return array
	 */
	private function addComponentsTplPath( &$componentCfg ) {
		$componentsId = $componentCfg['id'];
		$componentCfg['templateData']['templatePath'] = 
			$this->getComponentsDir() .
			$componentsId .
			DIRECTORY_SEPARATOR .
			'templates' .
			DIRECTORY_SEPARATOR .
			$componentsId;
	}

	/**
	 * @desc Adds assets to load
	 * @param $componentDependencies
	 */
	private function addAssets( $componentDependencies ) {
	}

	/**
	 * @desc Loads JS/CSS dependencies, creates and configurates an instance of UIComponent object which is returned
	 * @param $componentName
	 */
	public function init( $componentName ) {
		$componentConfig = $this->loadComponentConfig( $componentName );
		$this->addAssets( $componentConfig['dependencies'] );
		$component = new UIComponent();
		$component->setTemplateVarsConfig( $componentConfig['templateData'] );
		return $component;
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
