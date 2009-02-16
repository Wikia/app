<!-- s:<?= __FILE__ ?> -->
<style>
.dt-configure select {
	font-size:95%;
}
.dt-configure input {
	font-size:95%;
}
.dt-configure textarea {
	font-size:95%;
}
</style>
<div class="dt-configure">
<?php if (!empty($aDaemons)) { ?>
<fieldset>
<legend><?=wfMsg('daemonloader_alldaemons')?></legend>
<div><?=wfMsg('daemonloader_loaddaemon')?><select id="dt-daemons" style="min-width:200px">
<?php foreach ($aDaemons as $dt_id => $values) { ?>
	<option value="<?=$dt_id?>"><?=$values['dt_name']?></option>
<?php } ?>
</select><span><input type="button" id="dt-load" value="<?=wfMsg('go')?>" /></span><span id="dt-loader" style="padding-left:10px"></span>
</div>
</fieldset>
<?php } ?>
<fieldset>
<form method="post" action="">
<input type="hidden" name="dt_id" id="dt_id" value="">
<input type="hidden" name="dt_action" id="dt_action" value="save">
<table>
<tr>
	<th valign="middle"><?=wfMsg('daemonloader_daemonname')?></th>
	<td valign="middle"><input type="text" name="dt_name" id="dt_name" value="" /> <input type="submit" name="dt_remove" id="dt_remove" style="visibility:hidden" value="<?=wfMsg('daemonloader_removedaemon')?>" /> </td>
</tr>
<tr>
	<th valign="middle"><?=wfMsg('daemonloader_scriptname')?></th>
	<td valign="middle"><input type="text" name="dt_script" id="dt_script" value="" /></td>
</tr>
<tr>
	<th valign="top"><?=wfMsg('daemonloader_daemondesc')?></th>
	<td><textarea name="dt_desc" id="dt_desc" style="width:400px;height:100px"></textarea></td>
</tr>
<tr>
	<th valign="middle" colspan="2">
	<fieldset>
		<legend><?=wfMsg('daemonloader_inputparams')?></legend>
		<table class="TablePager">
			<tr>
				<th>#</th>
				<th><?=wfMsg('daemonloader_paramname')?></th>
				<th><?=wfMsg('daemonloader_paramdesc')?></th>
				<th><?=wfMsg('daemonloader_paramtype')?></th>
				<th><?=wfMsg('daemonloader_paramdefvalue')?></th>
				<th><?=wfMsg('daemonloader_paramremove')?></th>
			</tr>
<?php for ($i=0; $i<$paramsRows; $i++) { ?>
			<tr>
				<th><?=$i+1?></th>
				<td><input type="text" name="dt_param_name_<?=$i?>" id="dt_param_name_<?=$i?>" value="" size="10" /></td>
				<td><input type="text" name="dt_param_desc_<?=$i?>" id="dt_param_desc_<?=$i?>" value="" size="40" /></td>
				<td><?=$class->paramTypeSelector($i);?></td>
				<td><input type="text" name="dt_param_defvalue_<?=$i?>" id="dt_param_defvalue_<?=$i?>" size="5" value="" /></td>
				<td><input type="checkbox" name="dt_param_remove_<?=$i?>" id="dt_param_remove_<?=$i?>" /></td>
			</tr>
<?php } ?>
		</table>
	</fieldset>
	</th>
</tr>
<tr>
	<th valign="middle" align="right" colspan="2">
		<input type="submit" name="dt_submit" id="dt_submit" value="<?=wfMsg('save')?>" />
		<input type="reset" name="dt_cancel" id="dt_cancel" value="<?=wfMsg('cancel')?>" />
	</th>
</tr>
</table>
</form>
</fieldset>
</div>
<script>
YAHOO.util.Event.onDOMReady(function() {
	var loadImg = "<img src=\"/skins/monaco/images/widget_loading.gif\" />";
	var divLoader = YAHOO.util.Dom.get("dt-loader");

	__ShowDetailsCallback = {
		success: function( oResponse )
		{
			var resData = "";
			if (YAHOO.Tools) {
				resData = YAHOO.Tools.JSONParse(oResponse.responseText);
			} else if ((YAHOO.lang) && (YAHOO.lang.JSON)) {
				resData = YAHOO.lang.JSON.parse(oResponse.responseText);
			} else {
				resData = eval('(' + oResponse.responseText + ')');
			}
			if (resData['nbr_records']) {
				YAHOO.util.Dom.get("dt_id").value = resData['data'].dt_id;
				YAHOO.util.Dom.get("dt_name").value = resData['data'].dt_name;
				YAHOO.util.Dom.get("dt_script").value = resData['data'].dt_script;
				YAHOO.util.Dom.get("dt_desc").value = resData['data'].dt_desc;
				var params  = resData['data']['dt_params'];
				row = 0;
				for (i in params) {
					if (i) {
						YAHOO.util.Dom.get("dt_param_name_" + row).value = i;
						YAHOO.util.Dom.get("dt_param_desc_" + row).value = params[i].desc;
						YAHOO.util.Dom.get("dt_param_defvalue_" + row).value = params[i].default;
						YAHOO.util.Dom.get("dt_param_type_" + row).value = params[i].type;
						row++;
					}
				}
				YAHOO.util.Dom.get("dt_remove").style.visibility = "visible";
			}
			divLoader.innerHTML = "";
		},
		failure: function( oResponse )
		{
			divLoader.innerHTML = "";
		}
	};

	var loadDaemon = function (e, args) {
		divLoader.innerHTML = loadImg;
		var params = "&rsargs[0]=" + YAHOO.util.Dom.get("dt-daemons").value;
		//---
		var baseurl = wgScript + "?action=ajax&rs=DaemonLoader::axShowDaemon" + params;
		YAHOO.util.Connect.asyncRequest( "GET", baseurl, __ShowDetailsCallback);
	}
	YAHOO.util.Event.addListener("dt-load", "click", loadDaemon);
});
</script>
<!-- e:<?= __FILE__ ?> -->
