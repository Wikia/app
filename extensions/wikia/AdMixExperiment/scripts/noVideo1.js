require(['wikia.throttle'], function (throttle) {
	$(function () {

		var $adMixRecircWrapper;
		var $footer = $('#WikiaFooter');
		var $moduleBeforeRecirc;
		var $rail = $('#WikiaRail');
		var $recircWrapper;
		var $window = $(window);
		var adMixRecircWrapperHeight;
		var bottomMargin = 20;
		var breakpointSmall = 1023;
		var globalNavigationHeight = $('#globalNavigation').outerHeight(true);
		var moduleBeforeRecircHeight;
		var viewportWidth = $(window).width();

		function getStartPosition() {
			var recircOffsetTop = parseInt($moduleBeforeRecirc.offset().top, 10) + moduleBeforeRecircHeight;
			return recircOffsetTop - globalNavigationHeight;
		}

		function getStopPosition() {
			var stopPoint = parseInt($footer.offset().top, 10);
			adMixRecircWrapperHeight = $adMixRecircWrapper.outerHeight(true);
			return stopPoint - globalNavigationHeight - adMixRecircWrapperHeight - bottomMargin;
		}

		function udpate() {
			var scrollTop = $window.scrollTop();
			var stopPosition = getStopPosition();
			var startPosition = getStartPosition();

			if(scrollTop < startPosition || viewportWidth <= breakpointSmall) {
				$adMixRecircWrapper.css({
					position: '',
					top: '',
					width: ''
				});
			} if(scrollTop > startPosition && scrollTop < stopPosition) {
				$adMixRecircWrapper.css({
					position: 'fixed',
					top: globalNavigationHeight + 'px',
					width: '300px'
				});
			} else if(scrollTop > stopPosition) {
				var topAdHeight = $('#WikiaTopAds').outerHeight(true);
				$adMixRecircWrapper.css({
					position: 'absolute',
					top: (stopPosition - topAdHeight) + 'px',
					width: '300px'
				});
			}
		}

		function onRightRailReady() {
			$recircWrapper = $('#recirculation-rail');
			$recircWrapper.one('premiumRecirculationRail.ready', onRecircReady);
		}

		function onRecircReady() {
			$adMixRecircWrapper = $('#AdMixExperimentRecirculationAndAdPlaceholderWrapper');
			$moduleBeforeRecirc = $adMixRecircWrapper.prev();
			moduleBeforeRecircHeight = $moduleBeforeRecirc.outerHeight(true);
			$window.scroll(throttle(udpate, 100));
			$window.resize(throttle(function () {
				viewportWidth = $(window).width();
				update();
			}, 100));
		}

		$rail.one('afterLoad.rail', onRightRailReady);

	});

});
