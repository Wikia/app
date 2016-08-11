<?php

class TwitterTagTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../TwitterTag.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider prepareAttributesDataProvider
	 *
	 * @param array $passedAttributes
	 * @param array $permittedAttributes
	 * @param array $expectedResult
	 */
	public function testPrepareAttributes( $passedAttributes, $permittedAttributes, $expectedResult ) {
		$class = new TwitterTagController();
		$reflectedClass = new ReflectionClass( 'TwitterTagController' );
		$reflectedMethod = $reflectedClass->getMethod( 'prepareAttributes' );
		$reflectedMethod->setAccessible( true );

		$this->assertEquals(
			$reflectedMethod->invokeArgs( $class, [ $passedAttributes, $permittedAttributes ] ),
			$expectedResult
		);
	}

	public function prepareAttributesDataProvider() {
		return [
			[
				[ 'foo' => 'bar' ],
				[ ],
				[ 'data-height' => '500' ]
			],
			[
				[ 'foo' => 'bar' ],
				[ 'foo' => '/fizz/' ],
				[ 'data-height' => '500' ]
			],
			[
				[ 'foo' => 'bar' ],
				[ 'foo' => '/bar/' ],
				[ 'data-foo' => 'bar', 'data-height' => '500' ]
			],
			[
				[ 'foo' => 'BAR' ],
				[ 'foo' => '/bar/' ],
				[ 'data-height' => '500' ]
			],
			[
				[ 'foo' => 'BAR' ],
				[ 'foo' => '/bar/i' ],
				[ 'data-foo' => 'BAR', 'data-height' => '500' ]
			],
			[
				[ 'attr' => '0123456789' ],
				[ 'attr' => TwitterTagController::REGEX_DIGITS ],
				[ 'data-attr' => '0123456789' , 'data-height' => '500' ]
			],
			[
				[ 'attr' => 'NaN' ],
				[ 'attr' => TwitterTagController::REGEX_DIGITS ],
				[ 'data-height' => '500' ]
			],
			[
				[ 'attr' => '#bada55' ],
				[ 'attr' => TwitterTagController::REGEX_HEX_COLOR ],
				[ 'data-attr' => '#bada55', 'data-height' => '500' ]
			],
			[
				[ 'attr' => '#1ce' ],
				[ 'attr' => TwitterTagController::REGEX_HEX_COLOR ],
				[ 'data-attr' => '#1ce', 'data-height' => '500' ]
			],
			[
				[ 'attr' => '#beef' ],
				[ 'attr' => TwitterTagController::REGEX_HEX_COLOR ],
				[ 'data-height' => '500' ]
			],
			[
				[ 'attr' => 'GoodTestName_15' ],
				[ 'attr' => TwitterTagController::REGEX_TWITTER_SCREEN_NAME ],
				[ 'data-attr' => 'GoodTestName_15', 'data-height' => '500' ]
			],
			[
				[ 'attr' => 'TooLongTestName_18' ],
				[ 'attr' => TwitterTagController::REGEX_TWITTER_SCREEN_NAME ],
				[ 'data-height' => '500' ]
			],
			[
				[ '' => '' ],
				TwitterTagController::TAG_PERMITTED_ATTRIBUTES,
				[ 'data-height' => '500' ]
			],
			[
				[ 'widget-id' => '666' ],
				TwitterTagController::TAG_PERMITTED_ATTRIBUTES,
				[ 'data-widget-id' => '666', 'data-height' => '500' ]
			],
			[
				[ 'widget-id' => 'foo' ],
				TwitterTagController::TAG_PERMITTED_ATTRIBUTES,
				[ 'data-height' => '500' ]
			],
			[
				[
					'widget-id' => '123',
					'chrome' => 'transparent noborders noheader',
					'tweet-limit' => '12',
					'aria-polite' => 'assertive',
					'related' => 'twitter%3ATwitter%20News,twitterapi%3ATwitter%20API%20News',
					'lang' => 'pl',
					'theme' => 'dark',
					'link-color' => '#bada55',
					'border-color' => '#313373',
					'width' => '1920',
					'height' => '1080',
					'show-replies' => 'false',
					'screen-name' => 'Wikia',
					'user-id' => '1',
					'list-owner-screen-name' => '_',
					'list-owner-screen-id' => '42',
					'list-slug' => 'R2D2%/<>&',
					'list-id' => '112358132144',
				],
				TwitterTagController::TAG_PERMITTED_ATTRIBUTES,
				[
					'data-widget-id' => '123',
					'data-chrome' => 'transparent noborders noheader',
					'data-tweet-limit' => '12',
					'data-aria-polite' => 'assertive',
					'data-related' => 'twitter%3ATwitter%20News,twitterapi%3ATwitter%20API%20News',
					'data-lang' => 'pl',
					'data-theme' => 'dark',
					'data-link-color' => '#bada55',
					'data-border-color' => '#313373',
					'data-width' => '1920',
					'data-height' => '1080',
					'data-show-replies' => 'false',
					'data-screen-name' => 'Wikia',
					'data-user-id' => '1',
					'data-list-owner-screen-name' => '_',
					'data-list-owner-screen-id' => '42',
					'data-list-slug' => 'R2D2%/<>&',
					'data-list-id' => '112358132144',
				]
			],
			[
				[
					'widget-id' => 'faluty',
					'chrome' => 'nofooter',
					'tweet-limit' => 'twenty',
					'aria-polite' => 'polite',
					'lang' => 'Klingon',
					'theme' => 'light',
					'link-color' => '#hhh',
					'border-color' => '#123abc',
					'width' => '800',
					'height' => '100%',
					'show-replies' => 'true',
					'screen-name' => 'faulty-name',
					'user-id' => '1142492828',
					'list-owner-screen-id' => '1142492828',
					'list-slug' => '1 Bad List Name',
					'list-id' => '219735245',
				],
				TwitterTagController::TAG_PERMITTED_ATTRIBUTES,
				[
					'data-chrome' => 'nofooter',
					'data-aria-polite' => 'polite',
					'data-theme' => 'light',
					'data-border-color' => '#123abc',
					'data-width' => '800',
					'data-height' => '500',
					'data-show-replies' => 'true',
					'data-user-id' => '1142492828',
					'data-list-owner-screen-id' => '1142492828',
					'data-list-id' => '219735245',
				],
			],
		];
	}
}
