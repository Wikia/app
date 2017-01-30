<?php

/**
 * Created by PhpStorm.
 * User: ryba
 * Date: 30/01/2017
 * Time: 12:13
 */
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
					'param-name' => 'some-param',
					'tracking_label' => 'label',
					'subtitle' => [
						'type' => 'translatable-text',
						'key' => 'some-subtitle',
					]
				]
			]
		];
	}

}