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
<table>
<tr>
	<td class="pref-input" valign="middle" colspan="2"><h2><?=wfMsg('user-badge-current')?></h2></td>
</tr>	
<? if (!empty($sUserBadgeUrl)) { ?> 
<tr>
	<td class="pref-input" valign="top" colspan="2"><p><img src="<?=$sUserBadgeImg?>" /></p></td>
</tr>	
	<td class="pref-input" colspan="2">
		<fieldset class="wk-badge-fieldset-code">
			<legend style="font-weight:normal"><?=wfMsg('user-bagde-copypaste-int-code')?></legend>
			<code style="margin:5px"><?=htmlspecialchars("<badge user=\"".$wgUser->getName()."\"/>");?></code>
		</fieldset>
	</td>
</tr>
</tr>	
	<td class="pref-input" colspan="2">
		<fieldset class="wk-badge-fieldset-code">
		<legend style="font-weight:normal"><?=wfMsg('user-bagde-copypaste-int-other-code')?></legend>
			<code style="margin:5px"><?=htmlspecialchars("<badge user=\"".$wgUser->getName()."\" wikia=\"".$domain."\" />");?></code>
		</fieldset>
	</td>
</tr>		
</tr>	
	<td class="pref-input" colspan="2">
		<fieldset class="wk-badge-fieldset-code">
		<legend style="font-weight:normal"><?=wfMsg('user-bagde-copypaste-ext-code')?></legend>
			<code style="margin:5px"><?=htmlspecialchars("<a href=\"{$wgServer}\"><img src=\"{$sUserBadgeUrl}\" border=\"0\" /></a>");?></code>
		</fieldset>
	</td>
</tr>
<tr>
	<td class="pref-input" style="padding:15px 0px 0px;" valign="middle" colspan="2"><h2><?=wfMsg('user-badge-configure')?></h2></td>
</tr>
<tr>
	<td class="pref-input" colspan="2"><p><?=wfMsg('user-badge-use-configurator')?></p> </td>	
</tr>	
<? } else { ?> 		
<tr>
	<td class="pref-input" colspan="2"><?=wfMsg('user-badge-not-found')?></td>
</tr>
<tr>
	<td class="pref-input" style="padding:15px 0px 0px;" valign="middle" colspan="2"><h2><?=wfMsg('user-badge-configure')?></h2></td>
</tr>
<tr>
	<td class="pref-input" colspan="2"><p><?=wfMsg('user-badge-use-configurator')?></p> </td>	
</tr>	
<? } ?>		
	</td>
</tr>
<tr id="ub_configurator-panel">
<td class="pref-input" colspan="2" >
	<p><?=wfMsg('user-badge-create')?></p>
	<table border=0>
	<tr>
		<td style="margin:0px" valign="top">
			<fieldset class="wk-badge-fieldset"><legend><?=wfMsg('user-badge-header-body-box')?></legend>
			<table>
				<tr>
					<td><?=wfMsg('user-badge-header-text')?></td>
					<td class="wk-badge-button-bg">
						<input type="button" name="ub-header-btn-txt-color" id="ub-header-btn-txt-color" value="" class="wk-badge-button" style="background-color:<?=$mCurrentOptions->getHeaderTxtColor()?>;">
						<input type="hidden" name="ub-header-txt-color" id="ub-header-txt-color" value="" class="wk-badge-button">
					</td>
				</tr>
				<tr>
					<td><?=wfMsg('user-badge-header-bgcolor')?></td>
					<td class="wk-badge-button-bg">
						<input type="button" name="ub-header-btn-bg-color" id="ub-header-btn-bg-color" value="" class="wk-badge-button" style="background-color:<?=$mCurrentOptions->getHeaderBgColor()?>;">
						<input type="hidden" name="ub-header-bg-color" id="ub-header-bg-color" value="">
					</td>
				</tr>
				<tr>
					<td><?=wfMsg('user-badge-body-bgcolor')?></td>
					<td class="wk-badge-button-bg">
						<input type="button" name="ub-body-btn-bg-color" id="ub-body-btn-bg-color" value="" class="wk-badge-button" style="background-color:<?=$mCurrentOptions->getBodyBgColor()?>">
						<input type="hidden" name="ub-body-bg-color" id="ub-body-bg-color" value="">
					</td>
				</tr>
				<tr>
					<td><?=wfMsg('user-badge-text-align')?></td>
					<td style="padding:6px">
						<select name="ub-header-txt-align" id="ub-header-txt-align">
							<option value="left" <?= (("left" == $mCurrentOptions->getHeaderTxtAlign()) ? "selected" : "") ?>><?=wfMsg('user-badge-left-align')?></option>
							<option value="center" <?= (("center" == $mCurrentOptions->getHeaderTxtAlign()) ? "selected" : "") ?>><?=wfMsg('user-badge-center-align')?></option>
							<option value="right" <?= (("right" == $mCurrentOptions->getHeaderTxtAlign()) ? "selected" : "") ?>><?=wfMsg('user-badge-right-align')?></option>
						</select>
					</td>
				</tr>
				<tr>
					<td><?=wfMsg('user-badge-label-color')?></td>
					<td class="wk-badge-button-bg">
						<input type="button" name="ub-body-btn-label-color" id="ub-body-btn-label-color" value="" class="wk-badge-button" style="background-color:<?=$mCurrentOptions->getBodyLabelColor()?>">
						<input type="hidden" name="ub-body-label-color" id="ub-body-label-color" value="">
					</td>
				</tr>
				<tr>
					<td><?=wfMsg('user-badge-data-color')?></td>
					<td class="wk-badge-button-bg">
						<input type="button" name="ub-body-btn-data-color" id="ub-body-btn-data-color" value="" class="wk-badge-button" style="background-color:<?=$mCurrentOptions->getBodyDataColor()?>">
						<input type="hidden" name="ub-body-data-color" id="ub-body-data-color" value="">
					</td>
				</tr>
			</table>
			</fieldset>
		</td>
		<td style="margin:0px" valign="top">
			<fieldset class="wk-badge-fieldset"><legend><?=wfMsg('user-badge-logo-opt')?></legend>
			<table>
				<tr>
					<td><?=wfMsg('user-badge-wikia-logo-pos')?></td>
					<td style="padding:6px">
						<select name="ub-body-logo-align" id="ub-body-logo-align">
