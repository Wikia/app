<?php

class ScrollboxTemplateTest extends WikiaBaseTest {
	/**
	 * @param array $templateAgrs
	 * @param string $longestVal
	 *
	 * @dataProvider getTemplateArgsLongestValDataProvider
	 */
	public function testGetTemplateArgsLongestVal( $templateAgrs, $longestVal ) {
		$this->assertEquals( ScrollboxTemplate::getLongestElement( $templateAgrs ), $longestVal );
	}

	public function getTemplateArgsLongestValDataProvider() {
		return [
			[
				[
					'aaaaa',
					'aaa',
					'a'
				],
				'aaaaa',
			],
			[
				[
					'aaaaa',
					'',
				],
				'aaaaa',
			],
			[
				[
					'aaaaa'
				],
				'aaaaa',
			],
			[
				[
					'aaaaa1',
					'aaaaa2'
				],
				'aaaaa1',
			],
			[
				[
					'',
					''
				],
				'',
			]
		];
	}
}
