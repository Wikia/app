<!-- s:<?= __FILE__ ?> -->
<tr>
<td class="pref-label"><label for="wkUserBadge"><?=wfMsg('user-badge-title')?></label></td>
<td class="pref-input">
<div id="user-badges-canvas">
	<div id="user-badges-title">
		<div id="ub-layer-title" class="ub-layer-title" style="width:<?=(strlen($wgSitename)) * 10?>px;"><?=$wgSitename?></div>
	</div>
	<div id="user-badges-body">
		<div id="ub-layer-logo" class="ub-layer-logo"><img src="<?=$wgLogo?>" width="80" height="80" /></div>
		<div id="ub-layer-username-title" class="ub-layer-username-title" style="width:<?=(strlen("Username")) * 10?>px;">Username</div>
		<div id="ub-layer-username-url" class="ub-layer-username-url" style="width:<?=strlen($wgUser->getName()) * 9?>px;"><?=$wgUser->getName()?></div>
		<div id="ub-layer-edits-title" class="ub-layer-edits-title" style="width:<?=strlen("Edits") * 9?>px;">Edits</div>
		<div id="ub-layer-edits-value" class="ub-layer-edits-value" style="width:<?=strlen("78") * 10?>px;">78</div>
		<div id="ub-layer-wikia-title" class="ub-layer-wikia-title"><img src="http://images.wikia.com/common/skins/monaco/smoke/images/wikia_logo.png" width="56" height="15"/></div>
	</div>
</div>
</td>
</tr>
<!-- e:<?= __FILE__ ?> -->
