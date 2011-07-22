var GamingCalendarModal = {
	initialized: false,
	modal: null,
	displayWeek: 0,
	
	init: function() {
		$().log('init');
		if (GamingCalendarModal.initialized) {
			return;
		} else {
			GamingCalendarModal.initialized = true;
		}
		
		// Set up the initial weeks
		var weekNo = 1;
		var weeks = window.GamingCalendarData['entries'];
		for ( var i = 0; i < weeks.length; i++ ) {
			var weekHtml = GamingCalendarModal.renderWeek( weeks[i] );
			window.GamingCalendarData['entries'][i] = weekHtml;
			window.GamingCalendarModal.renderPage( null, 0 );
			weekNo++;
		}
		
		
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
		    itemsHtml = itemsHtml + '<li>Stay tuned!</li>';
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
	$('#GamingCalendar').find('.GamingCalendarItem.selected').slideUp('slow',function() { $(this).removeClass('selected').addClass('unselected').slideDown(); });
	$(this).slideUp('slow', function() { $(this).removeClass('unselected').addClass('selected').slideDown(); });
	$.tracker.byStr( 'gamingCalendar/brick/expand' );
    },
    
    renderPage: function(e, page) {
	if ( e ) { e.preventDefault(); }
	var targetWeek = window.GamingCalendarData.displayedWeek + page;
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
		$.get('/wikia.php?controller=GamingCalendar&method=getEntries&format=json&weeks=' + weeksToLoad + '&offset=' + offset, function( data ) {
			$(data.entries).each( function(index, value) {
				window.GamingCalendarData['entries'][offset + index] = value;
			});
			window.GamingCalendarModal.renderPage(e, page);
			return;
		});
	}

	var html = window.GamingCalendarModal.renderWeek(window.GamingCalendarData['entries'][targetWeek]) +
			window.GamingCalendarModal.renderWeek(window.GamingCalendarData['entries'][targetWeek + 1]);

	var obj = $('#GamingCalendar .weeks > ul');
	obj.hide(500, function() { obj.html(html); obj.show(500, function() { window.GamingCalendarModal.bindEventHandlers(page); }); });
	return;
    },

	bindEventHandlers: function(page) {

		// Bind event handlers
		$('#GamingCalendar')
			.find('.scroll-up').live('click', GamingCalendarModal.scrollUp).end()
			.find('.scroll-down').live('click', GamingCalendarModal.scrollDown).end()
			.find('.forward-week').live('click', function(event) { GamingCalendarModal.renderPage(event, page + 1); } ).end()
			//.find('.forward-month').live('click', function(event) { GamingCalendarModal.renderPage(event, -4); } ).end()
			.find('.back-week').live('click', function(event) { GamingCalendarModal.renderPage(event, page -1 ); } ).end()
			//.find('.back-month').live('click', function(event) { GamingCalendarModal.renderPage(event, 4); } ).end()
			.find('.today').live('click', function(event) { GamingCalendarModal.renderPage(event, 0); } ).end()
			.find('.GamingCalendarItem.unselected').live('click', GamingCalendarModal.expandOrCollapse);

		$.tracker.byStr( 'gamingCalendar/scroll/forward/week' );
	}
};
