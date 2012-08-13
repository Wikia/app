var GamingCalendar = {
	data: {},

    init: function() {
		$.nirvana.getJson('GamingCalendar', 'getEntries', {weeks:3, offset: 0}, $.proxy(function(data) {
			// get the current cookieVal
			var cookieVal = this.getCookieVal();

			// 0 if not set
			if ( cookieVal == null ) {
				cookieVal = 1;
			// +1 otherwise
			} else {
				cookieVal++;
			}

			// reset, if no such item
			if ( 'undefined' == typeof data.entries[0][cookieVal] ) {
				cookieVal = 1;
			}

			// store the cookieVal for future requests
			this.setCookieVal(cookieVal);

			// tell modal, which item to expand
			data.entries[0][cookieVal].expanded = true;

			// store for future use
			this.data = data;
			this.data.thisWeek = 0;

			// grab the first item
			var item = data.entries[0][cookieVal];

			// generate HTML from template
			var itemHTML = this.renderItem(item, false);

			// insert into module (after the h1)
			$('.GamingCalendarModule h1').after(itemHTML);
        }, this));

		$('.GamingCalendarModule').click(function(e) {
			e.preventDefault();
			GamingCalendar.showCalendar();
		});

		var modal = $.getUrlVar('showGamingCalendar');
		if(modal) {
			GamingCalendar.showCalendar();
		}
	},

	getCookieVal: function() {
		return $.cookies.get('wikiagc');
    },

	setCookieVal: function(value) {
		$.cookies.set('wikiagc', value, {
			hoursToLive: 1,
			path: wgCookiePath,
			domain: wgCookieDomain
		});
	},

	renderItem: function(item, expanded) {
		var template = $('#GamingCalendarItemTemplate').html();

		if ( item.gameSubtitle ) {
			template = template.replace('##gameSubTitle##', '<span class="game-subtitle">' + item.gameSubtitle + '</span>');
		} else {
			template = template.replace('##gameSubTitle##', '');
		}

		if ( expanded ) {
			template = template.replace('##expanded##', 'selected');
		} else {
			template = template.replace('##expanded##', 'unselected');
		}

		var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
		var date = new Date(item.releaseDate * 1000); // miliseconds!
		template = template.replace('##month##', months[date.getUTCMonth()]);
		template = template.replace('##day##', date.getUTCDate());

		template = template.replace('##gameTitle##', item.gameTitle);
		template = template.replace('##description##', item.description || '');
		template = template.replace('##imageSrc##', item.image.src);
		template = template.replace('##moreInfoUrl##', item.moreInfoUrl);
		var orderPhrase = 'Pre-order now';
		var now = new Date();
		if (now >= date) {
			orderPhrase = 'Available now';
		}
		template = template.replace('##preorderLink##', item.preorderUrl ? '<a href="'+item.preorderUrl+'" class="game-pre-order" target="_blank">'+orderPhrase+'</a>' : '');
		template = template.replace('##systems##', item.systems ? item.systems.join(', ') : '');
		template = template.replace('##rating##', item.rating || '');

		return template;
	},

	showCalendar: function() {

		// Check, whether the GamingCalendarModal has already been triggered once.
		// We don't want the resources to be retrieved more than once.
		if ( 'object' == typeof GamingCalendarModal && GamingCalendarModal.initialized ) {
			GamingCalendarModal.modal.showModal();
			return;
		}

		// Load CSS and JS
		$.getResources([
			$.getSassCommonURL('/extensions/wikia/GamingCalendar/css/GamingCalendarModal.scss'),
			wgExtensionsPath + '/wikia/GamingCalendar/js/GamingCalendarModal.js'
		], function() {
			// Get markup
			$.get('/wikia.php?controller=GamingCalendar&method=getModalLayout&format=html', function(html) {
				GamingCalendarModal.modal = $(html).makeModal({width: 588, persistent: true, blackoutOpacity: 0.80});
				GamingCalendarModal.init();
			});
		});
    }
}

$(function() {
	GamingCalendar.init();
});