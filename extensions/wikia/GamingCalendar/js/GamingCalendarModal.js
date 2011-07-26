var GamingCalendarModal = {
	initialized: false,
	modal: null,
	displayWeek: 0,
	firstWeek: new Date( Date.UTC( 2011, 06, 18, 0, 0, 0 ) ),
	lastWeek: null,
	
	init: function() {
		$().log('init');
		if (GamingCalendarModal.initialized) {
			return;
		} else {
			GamingCalendarModal.initialized = true;
		}

		if (1 == window.GamingCalendarData['entries'][2].length) {
			window.GamingCalendarModal.lastWeek = 1;
		}
		
		var weeks = window.GamingCalendarData['entries'];

		window.GamingCalendarModal.renderPage( null, 0 );
		
		
		var today = new Date();
		var months = new Array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
		$('#GamingCalendarWrapper > h1').append('<span>' + months[today.getMonth()] + ' ' + today.getDate() + ', ' + today.getFullYear() +'</span>');
		$('#GamingCalendarWrapper .game-more-info').trackClick('gamingCalendar/moreinfo');
		$('#GamingCalendarWrapper .game-pre-order').trackClick('gamingCalendar/preorder');
		$().log('finished init');
	},

	renderWeek: function(week) {
		var template = $('#GamingCalendarWeekTemplate').html();
		var itemsHtml = '';

		weekdates = week[0];
		
		template = template.replace('%start%', weekdates['start'] );
		template = template.replace('%end%', weekdates['end'] );

		template = template.replace('%startmonth%', weekdates['startmonth'] );
		template = template.replace('%endmonth%', weekdates['endmonth'] );
		
		template = template.replace('%week-caption%', weekdates['caption'] );
		
		if ( 1 == week.length ) {
		    itemsHtml = itemsHtml + '<li class="no-entries">No entries.</li>';
		} else {

		    for ( var i = 1; i < week.length; i++  ) {
			    if ( week[i].expanded ) {
				    itemsHtml = itemsHtml + '<li>' + GamingCalendar.renderItem( week[i], true ) + '</li>';
			    } else {
				    itemsHtml = itemsHtml + '<li>' + GamingCalendar.renderItem( week[i], false ) + '</li>';
			    }
		    }
		}

		template = template.replace( '%items%', itemsHtml );

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

		$.tracker.byStr( 'gamingCalendar/scroll/down' );
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

		$.tracker.byStr( 'gamingCalendar/scroll/up' );
    },
    
    expandOrCollapse: function(e) {
	e.preventDefault();
	$('#GamingCalendar').find('.GamingCalendarItem.selected').slideUp('slow',function() { $(this).removeClass('selected').addClass('unselected').slideDown().bind('click', GamingCalendarModal.expandOrCollapse ); });
	$(this).slideUp('slow', function() { $(this).removeClass('unselected').addClass('selected').slideDown().unbind('click'); });
	$.tracker.byStr( 'gamingCalendar/brick/expand' );
    },
    
    renderPage: function(e, page) {
    	var today = new Date();
	var thisWeek = new Date( Date.UTC( today.getFullYear(),	today.getMonth(), today.getDate() - today.getDay() + 1, 0, 0, 0 ) );
	var currentWeek = new Date( Date.UTC( thisWeek.getFullYear(), thisWeek.getMonth(), thisWeek.getDate() + ( 7 * page ), 0, 0, 0 ) );

	if (currentWeek.getTime() < window.GamingCalendarModal.firstWeek.getTime()) {
		window.GamingCalendarModal.renderPage(e, page + 1);
		return;
	}
	
	if ( e ) { e.preventDefault(); }
	var targetWeek = page;
	var offset = targetWeek;
	var weeksToLoad = 2;
	if ('object' == typeof window.GamingCalendarData['entries'][targetWeek]) {
		offset++;
		weeksToLoad--;
	}

	if ('object' == typeof window.GamingCalendarData['entries'][targetWeek + 1]) {
		weeksToLoad--;
	}
	
	if (0 < weeksToLoad) {
		$.get('/wikia.php?controller=GamingCalendar&method=getEntries&format=json&weeks='
		+ weeksToLoad + '&offset=' + offset, function( data ) {
			$(data.entries).each( function(index, value) {
				if ( 1 == value.length && page > 0 ) {
					window.GamingCalendarModal.lastWeek = offset + index - 1;
					if (offset + index < page + 1) {
						window.GamingCalendarModal.renderPage(e, page - 1);
						return;
					}
				}
				window.GamingCalendarData['entries'][offset + index] = value;
			});
			window.GamingCalendarModal.renderPage(e, page);
			return;
		});
	}

	var html = window.GamingCalendarModal.renderWeek(window.GamingCalendarData['entries'][targetWeek]) +
			window.GamingCalendarModal.renderWeek(window.GamingCalendarData['entries'][targetWeek + 1]);

	var obj = $('#GamingCalendar .weeks > ul');
	obj.children('li').addClass('remove');

	$().log(window.GamingCalendarModal.displayWeek + ', ' + page);

	if (window.GamingCalendarModal.displayWeek > page) {
		$(html).prependTo(obj).delay(100);
		obj.children('li.new').animate({width: 290 }, 250, function() { obj.children('li.remove').remove(); });
	} else {
		$(html).appendTo(obj);
		obj.children('li.new').width(290).delay(100);
		obj.children('li.remove').animate({width: 0, opacity: 0 }, 250, function() { obj.children('li.remove').remove(); });
	}
	window.GamingCalendarModal.bindEventHandlers(page);
	window.GamingCalendarModal.displayWeek = page;
	return;
    },

	bindEventHandlers: function(page) {
		var today = new Date();
		var thisWeek = new Date( Date.UTC( today.getFullYear(), today.getMonth(), today.getDate() - today.getDay() + 1, 0, 0, 0 ) );
		var currentWeek = new Date( Date.UTC( thisWeek.getFullYear(), thisWeek.getMonth(), thisWeek.getDate() + ( 7 * page ), 0, 0, 0 ) );
		var prevMonth = new Date( Date.UTC( currentWeek.getFullYear(), currentWeek.getMonth() - 1, 1, 0, 0, 0 ) );
		var nextMonth = new Date( Date.UTC( currentWeek.getFullYear(), currentWeek.getMonth() + 1, 1, 0, 0, 0 ) );
		var week = 7 * 24 * 3600 * 1000;
		var pagesPrevMonth = Math.ceil( (currentWeek - prevMonth) / week );
		var pagesNextMonth = Math.ceil( (nextMonth - currentWeek) / week );

		var calendarElement = $('#GamingCalendar');

		calendarElement.find('.forward-week').unbind('click').removeClass('disabled');
		calendarElement.find('.forward-week').bind('click', function(event) { GamingCalendarModal.renderPage(event, page + 1); });
		calendarElement.find('.back-week').unbind('click').removeClass('disabled');
		calendarElement.find('.back-week').bind('click', function(event) { GamingCalendarModal.renderPage(event, page - 1); });
		calendarElement.find('.forward-month').unbind('click').removeClass('disabled');
		calendarElement.find('.forward-month').bind('click', function(event) { GamingCalendarModal.renderPage( event, page + pagesNextMonth ); });
		calendarElement.find('.back-month').unbind('click').removeClass('disabled');
		calendarElement.find('.back-month').bind('click', function(event) { GamingCalendarModal.renderPage( event, page - pagesPrevMonth ); });
		calendarElement.find('.scroll-up').unbind('click').bind('click', GamingCalendarModal.scrollUp);
		calendarElement.find('.scroll-down').unbind('click').bind('click', GamingCalendarModal.scrollDown);
		calendarElement.find('.GamingCalendarItem').unbind('click');
		calendarElement.find('.GamingCalendarItem.unselected').bind('click', GamingCalendarModal.expandOrCollapse);

		var todayButton = calendarElement.find('.today');

		todayButton.unbind('click');

		if (0 != page) {
			todayButton.bind('click', function(event) { GamingCalendarModal.renderPage( event, 0 ); } ).removeClass('disabled');
		} else {
			todayButton.addClass('disabled');
		}

		if ( window.GamingCalendarModal.lastWeek && window.GamingCalendarModal.lastWeek < page + 2 ) {
			calendarElement.find('.forward-month').addClass('disabled').unbind('click');
			calendarElement.find('.forward-week').addClass('disabled').unbind('click');
		}

		if ( currentWeek.getTime() <= window.GamingCalendarModal.firstWeek.getTime() ) {
			calendarElement.find('.back-month').addClass('disabled');
			calendarElement.find('.back-month').unbind('click');
			calendarElement.find('.back-week').addClass('disabled');
			calendarElement.find('.back-week').unbind('click');
		}

		$.tracker.byStr( 'gamingCalendar/scroll/forward/week' );
	}
};
