<section id="FounderProgressList" class="FounderProgressList" style="display:none;">
	<canvas height="45" width="25" class="tail"></canvas>
	<nav>
		<a href="#" class="back-to-dash"><?= wfMsg('admindashboard-back-to-dashboard') ?></a>
	</nav>
	<header>
		<h1><?= wfMsg('founderprogressbar-list-label') ?></h1>
		<p class="task-description">
			<?= wfMsg('founderprogressbar-list-description1') ?>
		</p>
		<p class="task-description">
			<?= wfMsg('founderprogressbar-list-description2') ?>
		</p>
	</header>
	<ul class="tasks">
		<li class="task expanded">
			<div class="task-label">
				<?= wfMsg('founderprogressbar-list-task-label') ?>
				<img class="chevron" src="<?= $wg->BlankImgUrl ?>">
			</div>
			<div class="task-group">
				<?= F::app()->getView( 'FounderProgressBar', 'widgetTaskGroup', array('taskList' => $activeTaskList, 'clickEvents' => $clickEvents ) ) ?>
			</div>
		</li>
		<li class="task collapsed skipped">
			<div class="task-label">
				<?= wfMsg('founderprogressbar-list-skipped-task-label') ?> <span class="sub-label"><?= wfMsg('founderprogressbar-list-skipped-task-desc') ?></span>
				<img class="chevron" src="<?= $wg->BlankImgUrl ?>">
			</div>
			<div class="task-group" style="display:none">
				<?= F::app()->getView( 'FounderProgressBar', 'widgetTaskGroup', array('taskList' => $skippedTaskList, 'clickEvents' => $clickEvents )) ?>
			</div>
		</li>
		<li class="task collapsed bonus">
			<div class="task-label">
				<?= wfMsg('founderprogressbar-list-bonus-task-label') ?> <img class="lock" src="<?= $wg->BlankImgUrl ?>" width="13" height="17"> <span class="sub-label"><?= wfMsg('founderprogressbar-list-bonus-task-desc') ?></span>
				<img class="chevron" src="<?= $wg->BlankImgUrl ?>">
			</div>
			<div class="task-group" style="display:none">
				<?= F::app()->getView( 'FounderProgressBar', 'widgetTaskGroup', array('taskList' => $bonusTaskList, 'clickEvents' => $clickEvents )) ?>
			</div>
		</li>
	</ul>
	<div class="shadowColorContainer"></div>	<!-- purposeful empty div for shadowColor.  look at SASS file -->
</section>
<section id="FounderProgressWidget">
	<h1><?= wfMsg('founderprogressbar-widget-label') ?></h1>
	<section class="preview">
		<canvas id="FounderProgressBar" class="founder-progress-bar" height="95" width="95">
		</canvas>
		<div id="FounderProgressListClickArea" class="founder-progress-bar-click-area" data-tracking="toggle/bar"></div>
		<div class="numeric-progress">
			<span class="score"><?= $progressData['completion_percent'] ?></span><span class="percentage">%</span>
		</div>
		<header>
			<h1><?= wfMsg('founderprogressbar-progress-label') ?></h1>
			<a href="#" class="list-toggle" id="FounderProgressListToggle" data-tracking="toggle/link">
				<span class="see-full-list"><?= wfMsg('founderprogressbar-progress-see-full-list') ?></span>
				<span class="hide-full-list"><?= wfMsg('founderprogressbar-progress-hide-full-list') ?></span>
			</a>
		</header>
		<ul class="activities">
			<? $index = 0; ?>
			<? foreach($activityListPreview as $activity) { ?>
				<?= F::app()->getView( 'FounderProgressBar', 'widgetActivityPreview', array('activity' => $activity, 'clickEvents' => $clickEvents, 'index' => $index, 'wgBlankImgUrl' => $wg->BlankImgUrl )) ?>
				<? $index++; ?>
			<? } ?>
		</ul>
		<? if($showCompletionMessage) { ?>
			<p class="completion-message">
				<button class="close wikia-chiclet-button">
					<img src="<?= $wg->StylePath ?>/oasis/images/icon_close.png">
				</button>
				<?= wfMsg('founderprogressbar-completion-message') ?>
			</p>
		<? } ?>
	</section>
</section>
