YAHOO.util.Event.onDOMReady(function() {

	if(!$('ue_msg')) {
		return;
	}

	var dacookie = YAHOO.Tools.getCookie("wgWikiaUserEngagement");
	if(!dacookie) {
		return;
	}

	var callback = {
		success: function(o) {
			if(o.responseText !== undefined) {
				var aData = YAHOO.Tools.JSONParse(o.responseText);
				var div = $('ue_msg');
				div.innerHTML = '';
				if(aData["response"]!='') {
					if(aData["msg_id"]!='') {
						YAHOO.Wikia.Tracker.trackByStr(null, 'userengagement/msg_view' + aData["msg_id"]);
					}
					div.innerHTML = aData["response"];
					div.style.display = "block";
					document.getElementsByTagName('body')[0].style.width = '100%';
				}
			}
		},
		timeout: 50000
	};

	var oData = parseInt(dacookie.charAt(0)) + 1;
	if((!isNaN(oData)) && (oData < 9)){
		YAHOO.util.Connect.asyncRequest('GET', wgScriptPath + '/index.php?action=ajax&rs=UserengagementAjax&m='+oData, callback);
	}
});