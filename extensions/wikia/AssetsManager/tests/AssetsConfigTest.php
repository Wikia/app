<?php

require_once(dirname(__FILE__).'/../AssetsConfig.class.php');

class AssetsConfigTest extends PHPUnit_Framework_TestCase {

	public function testResolveNotExistingGroup() {
		$ac = new AssetsConfig();
		$res = $ac->resolve('non_existing_group');
		$this->assertEquals(array(), $res);
	}

	public function resolvePathDataProvider() {
		return array(
			array('single_path_group', array('//single/path/to/file/css/or/js'), false, false, array('single/path/to/file/css/or/js')),
			array('single_url_group', array('http://www.wikia.com'), false, false, array('http://www.wikia.com')),
		);
	}
	
	/**
	 * @dataProvider resolvePathDataProvider
	 */
	public function testResolvePath($groupName, $groupConfig, $combine, $minify, $expectedResult) {
		$ac = $this->getMock('AssetsConfig', array('getGroupConfig'));
		$ac->expects($this->once())
		   ->method('getGroupConfig')
		   ->with($this->equalTo($groupName))
		   ->will($this->returnValue($groupConfig));
		
		$res = $ac->resolve($groupName, $combine, $minify);
		$this->assertEquals($expectedResult, $res);		
	}

}