var wgUADTreshold = 0;

var UADtracker = {

	COOKIE_NAME: 'UADtracker',
	COOKIE_LIFESPAN: 7776000,

	init: function() {
		UADtracker.check();
		$('body').bind('click', UADtracker.events );
	},

	check: function() {

		var UADTag = UADtracker.getCookie();
		$().log( UADTag, UADTag );
		if ( UADTag.date ){
			if ( wgUADTreshold < UADTag.priority ){
				if ( UADTag.date == UADtracker.getCurrentDate() ){
					UADtracker.addVisit();
					UADtracker.addVisitedWikis();
				} else {
					UADtracker.update();
				}
			}
		} else {
			UADtracker.createCookie();
		}
	},

	update: function(){
		$.get( "/wikia.php", {controller: "UAD"} );
	},

	getCurrentDate: function(){

		var currDate = new Date();
		var strDate = currDate.getFullYear() + '-' + ( currDate.getMonth() + 1 ) + '-' + currDate.getDate();
		return strDate;
	},

	createCookie: function(){

		UADtracker.setCookieData( UADtracker.freshCookie() );

	},

	freshCookie: function(){

		return {
			priority: Math.floor( Math.random()*10000 ),
			date: UADtracker.getCurrentDate(),
			events: {
				'edit': 0,
				'save': 0,
				'comment': 0,
				'visit': 1,
				'visitedWikis' : [ wgCityId ]
			}
		}
	},

	addVisit: function(){

		var UADTag = UADtracker.getCookie();
		UADTag.events.visit = UADTag.events.visit + 1;
		UADtracker.setCookieData( UADTag );
	},

	addEdit: function(){

		var UADTag = UADtracker.getCookie();
		UADTag.events.edit = UADTag.events.edit + 1;
		UADtracker.setCookieData( UADTag );
	},

	addSave: function(){

		var UADTag = UADtracker.getCookie();
		UADTag.events.save = UADTag.events.save + 1;
		UADtracker.setCookieData( UADTag );
	},

	addComment: function(){

		var UADTag = UADtracker.getCookie();
		UADTag.events.comment = UADTag.daeventsta.comment + 1;
		UADtracker.setCookieData( UADTag );
	},

	addVisitedWikis: function(){

		var UADTag = UADtracker.getCookie();
		UADTag.events.visitedWikis.push( wgCityId );
		UADTag.events.visitedWikis = $.unique( UADTag.events.visitedWikis );
		UADtracker.setCookieData( UADTag );
	},

	setCookieData: function( cookieData ){

		$.cookies.set(
			UADtracker.COOKIE_NAME,
			JSON.stringify( cookieData ),
			{hoursToLive: 2400}
		);
	},

	getCookie: function(){

		var cookieData = $.cookies.get( UADtracker.COOKIE_NAME );

		if ( cookieData !== "undefined" ){
			return JSON.parse( cookieData );
		} else {
			return false;
		}
	},

	events: function( ev ){

		var node = $(ev.target);

		if ( node.attr('data-id') == 'edit' ){
			UADtracker.addEdit();
		}
		if ( node.attr('id') == 'wpSave' ){
			UADtracker.addSave();
		}
	}
};
//on content ready
wgAfterContentAndJS.push( UADtracker.init );

