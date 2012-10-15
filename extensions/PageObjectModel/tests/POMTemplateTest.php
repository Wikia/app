<?php
require_once 'PHPUnit/Framework.php';
require_once 'POM.php';
 
class POMTemplateTest extends PHPUnit_Framework_TestCase
{
	#
	# Testing template pass-through behavior
	#

	# TODO add more data
	public static function templateStringsProvider()
	{
		return array(
			array( '{{sometemplate|var1=var2}}' ),
			array( '{{title with spaces|var1=var2}}' ),
			array( '{{sometemplate| field name with spaces=var2}}' ),
			array( '{{sometemplate|var1=value with spaces}}' ),
			array( '{{sometemplate|1234|var1=value with spaces}}' ),
			array( '{{sometemplate|a=b|b=c|numbered}}' )
		);
	}

	/**
	 * @dataProvider templateStringsProvider 
	 */
	public function testTemplateMustPreserveOrderOfParameters( $templatestring )
	{
		$template = new POMTemplate( $templatestring );
		$this->assertEquals( $template->asString(), $templatestring );
	}

	# -------------------------------------------------------------------------------------------------------
	#
	# Testing getting parameter values
	#

	# TODO add more data
	public static function parameterGetNameValueProvider()
	{
		return array(
			array( '{{sometemplate|var1=var2}}', 'var1', 'var2' ),
			array( '{{title with spaces|var1=var2}}', 'var1', 'var2' ),
			array( '{{sometemplate| field name with spaces=var2}}', 'field name with spaces', 'var2' ),
			array( '{{sometemplate|var1=value with spaces}}', 'var1', 'value with spaces' ),
			array( '{{sometemplate|1234|var1=value with spaces}}', 'var1', 'value with spaces' ),
			array( '{{sometemplate|a=b|b=c|numbered}}', 'a', 'b' ),
			array( '{{sometemplate|a=b|b=c|numbered}}', 'b', 'c' ),
			array( '{{sometemplate|a=b|b=c|numbered}}', 1, 'numbered' ),
			array( '{{sometemplate|var1=var2}}', 'noexistent', null )
		);
	}

	/**
	 * @dataProvider parameterGetNameValueProvider 
	 */
	public function testTemplateGetParameter( $templatestring, $name, $value )
	{
		$template = new POMTemplate( $templatestring );
		$this->assertEquals( $value, $template->getParameter( $name ) );
	}


	# -------------------------------------------------------------------------------------------------------
	#
	# Testing setting parameter values
	#

	# TODO add more data
	public static function parameterChangeNameValueProvider()
	{
		return array(
			array( '{{sometemplate|a=b|b=c|numbered}}',
				1,
				'renumbered',
				'{{sometemplate|a=b|b=c|renumbered}}' ),
			array( '{{sometemplate|a=b|b=c|numbered 1|numbered 2}}',
				2,
				'renumbered 2',
				'{{sometemplate|a=b|b=c|numbered 1|renumbered 2}}' ),
			array( '{{sometemplate|a=b|b=c|numbered 1|numbered 2}}',
				3,
				'new numbered',
				'{{sometemplate|a=b|b=c|numbered 1|numbered 2|new numbered}}' ),
			array( '{{sometemplate|var1=var2}}',
				'var1',
				'var3',
				'{{sometemplate|var1=var3}}' ),
			array( '{{sometemplate|var1= var2}}',
				'var1',
				'var3',
				'{{sometemplate|var1= var3}}' ),
			array( '{{sometemplate|var1 =var2}}',
				'var1',
				'var3',
				'{{sometemplate|var1 =var3}}' ),
			array( '{{title with spaces|var1=var2}}',
				'var1',
				'var3',
				'{{title with spaces|var1=var3}}' ),
			array( '{{sometemplate| field name with spaces=var2}}',
				'field name with spaces',
				'var3',
				'{{sometemplate| field name with spaces=var3}}' ),
			array( '{{sometemplate|var1=value with spaces}}',
				'var1',
				'value with spaces 2',
				'{{sometemplate|var1=value with spaces 2}}' ),
			array( '{{sometemplate|1234|var1=value with spaces}}',
				'var1',
				'value with spaces 2',
				'{{sometemplate|1234|var1=value with spaces 2}}' ),
			array( '{{sometemplate|a=b|b=c|numbered}}',
				'a',
				'd',
				'{{sometemplate|a=d|b=c|numbered}}' ),
			array( '{{sometemplate|a=b|b=c|numbered}}',
				'x',
				'y',
				'{{sometemplate|a=b|b=c|numbered|x=y}}' )
		);
	}

