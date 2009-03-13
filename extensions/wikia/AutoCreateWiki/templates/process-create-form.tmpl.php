<!-- s:<?= __FILE__ ?> -->
<style type="text/css">
#awc-process {
	visibility: hidden;
	height: 1px;
}
.process-title {
	font-weight: normal;
	display: block;
	font-size: 13pt;
}
.process-info {
	font-size: 11pt;
	font-style: italic;
}
.process-info ul {
	overflow: hidden;	
	padding: 2px 0;
}
.process-info ul li {
	padding: 2px;
	list-style-image:none;
	list-style-position:outside;
	list-style-type:none;
	color: #666;
	white-space:nowrap
}
.process-row-title {
	width:300px;
	padding:2px 10px 2px 0px;
	float:left;
}
.process-row-loader {
	width:80px;
	padding:6px;
}

</style>
<div id="awc-info">
	<fieldset class="process-title">
	<legend><?=wfMsg('autocreatewiki-log-title')?></legend>
		<div id="awc-log" class="process-info">
		<?=wfMsg('autocreatewiki-step0')?><br />
		</div>
	</legend>
</div>
<br />
<iframe id="awc-process" height="10" width="50"></iframe>
<script type="text/javascript">
/*<![CDATA[*/
var YD = YAHOO.util.Dom;
var YE = YAHOO.util.Event;
var YC = YAHOO.util.Connect;

YE.onDOMReady(function () {
	var loop = 0;
	var ifr = YD.get('awc-process');
	var titleUrl = '<?=$mTitle->getLocalURL()."/Processing"?>';
	var wgAjaxPath = wgScriptPath + wgScript;
	var redirServer = '<?=$subdomain?>';
	var redirMsg = '<?=wfMsg('autocreatewiki-redirect', $subdomain . "." . $domain)?>';
	var usedMsg = new Array();

/*	var addLogRow = function(inx, title, prevInfo) {
		var logSteps = document.getElementById('awc-steps');
		if ( logSteps ) {
			// <li>
			var stepRow = document.createElement('li');
			stepRow.id = "awc-step" + inx;
			// first div awc-titleX
			var awcTitle = document.createElement('div');
			YD.addClass(awcTitle, 'process-row-title');
			awcTitle.id = "awc-title" + inx;
			awcTitle.innerHTML = title;
			
			// second div awc-logger0
			var awcLogger = document.createElement('div');
			YD.addClass(awcLogger, 'process-row-loader');
			awcLogger.id = "awc-logger" + inx;
			awcLogger.innerHTML = '';
			
			// disable previews logger
			var prevId = inx - 1;
			var prevRow = document.getElementById('awc-step' + prevId);
			if (prevId >= 0 && prevRow) {
				var prevLogger = document.getElementById('awc-logger' + prevId);
				prevLogger.innerHTML = prevInfo;
			}
			
			// append div to li
			stepRow.appendChild(awcTitle);
			stepRow.appendChild(awcLogger);
			
			// append li to ul
			logSteps.appendChild(stepRow);
		}
	}
*/
	var addLog = function (inx, text, resType)	{
		var logSteps = YD.get('awc-log');
		var styleColor = (resType == 'OK' || resType == 'END') ? "green" : "red";
		var styleMsg = (resType == 'OK' || resType == 'END') ? '<?=wfMsg('autocreatewiki-done')?>' : '<?=wfMsg('autocreatewiki-error')?>';
		var msgType = (resType != 'END') ? '&nbsp;&nbsp;<strong style="color:' + styleColor + '">' + styleMsg + '</strong>' : "";
		if (inx != 0) {
			var info = logSteps.innerHTML;
			logSteps.innerHTML = info + "<br />" + text + msgType;
		} else {
			logSteps.innerHTML = text + msgType;
		}
	}

	var prevMsg = "";
	var checkProcess = function () {
		var __callback = {
			success: function( oResponse ) {
				var data = YAHOO.Tools.JSONParse(oResponse.responseText);
				var isError = 0;
				var isEnd = 0;
				if (loop == 0) {
					ifr.src = titleUrl;
				}
				if ( data ) {
					for (i in data) {
						var rec = data[i];
						if (rec.info != 'undefined' && rec.info != '') {
							if ( !usedMsg["'" + rec.info + "'"] ) {
								addLog(loop, rec.info, rec.type);
							}
						}
						if (rec.type == 'ERROR') {
							isError++;
						}
						if (rec.type == 'END') {
							isEnd++;
						}
						usedMsg["'" + rec.info + "'"] = rec.type;
					}
					loop++;
				}
				
				if (isEnd > 0) {
					addLog(loop, '<br />' + redirMsg, 'OK');
					window.location.href = 'http://'+redirServer+'.<?=$domain?>';
				} else if ( !(isError > 0) ) {
					if (loop < 50) {
						setTimeout(checkProcess, 1000);
					}
				} 
			},
			failure: function( oResponse ) {
				var res = oResponse.responseText;
				addLog(loop, res + '&nbsp;&nbsp;<strong style="color:red"><?=wfMsg('autocreatewiki-error')?></strong>');
			},
			timeout: 5000
		}
				
		YC.asyncRequest( "GET", wgAjaxPath + "?action=ajax&rs=axACWRequestCheckLog", __callback);
	}
	
	checkProcess();
});
/*]]>*/
</script>
	

