require(['wikia.throttle'], function (throttle) {
	$(function () {

		var $adMixRecircWrapper;
		var $footer = $('#WikiaFooter');
		var $moduleBeforeRecirc;
		var $rail = $('#WikiaRail');
		var $recirc;
		var $recircWrapper;
		var $window = $(window);
		var adMixRecircWrapperHeight;
		var bottomMargin = 20;
		var breakpointSmall = 1023;
		var globalNavigationHeight = $('#globalNavigation').outerHeight(true);
		var gapSize = 200;
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

		function getMidPosition() {
			return getStartPosition() + gapSize;
		}

		function update() {
			var scrollTop = $window.scrollTop();
			var stopPosition = getStopPosition();
			var startPosition = getStartPosition();
			var midPosition = getMidPosition();

			if (scrollTop < startPosition || viewportWidth <= breakpointSmall) {
				$recircWrapper.css('margin-bottom', gapSize + 'px');
				$adMixRecircWrapper.css({
					position: '',
					top: '',
					width: ''
				});
				$recirc.css({
					position: '',
					top: '',
					width: ''
				});
			} else if (scrollTop > startPosition && scrollTop < midPosition) {
				$recircWrapper.css('margin-bottom', gapSize + 'px');
				$recirc.css({
					position: 'fixed',
					top: globalNavigationHeight + 'px',
					width: '280px'
				});
				$adMixRecircWrapper.css({
					position: '',
					top: '',
					width: ''
				});
			} else if (scrollTop >= midPosition && scrollTop < stopPosition) {
				$recircWrapper.css('margin-bottom', '0');
				$adMixRecircWrapper.css({
					position: 'fixed',
					top: globalNavigationHeight + 'px',
					width: '300px'
				});
				$recirc.css({
					position: '',
					top: '',
					width: ''
				});
			} else if (scrollTop > stopPosition) {
				var topAdHeight = $('#WikiaTopAds').outerHeight(true);
				$recircWrapper.css('margin-bottom', '0');
				$adMixRecircWrapper.css({
					position: 'absolute',
					top: (stopPosition - topAdHeight) + 'px',
					width: '300px'
				});
				$recirc.css({
					position: '',
					top: '',
					width: ''
				});
			}
		}

		function onRightRailReady() {
			$recircWrapper = $('#recirculation-rail');
			$recircWrapper.one('premiumRecirculationRail.ready', onRecircReady);
		}

		function onRecircReady() {
			$adMixRecircWrapper = $('#WikiaAdInContentPlaceHolder');
			$recirc = $recircWrapper.find('.premium-recirculation-rail');
			$recircWrapper.css('margin-bottom', gapSize + 'px');
			$recircWrapper.height($recirc.outerHeight(true));
			$moduleBeforeRecirc = $adMixRecircWrapper.prevAll(':not(#LEFT_SKYSCRAPER_2)').eq(0);
			moduleBeforeRecircHeight = $moduleBeforeRecirc.outerHeight(true);
			$window.scroll(throttle(update, 100));
			$window.resize(throttle(function () {
				viewportWidth = $(window).width();
				update();
			}, 100));
		}

		$rail.one('afterLoad.rail', onRightRailReady);

	});

});
