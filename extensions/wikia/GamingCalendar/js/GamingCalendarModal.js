var GamingCalendarModal = {
	initialized: false,
	modal: null,
	displayWeek: 0,
	firstWeek: new Date( 2011, 5, 20, 0, 0, 0 ),
	lastWeek: null,
	thisWeek: null,
	today: new Date(),
	expandFlag: false,
	renderPageFlag: false,

	init: function() {
		$().log('init');
		if (GamingCalendarModal.initialized) {
			return;
		}

		window.GamingCalendarModal.thisWeek = new Date(
			window.GamingCalendarModal.today.getUTCFullYear(),
			window.GamingCalendarModal.today.getUTCMonth(),
			window.GamingCalendarModal.today.getUTCDate() - window.GamingCalendarModal.today.getUTCDay() + 1,
			0, 0, 0
		);

		if (1 == GamingCalendar.data['entries'][2].length) {
			window.GamingCalendarModal.lastWeek = 1;
		}

		var weeks = GamingCalendar.data['entries'];

		window.GamingCalendarModal.renderPage( null, 0 );

		var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
		$('#GamingCalendarWrapper > h1').append('<span class="date">' + months[window.GamingCalendarModal.today.getUTCMonth()] + ' ' + window.GamingCalendarModal.today.getUTCDate() + ', ' + window.GamingCalendarModal.today.getUTCFullYear() +'</span>');
		$('#GamingCalendarWrapper .game-more-info').trackClick('gamingCalendar/moreinfo');
		$('#GamingCalendarWrapper .game-prie-order').trackClick('gamingCalendar/preorder');
		GamingCalendarModal.initialized = true;
		$().log('finished init');
	},

	renderWeek: function(week) {
		var template = $('#GamingCalendarWeekTemplate').html();
		var itemsHtml = '';

		var weekdates = week[0];

		template = template.replace('##start##', weekdates['start'] );
		template = template.replace('##end##', weekdates['end'] );

		template = template.replace('##startmonth##', weekdates['startmonth'] );
		template = template.replace('##endmonth##', weekdates['endmonth'] );

		template = template.replace('##week-caption##', weekdates['caption'] );

		if ( 1 == week.length ) {
                    if ( 'ent' == window.cityShort ) {
                        itemsHtml = itemsHtml + '<li class="no-entries">No Events This Week<br />Check out our <a href="http://www.wikia.com/Entertainment">Entertainment Wikis</a>!</li>';
                    } else {
                        itemsHtml = itemsHtml + '<li class="no-entries">No Game Releases This Week<br />Check out our <a href="http://www.wikia.com/Gaming">Gaming Wikis</a>!</li>';
                    }
		} else {

		    for ( var i = 1; i < week.length; i++  ) {
			    if ( week[i].expanded && ! GamingCalendarModal.initialized ) {
				    itemsHtml = itemsHtml + '<li>' + GamingCalendar.renderItem( week[i], true ) + '</li>';
			    } else {
				    itemsHtml = itemsHtml + '<li>' + GamingCalendar.renderItem( week[i], false ) + '</li>';
			    }
		    }
		}

		template = template.replace( '##items##', itemsHtml );

		return template;
    },

	scrollDown: function(e) {
		e.preventDefault();
		var wrapper = $(this).prev('div.list');
		var obj = wrapper.children('ul')[0];
		var top = $(obj).position().top;
		var objHeight = $(obj).height();
		var wrHeight = $(wrapper).height();
		var scrollBy = 0;

		if (objHeight > wrHeight && objHeight + top > wrHeight) {
			scrollBy = '-=' + Math.min( Math.abs(objHeight + top - wrHeight), 75 );
			$(obj).animate({
				top: scrollBy
			}, 250);
		}

		GamingCalendar.track('scroll/down');
	},

	scrollUp: function(e) {
		e.preventDefault();
		var wrapper = $(this).next('div.list');
		var obj = wrapper.children('ul')[0];
		var top = $(obj).position().top;
		var scrollBy = 0;

		if ( top < 0 ) {
			scrollBy = '+=' + Math.min( Math.abs(top), 75 );
			$(obj).animate({
				top: scrollBy
			}, 250);
		}

		GamingCalendar.track('scroll/up');
	},

	expandOrCollapse: function(e) {
		e.preventDefault();
		if (window.GamingCalendarModal.expandFlag) {
			return;
		}
		window.GamingCalendarModal.expandFlag = true;
		$('#GamingCalendar').find('.GamingCalendarItem.selected').slideUp('slow',function() { $(this).removeClass('selected').addClass('unselected').slideDown().bind('click', GamingCalendarModal.expandOrCollapse ); });
		$(this).slideUp('slow', function() { $(this).removeClass('unselected').addClass('selected').slideDown(
			'slow', function() {
				var obj = $(this).parent().parent();
				var objTop = $(obj).position().top;
				var objHeight = $(obj).height();
				var thisTop = $(this).position().top;
				var thisHeight = $(this).height();
				var vpHeight = $(obj).parent().height();

				if (objTop + thisTop < 0) {
					var scrollBy = '+=' + Math.min(
						Math.abs(objTop),
						Math.abs(objTop + thisTop) + 5
					);
					$(obj).animate({top: scrollBy}, 250);
				} else if (objTop + thisTop + thisHeight - vpHeight > -10) {
					var scrollBy = '-=' + Math.min(
						Math.abs(objHeight + objTop - vpHeight),
						Math.abs(objTop + thisTop + thisHeight - vpHeight) + 40
					);
					$(obj).animate({top: scrollBy}, 250);
				}
				window.GamingCalendarModal.expandFlag = false;
			}
		).unbind('click'); });

		GamingCalendar.track('brick/expand');
    },

	renderPage: function(e, page) {
		if ( window.GamingCalendarModal.renderPageFlag ) {
			return;
		}
		// FB#9271
		//if (window.GamingCalendarModal.lastWeek && window.GamingCalendarModal.lastWeek < page + 1) {
		//	window.GamingCalendarModal.renderPageFlag = false;
		//	window.GamingCalendarModal.renderPage(e, page - 1);
		//	return;
		//}
		window.GamingCalendarModal.renderPageFlag = true;
		var week = 7 * 24 * 3600 * 1000;
		var currentWeek = new Date( window.GamingCalendarModal.thisWeek.getTime() + (week * page) );

		if (currentWeek.getTime() < window.GamingCalendarModal.firstWeek.getTime()) {
			window.GamingCalendarModal.renderPageFlag = false;
			window.GamingCalendarModal.renderPage(e, page + 1);
			return;
		}

		if ( e ) { e.preventDefault(); }
		var targetWeek = page;
		var offset = targetWeek;
		var weeksToLoad = 2;
		if ('object' == typeof GamingCalendar.data['entries'][targetWeek]) {
			offset++;
			weeksToLoad--;
		}

		if ('object' == typeof GamingCalendar.data['entries'][targetWeek + 1]) {
			weeksToLoad--;
		}

		if (0 < weeksToLoad) {
			$.get('/wikia.php?controller=GamingCalendar&method=getEntries&format=json&weeks='
			+ weeksToLoad + '&offset=' + offset, function( data ) {
				$(data.entries).each( function(index, value) {
					GamingCalendar.data['entries'][offset + index] = value;
				});
				window.GamingCalendarModal.renderPageFlag = false;
				window.GamingCalendarModal.renderPage(e, page);
				return;
			});
		}

		var html = new Array (
			window.GamingCalendarModal.renderWeek(GamingCalendar.data['entries'][targetWeek]),
			window.GamingCalendarModal.renderWeek(GamingCalendar.data['entries'][targetWeek + 1])
		);

		var obj = $('#GamingCalendar .weeks > ul');
		var chl = obj.children('li');

		if ( 0 == window.GamingCalendarModal.displayWeek && 0 == page ) {
			$(chl.get(2)).html( html[0] );
			$(chl.get(3)).html( html[1] );
			$(chl.get(2)).css('left', 0);
			$(chl.get(3)).css('left', 290);
		} else if ( Math.abs(window.GamingCalendarModal.displayWeek - page) == 1 ) {
			if (window.GamingCalendarModal.displayWeek < page) {
				$(chl.get(4)).html( html[1] );
				$(chl.get(4)).css('left', 580);
				$(chl.get(2)).animate({left: '-=290'}, 250);
				$(chl.get(3)).animate({left: '-=290'}, 250);
				$(chl.get(4)).animate({left: '-=290'}, 250);
				$(chl.get(0)).remove();
				obj.append('<li class="week"></li>');
			} else {
				$(chl.get(1)).html( html[0] );
				$(chl.get(1)).css('left', -290);
				$(chl.get(1)).animate({left: '+=290'}, 250);
				$(chl.get(2)).animate({left: '+=290'}, 250);
				$(chl.get(3)).animate({left: '+=290'}, 250);
				$(chl.get(5)).remove();
				obj.prepend('<li class="week"></li>');
			}
		} else {
			if (window.GamingCalendarModal.displayWeek < page) {
				$(chl.get(4)).html( html[0] );
				$(chl.get(5)).html( html[1] );
				$(chl.get(4)).css('left', 580);
				$(chl.get(5)).css('left', 870);
				$(chl.get(2)).animate({left: '-=580'}, 250);
				$(chl.get(3)).animate({left: '-=580'}, 250);
				$(chl.get(4)).animate({left: '-=580'}, 250);
				$(chl.get(5)).animate({left: '-=580'}, 250);
				$(chl.get(0)).remove();
				$(chl.get(1)).remove();
				obj.append('<li class="week"></li><li class="week"></li>');
			} else {
				$(chl.get(0)).html( html[0] );
				$(chl.get(1)).html( html[1] );
				$(chl.get(0)).css('left', -580);
				$(chl.get(1)).css('left', -290);
				$(chl.get(0)).animate({left: '+=580'}, 250);
				$(chl.get(1)).animate({left: '+=580'}, 250);
				$(chl.get(2)).animate({left: '+=580'}, 250);
				$(chl.get(3)).animate({left: '+=580'}, 250);
				$(chl.get(4)).remove();
				$(chl.get(5)).remove();
				obj.prepend('<li class="week"></li><li class="week"></li>');
			}
		}

		window.GamingCalendarModal.bindEventHandlers(page);
		window.GamingCalendarModal.displayWeek = page;
		window.GamingCalendarModal.renderPageFlag = false;
    },

	bindEventHandlers: function(page) {
		var day = 24 * 3600 * 1000;
		var week = 7 * day;
		var _today = new Date( GamingCalendarModal.today.getTime() + ( GamingCalendarModal.today.getTimezoneOffset() * 60 * 1000 ) );
		// This Monday
		_today = new Date(
			_today.getUTCFullYear(),
			_today.getUTCMonth(),
			_today.getUTCDate() - _today.getUTCDay() + 1,
			0, 0, 0
		);
		// Next month
		var nextMonth = new Date(
			_today.getFullYear(),
			_today.getMonth() + 1,
			1, 0, 0, 0
		);
		var nextMonthWeeks = Math.floor(
			( nextMonth.getTime() - _today.getTime() - ( ( _today.getTimezoneOffset() - nextMonth.getTimezoneOffset() ) * 60 * 1000 ) ) / week
		);
		// Or the month after the next month
		if ( 2 > nextMonthWeeks ) {
			nextMonth = new Date(
				_today.getFullYear(),
				_today.getMonth() + 2,
				1, 0, 0, 0
			);
			nextMonthWeeks = Math.floor(
				( nextMonth.getTime() - _today.getTime() - ( ( _today.getTimezoneOffset() - nextMonth.getTimezoneOffset() ) * 60 * 1000 ) ) / week
			);
		}
		// This month
		var thisMonth = new Date(
			_today.getFullYear(),
			_today.getMonth(),
			1, 0, 0, 0
		);
		var thisMonthWeeks = Math.ceil(
			( _today.getTime() - thisMonth.getTime() - ( ( _today.getTimezoneOffset() - thisMonth.getTimezoneOffset() ) * 60 * 1000 ) ) / week
		);
		var thisMonthDays = Math.ceil(
			( _today.getTime() - thisMonth.getTime() - ( ( _today.getTimezoneOffset() - thisMonth.getTimezoneOffset() ) * 60 * 1000 ) ) / day
		);
		if ( 0 < thisMonthWeeks  ) {
			var previousMonth = thisMonth;
			var previousMonthWeeks = thisMonthWeeks;
		} else {
			var previousMonth = new Date(
				_today.getFullYear(),
				_today.getMonth() - 1,
				1, 0, 0, 0
			);
			var previousMonthWeeks = Math.ceil(
				( _today.getTime() - previousMonth.getTime() - ( ( _today.getTimezoneOffset() - previousMonth.getTimezoneOffset() ) * 60 * 1000 ) ) /  week
			);
		}
		var calendarElement = $('#GamingCalendar');

		calendarElement.find('.forward-week').
			unbind('click').
			attr('disabled', false).
			bind('click', function(event) {
				GamingCalendarModal.renderPage(event, page + 1);
				GamingCalendar.track('scroll/forward/week');
			});

		calendarElement.find('.back-week').
			unbind('click').
			attr('disabled', false).
			bind('click', function(event) {
				GamingCalendarModal.renderPage(event, page - 1);
				GamingCalendar.track('scroll/backward/week');
			});

		calendarElement.find('.scroll-up').unbind('click').bind('click', GamingCalendarModal.scrollUp);
		calendarElement.find('.scroll-down').unbind('click').bind('click', GamingCalendarModal.scrollDown);

		calendarElement.find('.GamingCalendarItem').unbind('click');
		calendarElement.find('.GamingCalendarItem.unselected').bind('click', GamingCalendarModal.expandOrCollapse);

		var todayButton = calendarElement.find('.today');

		todayButton.unbind('click');

		if (0 != page) {
			todayButton.bind('click', function(event) {
				GamingCalendarModal.renderPage( event, 0 );
				GamingCalendar.track('scroll/today');
			}).attr('disabled', false);
		} else {
			todayButton.attr('disabled', true);
		}

		if ( window.GamingCalendarModal.lastWeek && window.GamingCalendarModal.lastWeek < page + 2 ) {
			calendarElement.find('.forward-week').
				attr('disabled', true).
				unbind('click');
		}

		if ( _today.getTime() <= window.GamingCalendarModal.firstWeek.getTime() ) {
			calendarElement.find('.back-week').
				attr('disabled', true).
				unbind('click');
		}
	}
};