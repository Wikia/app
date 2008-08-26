// http://onlinetools.org/articles/unobtrusivejavascript/chapter4.html
function lqt_add_event(obj, evType, fn){ 
	if (obj.addEventListener){ 
		obj.addEventListener(evType, fn, false); 
		return true; 
	} else if (obj.attachEvent){ 
		var r = obj.attachEvent("on"+evType, fn); 
		return r; 
	} else { 
		return false; 
	} 
}

var LqtDateRangeRectifier = function( startsel, endsel ) {
	this.startsel = startsel;
	this.endsel = endsel;
	
	this.oldstart = this.startsel.selectedIndex;
	this.oldend = this.endsel.selectedIndex;

	this.handle_start_changed = function(e) {
		newi = this.startsel.selectedIndex;
		oldi = this.oldstart;
		endi = this.endsel.selectedIndex;
		goal = newi - (oldi - endi); // seem backwards?  it's because
		this.endsel.selectedIndex = Math.max(goal, 0);
		this.oldend = endi;          // later months have smaller
		this.oldstart = newi;        // indexes.
	}

	this.handle_end_changed = function(e){
		this.startsel.selectedIndex = Math.max(this.endsel.selectedIndex,
                                                       this.startsel.selectedIndex)
		this.oldend = this.endsel.selectedIndex;
		this.oldstart = this.startsel.selectedIndex;
	}

	// In order for this instance to recieve the events, we need to capture the
	// current value of 'this' with a closure, because this = the target object
	// in event handlers.
	var me = this;
	lqt_add_event( this.startsel, 'change', function(e) { me.handle_start_changed(e) });
	lqt_add_event( this.endsel, 'change', function(e) { me.handle_end_changed(e) });
}

function lqt_on_load() {
	if(!document.getElementById) return;

	var searchform = document.getElementById("lqt_archive_search_form");
	if ( searchform ) {
		var start = document.getElementById("lqt_archive_start");
		var end =  document.getElementById("lqt_archive_end");

		new LqtDateRangeRectifier( start, end );

		var filter = document.getElementById("lqt_archive_filter_by_date_yes");
		function set_date_filter_radio(e) { filter.checked = true; }
		lqt_add_event(start, 'change', set_date_filter_radio);
		lqt_add_event(end, 'change', set_date_filter_radio);
		if ( !filter.checked ) {
			start.selectedIndex = end.selectedIndex = 0;
		}
		
	}
}

addOnloadHook(lqt_on_load);