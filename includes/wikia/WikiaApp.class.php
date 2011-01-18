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
	 * constructor
	 * @param WikiaRegistry $registry
	 * @param WikiaHookDispatcher $hookDispatcher
	 */
	public function __construct(WikiaCompositeRegistry $registry = null, WikiaHookDispatcher $hookDispatcher = null) {
		if(is_null($registry)) {
			WF::setInstance( 'WikiaCompositeRegistry', new WikiaCompositeRegistry( array( self::REGISTRY_MEDIAWIKI => new WikiaGlobalsRegistry(), self::REGISTRY_WIKIA => new WikiaLocalRegistry() ) ) );
			$registry = WF::build( 'WikiaCompositeRegistry' );
		}
		if(is_null($hookDispatcher)) {
			WF::setInstance( 'HookDispatcher', new WikiaHookDispatcher());
			$hookDispatcher = WF::build( 'HookDispatcher' );
		}

		$this->hookDispatcher = $hookDispatcher;
		$this->registry = $registry;
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
	 * register hook (alias: WikiaHookDispatcher::registerHook)
	 * @param string $hookName
	 * @param string $className
	 * @param string $methodName
	 * @param array $options
	 * @param bool $alwaysRebuild
	 */
	public function registerHook($hookName, $className, $methodName, array $options = array(), $alwaysRebuild = false) {
		$this->getRegistry()->getRegistry(self::REGISTRY_MEDIAWIKI)->append('wgHooks', $this->hookDispatcher->registerHook($className, $methodName, $options, $alwaysRebuild), $hookName);
	}

	/**
	 * register class
	 * @param string $className
	 * @param string $filePath
	 */
	public function registerClass($className, $filePath) {
		$this->getRegistry()->getRegistry(self::REGISTRY_MEDIAWIKI)->set('wgAutoloadClasses', $filePath, $className);
	}

	/**
	 * register extension init function
	 * @param string $functionName
	 */
	public function registerExtensionFunction($functionName) {
		$this->getRegistry()->getRegistry(self::REGISTRY_MEDIAWIKI)->append('wgExtensionFunctions', $functionName);
	}

	/**
	 * register extension message file
	 * @param string $name
	 * @param string $filePath
	 */
	public function registerExtensionMessageFile($name, $filePath) {
		$this->getRegistry()->getRegistry(self::REGISTRY_MEDIAWIKI)->set('wgExtensionMessagesFiles', $name, $filePath);
	}

	/**
	 * register extension alias file
	 * @param string $name
	 * @param string $filePath
	 */
	public function registerExtensionAliasFile($name, $filePath) {
		$this->getRegistry()->getRegistry(self::REGISTRY_MEDIAWIKI)->set('wgExtensionAliasesFiles', $name, $filePath);
	}

	/**
	 * register special page
	 * @param string $name special page name
	 * @param string $className class name
	 */
	public function registerSpecialPage($name, $className) {
		$this->getRegistry()->getRegistry(self::REGISTRY_MEDIAWIKI)->set('wgSpecialPages', $name, $className);
	}

	/**
	 * get global variable (alias: WikiaCompositeRegistry::get(var,'mediawiki'))
	 * @param string $globalVarName
	 */
	public function getGlobal($globalVarName) {
		return $this->getRegistry()->get($globalVarName, 'mediawiki');
	}

	public function setGlobal($globalVarName, $value) {
		return $this->getRegistry()->set($globalVarName, $value, 'mediawiki');
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

}
