<?php

/** @defgroup nirvana Nirvana
 *  The Nirvana Framework
 */

/**
 * Nirvana Framework - Application class
 *
 * @ingroup nirvana
 *
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia-inc.com>
 * @author Owen Davis <owen(at)wikia-inc.com>
 * @author Wojciech Szela <wojtek(at)wikia-inc.com>
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class WikiaApp {

	/**
	 * localRegistry
	 * @var $localRegistry WikiaLocalRegistry
	 */
	private $localRegistry = null;

	/**
	 * hook dispatcher
	 * @var $hookDispatcher WikiaHookDispatcher
	 */
	private $hookDispatcher = null;

	/**
	 * namespace Registry
	 * @var $namespaceRegistry array list of namespaces Registered by nirvana framework
	 */
	private $namespaceRegistry = array();

	/**
	 * dispatcher
	 * @var $dispatcher WikiaDispatcher
	 */
	private $dispatcher = null;

	/**
	 * flag for Skin initializationn
	 * @var $skinInitialized Bool
	 */
	private $skinInitialized = null;

	/**
	 * This reference is necessary for some Controllers that need access to Skin $data
	 * @var $skinTemplateObj SkinTemplate
	 */
	protected $skinTemplateObj = null;

	/**
	 * global MW variables helper accessor
	 * @var $wg WikiaGlobalRegistry
	 */
	public $wg = null;

	/**
	 * global MW functions helper accessor
	 * @var $wf WikiaFunctionWrapper
	 */
	public $wf = null;

	/**
	 * this variable is use for local cache of view. Used by getViewOnce, renderViewOnce
	 */

	protected static $viewCache = array();

	/**
	 * constructor
	 * @param $globalRegistry WikiaGlobalRegistry
	 * @param $localRegistry WikiaLocalRegistry
	 * @param $hookDispatcher WikiaHookDispatcher
	 */

	public function __construct(WikiaGlobalRegistry $globalRegistry = null, WikiaLocalRegistry $localRegistry = null, WikiaHookDispatcher $hookDispatcher = null, WikiaFunctionWrapper $functionWrapper = null) {

		if(!is_object($globalRegistry)) {
			F::setInstance('WikiaGlobalRegistry', new WikiaGlobalRegistry());
			$globalRegistry = F::build( 'WikiaGlobalRegistry' );
		}

		if(!is_object($localRegistry)) {
			F::setInstance('WikiaLocalRegistry', new WikiaLocalRegistry());
			$localRegistry = F::build( 'WikiaLocalRegistry' );
		}

		if(!is_object($hookDispatcher)) {
			F::setInstance('WikiaHookDispatcher', new WikiaHookDispatcher());
			$hookDispatcher = F::build( 'WikiaHookDispatcher' );
		}

		if(!is_object($functionWrapper)) {
			$functionWrapper = F::build( 'WikiaFunctionWrapper' );
		}

		$this->localRegistry = $localRegistry;
		$this->hookDispatcher = $hookDispatcher;

		// set helper accessors
		$this->wg = $globalRegistry;
		$this->wf = $functionWrapper;

		// register ajax dispatcher
		if(is_object($this->wg)) {
			$this->wg->append('wgAjaxExportList', 'WikiaApp::ajax');
		} else {
			Wikia::log( __METHOD__, false, 'WikiaGlobalRegistry not set in ' . __CLASS__ . ' ' . __METHOD__ );
			Wikia::logBacktrace(__METHOD__);
		}
	}

	/**
	 * checks if an reference or a string refer to a WikiaService instance
	 *
	 * @param mixed $controllerName a string with the name of the class or a reference to an object
	 */
	public function isService( $controllerName ) {
		return ( is_object( $controllerName ) ) ? is_a( $controllerName, 'WikiaService' ) : ( ( strrpos( $controllerName, 'Service' ) === ( strlen( $controllerName ) - 7 ) ) );
	}

	/**
	 * checks if an reference or a string refer to a WikiaController instance
	 *
	 * @param mixed $controllerName a string with the name of the class or a reference to an object
	 */
	public function isController( $controllerName ) {
		return ( is_object( $controllerName ) ) ? is_a( $controllerName, 'WikiaController' ) : ( ( strrpos( $controllerName, 'Controller' ) === ( strlen( $controllerName ) - 10 ) ) );
	}

	/**
	 * @deprecated
	 *
	 * checks if an reference or a string refer to a Module instance, this method exists only for supporting legacy code
	 *
	 * @param mixed $controllerName a string with the name of the class or a reference to an object
	 */
	public function isModule( $controllerName ) {
		return ( is_object( $controllerName ) ) ? is_a( $controllerName, 'Module' ) : ( ( strrpos( $controllerName, 'Module' ) === ( strlen( $controllerName ) - 6 ) ) );
	}

	/**
	 * @deprecated
	 *
	 * returns a partial name for a WikiaController or a Module subclass name to use in dispatching requests and loading templates,
	 * this method exists only for supporting legacy code
	 *
	 * @param mixed $controllerName a string with the name of the class or a reference to an object
	 */
	public function getControllerLegacyName( $controllerName ) {
		if ( is_object( $controllerName ) ) {
			$controllerName = get_class( $controllerName );
		}

		if ( $this->isController( $controllerName ) ) {
			return substr( $controllerName, 0, strlen( $controllerName ) - 10 );
		} elseif ( $this->isModule( $controllerName ) ) {
			return substr( $controllerName, 0, strlen( $controllerName ) - 6 );
		} else {
			return $controllerName;
		}
	}

	/**
	 * get hook dispatcher
	 * @return WikiaHookDispatcher
	 */
	public function getHookDispatcher() {
		return $this->hookDispatcher;
	}

	/**
	 * set MediaWiki registry (global)
	 * @param WikiaGlobalRegistry $globalRegistry
	 */
	public function setGlobalRegistry(WikiaGlobalRegistry $globalRegistry) {
		$this->wg = $globalRegistry;
	}

	/**
	 * get MediaWiki registry (global)
	 * @return WikiaGlobalRegistry
	 */
	public function getGlobalRegistry() {
		return $this->wg;
	}

	/**
	 * set Wikia registry (local)
	 * @param WikiaLocalRegistry $localRegistry
	 */
	public function setLocalRegistry(WikiaLocalRegistry $localRegistry) {
		$this->localRegistry = $localRegistry;
	}

	/**
	 * get Wikia registry (local)
	 * @return WikiaLocalRegistry
	 */
	public function getLocalRegistry() {
		return $this->localRegistry;
	}

	/**
	 * get global function wrapper
	 * @return WikiaFunctionWrapper
	 */
	public function getFunctionWrapper() {
		return $this->wf;
	}

	/**
	 * set global function wrapper
	 * @param WikiaFunctionWrapper $functionWrapper
	 */
	public function setFunctionWrapper(WikiaFunctionWrapper $functionWrapper) {
		$this->wf = $functionWrapper;
	}

	/**
	 * forces skin initialization
	 * @param bool $flag
	 */
	public function initSkin( $flag ) {
		if ( $flag ) {
			// initialize skin via OutputPage Context
			$flag = ( is_object( $this->wg->Out ) && is_object( $this->wg->Out->getContext()->getSkin() ) );
		}

		$this->skinInitialized = $flag;
	}

	/**
	 * returns the skin initialization status
	 * @return bool
	 */
	public function isSkinInitialized() {
		//if null then initSkin has not been called at all, it's a normal request and skin is initialized automatically
		if ( $this->skinInitialized === null ) {
			$this->skinInitialized = true;
		}

		return $this->skinInitialized;
	}
	/** Getter/Setter for global/static skin template object
	 *
	 * @param SkinTemplate $skinTemplate
	 */
	public function setSkinTemplateObj( &$skinTemplate ) {
		$this->skinTemplateObj = $skinTemplate;
	}

	/**
	 * @return SkinTemplate
	 */

	public function getSkinTemplateObj() {
		return $this->skinTemplateObj;
	}

	/**
	 * Check if the skin is the one specified, useful to fork parser logic on a per-skin base
	 *
	 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
	 *
	 * @param mixed $skinName the skin short name (e.g. 'oasis' or 'wikiamobile') or an array of those
	 * @param object $skinObj [optional] a subclass of Skin, Linker or DummyLinker to be checked,
	 *        useful in hooks that have a skin instance as the paramenter, the global user skin
	 *        will be used if not passed
	 *
	 * @example
	 * $this->app->checkSkin( 'oasis' ); //single check against the global instance, in a WikiaObject subclass
	 * F::app()->checkSkin( 'oasis' ); //single check against the global instance
	 * F::app()->checkSkin( array( 'oasis', 'wikiamobile' ) ); //multiple checkagainst the global instance
	 * F::app()->checkSkin( 'monobook', $skinObj ); //e.g. in a hook that passes the skin instance as a parameter
	 *
	 * @return bool whether the skin is the one (or one of) specified
	 */
	public function checkSkin( $skinName, $skinObj = null ) {
		$this->wf->profileIn( __METHOD__ );
		$skinNames = null;
		$res = null;

		if ( is_string( $skinName ) ) {
			$skinNames = array( $skinName );
		} elseif ( is_array( $skinName ) ) {
			$skinNames = $skinName;
		} else {
			$res = false;
		}

		if ( is_null( $res ) ) {
			//MW 1.19 upgrade fix (FB#29972), hooks don't pass always a descendant of Skin or Linker,
			//so check if the passed in object actually has the required method
			if ( method_exists( $skinObj, 'getSkinName' ) ) {
				$skin = $skinObj;
			} else {
				//MW 1.19 upgrade fix, the global reference to the skin is not in the
				//User object anymore, use RequestContext::getSkin instead
				$skin = RequestContext::getMain()->getSkin();
			}

			$res = in_array( $skin->getSkinName(), $skinNames );
		}

		$this->wf->profileOut( __METHOD__ );
		return $res;
	}

	/**
	 * get dispatcher object
	 * @return WikiaDispatcher
	 */
	public function getDispatcher() {
		if( $this->dispatcher == null ) {
			$this->dispatcher = F::build( 'WikiaDispatcher' );
		}
		return $this->dispatcher;
	}

	/**
	 * set dispatcher object
	 * @param WikiaDispatcher $dispatcher
	 */
	public function setDispatcher(WikiaDispatcher $dispatcher) {
		$this->dispatcher = $dispatcher;
	}

	/**
	 * register hook (alias: WikiaHookDispatcher::registerHook)
	 * @param string $hookName
	 * @param string $className
	 * @param string $methodName
	 * @param array $options
	 * @param bool $alwaysRebuild
	 */
	public function registerHook( $hookName, $className, $methodName, Array $options = array(), $alwaysRebuild = false, $object = null ) {
		$this->wg->append( 'wgHooks', $this->hookDispatcher->registerHook( $className, $methodName, $options, $alwaysRebuild, $object ), $hookName );
	}

	/**
	 * registerNamespaceControler
	 * if the namespace is registered using registerNamespaceControler
	 * $className, $methodName will be exexuted instead of regular article path
	 *
	 * title is passed as a request attribute. ($app->renderView($className, $methodName, array( 'title' => $wgTitle ) )
	 *
	 * @param integer $namespace
	 * @param string $className
	 * @param string $methodName
	 * @param string $exists - Controler will be only executed if wgTitle exists
	 */

	public function registerNamespaceControler( $namespace, $className, $methodName, $exists ) {
		if(empty($this->namespaceRegistry)) {
			$this->registerHook( 'ArticleViewHeader', 'WikiaApp', 'onArticleViewHeader', array(), false, $this );
		}

		$this->namespaceRegistry[$namespace] =  array(
			'className' => $className,
			'methodName' => $methodName,
		  	'exists' => $exists
		);
	}

	/**
	 * Registers a controller for Wikia's public Nirvana-based API
	 *
	 * @param string $className The name of the class contained in the file
	 * @param string $path The path to the file
	 */
	public function registerApiController( $className, $path ) {
		//register class for autoloading
		$this->wg->set( 'wgAutoloadClasses', $path, $className );

		//register the API controller for discovery/auto-documentation
		$this->wg->set( 'wgWikiaApiControllers', $path, $className );
	}

	/**
	 *
	 * onArticleViewHeader
	 *
	 * This is a hook which serves the needs of registerNamespaceControler
	 *
	 * @param $article Article
	 * @param $outputDone Bool
	 * @param $useParserCache
	 */

	public function onArticleViewHeader(&$article, &$outputDone, &$useParserCache) {
		$title = $article->getTitle();

		$namespace = $title->getNamespace();
		if( !empty($this->namespaceRegistry[$namespace]) && (empty($this->namespaceRegistry['exists']) || $title->exists()) ) {
			$this->wg->Out->addHTML($this->renderView($this->namespaceRegistry[$namespace]['className'], $this->namespaceRegistry[$namespace]['methodName'], array( 'title' => $article->getTitle() ) ));
			$outputDone = true;
		}

		return true;
	}

	/**
	 * register class
	 * @param mixed $className the name of the class or a list of classes contained in the same file passed as an array
	 * @param string $filePath
	 */
	public function registerClass($className, $filePath) {
		//checking if $className is an array should be faster than creating a 1 element array and then use the same foreach loop
		if ( is_array( $className ) ) {
			foreach ( $className  as $cls ) {
				$this->wg->set( 'wgAutoloadClasses', $filePath, $cls );
			}
		} else {
			$this->wg->set( 'wgAutoloadClasses', $filePath, $className );
		}
	}

	/**
	 * register controller class
	 */

	public function registerController($className, $filePath, $options = null) {
		// register the class with the autoloader
		$this->registerClass($className, $filePath);

		if ( is_array ($className)) {
			foreach ( $className as $cls ) {
				$this->wg->set('wgWikiaControllers', $className, $options);
			}
		} else {
			$this->wg->set('wgWikiaControllers', $options);
		}
	}

	/**
	 * register extension init function
	 * @param string $functionName
	 */
	public function registerExtensionFunction( $functionName ) {
		$this->wg->append( 'wgExtensionFunctions', $functionName );
	}

	/**
	 * register extension message file
	 * @param string $name
	 * @param string $filePath
	 */
	public function registerExtensionMessageFile( $name, $filePath ) {
		$this->wg->set( 'wgExtensionMessagesFiles', $filePath, $name );
	}

	/**
	 * register extension alias file
	 * @param string $name
	 * @param string $filePath
	 */
	public function registerExtensionAliasFile( $name, $filePath ) {
		$this->wg->set( 'wgExtensionAliasesFiles', $filePath, $name );
	}

	/**
	 * register special page
	 * @param string $name special page name
	 * @param string $className class name
	 * @param string $group special page group
	 */
	public function registerSpecialPage( $name, $className, $group = null ) {
		$this->wg->set( 'wgSpecialPages', $className, $name );

		if( !empty( $group ) ) {
			$this->wg->set( 'wgSpecialPageGroups', $group, $name );
		}
	}

	/**
	 * get global variable (alias: WikiaGlobalRegistry::get(var,'mediawiki'))
	 * @param string $globalVarName
	 */
	public function getGlobal( $globalVarName ) {
		return $this->wg->get( $globalVarName );
	}

	/**
	 * set global variable (alias: WikiaGlobalRegistry::set(var, value, key))
	 * @param string $globalVarName variable name
	 * @param mixed $value value
	 * @param string $key key (optional)
	 */
	public function setGlobal( $globalVarName, $value, $key = null ) {
		return $this->wg->set( $globalVarName, $value, $key );
	}

	/**
	 * get array of globals
	 *
	 * how to use:
	 *  list( $wgTitle, $wgUser ) = $app->getGlobals( 'wgTitle', 'wgUser' );
	 *
	 * @params list of global's names, comma separated
	 * @return array
	 */
	public function getGlobals() {
		$globals = array();
		$funcArgs = func_get_args();

		foreach( $funcArgs as $globalName ) {
			$globals[] = $this->getGlobal( $globalName );
		}

		return $globals;
	}

	/**
	 * Prepares and sends a request to a Controller
	 *
	 * @param $controllerName string the name of the controller, without the 'Controller' or 'Model' suffix
	 * @param $methodName string the name of the Controller method to call
	 * @param $params array an array with the parameters to pass to the specified method
	 * @param $internal boolean wheter it's an internal (PHP to PHP) or external request
	 *
	 * @return WikiaResponse a response object with the data produced by the method call
	 */
	public function sendRequest( $controllerName = null, $methodName = null, $params = array(), $internal = true ) {
		$values = array();

		if ( !empty( $controllerName ) ) {
			$values['controller'] = $controllerName;
		}

		if ( !empty( $methodName ) ) {
			$values['method'] = $methodName;
		}

		$params = array_merge( (array) $params, $values );

		if ( empty( $methodName ) || empty( $controllerName ) ) {
			$params = array_merge( $params, $_POST, $_GET );
		}

		$request = F::build('WikiaRequest', array($params) );

		$request->setInternal( $internal );

		return $this->getDispatcher()->dispatch( $this, $request );
	}

	/**
	 * simple global function wrapper (most likely it won't work for references)
	 *
	 * @param string $funcName global function name
	 * @param mixed $arg1 - $argN function arguments
	 * @experimental
	 */
	public function runFunction() {
		$funcArgs = func_get_args();
		$funcName = array_shift( $funcArgs );
		return $this->wf->run( $funcName, $funcArgs );
	}

	/**
	 * simple wfRunHooks wrapper
	 *
	 * @param string $hookName The name of the hook to run
	 * @param array $params An array of the params to pass in the hook call
	 */
	public function runHook( $hookName, $parameters ) {
		return wfRunHooks( $hookName, $parameters );
	}

	/**
	 * get view Object for given controller and method, providing your own data
	 * @param string $controllerName
	 * @param string $method
	 * @param Array $params
	 * @return WikiaView
	 */
	public function getView( $controllerName, $method, Array $params = array() ) {
		return F::build( 'WikiaView', array( $controllerName, $method, $params ), 'newFromControllerAndMethodName' );
	}

	/**
	 * shortcut for getView(...)->render(); (previously wfRenderPartial)
	 * @param string $controllerName
	 * @param string $method
	 * @param Array $params
	 * @return string
	 */

	public function renderPartial( $controllerName, $method, Array $params = array() ) {
	 	return $this->getView( $controllerName, $method, $params )->render();
	}

	/**
	 * Helper function to get output as HTML for controller and method (previously wfRenderModule)
	 * @param string $controllerName
	 * @param string $method
	 * @param array $params
	 * @return string
	 */

	public function renderView( $controllerName, $method, Array $params = null ) {
		return $this->sendRequest( $controllerName, $method, $params, true )->toString();
	}

	/**
	 * call renderView and cache results locally. In case of subsequent call for the same controller/method with the same $key,
	 * previously rendered string will be returned.
	 *
	 * Use Case: repeated rendering of the some controller/method with the some input data
	 *
	 * @param string $controllerName
	 * @param string $method
	 * @param string $key caching key for you extension/parent template
	 * @param array $params
	 * @return string
	 */

	public function renderViewCached( $controllerName, $method, $key, Array $params = array() ) {
		if(empty(self::$viewCache["V_". $controllerName . $method . $key])) {
			self::$viewCache["V_". $controllerName . $method . $key] =  $this->renderView($controllerName, $method, $params);
		}

		return self::$viewCache["V_". $controllerName . $method . $key];
	}

	/**
	 * call renderPartial and cache results locally. In case of subsequent call for the same controller/method with the same $key,
	 * previously rendered string will be returned.
	 *
	 * Use Case: repeated rendering of the some controller/method with the some input data
	 *
	 * @param string $controllerName
	 * @param string $method
	 * @param string $key caching key for you extension/parent template
	 * @param array $params
	 * @return string
	 */

	public function renderPartialCached( $controllerName, $method, $key, Array $params = array() ) {
		if(empty(self::$viewCache["P_". $controllerName . $method . $key])) {
			self::$viewCache["P_". $controllerName . $method . $key] =  $this->renderPartial($controllerName, $method, $params);
		}

		return self::$viewCache["P_". $controllerName . $method . $key];
	}

	/**
	 * @todo: take a look here, consider removing
	 */
	public static function ajax() {
		return F::app()->sendRequest( null, null, null, false );
	}

	/**
	 * commit any open transactions, only if writes were done on connection and if it's a POST request
	 */
	public function commit(){
		if ( $this->wg->Request->wasPosted() ) {
			/**
			 * @var $factory LBFactory
			 */
			$factory = $this->wf->GetLBFactory();
			$factory->commitMasterChanges();  // commits only if writes were done on connection
		}
	}
}
