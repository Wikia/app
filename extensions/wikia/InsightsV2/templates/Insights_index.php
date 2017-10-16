<div class="insights-container-landing <?= $themeClass ?>">
	<div class="insights-landing-header">
		<h1><?= wfMessage( 'insights-landing-title' )->escaped() ?></h1>
		<p><?= wfMessage( 'insights-landing-lead' )->parse() ?></p>
	</div>
	<div class="insights-landing-nav">
		<ul class="insights-landing-nav-list">
			<?php foreach( InsightsHelper::getInsightsPages() as $key => $subpage ) : ?>
				<li class="insights-landing-nav-item insights-icon-<?= $key ?>" data-type="<?= Sanitizer::encodeAttribute( $subpage ) ?>">
					<a href="<?= InsightsHelper::getSubpageLocalUrl( $key ) ?>">
						<h3><?= wfMessage( InsightsHelper::INSIGHT_SUBTITLE_MSG_PREFIX . $key )->escaped() ?></h3>
					</a>
					<p><?= wfMessage( InsightsHelper::INSIGHT_DESCRIPTION_MSG_PREFIX . $key )->parse() ?></p>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
