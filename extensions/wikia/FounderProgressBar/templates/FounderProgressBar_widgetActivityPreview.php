<li class="activity<?= $index == 0 ? ' active' : '' ?><?= isset($clickEvents[$activity['task_id']]) ? ' clickevent' : '' ?>" data-task-id="<?= $activity['task_id'] ?>" <?= isset($visible) && $visible == false ? ' style="display:none"' : '' ?>>
	<div class="label">
		<div class="activity-name">
			<?= $activity['task_label'] ?>
		</div>
		<img class="chevron" src="<?= $wgBlankImgUrl ?>">
	</div>
	<div class="description" style="<?= $index == 0 ? '' : 'display:none'?>">
		<?= $activity['task_description'] ?>
		<div class="actions">
			<a href="#" class="skip"><?= wfMsg('founderprogressbar-skip-for-now') ?></a>
			<a class="wikia-button" href="<?= $activity['task_url']?>">
				<?= wfMsg('founderprogressbar-task-call-to-action') ?>
			</a>
		</div>
	</div>
</li>