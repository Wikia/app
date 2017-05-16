require(['wikia.throttle'], function (throttle) {
	$(function () {

		var $adMixRecircWrapper;
		var $footer = $('#WikiaFooter');
		var $moduleBeforeRecirc;
		var $rail = $('#WikiaRail');
		var $recircWrapper;
		var $window = $(window);
		var adMixRecircWrapperHeight;
		var globalNavigationHeight = $('#globalNavigation').outerHeight(true);
		var moduleBeforeRecircHeight;

		function getStartPosition() {
			var recircOffsetTop = parseInt($moduleBeforeRecirc.offset().top, 10) + moduleBeforeRecircHeight;
			return recircOffsetTop - globalNavigationHeight;
		}

		function getStopPosition() {
			var stopPoint = parseInt($footer.offset().top, 10);
			return stopPoint - globalNavigationHeight - adMixRecircWrapperHeight;
		}

		function onScroll() {
			var scrollTop = $window.scrollTop();
			var stopPosition = getStopPosition();
			var startPosition = getStartPosition();

			if(scrollTop < startPosition) {
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
			adMixRecircWrapperHeight = $adMixRecircWrapper.outerHeight(true);
			$moduleBeforeRecirc = $adMixRecircWrapper.prev();
			moduleBeforeRecircHeight = $moduleBeforeRecirc.outerHeight(true);
			$window.scroll(throttle(onScroll));
		}

		$rail.one('afterLoad.rail', onRightRailReady);

	});

});
