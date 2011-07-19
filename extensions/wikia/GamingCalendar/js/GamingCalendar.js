var GamingCalendar = {
    
    init: function() {
        $('.GamingCalendarModule a.more').bind( 'click', GamingCalendar.showCalendar );
    },
    
    showCalendar: function(e) {
        e.preventDefault();
        // AJAX request to load the data
        // process the data
        // put the data into a modal window
        $.showModal('', 'This is the GamingCalendar! ;-)');
        // perform additional actions
    }
    
}

wgAfterContentAndJS.push(
    function() {
        $('document').ready(function() {
            GamingCalendar.init();
        });
    }
);