<?php if ($defOptions && $defOptions['body-logo']) { foreach ($defOptions['body-logo'] as $txt => $values) { ?>
						<option value="<?=$values['value']?>" <?=(isset($values['default']) && ($values['default'] == 1)) ? 'selected':'' ?>><?=$values['text']?></option>
<?php } } ?>						
						</select>
					</td>
				</tr>
				<tr>
					<td><?=wfMsg('user-badge-small-wikia-logo-pos')?></td>
					<td style="padding:6px">
						<select name="ub-body-small-logo-align" id="ub-body-small-logo-align">
<?php if ($defOptions && $defOptions['body-small-logo']) { foreach ($defOptions['body-small-logo'] as $txt => $values) { ?>
						<option value="<?=$values['value']?>" <?=(isset($values['default']) && ($values['default'] == 1)) ? 'selected':'' ?>><?=$values['text']?></option>
<?php } } ?>						
						</select>
					</td>
				</tr>
				<tr>
					<td style="padding:6px" valign="top" align="center" colspan="2">
					<fieldset style="margin:0 auto;width:200px"><legend><?=wfMsg('user-badge-small-wikia-logo-color')?></legend>
						<table>
<?php if ($defOptions && $defOptions['small-logo-color']) { 
	foreach ($defOptions['small-logo-color'] as $id => $path) { 
		$checked = ""; if ($id == $mCurrentOptions->getSmallLogoColor()) $checked = " checked=\"checked\" "; 
?>
						<tr>
							<td valign="middle"><input type="radio" name="ub-body-small-logo-color" id="ub-body-small-logo-color-<?=$id?>" value="<?=$id?>" <?=$checked?> onclick="changeSmallLogo('<?=$id?>', '<?=$wgStylePath . $path?>');" /></td>
							<td valign="middle"><img src="<?=$wgStylePath . $path?>" width="<?=USER_BADGES_SMALL_LOGO_WIDTH?>" height="<?=USER_BADGES_SMALL_LOGO_HEIGHT?>" /></td>
						</tr>
<?php } } ?>						
						</table>
					</fieldset>
					</td>
				</tr>
			</table>
			</fieldset>
		</td>
	</tr>
	<tr>
		<td style="padding:7px" valign="top" align="left">
			<div class="user-badges-canvas">
				<div id="user-badges-title" style="background-color:<?=$mCurrentOptions->getHeaderBgColor()?>;">
					<div id="ub-layer-title" style="color:<?=$mCurrentOptions->getHeaderTxtColor()?>;"><?=$wgSitename?></div>
					<div id="ub-layer-logo"><img src="<?=$wgLogo?>" width="80" height="80" /></div>			
				</div>
				<div id="user-badges-body" style="background-color:<?=$mCurrentOptions->getBodyBgColor()?>;">
					<div id="ub-layer-username-title" style="color:<?=$mCurrentOptions->getBodyLabelColor()?>;"><?=str_replace(":", "", wfMsg('username'))?></div>
					<div id="ub-layer-username-url" style="color:<?=$mCurrentOptions->getBodyDataColor()?>;"><?=$wgUser->getName()?></div>
					<div id="ub-layer-edits-title" style="color:<?=$mCurrentOptions->getBodyLabelColor()?>;"><?=wfMsg('user-badge-edits-txt')?></div>
					<div id="ub-layer-edits-value" style="color:<?=$mCurrentOptions->getBodyDataColor()?>;"><?=UserBadges::getEditCount($wgUser->getId())?></div>
<? 
	$logocolor = $mCurrentOptions->getSmallLogoColor(); 
	$logocolor = ( !empty($logocolor) && isset($defOptions['small-logo-color'][$logocolor]) ) ? $logocolor : "yellow"; 
?> 
					<div id="ub-layer-wikia-title"><img src="<?= $wgStylePath . $defOptions['small-logo-color'][$logocolor] ?>" width="<?=USER_BADGES_SMALL_LOGO_WIDTH?>" height="<?=USER_BADGES_SMALL_LOGO_HEIGHT?>" id="ub-small-logo-img"/></div>
				</div>
			</div>
		</td>
		<td style="padding:5px" valign="top">
			<p><input type="checkbox" name="ub-overwrite-badge" id="ub-overwrite-badge" <?=(empty($sUserBadgeUrl)) ? "checked" : "";?> <?=(empty($sUserBadgeUrl))?" style=\"display:none;\" " : "" ?>> 
<? if (!empty($sUserBadgeUrl)) { ?><?=wfMsg('user-badge-overwrite-msg')?><? } ?>
			</p>
		</td>	
	</tr>	
	</table>
</td>
</tr>
</table>
<!-- e:<?= __FILE__ ?> -->
