$(function() {
	GamingCalendar.init();
});

var GamingCalendar = {

    init: function() {
	$.get( '/wikia.php?controller=GamingCalendar&method=getEntries&format=json&startDate=1310947200&endDate=1311465600', function(data) {
			// we pick "randomly" entry #0
			data.entries[0].extended = true;
			// store for future use
			window.GamingCalendarData = data;
			
			// grab the first item
			item = data.entries[0];
			
			// generate HTML from template
			var itemHTML = GamingCalendar.renderItem(item);
			
			// insert into module (after the h1)
			$('.GamingCalendarModule h1').after(itemHTML);
        });
		$('.GamingCalendarModule .more').click(GamingCalendar.showCalendar);        
	},
    
    renderItem: function(item) {
    	var template = $('#GamingCalendarItemTemplate').html();
		var date = new Date(item.releaseDate);

    	template = template.replace('%description%', item.description);
    	template = template.replace('%gameTitle%', item.gameTitle);
    	template = template.replace('%imageSrc%', item.image.src);
    	template = template.replace('%moreInfoUrl%', item.moreInfoUrl);
    	template = template.replace('%preorderUrl%', item.preorderUrl);
    	template = template.replace('%systems%', item.systems.join(', '));
    	template = template.replace('%month%', date.getMonth() + 1);
    	template = template.replace('%day%', date.getDate());

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
				$(html).makeModal({width: 710});
			});
		});
    }    
}
