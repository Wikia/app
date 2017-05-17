require(['wikia.throttle'], function (throttle) {
	$(function () {

		var $adAndRecircWrapper;
		var $footer = $('#WikiaFooter');
		var $rail = $('#WikiaRail');
		var $recirc;
		var $recircWrapper;
		var $visibleElementBeforeWrapper;
		var $window = $(window);

		var adMixRecircWrapperHeight;
		var bottomMargin = 20;
		var breakpointSmall = 1023;
		var globalNavigationHeight = $('#globalNavigation').outerHeight(true);
		var gapSize = 200;
		var recircEnabled = false;
		var viewportWidth = $(window).width();
		var visibleElementBeforeWrapperHeight;

		function getStartPosition() {
			// We can't cache this offset as there can be an ad injected at the top of rail
			var recircOffsetTop = parseInt($visibleElementBeforeWrapper.offset().top, 10) +
				visibleElementBeforeWrapperHeight;

			return recircOffsetTop - globalNavigationHeight;
		}

		function getStopPosition() {
			var stopPoint = parseInt($footer.offset().top, 10);
			adMixRecircWrapperHeight = $adAndRecircWrapper.outerHeight(true);

			return stopPoint - globalNavigationHeight - adMixRecircWrapperHeight - bottomMargin;
		}

		function getMidPosition() {
			return getStartPosition() + gapSize;
		}

		function reset() {
			if (recircEnabled) {
				$recircWrapper.css('margin-bottom', gapSize + 'px');

				$recirc.css({
					position: '',
					top: '',
					width: ''
				});
			}

			$adAndRecircWrapper.css({
				position: '',
				top: '',
				width: ''
			});
		}

		function scrollBeforeMid() {
			if (recircEnabled) {
				$recircWrapper.css('margin-bottom', gapSize + 'px');

				$recirc.css({
					position: 'fixed',
					top: globalNavigationHeight + 'px',
					width: '280px'
				});
			}

			$adAndRecircWrapper.css({
				position: '',
				top: '',
				width: ''
			});
		}

		function scrollAfterMid() {
			if (recircEnabled) {
				$recircWrapper.css('margin-bottom', '0');

				$recirc.css({
					position: '',
					top: '',
					width: ''
				});
			}

			$adAndRecircWrapper.css({
				position: 'fixed',
				top: globalNavigationHeight + 'px',
				width: '300px'
			});
		}

		function scrollAtBottom(stopPosition) {
			// FIXME cache it? at least the element
			var topAdHeight = $('#WikiaTopAds').outerHeight(true);

			if (recircEnabled) {
				$recircWrapper.css('margin-bottom', '0');

				$recirc.css({
					position: '',
					top: '',
					width: ''
				});
			}

			$adAndRecircWrapper.css({
				position: 'absolute',
				top: (stopPosition - topAdHeight) + 'px',
				width: '300px'
			});
		}

		function update() {
			var scrollTop = $window.scrollTop();
			var stopPosition = getStopPosition();
			var startPosition = getStartPosition();
			var midPosition = getMidPosition();

			if (scrollTop < startPosition || viewportWidth <= breakpointSmall) {
				reset();
			} else if (scrollTop > startPosition && scrollTop < midPosition) {
				scrollBeforeMid();
			} else if (scrollTop >= midPosition && scrollTop < stopPosition) {
				scrollAfterMid();
			} else if (scrollTop > stopPosition) {
				scrollAtBottom(stopPosition);
			}
		}

		function onRightRailReady() {
			$recircWrapper = $('#recirculation-rail');

			if (window.wgContentLanguage === 'en') {
				recircEnabled = true;
				$recircWrapper.one('premiumRecirculationRail.ready', onRecircReady);
			} else {
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
				viewportWidth = $(window).width();
				update();
			}, 100));
		}

		$rail.one('afterLoad.rail', onRightRailReady);
	});
});
