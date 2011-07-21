var GamingCalendarModal = {
	initialized: false,
	modal: null,
	
	init: function() {
		$().log('init');
		if (GamingCalendarModal.initialized) {
			return;
		} else {
			GamingCalendarModal.initialized = true;
		}
		
		// Bind event handlers
		$('#GamingCalendar')
			.find('.scroll-up').live('click', GamingCalendarModal.scrollUp).end()
			.find('.scroll-down').live('click', GamingCalendarModal.scrollDown).end()
			.find('.forward-week').live('click', GamingCalendarModal.forwardWeek).end()
			.find('.GamingCalendarItem').live('click', GamingCalendarModal.expandOrCollapse);
		
		// Set up the initial weeks
		var weekNo = 1;
		var weeks = window.GamingCalendarData['entries'];
		for ( var i = 0; i < weeks.length; i++ ) {
			var weekHtml = GamingCalendarModal.renderWeek( weeks[i] );
			//html = html.replace( '%week' + weekNo + '%', weekHtml );
			$('#GamingCalendarWrapper .weeks > ul').append(weekHtml);

			weekNo++;
		}		
		$().log('finished init');
	},

	renderWeek: function(week) {
		var template = $('#GamingCalendarWeekTemplate').html();
		var itemsHtml = '';

		weekdates = week.shift();

		template = template.replace('%start%', weekdates['start'] );
		template = template.replace('%end%', weekdates['end'] );

		template = template.replace('%startmonth%', weekdates['startmonth'] );
		template = template.replace('%endmonth%', weekdates['endmonth'] );
		
		template = template.replace('%week-caption%', weekdates['caption'] );

		for ( var i = 0; i < week.length; i++  ) {
			if ( week[i].expanded ) {
				itemsHtml = itemsHtml + '<li>' + GamingCalendar.renderItem( week[i], true ) + '</li>';
			} else {
				itemsHtml = itemsHtml + '<li>' + GamingCalendar.renderItem( week[i], false ) + '</li>';
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
    },
    
    expandOrCollapse: function(e) {
        
    },

    forwardWeek: function(e) {
        e.preventDefault();
        var targetWeek = window.GamingCalendarData.displayedWeek + 2;
        var offset = targetWeek - window.GamingCalendarData.thisWeek;

        // check if data has been pulled in yet and request if needed
        if ( typeof window.GamingCalendarData['entries'][targetWeek] == 'undefined' ) {
		$.get( '/wikia.php?controller=GamingCalendar&method=getEntries&format=json&weeks=1&offset=' + offset, function(data) {
			window.GamingCalendarData.entries[targetWeek] = data.entries[0];

			var html = GamingCalendarModal.renderWeek( data.entries[0] );

			var obj = $('#GamingCalendar .weeks ul');
			obj.append( html );

			obj.children().first().animate({
				'margin-left': '-290'
			}, 500);
		});
	}
    }
};
