
<div class="article-sidebar">
	<h2 class="first"><?= wfMessage('achievements-about-title')->escaped() ?></h2>
	<?= wfMessage( 'achievements-about-content' )->parse() ?>

	<form method="POST" class="customize-edit-plus-category" onsubmit="Achievements.AchPrepareData(true);">
		<input type="hidden" name="add_edit_plus_category_track" value="1"/>
		<input type="hidden" name="json-data" class="c-messages-ec" />
		<h2><?=wfMessage('achievements-create-edit-plus-category-title')->escaped();?></h2>
		<?=wfMessage( 'achievements-create-edit-plus-category-content' )->parse();?>
		<p class="input">
			<label><?=wfMessage('achievements-customize-new-category-track')->escaped();?></label><input name="edit_plus_category_name" type="text"/>
			<button type="submit"><?=wfMessage('achievements-create-edit-plus-category')->escaped();?></button>
		</p>
	</form>
</div>

<div style="padding-right:320px;">

<?if($successMsg != null):?>
	<div class="successbox"><strong><?= $successMsg ?></strong></div>
<?endif;?>
<?if($errorMsg != null):?>
	<div class="errorbox"><strong><?= $errorMsg ?></strong></div>
<?endif;?>
<?
global $wgCityId, $wgScriptPath, $wgExternalSharedDB, $wgJsMimeType;
$tracks = array();
foreach($config->getInTrackStatic() as $badgeTypeId => $trackData){
	if($badgeTypeId != BADGE_EDIT) {
		$tracks[$badgeTypeId] = $trackData;
	}
	else {
		$tracks[$badgeTypeId] = $trackData;
		$editPlusCategoryTracks = $config->getInTrackEditPlusCategory();

		if($editPlusCategoryTracks) {
			foreach($editPlusCategoryTracks as $editPlusCategoryTypeId => $editPlusCategoryData) {
				$tracks[$editPlusCategoryTypeId] = array('category' => $editPlusCategoryData['category'], 'enabled' => $editPlusCategoryData['enabled'], 'laps' => $tracks[$badgeTypeId]['laps'], 'infinite' => $tracks[$badgeTypeId]['infinite']);
			}
		}
	}
}
?>
<?foreach($tracks as $badgeTypeId => $trackData):?>
	<div class="customize-section" id="section<?= $badgeTypeId; ?>">
		<div class="save-title-button">
			<span class="enabled-flag">
				<?= (isset($trackData['category'])) ?
					"<input class=\"c-enabled-flags\" type=\"checkbox\" name=\"ec_{$badgeTypeId}\" value=\"1\"". (($trackData['enabled']) ? ' checked' : null) . '/><label>' . wfMsg('achievements-enable-track') . '</label> '
				:
					null?>
			</span>
			<form method="POST" class="save-all">
				<input type="hidden" name="json-data" class="c-messages" />
				<input type="submit" value="<?= wfMessage('achievements-save')->escaped() ?>" onclick="Achievements.AchPrepareData(false, '<?= $badgeTypeId; ?>');"/>
			</form>
		</div>
		<h2><?=wfMsg($config->getTrackNameKey($badgeTypeId), (isset($trackData['category']) ? $trackData['category'] : null));?></h2>

		<ul class="custom-badges">
			<?php
			$inTrackBadgesCount = count($trackData['laps']);
			?>
			<?foreach($trackData['laps'] as $lap => $badgeData):?>
				<?
				$badge = new AchBadge($badgeTypeId, $lap, $badgeData['level']);
				?>
				<li class="clearfix<?=($lap == ($inTrackBadgesCount - 1)) ? ' last' : null?>">

					<div class="content-form">
						<p class="input">
							<input class="c-message" type="text" name="msg_<?=$badgeTypeId;?>_<?=$lap;?>" value="<?=htmlspecialchars($badge->getName());?>">
						</p>
						<p><?=$config->getLevelName($badge->getLevel());?> (<?=wfMsg( 'achievements-points', $config->getLevelScore( $badge->getLevel() ) );?>)</p>
						<p><?=$badge->getGiveFor();?></p>
					</div>

					<div class="image-form">
						<p>
							<img width="90" height="90" src="<?=$badge->getPictureUrl(90);?>" />
							<br />
							<span class="custom-text"><?=wfMsg('achievements-customize')?>
								<br />
								<a href="#" onclick="Achievements.revert(this, <?=$badgeTypeId;?>, <?=$lap;?>); return false;">
									<?=wfMsg('achievements-revert');?>
								</a>
							</span>
						</p>
						<form method="POST" enctype="multipart/form-data" class="customize-upload" action="<?= $wgScriptPath ?>/index.php?action=ajax&amp;rs=AchAjax&amp;method=uploadBadgeImage&amp;type_id=<?=$badgeTypeId?>&amp;lap=<?=$lap?>&amp;level=<?=$badge->getLevel();?>" onsubmit="return Achievements.submitPicture(this);">
							<p class="input">
								<input name="wpUploadFile" type="file"/>
								<button type="submit"><?=wfMsg('achievements-send');?></button>
							</p>
						</form>
					</div>
				</li>
			<?endforeach;?>
		</ul>
	</div>
