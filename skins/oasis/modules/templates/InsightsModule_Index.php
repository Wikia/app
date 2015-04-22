<section class="insights-module <?= $themeClass ?> module">
	<h1><?= wfMessage( 'insights' )->escaped() ?></h1>
	<ul class="insights-module-list">
		<? foreach( $messageKeys as $key => $messages ) : ?>
			<li class="insights-module-item insights-icon-<?= strtolower( $key ) ?>">
				<a href="<?= InsightsHelper::getSubpageLocalUrl( $key ) ?>" class="insights-module-link">
					<?= wfMessage( $messages['subtitle'] )->escaped() ?>
				</a>
			</li>
		<? endforeach; ?>
	</ul>
</section>