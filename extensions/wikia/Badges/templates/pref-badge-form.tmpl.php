<!-- s:<?= __FILE__ ?> -->
<tr>
<td class="pref-label"><label for="wkUserBadge"><?=wfMsg('user-badge-title')?></label></td>
<td class="pref-input">
<div id="user-badges-canvas">
	<div id="user-badges-title"><div id="ub-layer-title" class="ub-layer-title"><div><?=$wgSitename?></div></div></div>
	<div id="user-badges-body">
		<div id="ub-layer-logo" class="ub-layer-logo"><div><img src="<?=$wgLogo?>" width="80" height="80" /></div></div>
		<div id="ub-layer-username-title" class="ub-layer-username-title"><div id="ub-username-title">Username</div></div>
		<div id="ub-layer-username-url" class="ub-layer-username-url"><div><?=$wgUser->getName()?></div></div>
		<div id="ub-layer-edits-title" class="ub-layer-edits-title"><div id="ub-edits-title">Edits</div></div>
		<div id="ub-layer-edits-value" class="ub-layer-edits-value"><div id="ub-edits-value">78</div></div>
		<div id="ub-layer-wikia-title" class="ub-layer-wikia-title"><div id="ub-wikia-title"><img src="http://images.wikia.com/common/skins/monaco/smoke/images/wikia_logo.png" width="56" height="15"/></div></div>
	</div>
</div>
</td>
</tr>
<!-- e:<?= __FILE__ ?> -->
