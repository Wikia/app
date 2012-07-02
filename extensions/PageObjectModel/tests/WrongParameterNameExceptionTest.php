<?php
require_once 'PHPUnit/Framework.php';
require_once 'POM.php';
 
class WrongParameterNameExceptionTest extends PHPUnit_Framework_TestCase
{
	public function testWrongParameterNameExceptionMustContainMessage()
	{
		$e = new WrongParameterNameException( "Can't get parameter with no name" );
		$this->assertEquals(
			"WrongParameterNameException: [0]: Can't get parameter with no name\n",
			$e->__toString()
		);
	}
}
