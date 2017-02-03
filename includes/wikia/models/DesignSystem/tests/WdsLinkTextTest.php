<?php

class WdsLinkTextTest extends WikiaBaseTest {

	/**
	 * @param $title
	 * @param $href
	 * @param $label
	 * @param $expected
	 *
	 * @dataProvider withTextObjectDataProvider
	 */
	public function testWithTextObject( $title, $href, $label, $expected ) {
		$linkText = (new WdsLinkText())
			->setTitle( $title )
			->setHref( $href )
			->setTrackingLabel( $label );
		$this->assertEquals( json_encode( $expected ), json_encode( $linkText ) );
	}

	public function withTextObjectDataProvider() {
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
	 * @dataProvider withTranslatableTextObjectDataProvider
	 */
	public function testWithTranslatableTextObject( $title, $href, $label, $expected ) {
		$linkText = (new WdsLinkText())
			->setTranslatableTitle( $title )
			->setHref( $href )
			->setTrackingLabel( $label );
		$this->assertEquals( json_encode( $expected ), json_encode( $linkText ) );
	}

	public function withTranslatableTextObjectDataProvider() {
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
