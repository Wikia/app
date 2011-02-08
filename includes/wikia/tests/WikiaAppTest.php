<?php
/**
 * @group mwabstract
 */
class WikiaAppTest extends PHPUnit_Framework_TestCase {
	private $application;
	private $registry;
	private $hookDispatcher;

	protected function setUp() {
		$this->registry = $this->getMock('WikiaCompositeRegistry');

		$this->hookDispatcher = $this->getMock('WikiaHookDispatcher');
		$this->application = new WikiaApp(null, $this->hookDispatcher);
		$this->application->setRegistry($this->registry);
	}

	public function testDefaultRegistryAndHookDispatcherInstances() {
		$application = new WikiaApp();
		$this->assertInstanceOf('WikiaHookDispatcher', $application->getHookDispatcher());
		$this->assertInstanceOf('WikiaCompositeRegistry', $application->getRegistry());
		$this->assertEquals(2, $application->getRegistry()->countRegistries());
		$this->assertTrue($application->getRegistry()->hasRegistry(WikiaApp::REGISTRY_WIKIA));
		$this->assertTrue($application->getRegistry()->hasRegistry(WikiaApp::REGISTRY_MEDIAWIKI));
		$this->assertInstanceOf('WikiaLocalRegistry', $application->getRegistry()->getRegistry(WikiaApp::REGISTRY_WIKIA));
		$this->assertInstanceOf('WikiaGlobalsRegistry', $application->getRegistry()->getRegistry(WikiaApp::REGISTRY_MEDIAWIKI));
	}

	public function testRegisteringHookProxiesToWikiaHookDispatcherAndMediaWikiRegistry() {
		$hookName = 'HookName';
		$class = 'HookClass';
		$method = 'HookMethod';
		$options = array('HookOptions');
		$rebuild = true;
		$callback = array();

		$registry = $this->getMock('WikiaGlobalsRegistry');
		$registry->expects($this->once())
		         ->method('append')
		         ->with($this->equalTo('wgHooks'), $this->equalTo($callback), $this->equalTo($hookName));

		$this->hookDispatcher
		     ->expects($this->once())
		     ->method('registerHook')
		     ->with($this->equalTo($class), $this->equalTo($method), $this->equalTo($options), $this->equalTo($rebuild))
		     ->will($this->returnValue($callback));

		$this->registry
		     ->expects($this->once())
		     ->method('getRegistry')
		     ->with($this->equalTo(WikiaApp::REGISTRY_MEDIAWIKI))
		     ->will($this->returnValue($registry));

		$this->application->registerHook($hookName, $class, $method, $options, $rebuild);
	}

	public function testRegisteringClassProxiesToMediaWikiRegistry() {
		$path = 'filepath';
		$class = 'HookClass';

		$registry = $this->getMock('WikiaGlobalsRegistry');
		$registry->expects($this->once())
		         ->method('set')
		         ->with($this->equalTo('wgAutoloadClasses'), $this->equalTo($path), $this->equalTo($class));

		$this->registry
		     ->expects($this->once())
		     ->method('getRegistry')
		     ->with($this->equalTo(WikiaApp::REGISTRY_MEDIAWIKI))
		     ->will($this->returnValue($registry));

		$this->application->registerClass($class, $path);
	}

	public function testRegisteringExtensionFunctionProxiesToMediaWikiRegistry() {
		$function = 'extensionFunction';

		$registry = $this->getMock('WikiaGlobalsRegistry');
		$registry->expects($this->once())
		         ->method('append')
		         ->with($this->equalTo('wgExtensionFunctions'), $this->equalTo($function));

		$this->registry
		     ->expects($this->once())
		     ->method('getRegistry')
		     ->with($this->equalTo(WikiaApp::REGISTRY_MEDIAWIKI))
		     ->will($this->returnValue($registry));

		$this->application->registerExtensionFunction($function);
	}

	public function testRegisteringExtensionMessageFileProxiesToMediaWikiRegistry() {
		$path = 'filepath';
		$name = 'name';

		$registry = $this->getMock('WikiaGlobalsRegistry');
		$registry->expects($this->once())
		         ->method('set')
		         ->with($this->equalTo('wgExtensionMessagesFiles'), $this->equalTo($path), $this->equalTo($name));

		$this->registry
		     ->expects($this->once())
		     ->method('getRegistry')
		     ->with($this->equalTo(WikiaApp::REGISTRY_MEDIAWIKI))
		     ->will($this->returnValue($registry));

		$this->application->registerExtensionMessageFile($name, $path);
	}

	public function testRegisteringExtensionAliasFileProxiesToMediaWikiRegistry() {
		$path = 'filepath';
		$name = 'name';

		$registry = $this->getMock('WikiaGlobalsRegistry');
		$registry->expects($this->once())
		         ->method('set')
		         ->with($this->equalTo('wgExtensionAliasesFiles'), $this->equalTo($path), $this->equalTo($name));

		$this->registry
		     ->expects($this->once())
		     ->method('getRegistry')
		     ->with($this->equalTo(WikiaApp::REGISTRY_MEDIAWIKI))
		     ->will($this->returnValue($registry));

		$this->application->registerExtensionAliasFile($name, $path);
	}

	public function testRegisteringSpecialPageProxiesToMediaWikiRegistry() {
		$name = 'name';
		$class = 'SpecialPageClass';

		$registry = $this->getMock('WikiaGlobalsRegistry');
		$registry->expects($this->once())
		         ->method('set')
		         ->with($this->equalTo('wgSpecialPages'), $this->equalTo($class), $this->equalTo($name));

		$this->registry
		     ->expects($this->once())
		     ->method('getRegistry')
		     ->with($this->equalTo(WikiaApp::REGISTRY_MEDIAWIKI))
		     ->will($this->returnValue($registry));

		$this->application->registerSpecialPage($name, $class);
	}

	public function testGettingGlobalProxiesToMediaWikiRegistry() {
		$name = 'name';

		$registry = $this->getMock('WikiaGlobalsRegistry');
		$registry->expects($this->once())
		         ->method('get')
		         ->with($this->equalTo($name));

		$this->registry
		     ->expects($this->once())
		     ->method('getRegistry')
		     ->with($this->equalTo(WikiaApp::REGISTRY_MEDIAWIKI))
		     ->will($this->returnValue($registry));

		$this->application->getGlobal($name);
	}

	public function testSettingGlobalProxiesToMediaWikiRegistry() {
		$name = 'name';
		$value = 'value';

		$registry = $this->getMock('WikiaGlobalsRegistry');
		$registry->expects($this->once())
		         ->method('set')
		         ->with($this->equalTo($name), $this->equalTo($value));

		$this->registry
		     ->expects($this->once())
		     ->method('getRegistry')
		     ->with($this->equalTo(WikiaApp::REGISTRY_MEDIAWIKI))
		     ->will($this->returnValue($registry));

		$this->application->setGlobal($name, $value);
	}
}
