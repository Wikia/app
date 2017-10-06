<?php
use PHPUnit\Framework\TestCase;

/**
 * @ingroup mwabstract
 */
class WikiaAppTest extends TestCase {
	/* @var WikiaApp */
	private $application;
	/* @var PHPUnit_Framework_MockObject_MockObject */
	private $globalRegistry;
	/* @var PHPUnit_Framework_MockObject_MockObject */
	private $localRegistry;

	protected function setUp() {
		$this->globalRegistry = $this->createMock( WikiaGlobalRegistry::class );
		$this->localRegistry = $this->createMock( WikiaLocalRegistry::class );
		$this->application = new WikiaApp($this->globalRegistry, $this->localRegistry );
	}

	public function testDefaultRegistryInstances() {
		$application = new WikiaApp();

		$this->assertInstanceOf('WikiaGlobalRegistry', $application->getGlobalRegistry());
		$this->assertInstanceOf('WikiaLocalRegistry', $application->getLocalRegistry());
	}

	public function testRegisteringClassProxiesToMediaWikiRegistry() {
		$path = 'filepath';
		$class = 'HookClass';

		$registry = $this->createMock( WikiaGlobalRegistry::class );
		$registry->expects($this->once())
		         ->method('set')
		         ->with($this->equalTo('wgAutoloadClasses'), $this->equalTo($path), $this->equalTo($class));
		$this->application->setGlobalRegistry($registry);
		$this->application->registerClass($class, $path);
	}

	public function testRegisteringExtensionFunctionProxiesToMediaWikiRegistry() {
		$function = 'extensionFunction';

		$registry = $this->createMock( WikiaGlobalRegistry::class );
		$registry->expects($this->once())
		         ->method('append')
		         ->with($this->equalTo('wgExtensionFunctions'), $this->equalTo($function));
		$this->application->setGlobalRegistry($registry);
		$this->application->registerExtensionFunction($function);
	}

	public function testRegisteringSpecialPageProxiesToMediaWikiRegistry() {
		$name = 'name';
		$class = 'SpecialPageClass';

		$registry = $this->createMock( WikiaGlobalRegistry::class );
		$registry->expects($this->once())
		         ->method('set')
		         ->with($this->equalTo('wgSpecialPages'), $this->equalTo($class), $this->equalTo($name));
		$this->application->setGlobalRegistry($registry);
		$this->application->registerSpecialPage($name, $class);
	}

	public function testGettingGlobalProxiesToMediaWikiRegistry() {
		$name = 'name';

		$registry = $this->createMock( WikiaGlobalRegistry::class );
		$registry->expects($this->once())
		         ->method('get')
		         ->with($this->equalTo($name));

		$this->application->setGlobalRegistry($registry);
		$this->application->getGlobal($name);
	}

	public function testSettingGlobalProxiesToMediaWikiRegistry() {
		$name = 'name';
		$value = 'value';

		$registry = $this->createMock( WikiaGlobalRegistry::class );
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

		$registry = $this->createMock( WikiaGlobalRegistry::class );
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
