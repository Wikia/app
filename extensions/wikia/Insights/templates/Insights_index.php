<div class="insights-container-landing <?= $themeClass ?>">
	<div class="insights-landing-header">
		<h1><?= wfMessage( 'insights-landing-title' )->escaped() ?></h1>
		<p><?= wfMessage( 'insights-landing-lead' )->parse() ?></p>
	</div>
	<div class="insights-landing-nav">
		<ul class="insights-landing-nav-list">
			<?php foreach( InsightsHelper::$insightsMessageKeys as $key => $messages ) : ?>
				<li class="insights-landing-nav-item insights-icon-<?= strtolower( $key ) ?>">
					<a href="<?= InsightsHelper::getSubpageLocalUrl( $key ) ?>">
						<h3><?= wfMessage( $messages['subtitle'] )->escaped() ?></h3>
					</a>
					<p><?= wfMessage( $messages['description'] )->escaped() ?></p>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
