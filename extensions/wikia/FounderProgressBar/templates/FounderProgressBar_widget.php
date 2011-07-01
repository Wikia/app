<section id="FounderProgressList" class="FounderProgressList" style="display:none;">
	<canvas height="45" width="25" class="tail"></canvas>
	<header>
		<h1><?= wfMsg('founderprogressbar-list-label') ?></h1>
		<p class="task-description">
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin id nunc mi. Maecenas elit velit, tempus quis pharetra a, fringilla blandit neque.
		</p>
	</header>
	<ul class="tasks">
		<li class="task expanded">
			<div class="task-label">
				<?= wfMsg('founderprogressbar-list-task-label') ?>
				<img class="chevron" src="<?= $wgBlankImgUrl ?>">
			</div>
			<div class="task-group">
				<?= F::app()->getView( 'FounderProgressBar', 'widgetTaskGroup', array('taskList' => $activeTaskList ) ) ?>
			</div>
		</li>
		<li class="task collapsed">
			<div class="task-label">
				<?= wfMsg('founderprogressbar-list-skipped-task-label') ?> <span class="sub-label"><?= wfMsg('founderprogressbar-list-skipped-task-desc') ?></span>
				<img class="chevron" src="<?= $wgBlankImgUrl ?>">
			</div>
			<div class="task-group" style="display:none">
				<?= F::app()->getView( 'FounderProgressBar', 'widgetTaskGroup', array('taskList' => $skippedTaskList )) ?>
			</div>
		</li>
		<li class="task collapsed">
			<div class="task-label">
				<?= wfMsg('founderprogressbar-list-bonus-task-label') ?> <span class="sub-label"><?= wfMsg('founderprogressbar-list-bonus-task-desc') ?></span>
				<img class="chevron" src="<?= $wgBlankImgUrl ?>">
			</div>
			<div class="task-group" style="display:none">
				<?= F::app()->getView( 'FounderProgressBar', 'widgetTaskGroup', array('taskList' => $bonusTaskList )) ?>
			</div>
		</li>
	</ul>
</section>
<section id="FounderProgressWidget">
	<h1><?= wfMsg('founderprogressbar-widget-label') ?></h1>
	<section class="preview">
		<canvas id="FounderProgressBar" class="founder-progress-bar" height="95" width="95">
		</canvas>
		<div class="numeric-progress">
			<span class="score"><?= $progressData['completion_percent'] ?></span><span class="percentage">%</span>
		</div>
		<header>
			<h1><?= wfMsg('founderprogressbar-progress-label') ?></h1>
			<a href="#" class="list-toggle" id="FounderProgressListToggle">
				<span class="see-full-list"><?= wfMsg('founderprogressbar-progress-see-full-list') ?></span>
				<span class="hide-full-list"><?= wfMsg('founderprogressbar-progress-hide-full-list') ?></span>
			</a>
		</header>
		<ul class="activities">
			<? $index = 0; ?>
			<? foreach($activityListPreview as $activity) { ?>
				<li class="activity<?= $index == 0 ? ' active' : '' ?>">
					<div class="label">
						<div class="activity-name">
							<?= $activity['task_label'] ?>
						</div>
						<img class="chevron" src="<?= $wgBlankImgUrl ?>">
					</div>
					<div class="description" style="<?= $index++ == 0 ? '' : 'display:none'?>">
						<?= $activity['task_description'] ?>
						<div class="actions">
							<span style=""><?= wfMsg('founderprogressbar-skip-for-now') ?></span> <a class="wikia-button" href="<?= $activity['task_url']?>"><?= $activity['task_action'] ?></a>
						</div>
					</div>
				</li>
			<? } ?>
		</ul>
	</sction>
</section>