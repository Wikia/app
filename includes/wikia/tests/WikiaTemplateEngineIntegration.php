<?php
/**
 * @group Integration
 *
 * Integration test for Wikia Teamplate System.
 *
 * Covers:
 * * Wikia\Template\Engine
 * * Wikia\Template\PHPEngine and its integration with FS I/O
 * * Wikia\Template\MustacheEngine and its integration with the Mustache PHP extension
 *
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 * @see WikiaTemplateEngineTest for the unit test
 */
class WikiaTemplateEngineIntegration extends PHPUnit_Framework_TestCase {
	protected $path;

	protected function setUp() {
		$this->path = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . '_fixtures/templates';
	}

	public function engines() {
		return [
			//Class, suffix
			['Wikia\Template\PHPEngine', '.php'],
			['Wikia\Template\MustacheEngine', '.mustache']
		];
	}

	/**
	 * Simple usage, render one template.
	 *
	 * @dataProvider engines
	 */
	public function testSimpleUsage( $class, $suffix ) {
		$template = $this->path . DIRECTORY_SEPARATOR . __CLASS__ . "_simple1{$suffix}";

		$result = ( new $class )->render( $template );

		$this->assertEquals( $result, 'Foo' );
	}

	/**
	 * Failing simple usage, render missing template
	 *
	 * @dataProvider engines
	 * @expectedException Exception
	 */
	public function testSimpleMissingTemplate( $class, $suffix ) {
		( new $class )->render( "simplyMissing{$suffix}" );
	}

	/**
	 * Simple usage, render one template passing values.
	 *
	 * @dataProvider engines
	 */
	public function testSimpleUsageWithValue( $class, $suffix ) {
		$testValue = 'Bar';
		$template = $this->path . DIRECTORY_SEPARATOR . __CLASS__ . "_simple2{$suffix}";

		$result = ( new $class )
			->setVal( 'testValue', $testValue )
			->render( $template );

		$this->assertEquals( $result, $testValue );
	}

	/**
	 * @dataProvider engines
	 */
	public function testIntermediateUsage( $class, $suffix ) {
		$tplEngine = ( new $class )
			->setPrefix( $this->path );

		foreach ( [1, 2] as $i ) {
			$template = __CLASS__ . "_intermediate{$i}{$suffix}";

			$this->assertEquals(
				$tplEngine->render( $template ),
				"Test {$i} {$suffix}"
			);
		}
	}

	/**
	 * Advanced usage, render multiple templates sharing values and variating
	 * only some.
	 *
	 * @dataProvider engines
	 */
	public function testAdvancedUsage( $class, $suffix ) {
		$template1 = __CLASS__ . "_advanced1{$suffix}";
		$template2 = __CLASS__ . "_advanced2{$suffix}";
		$lastName = 'Flinstone';
		$city = 'Bedrock';
		$family = [
			['name' => 'Fred'   , 'birthdate' => '01/01/10000 BC'],
			['name' => 'Wilma'  , 'birthdate' => '05/02/9994 BC' ],
			['name' => 'Pebbles', 'birthdate' => '10/7/9963 BC'  ]
		];

		$tplEngine = ( new $class )
			->setPrefix( $this->path )
			->setData( [
				'lastName' => $lastName,
				'city' => $city
			] );

		$result = $tplEngine->render( $template1 );

		$this->assertEquals(
			$result,
			"{$lastName} family from {$city} {$suffix}"
		);

		foreach ( $family as $member ) {
			$result = $tplEngine
				->updateData( [
					'name' => $member['name'],
					'birthdate' => $member['birthdate']
				] )
				->render( $template2 );

			$this->assertEquals(
				$result,
				"* {$member['name']} {$lastName} - {$member['birthdate']} {$suffix}"
			);
		}
	}

	/**
	 * Tests different usages of Engine::exists()
	 *
	 * @dataProvider engines
	 */
	public function testExists( $class, $suffix ) {
		$path = $this->path . DIRECTORY_SEPARATOR;
		$existingTemplate = __CLASS__ . "_simple1{$suffix}";
		$missingTemplate = "missingTemplate{$suffix}";

		$tplEngine = ( new $class );
		$this->assertTrue( $tplEngine->exists( "{$path}{$existingTemplate}" ) );
		$this->assertFalse( $tplEngine->exists( "{$path}{$missingTemplate}" ) );

		$tplEngine = ( new $class )
			->setPrefix( $path );
		$this->assertTrue( $tplEngine->exists( $existingTemplate ) );
		$this->assertFalse( $tplEngine->exists( $missingTemplate ) );
	}
}
