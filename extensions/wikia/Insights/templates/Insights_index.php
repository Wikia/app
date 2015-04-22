<div class="insights-container-landing">
	<div class="insights-landing-header">
		<h1><?= wfMessage( 'insights-landing-title' )->escaped() ?></h1>
		<p><?= wfMessage( 'insights-landing-lead' )->escaped() ?></p>
	</div>
	<div class="insights-landing-nav">
		<ul class="insights-landing-nav-list">
			<?php foreach( InsightsHelper::$insightsPages as $key => $subpage ) : ?>
				<a href="<?= InsightsHelper::getSubpageLocalUrl( $key ) ?>">
					<li class="insights-landing-nav-item insights-icon-<?= $key ?>">
						<h3><?= wfMessage( InsightsHelper::INSIGHT_SUBTITLE_MSG_PREFIX . $key )->escaped() ?></h3>
						<p><?= wfMessage( InsightsHelper::INSIGHT_DESCRIPTION_MSG_PREFIX . $key )->escaped() ?></p>
					</li>
				</a>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
