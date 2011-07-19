$(function() {
	GamingCalendar.init();
});

var GamingCalendar = {
    
    init: function() {
        $('.GamingCalendarModule a.more').bind( 'click', GamingCalendar.showCalendar );
    },
    
    showCalendar: function(e) {
        e.preventDefault();
      	$.get('/wikia.php?controller=GamingCalendar&method=getModalLayout&format=html', function(html) {
			$(html).makeModal({width: 500, height: 400});
		});
    }    
}