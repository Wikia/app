$(function() {
	GamingCalendar.init();
});

var GamingCalendar = {

    init: function() {
	$.get( '/wikia.php?controller=GamingCalendar&method=getEntries&format=json', function(data) {
                        // get the current cookieVal
                        var cookieVal = GamingCalendar.getCookieVal();
                        
                        // 0 if not set
                        if ( cookieVal == null ) {
                            cookieVal = 1;
                        // +1 othewise
                        } else {
                            cookieVal++;
                        }
                        
                        // reset, if no such item
                        if ( 'undefined' == typeof data.entries[cookieVal] ) {
                            cookieVal = 1;
                        }
                        
                        // store the cookieVal for future requests
                        GamingCalendar.setCookieVal( cookieVal );
                        
                        // tell modal, which item to extend
			data.entries[0][cookieVal].extended = true;
                        
			// store for future use
			window.GamingCalendarData = data;

			// grab the first item
			item = data.entries[0][cookieVal];
			
			// generate HTML from template
			var itemHTML = GamingCalendar.renderItem(item);
			
			// insert into module (after the h1)
			$('.GamingCalendarModule h1').after(itemHTML);
        });
		$('.GamingCalendarModule .more').click(GamingCalendar.showCalendar);
	},
        
    getCookieVal: function() {
            var cookieStart = document.cookie.indexOf( 'wikiagc=' );
            if ( cookieStart == -1 ) {
                return null;
            }
            var valueStart = document.cookie.indexOf( '=', cookieStart ) + 1;
            var valueEnd   = document.cookie.indexOf( ';', valueStart );
            if ( valueEnd == -1 ) {
                valueEnd = document.cookie.length;
            }
            var val = document.cookie.substring( valueStart, valueEnd );
            if ( val != null ) {
                return unescape( val );
            }
            return null;
    },
    
    setCookieVal: function( value ) {
        var expiration = new Date( new Date().getTime() + 3600000 ); // 1 hour
        var str = 'wikiagc=' + escape( value ) + '; path=/ ; expires=' + expiration.toGMTString();
        document.cookie = str;
    },
    
    renderItem: function(item) {
    	var template = $('#GamingCalendarItemTemplate').html();

        if ( item.subTitle ) {
            template = template.replace('%gameSubTitle%', '<span class="game-subtitle">' + item.subTitle + '</span>');
        } else {
            template = template.replace('%gameSubTitle%', '');
        }
        
        template = template.replace('%gameTitle%', item.title);
        template = template.replace('%description%', item.description);
    	template = template.replace('%imageSrc%', item.image.src);
    	template = template.replace('%moreInfoUrl%', item.moreInfoUrl);
    	template = template.replace('%preorderUrl%', item.preorderUrl);
    	template = template.replace('%systems%', item.systems.join(', '));
        
        var months = new Array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
        var date = new Date(item.releaseDate * 1000); // miliseconds!
    	template = template.replace('%month%', months[date.getMonth()]);
    	template = template.replace('%day%', date.getDate());

    	return template;
    },

    renderWeek: function(week) {
	var template = $('#GamingCalendarWeekTemplate').html();
	var itemsHtml = '';

	weekdates = week.shift();

	template = template.replace('%start%', weekdates[0] );
	template = template.replace('%end%', weekdates[1] );

	for ( var i = 0; i < week.length; i++  ) {
		itemsHtml = itemsHtml + '<li>' + GamingCalendar.renderItem( week[i] ) + '</li>';
	}

	template = template.replace( '%items%', itemsHtml );

	return template;
    },
    
	showCalendar: function(e) {
		e.preventDefault();
		
		// Load CSS and JS
		$.getResources([
			$.getSassCommonURL('/extensions/wikia/GamingCalendar/css/GamingCalendarModal.scss'),
			wgScriptPath + '/extensions/wikia/GamingCalendar/js/GamingCalendarModal.js'
		], function() {
			// Get markup
			$.get('/wikia.php?controller=GamingCalendar&method=getModalLayout&format=html', function(html) {
				var weekNo = 1;
				var weeks = window.GamingCalendarData['entries'];
				for ( var i = 0; i < weeks.length; i++ ) {
					var weekHtml = GamingCalendar.renderWeek( weeks[i] );
					html = html.replace( '%week' + weekNo + '%', weekHtml );

					weekNo++;
				}
				$(html).makeModal({width: 710});
                                $('#GamingCalendar .scroll-up').click(GamingCalendar.scrollUp);
                                $('#GamingCalendar .scroll-down').click(GamingCalendar.scrollDown);
                                $('#GamingCalendar .GamingCalendarItem').click(GamingCalendar.expandOrCollapse);
			});
		});
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
        
    }
}
