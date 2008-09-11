YAHOO.util.Event.onDOMReady(function() {
	
	if(!$('ue_msg')) {
	  return;
	}

	var dacookie = YAHOO.Tools.getCookie("wgWikiaUserEngagement");
	if(!dacookie) {
	 var oData = 0;	
	}else{
	 var oData = parseInt(dacookie.charAt(0));	
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

	if( oData < 9 ){
		var cExpire = new Date();
		cExpire.setMonth( cExpire.getMonth()+1 );
		YAHOO.Tools.setCookie( 'wgWikiaUserEngagement', oData+1, cExpire, '/' );
		YAHOO.util.Connect.asyncRequest('GET', wgScriptPath + '/index.php?action=ajax&rs=UserengagementAjax&m='+oData + '&lan=' + wgUserLanguage, callback);
	}
});