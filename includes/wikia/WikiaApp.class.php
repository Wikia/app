<?php

/**
 * Wikia Application class
 * @author ADi
 * @author Wojtek
 */
class WikiaApp {

	/**
	 * globalRegistry
	 * @var WikiaGlobalRegistry
	 */
	private $globalRegistry = null;
	/**
	 * localRegistry
	 * @var WikiaLocalRegistry
	 */
	private $localRegistry = null;
	/**
	 * hook dispatcher
	 * @var WikiaHookDispatcher
	 */
	private $hookDispatcher = null;
	/**
	 * dispatcher
	 * @var WikiaDispatcher
	 */
	private $dispatcher = null;
	/**
	 * function wrapper
	 * @var WikiaFunctionWrapper
	 */
	private $functionWrapper = null;
	/**
	 * global MW variables helper accessor
	 * @var WikiaGlobalRegistry
	 */
	public $wg = null;
	/**
	 * global MW functions helper accessor
	 * @var WikiaFunctionWrapper
	 */
	public $wf = null;

	/**
	 * constructor
	 * @param WikiaRegistry $registry
	 * @param WikiaHookDispatcher $hookDispatcher
	 */
	public function __construct(WikiaGlobalRegistry $globalRegistry = null, WikiaLocalRegistry $localRegistry = null, WikiaHookDispatcher $hookDispatcher = null) {

		if(is_null($globalRegistry)) {
			F::setInstance('WikiaGlobalRegistry', new WikiaGlobalRegistry());
			$globalRegistry = F::build('WikiaGlobalRegistry');
		}
		if(is_null($localRegistry)) {
			F::setInstance('WikiaLocalRegistry', new WikiaLocalRegistry());
			$localRegistry = F::build('WikiaLocalRegistry');
		}
		if(is_null($hookDispatcher)) {
			F::setInstance( 'WikiaHookDispatcher', new WikiaHookDispatcher());
			$hookDispatcher = F::build( 'WikiaHookDispatcher' );
		}

		$this->globalRegistry = $globalRegistry;
		$this->localRegistry = $localRegistry;
		$this->hookDispatcher = $hookDispatcher;
		$this->functionWrapper = new WikiaFunctionWrapper();

		// set helper accessors
		$this->wg = $this->globalRegistry;
		$this->wf = $this->functionWrapper;

		// register ajax dispatcher
		$this->globalRegistry->append('wgAjaxExportList', 'WikiaApp::ajax');
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
		$this->globalRegistry = $globalRegistry;
	}

	/**
	 * get MediaWiki registry (global)
	 * @return WikiaGlobalRegistry
	 */
	public function getGlobalRegistry() {
		return $this->globalRegistry;
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
		return $this->functionWrapper;
	}

