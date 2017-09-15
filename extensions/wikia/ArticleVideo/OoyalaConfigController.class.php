<?php

class OoyalaConfigController extends WikiaController {
	const CONFIG = [
		'general' => [
			'watermark' => [
				'imageResource' => [
					'url' => '',
					'androidResource' => 'logo',
					'iosResource' => 'logo',
				],
				'position' => 'bottomRight',
				'clickUrl' => '',
				'target' => '_blank',
				'transparency' => 1,
				'scalingOption' => 'default',
				'scalingPercentage' => 20,
			],
			'loadingImage' => [
				'imageResource' => [
					'url' => '//player.ooyala.com/static/v4/stable/4.10.6/skin-plugin/assets/images/loader_svg.svg',
				],
			],
			'accentColor' => '#00b7e0',
		],
		'localization' => [
			'defaultLanguage' => 'en',
			'availableLanguageFile' => [
				0 => [
					'language' => 'en',
					'androidResource' => 'skin-config/en.json',
					'iosResource' => 'en',
				],
			],
		],
		'responsive' => [
			'breakpoints' => [
				'xs' => [
					'id' => 'xs',
					'name' => 'oo-xsmall',
					'maxWidth' => 559,
					'multiplier' => 0.69999999999999996,
				],
				'sm' => [
					'id' => 'sm',
					'name' => 'oo-small',
					'minWidth' => 560,
					'maxWidth' => 839,
					'multiplier' => 1,
				],
				'md' => [
					'id' => 'md',
					'name' => 'oo-medium',
					'minWidth' => 840,
					'maxWidth' => 1279,
					'multiplier' => 1,
				],
				'lg' => [
					'id' => 'lg',
					'name' => 'oo-large',
					'minWidth' => 1280,
					'multiplier' => 1.2,
				],
			],
			'aspectRatio' => 'auto',
		],
		'startScreen' => [
			'promoImageSize' => 'default',
			'showPlayButton' => true,
			'playButtonPosition' => 'center',
			'playIconStyle' => [
				'opacity' => 1,
			],
			'showTitle' => true,
			'showDescription' => false,
			'titleFont' => [],
			'descriptionFont' => [
				'color' => 'white',
			],
			'infoPanelPosition' => 'topLeft',
			'showPromo' => true,
		],
		'pauseScreen' => [
			'showPauseIcon' => true,
			'pauseIconPosition' => 'center',
			'PauseIconStyle' => [
				'color' => 'white',
				'opacity' => 1,
			],
			'showTitle' => true,
			'showDescription' => false,
			'infoPanelPosition' => 'topLeft',
			'screenToShowOnPause' => 'default',
		],
		'endScreen' => [
			'screenToShowOnEnd' => 'discovery',
			'showReplayButton' => true,
			'replayIconStyle' => [
				'color' => 'white',
				'opacity' => 1,
			],
			'showTitle' => false,
			'showDescription' => false,
			'infoPanelPosition' => 'topLeft',
		],
		'adScreen' => [
			'showAdMarquee' => true,
			'showAdCountDown' => true,
			'showControlBar' => true,
		],
		'shareScreen' => [
			'shareContent' => [
				0 => 'social',
				1 => 'embed',
			],
			'embed' => [
				'source' => "<iframe width='640' height='480' frameborder='0' allowfullscreen src='//player.ooyala.com/static/v4/stable/4.10.6/skin-plugin/iframe.html?ec=<ASSET_ID>&pbid=<PLAYER_ID>&pcode=<PUBLISHER_ID>'></iframe>",
			],
		],
		"discoveryScreen" => [
			"showCountDownTimerOnEndScreen" => true,
			"countDownTime" => 5
		],
		'upNext' => [
			'showUpNext' => false,
			'timeToShow' => '10',
		],
		'controlBar' => [
			'volumeControl' => [
				'color' => '#FFFFFF',
			],
			'iconStyle' => [
				'active' => [
					'color' => '#FFFFFF',
					'opacity' => 1,
				],
				'inactive' => [
					'color' => '#FFFFFF',
					'opacity' => 0.94999999999999996,
				],
			],
			'autoHide' => true,
			'logo' => [
				'imageResource' => [
					'url' => '//player.ooyala.com/static/v4/stable/4.6.9/skin-plugin/assets/images/ooyala-logo.svg',
					'androidResource' => 'logo',
					'iosResource' => 'logo',
				],
				'clickUrl' => 'http://www.ooyala.com',
				'target' => '_blank',
				'width' => 0,
				'height' => 24,
			],
			'adScrubberBar' => [
				'backgroundColor' => 'rgba(175,175,175,1)',
				'bufferedColor' => 'rgba(127,127,127,1)',
				'playedColor' => 'rgba(255,63,128,1)',
				'scrubberHandleColor' => 'rgba(67,137,255,1)',
				'scrubberHandleBorderColor' => 'rgba(255,255,255,1)',
			],
			'scrubberBar' => [
				'backgroundColor' => 'rgba(175,175,175,0.5)',
				'bufferedColor' => 'rgba(175,175,175,0.7)',
				'playedColor' => '',
				'scrubberHandleColor' => '#00b7e0',
				'scrubberHandleBorderColor' => 'rgba(255,255,255,1)',
				'thumbnailPreview' => true,
			],
		     'autoplayToggle' => true,

			// to set autoplay cookie name use:
		    // 'autoplayCookieName': 'cookie-name'
		],
		'buttons' => [
			'desktopContent' => [
				[
					'name' => 'playPause',
					'location' => 'controlBar',
					'whenDoesNotFit' => 'keep',
					'minWidth' => 45,
				],
				[
					'name' => 'volume',
					'location' => 'controlBar',
					'whenDoesNotFit' => 'keep',
					'minWidth' => 240,
				],
				[
					'name' => 'adTimeLeft',
					'location' => 'controlBar',
					'whenDoesNotFit' => 'keep',
					'minWidth' => 100,
				],
				[
					'name' => 'live',
					'location' => 'controlBar',
					'whenDoesNotFit' => 'keep',
					'minWidth' => 45,
				],
				[
					'name' => 'timeDuration',
					'location' => 'controlBar',
					'whenDoesNotFit' => 'drop',
					'minWidth' => 145,
				],
				[
					'name' => 'flexibleSpace',
					'location' => 'controlBar',
					'whenDoesNotFit' => 'keep',
					'minWidth' => 1,
				],
				[
					'name' => 'share',
					'location' => 'controlBar',
					'whenDoesNotFit' => 'drop',
					'minWidth' => 45,
				],
				[
					'name' => 'quality',
					'location' => 'controlBar',
					'whenDoesNotFit' => 'drop',
					'minWidth' => 45,
				],
				[
					'name' => 'fullscreen',
					'location' => 'controlBar',
					'whenDoesNotFit' => 'keep',
					'minWidth' => 45,
				]
			],
		],
		'icons' => [
			'play' => [// svg set in skin()
			],
			'pause' => [// svg set in skin()
			],
			'volume' => [// svg set in skin()
			],
			'volumeOff' => [// svg set in skin()
			],
			'expand' => [// svg set in skin()
			],
			'compress' => [// svg set in skin()
			],
			'ellipsis' => [
				'fontFamilyName' => 'ooyala-slick-type',
				'fontString' => 'f',
				'fontStyleClass' => 'oo-icon oo-icon-system-menu',
			],
			'replay' => [
				'fontFamilyName' => 'ooyala-slick-type',
				'fontString' => 'c',
				'fontStyleClass' => 'oo-icon oo-icon-system-replay',
			],
			'share' => [// svg set in skin()
			],
			'cc' => [
				'fontFamilyName' => 'ooyala-slick-type',
				'fontString' => 'k',
				'fontStyleClass' => 'oo-icon oo-icon-cc',
			],
			'discovery' => [
				'fontFamilyName' => 'ooyala-slick-type',
				'fontString' => 'l',
				'fontStyleClass' => 'oo-icon oo-icon-discovery-binoculars',
			],
			'quality' => [// svg set in skin()
			],
			'setting' => [
				'fontFamilyName' => 'ooyala-slick-type',
				'fontString' => 'n',
				'fontStyleClass' => 'oo-icon oo-icon-system-settings',
			],
			'dismiss' => [// svg set in skin()
			],
			'toggleOn' => [
				'fontFamilyName' => 'fontawesome',
				'fontString' => '',
				'fontStyleClass' => '',
			],
			'toggleOff' => [
				'fontFamilyName' => 'fontawesome',
				'fontString' => '',
				'fontStyleClass' => '',
			],
			'left' => [
				'fontFamilyName' => 'ooyala-slick-type',
				'fontString' => 'r',
				'fontStyleClass' => 'oo-icon oo-icon-system-left-arrow',
			],
			'right' => [
				'fontFamilyName' => 'ooyala-slick-type',
				'fontString' => 's',
				'fontStyleClass' => 'oo-icon oo-icon-system-right-arrow',
			],
			'learn' => [
				'fontFamilyName' => 'ooyala-slick-type',
				'fontString' => 't',
				'fontStyleClass' => 'oo-icon oo-icon-system-more-information',
			],
			'skip' => [
				'fontFamilyName' => 'ooyala-slick-type',
				'fontString' => 'u',
				'fontStyleClass' => 'oo-icon oo-icon-skip-slick',
			],
			'warning' => [
				'fontFamilyName' => 'fontawesome',
				'fontString' => '',
				'fontStyleClass' => '',
			],
			'auto' => [
				'fontFamilyName' => 'ooyala-slick-type',
				'fontString' => 'd',
				'fontStyleClass' => 'oo-icon oo-icon-system-auto',
			],
		],
	];

