YAHOO.namespace("wikia.UserProfile");
var Event = YAHOO.util.Event;

(function() { 
    
YAHOO.wikia.UserProfile = {
    
	init: function() {
        var optArray = new Array("all", "last_edits", "last_votes", "gift_sent", "gift_rec", "friend", "foe");
        for (var i in optArray) {
            Event.addListener("wk-activity-" + optArray[i], "click", YAHOO.wikia.UserProfile.ShowUserActivityEvent, [optArray[i]]);
        }
    },
    
    ShowUserActivityEvent: function( e, data ) {
        var filter = data[0];
        var div = document.getElementById('activity-data');
        var username = document.getElementById('activity-user').value;
        params = "&rsargs[0]=" + filter + "&rsargs[1]=" + username;

        var oShowUserActivityCallback = {
            success: function( oResponse ) {
                div.innerHTML = oResponse.responseText;
            },
            failure: function( oResponse ) {
                div.innerHTML = oResponse.responseText;
            }
        };

        var baseurl = "/index.php?action=ajax&rs=wfwkGetLastActivity" + params;
        YAHOO.util.Connect.asyncRequest( "GET", baseurl, oShowUserActivityCallback);
        div.innerHTML = '<div align="center"><img src="http://images.wikia.com/skins/common/progress-wheel.gif" width="16" height="16" alt="wait" border="0" /></div>';
        
        return true;
    }
}
Event.onDOMReady(YAHOO.wikia.UserProfile.init, YAHOO.wikia.UserProfile, true); 
}
)();