	/**
	 * @dataProvider parameterChangeNameValueProvider 
	 */
	public function testTemplateParameterChange( $orig, $index, $value, $result )
	{
		$template = new POMTemplate( $orig );
		$template->setParameter( $index, $value );
		$this->assertEquals( $result, $template->asString() );
	}

	# TODO add more data
	public static function parameterChangeSpacedNameValueProvider()
	{
		return array(
			array( '{{sometemplate|a=b|b=c|numbered}}',
				' 1',
				'renumbered',
				'{{sometemplate|a=b|b=c|renumbered}}' ),
			array( '{{sometemplate|a=b|b=c|numbered 1|numbered 2}}',
				' 2 ',
				'renumbered 2',
				'{{sometemplate|a=b|b=c|numbered 1|renumbered 2}}' ),
			array( '{{sometemplate|a=b|b=c|numbered 1|numbered 2}}',
				'3 ',
				'new numbered',
				'{{sometemplate|a=b|b=c|numbered 1|numbered 2|new numbered}}' ),
			array( '{{sometemplate|var1=var2}}',
				' var1 ',
				' var3',
				'{{sometemplate| var1 = var3}}' ),
			array( '{{sometemplate|var1= var2}}',
				' var1 ',
				' var3 ',
				'{{sometemplate| var1 = var3 }}' ),
			array( '{{sometemplate|var1 =var2}}',
				' var1 ',
				' var3 ',
				'{{sometemplate| var1 = var3 }}' ),
			array( '{{title with spaces|var1=var2}}',
				' var1 ',
				' var3 ',
				'{{title with spaces| var1 = var3 }}' ),
			array( '{{sometemplate| field name with spaces=var2}}',
				'field name with spaces  ',
				'var3  ',
				'{{sometemplate|field name with spaces  =var3  }}' ),
			array( '{{sometemplate| var1 = value with spaces }}',
				'var1',
				'value with spaces 2',
				'{{sometemplate|var1=value with spaces 2}}' ),
			array( '{{sometemplate|1234|var1=  value with spaces}}',
				'var1',
				'value with spaces 2',
				'{{sometemplate|1234|var1=value with spaces 2}}' ),
			array( '{{sometemplate|a =b | b = c|numbered}}',
				'a',
				'd',
				'{{sometemplate|a=d| b = c|numbered}}' ),
			array( '{{sometemplate| a =b|b=c|numbered}}',
				'x ',
				' y',
				'{{sometemplate| a =b|b=c|numbered|x = y}}' )
		);
	}
	/**
	 * @dataProvider parameterChangeSpacedNameValueProvider
	 */
	public function testTemplateParameterChangeHonoringSpacing( $orig, $index, $value, $result )
	{
		$template = new POMTemplate( $orig );
		$template->setParameter( $index, $value, false, false, true, true );
		$this->assertEquals( $result, $template->asString() );
	}

	public function testParameterWithEmptyNameShouldBeIgnoredButPreserved()
	{
		$somestring = '{{tempname|name=val1|=val2}}';
		$template = new POMTemplate( $somestring );
		$this->assertEquals( $somestring, $template->asString() );
	}

	/**
	 * @expectedException WrongParameterNameException 
	 */
	public function testThrowExceptionOnGettingParameterByEmptyName()
	{
		$somestring = '{{tempname|name=val1}}';
		$template = new POMTemplate( $somestring );
		$res = $template->getParameter( ' ' );
	}

	/**
	 * @expectedException WrongParameterNameException 
	 */
	public function testThrowExceptionSettingParameterByEmptyName()
	{
		$somestring = '{{tempname|name=val1}}';
		$template = new POMTemplate( $somestring );
		$res = $template->setParameter( ' ', 'value' );
	}
}
