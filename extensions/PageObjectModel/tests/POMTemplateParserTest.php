<?php
require_once 'PHPUnit/Framework.php';
require_once 'POM.php';
 
class POMTeamplateParserTest extends PHPUnit_Framework_TestCase
{
    public function testTemplateParserMustFindTemplatesInTextNodes()
    {
	$sometext = "sometext\nbefore first with spaces     {{sometemplate|var1=var2}}\nbefore second {{someothertemplate}}   more text at the end\n";

	$page = new POMPage( $sometext );
	$this->assertTrue( is_a( $page->children[0], 'POMTextNode' ) );
        $this->assertEquals( "sometext\nbefore first with spaces     ", $page->children[0]->asString() );
	
	$this->assertTrue( is_a( $page->children[1], 'POMTemplate' ) );
        $this->assertEquals( '{{sometemplate|var1=var2}}', $page->children[1]->asString() );

	$this->assertTrue( is_a( $page->children[2], 'POMTextNode' ) );
        $this->assertEquals( "\nbefore second ", $page->children[2]->asString() );

	$this->assertTrue( is_a( $page->children[3], 'POMTemplate' ) );
        $this->assertEquals( '{{someothertemplate}}', $page->children[3]->asString() );

	$this->assertTrue( is_a( $page->children[4], 'POMTextNode' ) );
        $this->assertEquals( "   more text at the end\n", $page->children[4]->asString() );
    }

    public function testTemplateParserMustPopulateTemplatesCollection()
    {
	$sometext = "sometext\nbefore first with spaces     {{sometemplate |var1=var2}}\nbefore second {{ someothertemplate|param1 = 0}}   plus another  {{someothertemplate
|param2 = something
}}    more text  at the end\n";

	$page = new POMPage( $sometext );
	$this->assertEquals( count( $page->c['templates']['sometemplate'] ), 1 );
	$this->assertEquals( count( $page->c['templates']['someothertemplate'] ), 2 );
    }

    public function testTemplateParserMustCorrectlyParseTemplatesWithParameters()
    {
	$sometext = "sometext\nbefore first with spaces     {{sometemplate|var1=val1 {{subtemplate|subvar1=subval2}} val1 continue|var2=val2}}\nbefore second {{someothertemplate}}   more text at the end\n";

	$page = new POMPage( $sometext );
	$this->assertTrue( is_a( $page->children[0], 'POMTextNode' ) );
        $this->assertEquals( "sometext\nbefore first with spaces     ", $page->children[0]->asString() );
	
	$this->assertTrue( is_a( $page->children[1], 'POMTemplate' ) );
        $this->assertEquals( '{{sometemplate|var1=val1 {{subtemplate|subvar1=subval2}} val1 continue|var2=val2}}', $page->children[1]->asString() );

	$this->assertTrue( is_a( $page->children[2], 'POMTextNode' ) );
        $this->assertEquals( "\nbefore second ", $page->children[2]->asString() );

	$this->assertTrue( is_a( $page->children[3], 'POMTemplate' ) );
        $this->assertEquals( '{{someothertemplate}}', $page->children[3]->asString() );

	$this->assertTrue( is_a( $page->children[4], 'POMTextNode' ) );
        $this->assertEquals( "   more text at the end\n", $page->children[4]->asString() );
    }
}
