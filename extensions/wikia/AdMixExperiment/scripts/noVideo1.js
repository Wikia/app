require(['wikia.throttle'], function (throttle) {
	$(function () {
		var $adAndRecircWrapper;
		var $topRightAd = $('#TOP_RIGHT_BOXAD');
		var $topRightAdWrapper = $('#top-right-boxad-wrapper');
		var $footer = $('#WikiaFooter');
		var $rail = $('#WikiaRail');
		var $recirc;
		var $recircWrapper;
		var $visibleElementBeforeWrapper;
		var $window = $(window);

		var bottomMargin = 20;
		var breakpointSmall = 1023;
		var globalNavigationHeight = $('#globalNavigation').outerHeight(true);
		var gapSize = 200;
		var magicNumber = 270;
		var noRecircAdBottomPosition = 5;
		var recircEnabled = true;
		var topRightAdHeight = 250;
		var viewportHeight = $window.height();
		var viewportWidth = $window.width();
		var visibleElementBeforeWrapperHeight;

		// FIXME it should be true only for ad mix variant XW-3156
		// var topRightAdFixed = true;
		var topRightAdFixed = false;

		function getAdAndRecircWrapperTopPosition() {
			var visibleElementBeforeWrapperBottom = parseInt($visibleElementBeforeWrapper.offset().top, 10) +
				visibleElementBeforeWrapperHeight;

			if (recircEnabled) {
				return visibleElementBeforeWrapperBottom - globalNavigationHeight;
			} else {
				return visibleElementBeforeWrapperBottom + noRecircAdBottomPosition -
					(viewportHeight - $adAndRecircWrapper.outerHeight(true));
			}
		}

		function getAdAndRecircWrapperBottomPosition(startPosition) {
			return startPosition + gapSize;
		}

		function getFirstAdTopPosition() {
			return $rail.offset().top - globalNavigationHeight;
		}

		function getFirstAdBottomPosition() {
			return getFirstAdTopPosition() + gapSize;
		}

		function getStopPosition() {
			var footerOffsetTop = parseInt($footer.offset().top, 10);
			var adMixRecircWrapperHeight = $adAndRecircWrapper.outerHeight(true);

			if (recircEnabled) {
				return footerOffsetTop - globalNavigationHeight - adMixRecircWrapperHeight - bottomMargin;
			} else {
				return footerOffsetTop - globalNavigationHeight - adMixRecircWrapperHeight -
					noRecircAdBottomPosition - magicNumber;
			}
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
					top: globalNavigationHeight + 'px',
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

				adAndRecircWrapperStyles.top = globalNavigationHeight + 'px';
			} else {
				adAndRecircWrapperStyles.bottom = noRecircAdBottomPosition + 'px';
				adAndRecircWrapperStyles.top = '';
			}

			$adAndRecircWrapper.css(adAndRecircWrapperStyles);
		}

		function scrollAtBottom(stopPosition) {
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
				adAndRecircWrapperStyles.top = (stopPosition - topAdHeight) + magicNumber + 'px';
			}

			$adAndRecircWrapper.css(adAndRecircWrapperStyles);
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

		function scrollAfterFirstAdTopPosition() {
			resetRecircStyles();
			resetTopAdPaddings();
			$topRightAd.css({
				position: 'fixed',
				top: globalNavigationHeight + 'px',
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

		function update() {
			var scrollTop = $window.scrollTop();
			var firstAdTopPosition = getFirstAdTopPosition();
			var firstAdBottomPosition = getFirstAdBottomPosition();
			var adAndRecircWrapperTopPosition = getAdAndRecircWrapperTopPosition();
			var adAndRecircWrapperBottomPosition = getAdAndRecircWrapperBottomPosition(adAndRecircWrapperTopPosition);
			var stopPosition = getStopPosition();

			if (
				scrollTop < firstAdTopPosition ||
				(!topRightAdFixed && scrollTop < adAndRecircWrapperTopPosition) ||
				viewportWidth <= breakpointSmall
			) {
				reset();
			} else if (
				scrollTop >= firstAdTopPosition &&
				scrollTop < firstAdBottomPosition
			) {
				scrollAfterFirstAdTopPosition();
			} else if (
				scrollTop >= firstAdBottomPosition &&
				scrollTop < adAndRecircWrapperTopPosition
			) {
				scrollAfterFirstAdBottomPosition();
			} else if (
				scrollTop >= adAndRecircWrapperTopPosition &&
				scrollTop < adAndRecircWrapperBottomPosition
			) {
				scrollAfterAdAndRecircWrapperTopPosition();
			} else if (
				scrollTop >= adAndRecircWrapperBottomPosition &&
				scrollTop < stopPosition
			) {
				scrollAfterAdAndRecircWrapperBottomPosition();
			} else if (scrollTop >= stopPosition) {
				scrollAtBottom(stopPosition);
			}
		}

		function onRightRailReady() {
			$recircWrapper = $('#recirculation-rail');

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

			$adAndRecircWrapper = $('#WikiaAdInContentPlaceHolder');

			$visibleElementBeforeWrapper = $adAndRecircWrapper.prevAll(':not(#LEFT_SKYSCRAPER_2)').eq(0);
			visibleElementBeforeWrapperHeight = $visibleElementBeforeWrapper.outerHeight(true);

			$window.scroll(throttle(update, 100));
			$window.resize(throttle(function () {
				viewportHeight = $(window).height();
				viewportWidth = $(window).width();
				update();
			}, 100));

			update();
		}

		$rail.one('afterLoad.rail', onRightRailReady);

		if (topRightAdFixed) {
			$topRightAdWrapper.css({
				height: topRightAdHeight + 'px',
				'padding-bottom': gapSize + 'px'
			});
		}
	});
});
