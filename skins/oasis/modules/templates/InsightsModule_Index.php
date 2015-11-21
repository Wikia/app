<section class="insights-module <?= $themeClass ?> module">
	<h2><?= wfMessage( 'insights' )->escaped() ?></h2>
	<ul class="insights-module-list">
		<? foreach( $messageKeys as $key => $messages ) : ?>
			<?php $key = Sanitizer::encodeAttribute( $key ); ?>
			<li class="insights-module-item insights-icon-<?= strtolower( $key ) ?>">
				<a href="<?= InsightsHelper::getSubpageLocalUrl( $key ) ?>" class="insights-module-link" data-type="<?= $key ?>">
					<?= wfMessage( $messages['subtitle'] )->escaped() ?>
				</a>
			</li>
		<? endforeach; ?>
	</ul>
	<a class="more" href="<?= SpecialPage::getTitleFor( 'Insights' )->getFullURL() ?>"><?= wfMessage( 'insights-module-see-more' )->escaped() ?></a>
</section>
