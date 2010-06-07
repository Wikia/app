<?php
global $wgScriptPath;
$badgeName = wfMsgForContent(AchConfig::getInstance()->getBadgeNameKey($type_id));
$badgeAwardedFor = wfMsgForContent(AchConfig::getInstance()->getBadgeDescKey($type_id));
$badgeHowToEarn = wfMsgForContent(AchConfig::getInstance()->getBadgeToGetKey($type_id));
?>
<form class="clearfix" action="<?=$wgScriptPath;?>/index.php?action=ajax&amp;rs=AchAjax&amp;method=editPlatinumBadge" method="POST" onsubmit="return SpecialCustomizePlatinum.editSubmit(this);"   enctype="multipart/form-data">
	<fieldset class="customize-platinum-badge readonly">
		<input type="hidden" name="type_id" value="<?= $type_id ?>"/>
		<legend>
			<!-- toggle group -->
			<input name="badge_name" type="text" class="dark_text_2" value="<?= $badgeName; ?>" />
			<span class="dark_text_2"><?= $badgeName; ?></span>

			<!-- toggle group -->
			<input name="status" type="checkbox" <?= $enabled ? 'checked="checked" ' : ''?>value="1" disabled="disabled" /><label>enabled</label>
			<input name="show_recents" type="checkbox" <?= $show_recents ? 'checked="checked" ' : ''?>value="1" disabled="disabled" /><label>show in recents</label>
		</legend>

		<div class="column">
			<label>Awarded for:</label><span class="input-suggestion">&nbsp;(e.g. &quot;for doing...&quot;)</span>

			<!-- toggle group -->
			<textarea name="awarded_for"><?= $badgeAwardedFor; ?></textarea>
			<p><?= $badgeAwardedFor; ?></p>

			<!-- toggle group -->
			<label>How to earn:</label><span class="input-suggestion">&nbsp;(e.g. &quot;make 3 edits...&quot;)</span>

			<!-- toggle group -->
			<textarea name="how_to"><?= $badgeHowToEarn; ?></textarea>
			<p><?= $badgeHowToEarn; ?></p>

			<!-- toggle group -->
		</div>

		<div class="column">
			<label>Badge image:</label>
			<img src="<?= $thumb_url ?>" class="badge-preview neutral" />
			<input type="file" name="wpUploadFile"/>
		</div>

		<div class="column awarded-to">
			<label>Awarded to:</label>
			<ul>
			<?php
			if(is_array($awarded_users)) {
				foreach($awarded_users as $awarded_user) {
			?>
				<li><?= $awarded_user ?></li>
			<?php
				}
			}
			?>
				<li class="award-to">
					<input name="award_user[]" type="text" />
				</li>
			</ul>
		</div>

		<div class="commands accent">
			<input type="button" value="Edit" onclick="SpecialCustomizePlatinum.edit(this)" class="button-edit secondary" />
			<input type="submit" value="Save" class="button-save" />
		</div>
	</fieldset>
</form>