	public function skin() {
		global $wgCookieDomain;

		$config = self::CONFIG;
		$config['icons']['play']['svg'] = DesignSystemHelper::renderSvg( 'wds-icons-play-triangle-small' );
		$config['icons']['pause']['svg'] = DesignSystemHelper::renderSvg( 'wds-icons-pause-small' );
		$config['icons']['volume']['svg'] = DesignSystemHelper::renderSvg( 'wds-icons-volume-small' );
		$config['icons']['volumeOff']['svg'] = DesignSystemHelper::renderSvg( 'wds-icons-volume-off-small' );
		$config['icons']['expand']['svg'] = DesignSystemHelper::renderSvg( 'wds-icons-fullscreen-small' );
		$config['icons']['compress']['svg'] = DesignSystemHelper::renderSvg( 'wds-icons-fullscreen-off-small' );
		$config['icons']['share']['svg'] = DesignSystemHelper::renderSvg( 'wds-icons-share-small' );
		$config['icons']['quality']['svg'] = DesignSystemHelper::renderSvg( 'wds-icons-gear-small' );
		$config['icons']['shareTwitter']['svg'] = DesignSystemHelper::renderSvg( 'wds-icons-twitter' );
		$config['icons']['shareFacebook']['svg'] = DesignSystemHelper::renderSvg( 'wds-icons-facebook' );
		$config['icons']['shareGoogle']['svg'] = DesignSystemHelper::renderSvg( 'wds-icons-googleplus' );
		$config['icons']['shareMail']['svg'] = DesignSystemHelper::renderSvg( 'wds-icons-mail' );
		$config['icons']['dismiss']['svg'] = DesignSystemHelper::renderSvg( 'wds-icons-cross' );

		$config['localization']['availableLanguageFile'][0]['languageFile'] =
			'/extensions/wikia/ArticleVideo/bower_components/skin-config/languageFiles/en.json';

		if ( $this->getVal( 'isMobile' ) ) {
			$config['controlBar']['volumeControl']['sliderVisible'] = false;
		}

		$config['controlBar']['autoplayCookieDomain'] = $wgCookieDomain;

		$this->getResponse()->setData( $config );
		$this->getResponse()->setFormat( WikiaResponse::FORMAT_JSON );
		$this->getResponse()->setCacheValidity( WikiaResponse::CACHE_LONG );
	}
}
