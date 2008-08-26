wikiaClickEventMessageBox = function ( e, vars ) 
{
	YAHOO.util.Event.preventDefault(e);
	
	var oEventStatsCallback = {
		success: function( oResponse ) {
			//---
			YAHOO.util.Dom.setStyle('systemEventBar', 'display', 'none');
			vars.event_id = "";
			vars.type_id = "";
			//---
			document.location = e.target.href;
		},
		failure: function( oResponse ) {
			//---
			YAHOO.util.Dom.setStyle('systemEventBar', 'display', 'none');
			//---
			document.location = e.target.href;
		}
	};
	
	if ((vars.event_id != "") && (vars.type_id != ""))
	{
		var baseurl = "/index.php?action=ajax&rs=wfwkAddEventInfo";
		baseurl += "&rsargs[0]=" + vars.event_id;
		baseurl += "&rsargs[1]=" + vars.type_id;
		baseurl += "&rsargs[2]=" + vars.id;
		YAHOO.util.Connect.asyncRequest( "GET", baseurl, oEventStatsCallback);
	}
}
