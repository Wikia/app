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
		var recircEnabled = false;
		var $recircWrapper;
		var $visibleElementBeforeWrapper;
		var $window = $(window);

		var adMixRecircWrapperHeight = 0;
		var bottomMargin = 20;
		var breakpointSmall = 1023;
		var globalNavigationHeight = $('#globalNavigation').outerHeight(true);
		var gapSize = 200;
		var firstAdTopSpace = 10;
		var noRecircAdBottomSpace = 30;
		var recircTopSpace = 10;
		var topRightAdHeight = 250;
		var viewportHeight;
		var viewportWidth;
		var visibleElementBeforeWrapperHeight;

		// ad mix flags
		// AD_MIX_1: reloadFloatingMedrec === true && recircFixed === true
		// AD_MIX_2: topRightAdFixed === true && recircFixed === true
		// AD_MIX_3: reloadRecirc === true && recircFixed === true
		// CONTROL: all === false
		var reloadFloatingMedrec = abTest.getGroup('AD_MIX') === 'AD_MIX_1';
		var topRightAdFixed = abTest.getGroup('AD_MIX') === 'AD_MIX_2';
		var reloadRecirc = abTest.getGroup('AD_MIX') === 'AD_MIX_3';
		var recircFixed = abTest.getGroup('AD_MIX') !== 'CONTROL';

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
			resetTopAdPaddings();
			$topRightAd.css({
				position: 'fixed',
				top: globalNavigationHeight + firstAdTopSpace + 'px',
				width: '300px'
			});
		}

		function scrollAfterFirstAdBottomPosition() {
			resetRecircStyles();
			resetTopAd();
			$topRightAdWrapper.css({
				'padding-bottom': '',
				'padding-top': gapSize + 'px'
			});
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
				position: 'absolute',
				width: '300px'
			};

			if (recircEnabled) {
				$recircWrapper.css('margin-bottom', '0');

				$recirc.css({
					position: '',
					top: '',
					width: ''
				});

				adAndRecircWrapperStyles.top = (stopPosition - topAdHeight) + 'px';
			} else {
				adAndRecircWrapperStyles.top = (stopPosition - topAdHeight - globalNavigationHeight + viewportHeight - adMixRecircWrapperHeight - noRecircAdBottomSpace) + 'px';
			}

			$adAndRecircWrapper.css(adAndRecircWrapperStyles);
		}

		function resetRecircStyles() {
			if (recircEnabled) {
				$recircWrapper.css('margin-bottom', gapSize + 'px');

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
				top: '',
				width: ''
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

			if (recircFixed) {
				$adAndRecircWrapper.addClass('ad-mix-experiment-enabled');
			}

			// There is no recirculation right rail module on non-en wikis
			if (window.wgContentLanguage === 'en') {
				$recircWrapper.one('premiumRecirculationRail.ready', onRecircReady);
			} else {
				recircEnabled = false;
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

			if (reloadRecirc || topRightAdFixed) {
				$floatingMedrec.hide();
			}

			if (reloadFloatingMedrec) {
				// reload the FMR ad
			}

			$visibleElementBeforeWrapper = $adAndRecircWrapper.prevAll(':not(#LEFT_SKYSCRAPER_2)').eq(0);
			visibleElementBeforeWrapperHeight = $visibleElementBeforeWrapper.outerHeight(true);

			viewportHeight = $window.height();
			viewportWidth = $window.width();

			$window.scroll(throttle(update, 100));
			$window.resize(throttle(function () {
				viewportHeight = $window.height();
				viewportWidth = $window.width();
				update();
			}, 100));

			update();
		}

		if (context.opts.adMixExperimentEnabled) {
			$rail.one('afterLoad.rail', onRightRailReady);

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
