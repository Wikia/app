<!-- s:<?= __FILE__ ?> -->
<tr><td class="pref-label" colspan="2"><h2><?=wfMsg('blog-avatar-preferences-title')?></h2></td></tr>
<tr>
<td class="pref-input" colspan="2">
<table border="0" width="50" valign="top">
<tr>
	<td valign="top">
		<table style="border:1px solid #DFDFDF;margin:8px 2px;width:<?=$imgW?>px;height:<?=$imgH?>px;">
		    <tr><td valign="middle" align="center"><img height="<?=$imgH?>" width="<?=$imgW?>" src="<?=$sUserImg?>" border="0" /></td></tr>
		</table>
	</td>
	<td><div style="text-align:left;padding:3px;">
		<div style="text-align:left;padding:3px;" id="wkUserChooseDivText"></div>
		<input type="hidden" name="wkDefaultAvatar" id="wkDefaultAvatar" value="" >
		<script type="text/javascript">
		/*<![CDATA[*/
		$.loadYUI( function() {
			YAHOO.util.Event.onDOMReady(function () {
				if (document.createTextNode) {
					var defaultAvatar = YAHOO.util.Dom.get("wkDefaultAvatar");
					var listDiv = YAHOO.util.Dom.get("wkDefaultAvatarList");
					if (!listDiv && !defaultAvatar) {
						return;
					}
					var imgs = new Array();
	<? if ( !empty($aDefAvatars) && is_array($aDefAvatars) ) { $loop = 0; foreach ($aDefAvatars as $id => $sDefAvatarUrl) { ?>
					imgs[<?=$loop?>] = document.createElement('img');
					imgs[<?=$loop?>].src = '<?=$sDefAvatarUrl?>';
					imgs[<?=$loop?>].style.border = '2px solid #FFFFFF';
					imgs[<?=$loop?>].style.margin = '2px';
					imgs[<?=$loop?>].style.cursor = 'pointer';
					imgs[<?=$loop?>].setAttribute('width', '40');
					imgs[<?=$loop?>].setAttribute('height', '40');
					imgs[<?=$loop?>].onclick = function() {
						clearBorders();
						clearUploadAvatar();
						if (defaultAvatar.value == this.src) {
							this.style.border = '2px solid #FFFFFF';
							defaultAvatar.value = "";
						} else {
							this.style.border = '2px solid #008000';
							defaultAvatar.value = this.src;
						}
					}
					listDiv.appendChild(imgs[<?=$loop?>]);
	<? $loop++; } } ?>

					var chooseDivTxt = YAHOO.util.Dom.get("wkUserChooseDivText");
					if (chooseDivTxt) {
						chooseDivTxt.innerHTML = "<?=wfMsg('blog-avatar-choose-avatar')?>";
					}

					var uploadDivTxt = YAHOO.util.Dom.get("wkUserUploadDivText");
					if (uploadDivTxt) {
						uploadDivTxt.innerHTML = "<?=wfMsg('blog-avatar-upload-avatar')?>";
					}

					var uploadDiv = YAHOO.util.Dom.get("wkUserUploadDiv");
					if (uploadDiv) {
						uploadFile = document.createElement('input');
						uploadFile.setAttribute('type', 'file');
						uploadFile.setAttribute('name', '<?=$sFieldName?>');
						uploadFile.setAttribute('id', '<?=$sFieldName?>');
						uploadFile.onchange = function() {
							clearBorders();
							clearDefaultAvatar();
						}
						uploadDiv.appendChild(uploadFile);
					}

					function clearBorders() {
						if (imgs && imgs.length > 0) {
							for (var i in imgs) {
								imgs[i].style.border = '2px solid #FFFFFF';
							}
						}
					}
					function clearDefaultAvatar() {
						var defaultAvatar = YAHOO.util.Dom.get("wkDefaultAvatar");
						if (defaultAvatar) {
							defaultAvatar.value = "";
						}
					}
					function clearUploadAvatar() {
						var uploadAvatar = YAHOO.util.Dom.get("wkUserAvatar");
						if (uploadAvatar) {
							uploadAvatar.value = "";
						}
					}
				}
			});
		});
		</script>
		</div>
		<div style="padding:3px;" id="wkDefaultAvatarList"></div>
		<div style="text-align:left;padding:3px;" id="wkUserUploadDivText"></div>
		<div style="text-align:left;padding:3px;" id="wkUserUploadDiv"></div>
	</td>
</tr>
</table>
</td>
</tr>
<tr><td colspan="2"><?=wfMsg('blog-avatar-save-info')?></td></tr>
<!-- e:<?= __FILE__ ?> -->
