<?php
global $wgScriptPath, $wgStylePath;
?>
<div class="CustomizePlatinum">

	<!-- new platinum badge form -->

	<form id="createPlatinumForm" class="clearfix" action="<?= $wgScriptPath ?>/index.php?action=ajax&amp;rs=AchAjax&amp;method=addPlatinumBadge" method="POST" onsubmit="return SpecialCustomizePlatinum.addSubmit(this)" enctype="multipart/form-data">
		<fieldset class="customize-platinum-badge new editable">
			<legend>
				<input name="badge_name" type="text" class="dark_text_2" />
			</legend>
			<div class="column">
				<label><?=wfMsg('achievements-community-platinum-awarded-for');?></label><span class="input-suggestion">&nbsp;(<?=wfMsg('achievements-community-platinum-awarded-for-example');?>)</span>
				<textarea name="awarded_for"></textarea>
				<label><?=wfMsg('achievements-community-platinum-how-to-earn');?></label><span class="input-suggestion">&nbsp;(<?=wfMsg('achievements-community-platinum-how-to-earn-example');?>)</span>
				<textarea name="how_to"></textarea>
			</div>
			<div class="column">
				<label><?=wfMsg('achievements-community-platinum-badge-image');?></label>
				<img src="<?= $wgStylePath ?>/common/blank.gif" class="badge-preview neutral" />
				<input type="file" name="wpUploadFile" />
			</div>
			<div class="commands accent">
				<input type="submit" value="<?=wfMsg('achievements-community-platinum-create-badge');?>"/>
			</div>
		</fieldset>
	</form>

	<h2><?=wfMsg('achievements-community-platinum-current-badges');?></h2>

	<?php
	foreach($badges as $badge) {
		echo AchPlatinumService::getPlatinumForm($badge);
	}
	?>
</div>
