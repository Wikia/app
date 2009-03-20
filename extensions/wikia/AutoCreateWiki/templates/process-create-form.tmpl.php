<!-- s:<?= __FILE__ ?> -->
<style type="text/css">
#awc-process { visibility: hidden; height: 1px; }
#awc-log { text-align: center; }
</style>
<div style="text-align:center">
	<div><img src="<?=$wgExtensionsPath?>/wikia/AutoCreateWiki/images/Installation_animation.gif?<?=$wgStyleVersion?>" width="700" height="142" /></div>
	<div id="awc-log" class="note"></div>
</div>
<br />
<iframe id="awc-process" height="10" width="50"></iframe>
<script type="text/javascript">
/*<![CDATA[*/
var YD = YAHOO.util.Dom;
var YE = YAHOO.util.Event;
var YC = YAHOO.util.Connect;
var YT = YAHOO.Tools;

YE.onDOMReady(function () {
	var loop = 0;
	var ifr = YD.get('awc-process');
	var titleUrl = '<?=$mTitle->getLocalURL()."/Testing"?>'; //Processing
	var wgAjaxPath = wgScriptPath + wgScript;
	var redirServer = '<?=$subdomain?>';
	var errorMsg = '<?=wfMsg('autocreatewiki-errordefault')?>';
	var usedMsg = new Array();

	var setLog = function (inx, text, resType)	{
		var logSteps = YD.get('awc-log');
		alert("logSteps => " + logSteps);
		var styleColor = (resType == 'OK' || resType == 'END') ? "green" : "red";
		var styleMsg = (resType == 'OK' || resType == 'END') ? '<?=wfMsg('autocreatewiki-done')?>' : '<?=wfMsg('autocreatewiki-error')?>';
		var msgType = (resType != 'END') ? '&nbsp;&nbsp;<strong style="color:' + styleColor + '">' + styleMsg + '</strong>' : "";
		var msg = text + ((resType != '') ? msgType : "");
		alert(msg);
		logSteps.innerHTML = msg;
		if (typeof TieDivLibrary != "undefined" ) {
			TieDivLibrary.calculate();
		};
	}

	var prevMsg = "";
	var checkProcess = function () {
		var __callback = {
			success: function( oResponse ) {
				var data = YT.JSONParse(oResponse.responseText);
				var isError = isEnd = 0;
				if (loop == 0) ifr.src = titleUrl;
				alert(loop);
				if ( data ) {
					if (typeof data['info'] != 'undefined' && data['info'] != '') {
						alert (data['info'] + "=>" + data['type']);
						if ( !usedMsg["'" + data['info'] + "'"] ) {
							setLog(loop, data['info'], data['type']);
						}
					}
					if (data['type'] == 'ERROR') isError++;
					if (data['type'] == 'END') isEnd++;
					usedMsg["'" + data['info'] + "'"] = data['type'];
					loop++;
				}
				
				alert("isEnd = " + isEnd);
				alert("isError = " + isError);
				if (isEnd > 0) {
					//window.location.href = 'http://'+redirServer+'.<?=$domain?>';
				} else if ( !(isError > 0) ) {
					if (loop < 20) {
						alert('timeout');
						setTimeout(checkProcess, 666);
					} else {
						setLog(loop, errorMsg, 'ERROR');
					}
				} 
			},
			failure: function( oResponse ) {
				var res = oResponse.responseText;
				setLog(loop, res, 'ERROR');
			},
			timeout: 20000
		}
				
		var url = wgAjaxPath + "?action=ajax&rs=axACWRequestCheckLog";
		YC.asyncRequest( "GET", url, __callback);
	}
	
	checkProcess();
});
/*]]>*/
</script>
