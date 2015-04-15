<div class="insights-container-landing">
	<div class="insights-landing-header">
		<h1><?= wfMessage( 'insights-landing-title' )->escaped() ?></h1>
		<p><?= wfMessage( 'insights-landing-lead' )->escaped() ?></p>
	</div>
	<div class="insights-landing-nav">
		<ul class="insights-landing-nav-list">
			<?php foreach( InsightsHelper::$insightsMessageKeys as $key => $messages ) : ?>
				<a href="<?= InsightsHelper::getSubpageLocalUrl( $key ) ?>">
					<li class="insights-landing-nav-item insights-icon-<?= $key ?>">
						<h3><?= wfMessage( $messages['subtitle'] )->escaped() ?></h3>
						<p><?= wfMessage( $messages['description'] )->escaped() ?></p>
					</li>
				</a>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
