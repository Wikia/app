require(['ext.wikia.adEngine.adContext', 'wikia.abTest', 'wikia.throttle'], function (adContext, abTest, throttle) {
	$(function () {
		var context = adContext.getContext();
		var $adAndRecircWrapper;
		var $topRightAd = $('#TOP_RIGHT_BOXAD');
		var $floatingMedrec = $('#INCONTENT_BOXAD_1');
		var $topRightAdWrapper = $('#top-right-boxad-wrapper');
		var $footer = $('#WikiaFooter');
		var $rail = $('#WikiaRail');
		var $recirc;
		var $recircWrapper;
		var $visibleElementBeforeWrapper;
		var $window = $(window);

		var adMixRecircWrapperHeight = 0;
		var bottomMargin = 20;
		var breakpointSmall = 1023;
		var globalNavigationHeight = $('#globalNavigation').outerHeight(true);
		var communityHeaderHeight = $('.wds-community-header').height();
		var gapSize = 200;
		var firstAdTopSpace = 10;
		var noRecircAdBottomSpace = 30;
		var recircTopSpace = 10;
		var topRightAdHeight = 250;
		var viewportHeight;
		var viewportWidth;
		var visibleElementBeforeWrapperHeight;

		// ad mix flags
		// AD_MIX_1 & AD_MIX_1B: reloadFloatingMedrec === true && recircEnabled === true
		// AD_MIX_2 & AD_MIX_2B: topRightAdFixed === true && recircEnabled === true
		// AD_MIX_3 & AD_MIX_3B: reloadRecirc === true && recircEnabled === true
		// CONTROL: all === false
		var topRightAdFixed = abTest.getGroup('AD_MIX') === 'AD_MIX_2' || abTest.getGroup('AD_MIX') === 'AD_MIX_2B';
		var recircEnabled = abTest.getGroup('AD_MIX') !== 'CONTROL';

		if (context.opts.adMix3Enabled || context.opts.adMix5Enabled) {
			gapSize = 0;
		}

		function getFirstAdTopPosition() {
			return $rail.offset().top - globalNavigationHeight - firstAdTopSpace;
		}

		function getFirstAdBottomPosition(firstAdTopPosition) {
			return firstAdTopPosition + gapSize;
		}

		function getAdAndRecircWrapperTopPosition() {
			var visibleElementBeforeWrapperBottom = parseInt($visibleElementBeforeWrapper.offset().top, 10) +
				visibleElementBeforeWrapperHeight;

			if (recircEnabled) {
				return visibleElementBeforeWrapperBottom - globalNavigationHeight - recircTopSpace;
			} else {
				return visibleElementBeforeWrapperBottom + noRecircAdBottomSpace -
					(viewportHeight - $adAndRecircWrapper.outerHeight(true));
			}
		}

		function getAdAndRecircWrapperBottomPosition(adAndRecircWrapperTopPosition) {
			return adAndRecircWrapperTopPosition + gapSize;
		}

		function getStopPosition() {
			var footerOffsetTop = parseInt($footer.offset().top, 10);

			if (recircEnabled) {
				return footerOffsetTop - globalNavigationHeight - adMixRecircWrapperHeight - bottomMargin;
			} else {
				return footerOffsetTop - viewportHeight;
			}
		}

		function reset() {
			if (topRightAdFixed) {
				resetTopAd();
				resetTopAdPaddings();
			}

			resetRecircStyles();
		}

		function scrollAfterAdAndRecircWrapperTopPosition() {
			if (topRightAdFixed) {
				resetTopAd();
				resetTopAdPaddings();
			}

			if (recircEnabled) {
				$recircWrapper.css('margin-bottom', gapSize + 'px');

				$recirc.css({
					position: 'fixed',
					top: globalNavigationHeight + recircTopSpace + 'px',
					width: '280px'
				});
			}

			resetAdAndRecircWrapper();
		}

		function scrollAfterAdAndRecircWrapperBottomPosition() {
			var adAndRecircWrapperStyles = {
				position: 'fixed',
				width: '300px'
			};

			if (topRightAdFixed) {
				resetTopAd();
				resetTopAdPaddings();
			}

			if (recircEnabled) {
				$recircWrapper.css('margin-bottom', '0');

				$recirc.css({
					position: '',
					top: '',
					width: ''
				});

				adAndRecircWrapperStyles.top = globalNavigationHeight + recircTopSpace + 'px';
			} else {
				adAndRecircWrapperStyles.bottom = noRecircAdBottomSpace + 'px';
				adAndRecircWrapperStyles.top = '';
			}

			$adAndRecircWrapper.css(adAndRecircWrapperStyles);
		}

		function scrollAfterFirstAdTopPosition() {
			resetRecircStyles();

			if (topRightAdFixed) {
				resetTopAdPaddings();
				$topRightAd.css({
					position: 'fixed',
					top: globalNavigationHeight + firstAdTopSpace + 'px',
					width: '300px'
				});
			}
		}

		function scrollAfterFirstAdBottomPosition() {
			resetRecircStyles();

			if (topRightAdFixed) {
				resetTopAd();
				$topRightAdWrapper.css({
					'padding-bottom': '',
					'padding-top': gapSize + 'px'
				});
			}
		}

		function scrollStopPosition(stopPosition) {
			if (topRightAdFixed) {
				resetTopAd();
				resetTopAdPaddings();
			}

			// FIXME cache it? at least the element
			var topAdHeight = $('#WikiaTopAds').outerHeight(true);
			var adAndRecircWrapperStyles = {
				bottom: '',
				position: 'absolute'
			};

			if (recircEnabled) {
				$recircWrapper.css('margin-bottom', '0');

				$recirc.css({
					position: '',
					top: '',
					width: ''
				});

				adAndRecircWrapperStyles.top = (stopPosition - topAdHeight - communityHeaderHeight) + 'px';
			} else {
				adAndRecircWrapperStyles.top = (stopPosition - topAdHeight - globalNavigationHeight + viewportHeight - adMixRecircWrapperHeight - noRecircAdBottomSpace) + 'px';
			}

			$adAndRecircWrapper.css(adAndRecircWrapperStyles);
		}

		function resetRecircStyles() {
			if (recircEnabled) {
				$recircWrapper.css('margin-bottom', (viewportWidth > breakpointSmall ? gapSize : 0) + 'px');

				$recirc.css({
					position: '',
					top: '',
					width: ''
				});
			}

			resetAdAndRecircWrapper();
		}

		function resetTopAd() {
			$topRightAd.css({
				position: '',
				top: '',
				width: ''
			});
		}

		function resetTopAdPaddings() {
			$topRightAdWrapper.css({
				'padding-top': '',
				'padding-bottom': gapSize + 'px'
			});
		}

		function resetAdAndRecircWrapper() {
			$adAndRecircWrapper.css({
				bottom: '',
				position: '',
				top: ''
			});
		}

		function update() {
			var scrollTop = $window.scrollTop();
			var firstAdTopPosition = getFirstAdTopPosition();
			var firstAdBottomPosition;
			var adAndRecircWrapperTopPosition = getAdAndRecircWrapperTopPosition();
			var adAndRecircWrapperBottomPosition;
			var stopPosition;

			if (
				scrollTop < firstAdTopPosition ||
				(!topRightAdFixed && scrollTop < adAndRecircWrapperTopPosition) ||
				viewportWidth <= breakpointSmall
			) {
				reset();
				return;
			}

			firstAdBottomPosition = getFirstAdBottomPosition(firstAdTopPosition);

			if (
				scrollTop >= firstAdTopPosition &&
				scrollTop < firstAdBottomPosition
			) {
				scrollAfterFirstAdTopPosition();
				return;
			}

			if (
				scrollTop >= firstAdBottomPosition &&
				scrollTop < adAndRecircWrapperTopPosition
			) {
				scrollAfterFirstAdBottomPosition();
				return;
			}

			adAndRecircWrapperBottomPosition = getAdAndRecircWrapperBottomPosition(adAndRecircWrapperTopPosition);

			if (
				scrollTop >= adAndRecircWrapperTopPosition &&
				scrollTop < adAndRecircWrapperBottomPosition
			) {
				scrollAfterAdAndRecircWrapperTopPosition();
				return;
			}

			adMixRecircWrapperHeight = $adAndRecircWrapper.outerHeight(true);
			stopPosition = getStopPosition();

			if (
				scrollTop >= adAndRecircWrapperBottomPosition &&
				scrollTop < stopPosition
			) {
				scrollAfterAdAndRecircWrapperBottomPosition();
			} else if (scrollTop >= stopPosition) {
				scrollStopPosition(stopPosition);
			}
		}

		function onRightRailReady() {
			$recircWrapper = $('#recirculation-rail');
			$adAndRecircWrapper = $('#WikiaAdInContentPlaceHolder');

			if (recircEnabled) {
				$adAndRecircWrapper.addClass('ad-mix-experiment-enabled');
			}

			// There is no recirculation right rail module on non-en wikis
			if (window.wgContentLanguage === 'en') {
				if (!$recircWrapper.find('.premium-recirculation-rail').exists()) {
					$recircWrapper.one('premiumRecirculationRail.ready', onRecircReady);
				} else {
					onRecircReady();
				}
			} else {
				// TODO check which experiment needs it
				// recircEnabled = false;
				gapSize = 0;
				onRecircReady();
			}
		}

		function onRecircReady() {
			if (recircEnabled) {
				$recirc = $recircWrapper.find('.premium-recirculation-rail');
				$recircWrapper
					.css('margin-bottom', gapSize + 'px')
					.height($recirc.outerHeight(true));
			}

			$visibleElementBeforeWrapper = $adAndRecircWrapper.prevAll(':not(#LEFT_SKYSCRAPER_2)').eq(0);
			visibleElementBeforeWrapperHeight = $visibleElementBeforeWrapper.outerHeight(true);

			viewportHeight = $window.height();
			viewportWidth = $window.width();


			if (!context.opts.adMix5Enabled) {
				$('#WikiaArticleBottomAd').hide();
			}

			if ($adAndRecircWrapper.offset().top + $adAndRecircWrapper.height() >= $footer.offset().top) {
				$adAndRecircWrapper.css('position', 'static');
				$recircWrapper.css('margin-bottom', '0');
				return;
			}

			$window.scroll(throttle(update, 32));
			$window.resize(throttle(function () {
				viewportHeight = $window.height();
				viewportWidth = $window.width();
				update();
			}, 32));

			update();
		}

		if (context.opts.adMixExperimentEnabled) {
			if ($rail.find('.loading').exists()) {
				$rail.one('afterLoad.rail', onRightRailReady);
			} else {
				onRightRailReady();
			}

			if (topRightAdFixed) {
				$topRightAdWrapper.css({
					height: topRightAdHeight + 'px',
					'padding-bottom': gapSize + 'px',
					'margin-bottom': '10px'
				});
			}
		}
	});
});
