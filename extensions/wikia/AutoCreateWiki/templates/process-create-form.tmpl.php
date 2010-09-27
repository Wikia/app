<!-- s:<?= __FILE__ ?> -->
<?php
global $wgSuppressWikiHeader, $wgSuppressPageHeader, $wgSuppressFooter, $wgSuppressAds;
$wgSuppressWikiHeader = true;
$wgSuppressPageHeader = true;
$wgSuppressFooter = true;
$wgSuppressAds = true;
?>
<style type="text/css">
#awc-process { visibility: hidden; height: 1px; }
#awc-log { text-align: center; margin: 40px 0 20px;}
#WikiaMainContent { float: none; }
</style>
<div style="text-align:center">
	<div id="awc-log" class="note"></div>
	<div><img id="awc-main-img" src="<?=$wgExtensionsPath?>/wikia/AutoCreateWiki/images/processing.jpg?<?=$wgStyleVersion?>" /></div>
</div>
<br />
<iframe id="awc-process" height="1" width="1"></iframe>
<div style="clear:both"></div>
<script type="text/javascript">
/*<![CDATA[*/

$(function () {
	var loop = 0;
	var ifr = $('#awc-process');
	var titleUrl = '<?php echo $mTitle->getLocalURL()."/Processing?" . $mQuery ?>';
	var wgAjaxPath = wgScriptPath + wgScript;
	var redirServer = '<?=$subdomain?>';
	var waitMsg = '<?=addslashes(wfMsg('autocreatewiki-stepdefault'))?>';
	var errorMsg = '<?=addslashes(wfMsg('autocreatewiki-errordefault'))?>';
	//var usedMsg = new Array();

	var setLog = function (inx, text, resType)	{
		var logSteps = $('#awc-log');
		var styleColor = (resType == 'OK' || resType == 'END') ? "green" : "red";
		var styleMsg = (resType == 'OK' || resType == 'END') ? '<img style="vertical-align:middle;" src="http://images.wikia.com/common/skins/common/images/ajax.gif?<?=$wgStyleVersion?>" width="16" height="16" />' : '<?=wfMsg('autocreatewiki-error')?>';
		var msgType = (resType != 'END') ? '&nbsp;&nbsp;<strong style="color:' + styleColor + '">' + styleMsg + '</strong>' : "";
		var msg = ((resType == 'OK') ? waitMsg + "<br />" : "") + "<span style=\"vertical-align:middle;\">" + text + ((resType != '') ? msgType : "") + "</span>";
		logSteps.html(msg);
	}

	var prevMsg = "";
	var checkProcess = function () {
		var url = wgAjaxPath;// + "?action=ajax&rs=axACWRequestCheckLog&token=<?=$ajaxToken?>";
		$.get(
			url,
			{action: "ajax", rs: "axACWRequestCheckLog", token: "<?=$ajaxToken?>"},
			function( data ) {
				var isError = isEnd = 0;
				if (loop == 0) ifr.attr("src", titleUrl);
				if ( data ) {
					if (typeof data['info'] != 'undefined' && data['info'] != '') {
						setLog(loop, data['info'], data['type']);
					}
					if (data['type'] == 'ERROR') isError++;
					if (data['type'] == 'END') isEnd++;
					loop++;
				}

				if (isEnd > 0) {
					//window.location.href = domain + 'wiki/Special:WikiBuilder';
				} else if ( !(isError > 0) ) {
					if (loop < 100) {
						setTimeout(checkProcess, 2000);
					} else {
						setLog(loop, errorMsg, 'ERROR');
					}
				}
			},
			"json"
		);
	}

	checkProcess();
});
/*]]>*/
</script>