<?endforeach;?>

<?php

$sections = array(
	'special' => array(),
	'secret' => array()
);

foreach($config->getNotInTrackStatic() as $badgeTypeId => $badgeData) {
	$section = null;

	if($config->isSpecial($badgeTypeId))
		$section = 'special';
	elseif($config->isSecret($badgeTypeId))
		$section = 'secret';
	else
		continue;

	$sections[$section][] = new AchBadge($badgeTypeId, null, $badgeData['level']);
}
?>
<?foreach($sections as $section => $badges):?>
	<div class="customize-section" id="section<?= $section; ?>">

		<div class="save-title-button">
			<form method="POST">
				<input type="hidden" name="json-data" class="c-messages" />
				<input type="submit" value="<?= wfMsg('achievements-save') ?>" onclick="Achievements.AchPrepareData(false, '<?= $section; ?>');"/>
			</form>
		</div>

		<h2><?= wfMsg('achievements-'.$section) ?></h2>
		<ul class="custom-badges">
			<?php
			$badgesCount = count($badges);
			?>
			<?foreach($badges as $index => $badge):?>
				<li class="clearfix<?= ($index == ($badgesCount-1)) ? ' last' : '' ?>">
					<div class="content-form">
						<p class="input">
							<input class="c-message" type="text" name="msg_<?=$badge->getTypeId();?>" value="<?=htmlspecialchars($badge->getName());?>">
						</p>
						<p><?=$config->getLevelName($badge->getLevel());?> (<?=wfMsg( 'achievements-points', $config->getLevelScore( $badge->getLevel() ) );?>)</p>
						<p><?=$badge->getGiveFor();?></p>
					</div>

					<div class="image-form">
						<p><img width="90" height="90" src="<?=$badge->getPictureUrl(90);?>" /><br /><span class="custom-text"><?= wfMsg('achievements-customize') ?><br /><a href="#" onclick="Achievements.revert(this, <?=$badge->getTypeId();?>); return false;"><?= wfMsg('achievements-revert') ?></a></span></p>
						<form method="POST" enctype="multipart/form-data" class="customize-upload" action="<?= $wgScriptPath ?>/index.php?action=ajax&amp;rs=AchAjax&amp;method=uploadBadgeImage&amp;type_id=<?=$badge->getTypeId();?>&amp;level=<?=$badge->getLevel();?>" onsubmit="return Achievements.submitPicture(this);">
							<p class="input">
								<input name="wpUploadFile" type="file"/>
								<button><?= wfMsg('achievements-send') ?></button>
							</p>
						</form>
					</div>
				</li>
			<?endforeach;?>
		</ul>
	</div>
<?endforeach;?>
	<form method="POST" class="save-all">
		<input type="hidden" name="json-data" class="c-messages" />
		<input type="submit"  value="<?= wfMessage( 'achievements-save' )->escaped() ?>" onclick="Achievements.AchPrepareData(false, '');"/>
	</form>
</div>
<?if($scrollTo):?>
	<script type="<?= $wgJsMimeType; ?>">
		setTimeout(function(){$(window).scrollTo('#section<?= $scrollTo ?>', 2000);}, '3000');
	</script>
<?endif;?>
