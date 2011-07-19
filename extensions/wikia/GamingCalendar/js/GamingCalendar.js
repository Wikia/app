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
            item = data.entries[0];
            // extract date
            // split title by : and do h2 and h3
            // systems to comma separated
            // open the calendar link
            // but right now just a shortcut
            html = '<div class="calendar"><div class="month">July</div><div class="day"><span>14</span></div></div>';
            html += '<img src="http://images4.wikia.nocookie.net/__spotlights/images/b0822292901836dabc186d0979b1f91f.jpg" width="" height="" alt="" />';
            html += '<h2>Prince of Persia</h2>';
            html += '<h3>How to Become a Hacker</h3>';
            html += '<p>PS3, paper and pencil</p>';
            html += '<a href="#" class="more">Open&nbsp;Calendar&nbsp;&gt;</a>';
            $('.GamingCalendarModule').append(html);
            $('.GamingCalendarModule a.more').bind( 'click', GamingCalendar.showCalendar );
        });
    },
    
    showCalendar: function(e) {
        e.preventDefault();
      	$.get('/wikia.php?controller=GamingCalendar&method=getModalLayout&format=html', function(html) {
			$(html).makeModal({width: 500, height: 400});
		});
    }    
}
