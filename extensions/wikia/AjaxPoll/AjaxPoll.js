/**
 * YUI! javascript code for AjaxPoll
 */
YAHOO.namespace( "AjaxPoll" );

YAHOO.AjaxPoll.Callback = {
	success: function( response ) {
//	var answer = YAHOO.Tools.JSONParse( response.responseText );
// simple hack to avoid YUI "parseJSON error":
		var answer = eval('(' + response.responseText + ')');
		var votes = answer["votes"];

		YAHOO.util.Dom.setStyle('pollSubmittingInfo', 'visibility', 'hidden');

		/**
		 * get all spans with class "wpBar<id>"
		 */
		var bars = YAHOO.util.Dom.getElementsByClassName( "wpPollBar" + answer["id"], "div" );
		for( var b in bars ) {
			/**
			 * now take id of span and check new value in votes, if not defined
			 * means 0px
			 */
			var bar_id = bars[ b ].id;
			if( bar_id.match( /^wpPollBar\w{32}\-(\d+)$/ ) ) {
				var key = RegExp.$1;
				if( votes[ key ] ) {
					YAHOO.util.Dom.setStyle( [ bar_id ], "width", votes[ key ][ "percent" ] + "%" );
					YAHOO.util.Dom.get( "wpPollVote" + answer["id"] + "-" + key ).innerHTML = votes[ key ][ "value" ];
					YAHOO.util.Dom.get( "wpPollVote" + answer["id"] + "-" + key ).title = votes[ key ][ "title" ];
				}
				else {
					YAHOO.util.Dom.setStyle( [ bar_id ], "width", "0px" );
					YAHOO.util.Dom.get( "wpPollVote" + answer["id"] + "-" + key ).innerHTML = 0;
					YAHOO.util.Dom.get( "wpPollVote" + answer["id"] + "-" + key ).title = 0;
				}
			}
		}

		/**
		 * update total div and status
		 */
		YAHOO.util.Dom.get( "wpPollTotal" + answer["id"] ).innerHTML = answer["total"];
		YAHOO.util.Dom.get( "wpPollStatus" + answer["id"] ).innerHTML = answer["status"];
	},
	failure: function( response ) {},
	timeout: 50000
};

YAHOO.AjaxPoll.submit = function( e, data ) {
	YAHOO.util.Dom.setStyle('pollSubmittingInfo', 'visibility', 'visible');
	YAHOO.util.Event.preventDefault( e );
	YAHOO.AjaxPoll.form = YAHOO.util.Dom.get( data["form"] );
	YAHOO.util.Connect.setForm( YAHOO.AjaxPoll.form );
	var amp = new RegExp("&amp;", "g");
	data["url"]	= data["url"].replace( amp, "&" );
	YAHOO.util.Connect.asyncRequest( "POST", data["url"], YAHOO.AjaxPoll.Callback );
	return false;
}

YAHOO.AjaxPoll.init = function() {
	for( var key in AjaxPollSubmitsArray ) {
		YAHOO.util.Event.addListener(
			AjaxPollSubmitsArray[ key ][ "submit" ],
			"click",
			YAHOO.AjaxPoll.submit,
			{ "form":AjaxPollSubmitsArray[ key ][ "id" ], "url":AjaxPollSubmitsArray[ key ][ "url" ] }
		);
	}
};

YAHOO.util.Event.onDOMReady( YAHOO.AjaxPoll.init );
