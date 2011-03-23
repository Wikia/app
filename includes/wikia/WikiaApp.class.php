<?php

/**
 * Wikia Application class
 * @author ADi
 * @author Wojtek
 */
class WikiaApp {
	const REGISTRY_MEDIAWIKI = WikiaCompositeRegistry::DEFAULT_NAMESPACE;
	const REGISTRY_WIKIA = 'wikia';

		/**
	 * registry
	 * @var WikiaCompositeRegistry
	 */
	private $registry = null;
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
	 * constructor
	 * @param WikiaRegistry $registry
	 * @param WikiaHookDispatcher $hookDispatcher
	 */
	public function __construct(WikiaCompositeRegistry $registry = null, WikiaHookDispatcher $hookDispatcher = null) {
		if(is_null($registry)) {
			F::setInstance( 'WikiaCompositeRegistry', new WikiaCompositeRegistry( array( self::REGISTRY_MEDIAWIKI => new WikiaGlobalsRegistry(), self::REGISTRY_WIKIA => new WikiaLocalRegistry() ) ) );
			$registry = F::build( 'WikiaCompositeRegistry' );
		}
		if(is_null($hookDispatcher)) {
			F::setInstance( 'WikiaHookDispatcher', new WikiaHookDispatcher());
			$hookDispatcher = F::build( 'WikiaHookDispatcher' );
		}

		$this->hookDispatcher = $hookDispatcher;
		$this->registry = $registry;

		// register ajax dispatcher
		$this->registry->getRegistry(self::REGISTRY_MEDIAWIKI)->append('wgAjaxExportList', 'WikiaApp::ajax');
	}

	/**
	 * get hook dispatcher
	 * @return WikiaHookDispatcher
	 */
	public function getHookDispatcher() {
		return $this->hookDispatcher;
	}

	/**
	 * get registry
	 * @return WikiaCompositeRegistry
	 */
	public function getRegistry() {
		return $this->registry;
	}

	/**
	 * set registry
	 * @param WikiaCompositeRegistry $registry
	 */
	public function setRegistry(WikiaCompositeRegistry $registry) {
		$this->registry = $registry;
	}

	/**
	 * get MediaWiki registry (global)
	 * @return WikiaGlobalsRegistry
	 */
	public function getMWRegistry() {
		return $this->getRegistry()->getRegistry(self::REGISTRY_MEDIAWIKI);
	}

	/**
	 * get Wikia registry (local
	 * @return WikiaLocalRegistry
	 */
	public function getWikiaRegistry() {
		return $this->getRegistry()->getRegistry(self::REGISTRY_WIKIA);
	}

	/**
	 * get dispatcher object
	 * @return WikiaDispatcher
	 */
	protected function getDispatcher() {
		if( $this->dispatcher == null ) {
			$this->dispatcher = F::build( 'WikiaDispatcher' );
		}
		return $this->dispatcher;
	}

	/**
	 * register hook (alias: WikiaHookDispatcher::registerHook)
	 * @param string $hookName
	 * @param string $className
	 * @param string $methodName
	 * @param array $options
	 * @param bool $alwaysRebuild
	 */
	public function registerHook($hookName, $className, $methodName, array $options = array(), $alwaysRebuild = false) {
		$this->getMWRegistry()->append('wgHooks', $this->hookDispatcher->registerHook($className, $methodName, $options, $alwaysRebuild), $hookName);
	}

	/**
	 * register class
	 * @param string $className
	 * @param string $filePath
	 */
	public function registerClass($className, $filePath) {
		$this->getMWRegistry()->set('wgAutoloadClasses', $filePath, $className);
	}

	/**
	 * register extension init function
	 * @param string $functionName
	 */
	public function registerExtensionFunction($functionName) {
		$this->getMWRegistry()->append('wgExtensionFunctions', $functionName);
	}

	/**
	 * register extension message file
	 * @param string $name
	 * @param string $filePath
	 */
	public function registerExtensionMessageFile($name, $filePath) {
		$this->getMWRegistry()->set('wgExtensionMessagesFiles', $filePath, $name);
	}

	/**
	 * register extension alias file
	 * @param string $name
	 * @param string $filePath
	 */
	public function registerExtensionAliasFile($name, $filePath) {
		$this->getMWRegistry()->set('wgExtensionAliasesFiles', $filePath, $name);
	}

	/**
	 * register special page
	 * @param string $name special page name
	 * @param string $className class name
	 */
	public function registerSpecialPage($name, $className) {
		$this->getMWRegistry()->set('wgSpecialPages', $className, $name);
	}

	/**
	 * get global variable (alias: WikiaCompositeRegistry::get(var,'mediawiki'))
	 * @param string $globalVarName
	 */
	public function getGlobal($globalVarName) {
		return $this->getMWRegistry()->get($globalVarName);
	}

	/**
	 * set global variable (alias: WikiaGlobalRegistry::set(var, value, key))
	 * @param string $globalVarName variable name
	 * @param mixed $value value
	 * @param string $key key (optional)
	 */
	public function setGlobal($globalVarName, $value, $key = null) {
		return $this->getMWRegistry()->set($globalVarName, $value, $key);
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
	 * simple global function wrapper (most likely it won't work for references)
	 *
	 * @param string $funcName global function name
	 * @param mixed $arg1 - $argN function arguments
	 * @experimental
	 */
	public function runFunction() {
		$funcArgs = func_get_args();
		$funcName = array_shift($funcArgs);
		return call_user_func_array( $funcName, $funcArgs );
	}

	public function dispatch( $request = null, WikiaResponse $response = null ) {
		if( is_array( $request ) ) {
			$request = new WikiaHTTPRequest( $request );
		}

		return $this->getDispatcher()->dispatch( $this, $request, $response );
	}

	public static function ajax() {
		return F::build( 'App' )->dispatch();
	}

}
