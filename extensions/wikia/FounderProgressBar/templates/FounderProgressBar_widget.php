<section id="FounderProgressWidget">
	<h1>Glee Wiki's Progress</h1>
	<section class="preview">
		<canvas id="FounderProgressBar" class="founder-progress-bar" height="95" width="95">
		</canvas>
		<div class="numeric-progress">
			<span class="score">20</span><span class="percentage">%</span>
		</div>
		<header>
			<h1><?= wfMsg('founderprogressbar-progress-label') ?></h1>
			<a href="#" class="list-toggle"><?= wfMsg('founderprogressbar-progress-see-full-list') ?></a>
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