	/**
	 * set global function wrapper
	 * @param WikiaFunctionWrapper $functionWrapeper
	 */
	public function setFunctionWrapper(WikiaFunctionWrapper $functionWrapper) {
		$this->functionWrapper = $functionWrapper;
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
	public function registerHook($hookName, $className, $methodName, array $options = array(), $alwaysRebuild = false, $object = null) {
		$this->globalRegistry->append('wgHooks', $this->hookDispatcher->registerHook($className, $methodName, $options, $alwaysRebuild, $object), $hookName);
	}

	/**
	 * register class
	 * @param string $className
	 * @param string $filePath
	 */
	public function registerClass($className, $filePath) {
		$this->globalRegistry->set('wgAutoloadClasses', $filePath, $className);
	}

	/**
	 * register extension init function
	 * @param string $functionName
	 */
	public function registerExtensionFunction($functionName) {
		$this->globalRegistry->append('wgExtensionFunctions', $functionName);
	}

	/**
	 * register extension message file
	 * @param string $name
	 * @param string $filePath
	 */
	public function registerExtensionMessageFile($name, $filePath) {
		$this->globalRegistry->set('wgExtensionMessagesFiles', $filePath, $name);
	}

	/**
	 * register messages package to be used in JS
	 * @param string $name
	 * @param string $filePath
	 * @author macbre
	 * @see /extensions/wikia/JSMessages
	 */
	public function registerExtensionJSMessagePackage($name, $messages) {
		$this->globalRegistry->set('wgJSMessagesPackages', $messages, $name);
	}

	/**
	 * register extension alias file
	 * @param string $name
	 * @param string $filePath
	 */
	public function registerExtensionAliasFile($name, $filePath) {
		$this->globalRegistry->set('wgExtensionAliasesFiles', $filePath, $name);
	}

	/**
	 * register special page
	 * @param string $name special page name
	 * @param string $className class name
	 * @param string $group special page group
	 */
	public function registerSpecialPage($name, $className, $group = null) {
		$this->globalRegistry->set('wgSpecialPages', $className, $name);
		if( !empty( $group ) ) {
			$this->globalRegistry->set('wgSpecialPageGroups', $group, $name);
		}
	}

	/**
	 * get global variable (alias: WikiaGlobalRegistry::get(var,'mediawiki'))
	 * @param string $globalVarName
	 */
	public function getGlobal($globalVarName) {
		return $this->globalRegistry->get($globalVarName);
	}

	/**
	 * set global variable (alias: WikiaGlobalRegistry::set(var, value, key))
	 * @param string $globalVarName variable name
	 * @param mixed $value value
	 * @param string $key key (optional)
	 */
	public function setGlobal($globalVarName, $value, $key = null) {
		return $this->globalRegistry->set($globalVarName, $value, $key);
	}

	/**
	 * get array of globals
	 *
	 * how to use:
	 *  list( $wgTitle, $wgUser ) = $app->getGlobals( 'wgTitle', 'wgUser' );
	 *
	 * @param list of global's names, comma separated
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
	 * get cookies array
	 * @deprecated
	 * @return array
	 */
	public function getCookies() {
		return $_COOKIE;
	}

	/**
	 * get cookie
	 * @param string $key
	 * @return mixed
	 */
	public function getCookie( $key ) {
		return $this->isCookie( $key ) ? $_COOKIE[ $key ] : null;
	}

	/**
	 * set cookie
	 * @deprecated
	 * @param string $key
	 * @param mixed $value
	 * @param int $expire
	 */
	public function setCookie( $key, $value, $expire ) {
		setcookie( $key, $value, $expire );
	}

	/**
	 * unset cookie
	 * @deprecated
	 * @param string $key
	 */
	public function unsetCookie( $key ) {
		unset( $_COOKIE[ $key ] );
	}

	/**
	 * check if cookie is set
	 * @deprecated
	 * @param string $key
	 */
	public function isCookie( $key ) {
		return (bool) isset( $_COOKIE[ $key ] );
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
	public function sendRequest( $controllerName, $methodName = null, $params = null, $internal = true ) {
		$values = array( 'controller' => $controllerName, 'method' => $methodName );
		$request = new WikiaRequest( array_merge( $values, (array) $params ) );

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
		$funcName = array_shift($funcArgs);
		return $this->functionWrapper->run( $funcName, $funcArgs );
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
	 * get view Object for given controller and method (previously wfRenderPartial)
	 * @param string $controllerName
	 * @param string $method
	 * @param array $data
	 */
	public function getView( $controllerName, $method, Array $data = array() ) {
		return F::build( 'WikiaView', array( $controllerName, $method, $data ), 'newFromControllerAndMethodName' );
	}

	/**
	 * Helper function to get output as HTML for controller and method (previously wfRenderModule)
	 * @param string $name
	 * @param string $action
	 * @param array $params
	 * @return string
	 */
	public function renderView($name, $action, $params = null) {
		$response = $this->sendRequest( $name, $action, (array) $params, false );
		return $response->toString();
	}

	//TODO: take a look here
	public static function ajax() {
		return F::app()->sendRequest( null, null, null, false );
	}

}
