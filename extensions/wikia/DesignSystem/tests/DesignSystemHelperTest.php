<?php

class DesignSystemHelperTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../DesignSystem.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider renderTextProvider
	 *
	 * @param $fields
	 * @param $messages
	 * @param $expected
	 */
	public function testRenderText( $fields, $messages, $expected ) {
		foreach ( $messages as $key => $value ) {
			$this->mockMessage( $key, $value );
		}

		$this->assertEquals( $expected, DesignSystemHelper::renderText( $fields ) );
	}

	public function renderTextProvider() {
		return [
			[
				'fields' => [
					'type' => 'translatable-text',
					'key' => 'global-footer-licensing-and-vertical-description',
					'params' => [
						'sitename' => [
							'type' => 'text',
							'value' => 'Muppet Wiki'
						],
						'vertical' => [
							'type' => 'translatable-text',
							'key' => 'global-footer-licensing-and-vertical-description-param-vertical-tv'
						],
						'license' => [
							'type' => 'link-text',
							'title' => [
								'type' => 'text',
								'value' => 'CC-BY-SA'
							],
							'href' => 'http://wikia.com/Licensing'
						]
					]
				],
				'messages' => [
					'global-footer-licensing-and-vertical-description' => '$1 is a Fandom $2 Community. Content is available under $3.',
					'global-footer-licensing-and-vertical-description-param-vertical-tv' => 'TV'
				],
				'expected' => 'Muppet Wiki is a Fandom TV Community. Content is available under <a href="http://wikia.com/Licensing">CC-BY-SA</a>.'
			],
		];
	}
}
