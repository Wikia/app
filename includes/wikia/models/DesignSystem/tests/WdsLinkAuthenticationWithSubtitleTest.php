<?php

class WdsLinkAuthenticationWithSubtitleTest extends WikiaBaseTest {
	/**
	 * @param $paramName
	 * @param $title
	 * @param $subtitle
	 * @param $href
	 * @param $label
	 * @param $expected
	 *
	 * @dataProvider withTextObjectDataProvider
	 */
	public function testWithTranslatableTextObject( $paramName, $title, $subtitle, $href, $label, $expected ) {
		$link = ( new WdsLinkAuthenticationWithSubtitle() )->setTrackingLabel( $label )
			->setTranslatableSubtitle( $subtitle )
			->setHref( $href )
			->setTranslatableTitle( $title )
			->setParamName( $paramName );
		$this->assertEquals( json_encode( $expected ), json_encode( $link ) );
	}

	public function withTextObjectDataProvider() {
		return [
			[
				'paramName' => 'some-param',
				'title' => 'some-title',
				'subtitle' => 'some-subtitle',
				'href' => 'some.href.com',
				'label' => 'label',
				'expected' => [
					'type' => 'link-authentication',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'some-title'
					],
					'href' => 'some.href.com',
					'tracking_label' => 'label',
					'subtitle' => [
						'type' => 'translatable-text',
						'key' => 'some-subtitle',
					],
					'param-name' => 'some-param',
				]
			]
		];
	}

}
