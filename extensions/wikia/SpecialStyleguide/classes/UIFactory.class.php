<?php
class UIFactory {
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
	private function __constructor() {}

	/**
	 * @desc Sets the path to components' directory
	 * @param String $path
	 */
	private function setComponentsDir( $path ) {
		$this->componentsDir = $path;
	}

	/**
	 * @desc Returns the path to component's directory
	 * @return null|String
	 */
	private function getComponentsDir() {
		return $this->componentsDir;
	}

	/**
	 * @desc Returns the only instnace of the class; singleton
	 * @return UIFactory
	 */
	static public function getInstance() {
		if( is_null(static::$instance) ) {
			static::$instance = new self();
			static::$instance->setComponentsDir( realpath( dirname( __FILE__ ) . '/../../../../resources/wikia/ui_components/' ) );
		}
		
		return static::$instance;
	}

	/**
	 * @desc Returns an array with all available components configuration
	 * 
	 * @return array
	 */
	public function getAllComponents() {
		$directory = new DirectoryIterator( $this->getComponentsDir() );
		$components = [];
		
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
		$configPath = realpath( $this->getComponentsDir() . '/' . $componentName . '/' . $componentName . '_config.json' );

		$config = null;
		
		if( !is_null( $configPath ) ) {
			$configContent = file_get_contents($configPath);
			$config = json_decode( $configContent, true );
		}
		
		return $this->addComponentsId( $config );
	}
	
	private function addComponentsId( $componentCfg ) {
		$componentCfg['id'] = mb_strtolower( str_replace( ' ', '_', $componentCfg['name'] ) );
		return $componentCfg;
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
		// We're going to implement it (maybe slightly change) in DAR-809
		// $componentConfig = $this->loadComponentConfig( $componentName );
		// $this->addAssets( $componentConfig['dependencies'] );
		// $component = new UIComponent();
		// $component->setTemplateVarsConfig($componentConfig['templateVars']);
		// return $component;
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
