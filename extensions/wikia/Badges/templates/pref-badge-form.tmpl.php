<!-- s:<?= __FILE__ ?> -->
<script>
var ColorTxt = new Array();
ColorTxt["ILLEGAL_HEX"] = "<?=wfMsg("user-badge-invalid-color")?>";
ColorTxt["SHOW_CONTROLS"] = "<?=wfMsg("user-badge-show-color")?>";
ColorTxt["HIDE_CONTROLS"] = "<?=wfMsg("user-badge-hide-color")?>";
ColorTxt["CURRENT_COLOR"] = "<?=wfMsg("user-badge-selected-color")?>";
ColorTxt["CLOSEST_WEBSAFE"] = "<?=wfMsg("user-badge-web-color")?>";
ColorTxt["DIALOG_HEADER"] = "<?=wfMsg("user-badge-dialog-title")?>";
</script>
<tr>
	<td class="pref-label" colspan="2"><h2><?=wfMsg('user-badge-title')?></h2></td>
</tr>
<tr>
	<td class="pref-label" valign="top">Current badge:</td>
	<td class="pref-input">No badge found!<br />Use configurator to create new one!</td>
</tr>
<tr>
<td class="pref-label" valign="top">Create Your badge:</td>
<td class="pref-input">
	<table border=0><tr>
		<td style="margin:0px" valign="top">
			<fieldset class="wk-badge-fieldset"><legend>Header and body:</legend>
			<table>
				<tr><td>Header text color:</td><td class="wk-badge-button-bg"><input type="button" name="ub-header-txt-color" id="ub-header-txt-color" value="" class="wk-badge-button"></td></tr>
				<tr><td>Header background color:</td><td class="wk-badge-button-bg"><input type="button" name="ub-header-bg-color" id="ub-header-bg-color" value="" class="wk-badge-button"></td></tr>
				<tr><td>Body background color:</td><td class="wk-badge-button-bg"><input type="button" name="ub-body-bg-color" id="ub-body-bg-color" value="" class="wk-badge-button"></td></tr>
				<tr><td>Header text align:</td><td style="padding:6px"><select name="ub-header-txt-align" id="ub-header-txt-align"><option value="left">left</option><option value="center">center</option><option value="right" selected>right</option></select></td></tr>
			</table>
			</fieldset>
		</td>
		<td style="margin:0px" valign="top">
			<fieldset class="wk-badge-fieldset"><legend>Body options:</legend>
			<table>
				<tr><td>Wikia logo position:</td><td style="padding:6px"><select name="ub-header-logo-align" id="ub-header-logo-align"><option value="-15px auto 0 5px" selected>left</option><option value="-15px 5px 0 auto">right</option></select></td></tr>
				<tr><td>Small Wikia logo position:</td><td style="padding:6px"><select name="ub-header-small-logo-align" id="ub-header-small-logo-align"><option value="-20px auto 0 0">left</option><option value="-20px 0 0 auto" selected>right</option></select></td></tr>
				<tr><td>Label color (username, edits):</td><td class="wk-badge-button-bg"><input type="button" name="ub-body-label-color" id="ub-body-label-color" value="" class="wk-badge-button"></td></tr>
				<tr><td>Data color:</td><td class="wk-badge-button-bg"><input type="button" name="ub-body-data-color" id="ub-body-data-color" value="" class="wk-badge-button"></td></tr>
			</table>
			</fieldset>
		</td>
	</tr>
	<tr>
		<td style="padding:5px 25%;" valign="top" colspan="2">
			<div class="user-badges-canvas">
				<div id="user-badges-title">
					<div id="ub-layer-title"><?=$wgSitename?></div>
					<div id="ub-layer-logo"><img src="<?=$wgLogo?>" width="80" height="80" /></div>			
				</div>
				<div id="user-badges-body">
					<div id="ub-layer-username-title" class=>Username</div>
					<div id="ub-layer-username-url"><u><?=$wgUser->getName()?></u></div>
					<div id="ub-layer-edits-title">Edits</div>
					<div id="ub-layer-edits-value">78</div>
					<div id="ub-layer-wikia-title"><img src="http://images.wikia.com/common/skins/monaco/smoke/images/wikia_logo.png" width="56" height="15"/></div>
				</div>
			</div>
		</td>
	</tr>
	</table>
</td>
</tr>
<!-- e:<?= __FILE__ ?> -->
