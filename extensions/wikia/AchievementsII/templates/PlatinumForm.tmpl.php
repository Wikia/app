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
			<input name="status" id="enabled-status" type="checkbox" <?= $enabled ? 'checked="checked" ' : ''?>value="1" disabled="disabled" /><label for="enabled-status"><?=wfMsg('achievements-community-platinum-enabled');?></label>
		</legend>

		<div class="column description-fields"<?= ( $is_sponsored ) ? ' style="display:none;"' : null ;?>>
			<label><?=wfMsg('achievements-community-platinum-awarded-for');?></label><span class="input-suggestion">&nbsp;(<?=wfMsg('achievements-community-platinum-awarded-for-example');?>)</span>

			<!-- toggle group -->
			<textarea name="awarded_for"><?= $badgeAwardedFor; ?></textarea>
			<p><?= $badgeAwardedFor; ?></p>

			<!-- toggle group -->
			<label><?=wfMsg('achievements-community-platinum-how-to-earn');?></label><span class="input-suggestion">&nbsp;(<?=wfMsg('achievements-community-platinum-how-to-earn-example');?>)</span>

			<!-- toggle group -->
			<textarea name="how_to"><?= $badgeHowToEarn; ?></textarea>
			<p><?= $badgeHowToEarn; ?></p>

			<!-- toggle group -->
		</div>

		<div class="column">
			<label><?=wfMsg('achievements-community-platinum-badge-image');?></label>
			<img src="<?= $thumb_url ?>" class="badge-preview neutral" />
			<input type="file" name="wpUploadFile"/>
		</div>

		<div class="column awarded-to">
			<label><?=wfMsg('achievements-community-platinum-awarded-to');?></label>
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

		<div class="clearfix"></div>
		<div class="sponsored-fields">
			<div class="clearfix sponsored-fields-1">
				<input type="checkbox" name="is_sponsored" value="1" disabled="disabled" <?= ( $is_sponsored ) ? ' checked' : null ;?>/>
				<label><?=wfMsg('achievements-community-platinum-sponsored-label');?></label>
			</div>

			<div class="sponsored-fields-3"<?= ( !$is_sponsored ) ? ' style="display:none;"' : null ;?>>
				<label for="hover_content"><?=wfMsg('achievements-community-platinum-sponsored-hover-content-label');?></label>
				<input type="file" name="hover_content"/>
				
				<label for="hover_impression_pixel_url"><?=wfMsg('achievements-community-platinum-sponsored-hover-impression-pixel-url-label');?></label>
				<input type="text" name="hover_impression_pixel_url" value="<?= $hover_tracking_url ;?>"/>
				<p><?= $hover_tracking_url ;?></p>

				<label for="badge_impression_pixel_url"><?=wfMsg('achievements-community-platinum-sponsored-badge-impression-pixel-url-label');?></label>
				<input type="text" name="badge_impression_pixel_url" value="<?= $badge_tracking_url ;?>"/>
				<p><?= $badge_tracking_url ;?></p>

				<label for="badge_redirect_url"><?=wfMsg('achievements-community-platinum-sponsored-badge-click-url-label');?></label>
				<input type="text" name="badge_redirect_url" value="<?= $click_tracking_url ;?>"/>
				<p><a href="<?= $click_tracking_url ;?>" target="_blank"><?= $click_tracking_url ;?></a></p>
			</div>
			<? if( !empty( $hover_content_url ) ) :?>
				<div align="center">
					<div class="sponsored-fields-2"<?= ( !$is_sponsored ) ? ' style="display:none;"' : null ;?>>
						<div class="badges">
							<div class="profile-hover sponsored-hover">
								<img src="<?= $hover_content_url ;?>" />
								<p class="earned"><?= wfMsgExt('achievements-earned', array('parsemag'), 'X') ?></p>
							</div>
						</div>
					</div>
				</div>
			<? endif ;?>
		</div>
	

		<div class="commands accent">
			<input type="button" value="<?=wfMsg('achievements-community-platinum-edit');?>" onclick="SpecialCustomizePlatinum.edit(this)" class="button-edit secondary" />
			<input type="submit" value="<?=wfMsg('achievements-community-platinum-save');?>" class="button-save" />
			<input type="button" value="<?=wfMsg('achievements-community-platinum-cancel');?>" onclick="SpecialCustomizePlatinum.cancel(this)" class="button-cancel secondary" />
		</div>
	</fieldset>
</form>
