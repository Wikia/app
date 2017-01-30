<?php

/**
 * Created by PhpStorm.
 * User: ryba
 * Date: 30/01/2017
 * Time: 12:05
 */
class WdsLinkAuthenticationTest extends WikiaBaseTest {
	/**
	 * @param $paramName
	 * @param $title
	 * @param $href
	 * @param $label
	 * @param $expected
	 *
	 * @dataProvider withTextObjectDataProvider
	 */
	public function testWithTranslatableTextObject( $paramName, $title, $href, $label, $expected ) {
		$link = ( new WdsLinkAuthentication() )->setTrackingLabel( $label )
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
					'param-name' => 'some-param',
				]
			]
		];
	}

}