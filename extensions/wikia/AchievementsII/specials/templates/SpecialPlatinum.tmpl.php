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
				<label>Awarded for:</label><span class="input-suggestion">&nbsp;(e.g. &quot;for doing...&quot;)</span>
				<textarea name="awarded_for"></textarea>
				<label>How to earn:</label><span class="input-suggestion">&nbsp;(e.g. &quot;make 3 edits...&quot;)</span>
				<textarea name="how_to"></textarea>
			</div>
			<div class="column">
				<label>Badge image:</label>
				<img src="<?= $wgStylePath ?>/common/blank.gif" class="badge-preview neutral" />
				<input type="file" name="wpUploadFile" />
			</div>
			<div class="commands accent">
				<input type="submit" value="Create Badge"/>
			</div>
		</fieldset>
	</form>

	<h2>Current Platinum Badges</h2>

	<?php
	foreach($badges as $badge) {
		echo AchPlatinumService::getPlatinumForm($badge);
	}
	?>
</div>
