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
		var noRecircAdBottomPosition = 5;
		var recircEnabled = true;
		var viewportHeight = $(window).height();
		var viewportWidth = $(window).width();
		var visibleElementBeforeWrapperHeight;

		function getStartPosition() {
			var visibleElementBeforeWrapperBottom = parseInt($visibleElementBeforeWrapper.offset().top, 10) +
				visibleElementBeforeWrapperHeight;

			if (recircEnabled) {
				return visibleElementBeforeWrapperBottom - globalNavigationHeight;
			} else {
				return visibleElementBeforeWrapperBottom + noRecircAdBottomPosition -
					(viewportHeight - $adAndRecircWrapper.outerHeight(true));
			}
		}

		function getStopPosition() {
			var stopPoint = parseInt($footer.offset().top, 10);
			adMixRecircWrapperHeight = $adAndRecircWrapper.outerHeight(true);

			return stopPoint - globalNavigationHeight - adMixRecircWrapperHeight - bottomMargin;
		}

		function getMidPosition(startPosition) {
			return startPosition + gapSize;
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
				bottom: '',
				position: '',
				top: '',
				width: ''
			});
		}

		function scrollBeforeMid() {
			var adAndRecircWrapperStyles = {
				position: '',
				width: ''
			};

			if (recircEnabled) {
				$recircWrapper.css('margin-bottom', gapSize + 'px');

				$recirc.css({
					position: 'fixed',
					top: globalNavigationHeight + 'px',
					width: '280px'
				});

				adAndRecircWrapperStyles.top = '';
			} else {
				adAndRecircWrapperStyles.bottom = '';
			}

			$adAndRecircWrapper.css(adAndRecircWrapperStyles);
		}

		function scrollAfterMid() {
			var adAndRecircWrapperStyles = {
				position: 'fixed',
				width: '300px'
			};

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
			}

			$adAndRecircWrapper.css(adAndRecircWrapperStyles);
		}

		function scrollAtBottom(stopPosition) {
			// FIXME cache it? at least the element
			var topAdHeight = $('#WikiaTopAds').outerHeight(true);
			var adAndRecircWrapperStyles = {
				position: 'absolute',
				top: (stopPosition - topAdHeight) + 'px',
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
				adAndRecircWrapperStyles.bottom = noRecircAdBottomPosition + 'px';
			}

			$adAndRecircWrapper.css(adAndRecircWrapperStyles);
		}

		function update() {
			var scrollTop = $window.scrollTop();
			var startPosition = getStartPosition();
			var midPosition = getMidPosition(startPosition);
			var stopPosition = getStopPosition();

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
		}

		$rail.one('afterLoad.rail', onRightRailReady);
	});
});
