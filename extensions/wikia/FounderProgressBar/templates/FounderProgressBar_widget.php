<section id="FounderProgressList" class="FounderProgressList" style="display:none;">
	<header>
		<h1>Glee Wiki's Tasks</h1>
		<p class="task-description">
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin id nunc mi. Maecenas elit velit, tempus quis pharetra a, fringilla blandit neque.
		</p>
	</header>
	<ul class="tasks">
		<li class="task">
			<div class="task-label">
				Tasks
			</div>
			<div class="task-group">
				<? for ($j = 0; $j < 3; $j++) { ?>
					<ul class="activities">
						<? for ($i = 0; $i < 10; $i++) { ?>
							<li class="activity">
								<div class="activity-label">Activity is number <?= $i ?></div>
								<div class="activity-description">
									<div class="description">
										<h4>Activity whatever</h4>
										Description of this activity.  Description of this activity.  Description of this activity.
									</div>
									<div class="actions">
										<button>Do something</button>
									</div>
								</div>
							</li>
						<? } ?>
					</ul>
				<? } ?>
			</div>
		</li>
		<li class="task">
			<div class="task-label">
				Skipped Tasks
			</div>
		</li>
		<li class="task">
			<div class="task-label">
				Bonus Tasks
			</div>
		</li>
	</ul>
</section>
<section id="FounderProgressWidget">
	<h1>Glee Wiki's Progress</h1>
	<section class="preview">
		<canvas id="FounderProgressBar" class="founder-progress-bar" height="95" width="95">
		</canvas>
		<div class="numeric-progress">
			<span class="score">68</span><span class="percentage">%</span>
		</div>
		<header>
			<h1><?= wfMsg('founderprogressbar-progress-label') ?></h1>
			<a href="#" class="list-toggle" id="FounderProgressListToggle"><?= wfMsg('founderprogressbar-progress-see-full-list') ?></a>
		</header>
		<ul class="activities">
			<li class="activity active">
				<div class="label">
					<div class="activity-name">
						Add 10 pages
					</div>
					<div class="activity-score">
						+ 5%
					</div>
				</div>
				<div class="description">
					Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin id nunc mi. Maecenas elit velit, tempus quis pharetra a, fringilla blandit neque.
					<div class="actions">
						<button>Do Something Useful</button>  <span style="">Skip for now</span>
					</div>
				</div>
			</li>
			<li class="activity">
				<div class="label">
					<div class="activity-name">
						I am a placeholder
					</div>
					<div class="activity-score">
						+ 5%
					</div>
				</div>
				<div class="description" style="display:none">
					Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin id nunc mi. Maecenas elit velit, tempus quis pharetra a, fringilla blandit neque.
					<div class="actions">
						<button>Do Something Useful</button>  <span style="">Skip for now</span>
					</div>
				</div>
			</li>
		</ul>
	</sction>
</section>