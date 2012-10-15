<?php
/**
 * @ingroup mwabstract
 */
class WikiaAppTest extends PHPUnit_Framework_TestCase {
	/* @var WikiaApp */
	private $application;
	/* @var PHPUnit_Framework_MockObject_MockObject */
	private $globalRegistry;
	/* @var PHPUnit_Framework_MockObject_MockObject */
	private $localRegistry;
	/* @var PHPUnit_Framework_MockObject_MockObject */
	private $hookDispatcher;

	protected function setUp() {
		$this->globalRegistry = $this->getMock('WikiaGlobalRegistry');
		$this->localRegistry = $this->getMock('WikiaLocalRegistry');
		$this->hookDispatcher = $this->getMock('WikiaHookDispatcher');
		$this->application = new WikiaApp($this->globalRegistry, $this->localRegistry, $this->hookDispatcher);
	}

	public function testDefaultRegistryAndHookDispatcherInstances() {
		$application = new WikiaApp();
		$this->assertInstanceOf('WikiaHookDispatcher', $application->getHookDispatcher());
		$this->assertInstanceOf('WikiaGlobalRegistry', $application->getGlobalRegistry());
		$this->assertInstanceOf('WikiaLocalRegistry', $application->getLocalRegistry());
	}

	public function testRegisteringHookProxiesToWikiaHookDispatcherAndMediaWikiRegistry() {
		$hookName = 'HookName';
		$class = 'HookClass';
		$method = 'HookMethod';
		$options = array('HookOptions');
		$rebuild = true;
		$callback = array();

		$registry = $this->getMock('WikiaGlobalRegistry');
		$registry->expects($this->once())
		         ->method('append')
		         ->with($this->equalTo('wgHooks'), $this->equalTo($callback), $this->equalTo($hookName));

		$this->hookDispatcher
		     ->expects($this->once())
		     ->method('registerHook')
		     ->with($this->equalTo($class), $this->equalTo($method), $this->equalTo($options), $this->equalTo($rebuild))
		     ->will($this->returnValue($callback));

		$this->application->setGlobalRegistry($registry);

		$this->application->registerHook($hookName, $class, $method, $options, $rebuild);
	}

	public function testRegisteringClassProxiesToMediaWikiRegistry() {
		$path = 'filepath';
		$class = 'HookClass';

		$registry = $this->getMock('WikiaGlobalRegistry');
		$registry->expects($this->once())
		         ->method('set')
		         ->with($this->equalTo('wgAutoloadClasses'), $this->equalTo($path), $this->equalTo($class));
		$this->application->setGlobalRegistry($registry);
		$this->application->registerClass($class, $path);
	}

	public function testRegisteringExtensionFunctionProxiesToMediaWikiRegistry() {
		$function = 'extensionFunction';

		$registry = $this->getMock('WikiaGlobalRegistry');
		$registry->expects($this->once())
		         ->method('append')
		         ->with($this->equalTo('wgExtensionFunctions'), $this->equalTo($function));
		$this->application->setGlobalRegistry($registry);
		$this->application->registerExtensionFunction($function);
	}

	public function testRegisteringExtensionMessageFileProxiesToMediaWikiRegistry() {
		$path = 'filepath';
		$name = 'name';

		$registry = $this->getMock('WikiaGlobalRegistry');
		$registry->expects($this->once())
		         ->method('set')
		         ->with($this->equalTo('wgExtensionMessagesFiles'), $this->equalTo($path), $this->equalTo($name));
		$this->application->setGlobalRegistry($registry);
		$this->application->registerExtensionMessageFile($name, $path);
	}

	public function testRegisteringExtensionAliasFileProxiesToMediaWikiRegistry() {
		$path = 'filepath';
		$name = 'name';

		$registry = $this->getMock('WikiaGlobalRegistry');
		$registry->expects($this->once())
		         ->method('set')
		         ->with($this->equalTo('wgExtensionAliasesFiles'), $this->equalTo($path), $this->equalTo($name));
		$this->application->setGlobalRegistry($registry);
		$this->application->registerExtensionAliasFile($name, $path);
	}

	public function testRegisteringSpecialPageProxiesToMediaWikiRegistry() {
		$name = 'name';
		$class = 'SpecialPageClass';

		$registry = $this->getMock('WikiaGlobalRegistry');
		$registry->expects($this->once())
		         ->method('set')
		         ->with($this->equalTo('wgSpecialPages'), $this->equalTo($class), $this->equalTo($name));
		$this->application->setGlobalRegistry($registry);
		$this->application->registerSpecialPage($name, $class);
	}

	public function testGettingGlobalProxiesToMediaWikiRegistry() {
		$name = 'name';

		$registry = $this->getMock('WikiaGlobalRegistry');
		$registry->expects($this->once())
		         ->method('get')
		         ->with($this->equalTo($name));

		$this->application->setGlobalRegistry($registry);
		$this->application->getGlobal($name);
	}

	public function testSettingGlobalProxiesToMediaWikiRegistry() {
		$name = 'name';
		$value = 'value';

		$registry = $this->getMock('WikiaGlobalRegistry');
		$registry->expects($this->once())
		         ->method('set')
		         ->with($this->equalTo($name), $this->equalTo($value));

		$this->application->setGlobalRegistry($registry);
		$this->application->setGlobal($name, $value);
	}

	public function testGettingListOfGlobalsFromMediaWikiRegistry() {
		$globals = array(
					'global1' => new stdClass(),
					'global2' => new stdClass(),
					'global3' => 10
		);

		$registry = $this->getMock('WikiaGlobalRegistry');
		$registry->expects($this->exactly(5))
	         ->method('get')
	         ->will($this->onConsecutiveCalls(
	           $globals['global1'],
	           $globals['global2'],
	           $globals['global3'],
	           $globals['global3'],
	           $globals['global2'] ));

		$this->application->setGlobalRegistry($registry);
		$results = $this->application->getGlobals('global1', 'global2', 'global3');
		$this->assertEquals( array_values($globals), $results );

		list($global3, $global2) = $this->application->getGlobals('global3', 'global2');
		$this->assertEquals($globals['global3'], $global3);
		$this->assertEquals($globals['global2'], $global2);
	}
}
