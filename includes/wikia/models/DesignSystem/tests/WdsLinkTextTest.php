<?php

class WdsLinkTextTest extends WikiaBaseTest {

	/**
	 * @param $title
	 * @param $href
	 * @param $label
	 * @param $expected
	 *
	 * @dataProvider getWithTextObjectDataProvider
	 */
	public function testGetWithTextObject( $title, $href, $label, $expected ) {
		$linkText = (new WdsLinkText())
			->setTitle( $title )
			->setHref( $href )
			->setTrackingLabel( $label );
		$this->assertEquals( $expected, $linkText->get() );
	}

	public function getWithTextObjectDataProvider() {
		return [
			[
				'title' => 'some title',
				'href' => 'some.href.com',
				'label' => 'label',
				'expected' => [
					'type' => 'link-text',
					'title' => [
						'type' => 'text',
						'value' => 'some title'
					],
					'href' => 'some.href.com',
					'tracking_label' => 'label'
				]
			]
		];
	}

	/**
	 * @param $title
	 * @param $href
	 * @param $label
	 * @param $expected
	 *
	 * @dataProvider getWithTranslatableTextObjectDataProvider
	 */
	public function testGetWithTranslatableTextObject( $title, $href, $label, $expected ) {
		$linkText = (new WdsLinkText())
			->setTranslatableTitle( $title )
			->setHref( $href )
			->setTrackingLabel( $label );
		$this->assertEquals( $expected, $linkText->get() );
	}

	public function getWithTranslatableTextObjectDataProvider() {
		return [
			[
				'title' => 'some-title',
				'href' => 'some.href.com',
				'label' => 'label',
				'expected' => [
					'type' => 'link-text',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'some-title'
					],
					'href' => 'some.href.com',
					'tracking_label' => 'label'
				]
			]
		];
	}
}
