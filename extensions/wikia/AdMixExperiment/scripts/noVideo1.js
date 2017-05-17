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

		function getMidPosition() {
			// INCONTENT_BOXAD_1
			// var adOffset = parseInt($('#INCONTENT_BOXAD_1').offset().top, 10);
			return getStartPosition() + $('#premium-recirculation-rail').outerHeight(true) + 250;
		}

		function update() {
			var scrollTop = $window.scrollTop();
			var stopPosition = getStopPosition();
			var startPosition = getStartPosition();
			var midPosition = getMidPosition();

			if (scrollTop < startPosition || viewportWidth <= breakpointSmall) {
				$('#recirculation-rail').css('margin-bottom', '250px');

				$adMixRecircWrapper.css({
					position: '',
					top: '',
					width: ''
				});
				$('.premium-recirculation-rail').css({
					position: '',
					top: '',
					width: ''
				});
			} else if (scrollTop > startPosition && scrollTop < midPosition) {
				$('#recirculation-rail').css('margin-bottom', '250px');
				$('.premium-recirculation-rail').css({
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
				$('#recirculation-rail').css('margin-bottom', '0');
				$adMixRecircWrapper.css({
					position: 'fixed',
					top: globalNavigationHeight + 'px',
					width: '300px'
				});
				$('.premium-recirculation-rail').css({
					position: '',
					top: '',
					width: ''
				});
			} else if (scrollTop > stopPosition) {
				$('#recirculation-rail').css('margin-bottom', '0');

				var topAdHeight = $('#WikiaTopAds').outerHeight(true);
				$adMixRecircWrapper.css({
					position: 'absolute',
					top: (stopPosition - topAdHeight) + 'px',
					width: '300px'
				});
				$('.premium-recirculation-rail').css({
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
			$('#recirculation-rail').css('margin-bottom', '250px');
			$('#recirculation-rail').height($('.premium-recirculation-rail').outerHeight(true));
			$moduleBeforeRecirc = $adMixRecircWrapper.prevAll(':visible').eq(0);
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
