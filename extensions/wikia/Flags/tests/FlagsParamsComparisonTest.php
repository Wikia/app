<?php

class FlagsParamsComparisonTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../Flags.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider compareTemplateVariablesDataProvider
	 */
	public function testCompareTemplateVariables( $oldText, $newText, $flagVariables, $expected, $msg ) {
		$mockTitle = $this->getMock( 'Title' );

		$flagsParamsComparison = new Flags\FlagsParamsComparison();

		$result = $flagsParamsComparison->compareTemplateVariables( $mockTitle, $oldText, $newText, $flagVariables );

		asort( $result );
		asort( $result['params'] );
		asort( $expected );
		asort( $expected['params'] );

		$this->assertSame( $result, $expected, $msg );
	}

	public function compareTemplateVariablesDataProvider() {
		return [
			[
				'template without variables',
				'still template without variables',
				[],
				null,
				'Template without variables and without change'
			],
			[
				'template with {{{1}}} variable',
				'still template with the same {{{1}}} variable',
				[ 1 => 'parameter description' ],
				null,
				'Template with variables and without change'
			],
			[
				'template without variables',
				'template with new {{{newVar}}} variable',
				[],
				[
					'added' => [ 'newVar' ],
					'params' => [
						'newVar' => ''
					]
				],
				'Template with new variable added'
			],
			[
				'template without variables',
				'template with new {{{newVar}}} two {{{2}}} variables',
				[],
				[
					'added' => [ 'newVar', 2 ],
					'params' => [
						'newVar' => '', 2 => ''
					]
				],
				'Template with two new variables added'
			],
			[
				'template with {{{1}}} variable',
				'template with removed variable',
				[ 1 => 'parameter description' ],
				[
					'removed' => [ 1 ],
					'params' => []
				],
				'Template with all variables removed'
			],
			[
				'template with {{{1}}} and {{{2}}} variables',
				'template with {{{2}}} one variable removed',
				[ 1 => 'parameter 1 description', 2 => 'parameter 2 description' ],
				[
					'removed' => [ 1 ],
					'params' => [
						2 => 'parameter 2 description'
					]
				],
				'Template with one variable removed'
			],
			[
				'template with {{{1}}} and {{{2}}} variables',
				'template with {{{2}}} one variable removed and one {{{3}}} changed',
				[ 1 => 'parameter 1 description', 2 => 'parameter 2 description' ],
				[
					'added' => [ 3 ],
					'removed' => [ 1 ],
					'params' => [
						2 => 'parameter 2 description', 3 => ''
					]
				],
				'Template with one variable removed and one added'
			],
			[
				'template with {{{1}}} variable',
				'template with changed {{{2}}} variable',
				[ 1 => 'parameter description' ],
				[
					'changed' => [
						2 => [
							'old' => '1',
							'new' => '2'
						]
					],
					'params' => [
						2 => 'parameter description'
					]
				],
				'Template with changed variable name'
			],
			[
				'template with {{{1}}} and {{{2}}} and even three {{{third}}} variables',
				'template with {{{1}}} and even three {{{thirdChanged}}} variables',
				[ 1 => 'parameter description', 2 => 'second param description', 'third' => 'thirdParam' ],
				[
					'changed' => [
						'thirdChanged' => [
							'old' => 'third',
							'new' => 'thirdChanged'
						]
					],
					'removed' => [ 2 ],
					'params' => [
						1 => 'parameter description', 'thirdChanged' => 'thirdParam'
					]
				],
				'Template with first variable the same, second removed, third changed'
			],
			[
				'template with {{{1}}} and {{{2}}} and even three {{{third}}} variables',
				'template with {{{1}}} and {{{4}}} and even three {{{third}}} variables',
				[ 1 => 'parameter description', 2 => 'second param description', 'third' => 'thirdParam' ],
				[
					'changed' => [
						4 => [
							'old' => '2',
							'new' => '4'
						]
					],
					'params' => [
						1 => 'parameter description', 4 => 'second param description', 'third' => 'thirdParam'
					]
				],
				'Template with one variable changed'
			],
		];
	}
}
