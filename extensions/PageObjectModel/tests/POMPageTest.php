<?php
require_once 'PHPUnit/Framework.php';
require_once 'POM.php';
 
class POMPageTest extends PHPUnit_Framework_TestCase
{
	# TODO add more data
	public static function pageProvider()
	{
		return array(
			array( '{{sometemplate|var1=var2}}' ),
			array( '{{title with spaces|var1=var2}}' ),
			array( '{{sometemplate| field name with spaces=var2}}' ),
			array( '{{sometemplate|var1=value with spaces}}' ),
			array( '{{sometemplate|1234|var1=value with spaces}}' ),
			array( '{{sometemplate|a=b|b=c|numbered}}' ),
			array( '{{sometemplate|a={{othertemplate|x=y}}|b=c|numbered}}' ),
			array( "sometext\nbefore first with spaces     {{sometemplate |var1=var2}}\nbefore second {{ someothertemplate|param1 = 0}}   plus another  {{someothertemplate
|param2 = something
}}    more text  at the end\n" )
		);
	}

	/**
	 * @dataProvider pageProvider
	 */
	public function testInputIsTheSameAsOutput( $pagetext )
	{
		$page = new POMPage( $pagetext );
		$this->assertEquals( $pagetext, $page->asString() );
	}
}
