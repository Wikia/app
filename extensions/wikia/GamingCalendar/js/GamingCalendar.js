var GamingCalendar = {
    
    init: function() {
        $('.GamingCalendarModule a.more').bind( 'click', GamingCalendar.showCalendar );
    },
    
    showCalendar: function(e) {
        e.preventDefault();
        // AJAX request to load the data
        var html = $.ajax({
            url: "/wikia.php?controller=GamingCalendar&method=getModalLayout&format=html",
            async: false
        }).responseText;
        // process the data
        // put the data into a modal window
        $.showModal( '', html );
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