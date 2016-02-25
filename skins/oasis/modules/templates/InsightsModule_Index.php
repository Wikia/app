<section class="insights-module <?= $themeClass ?> module">
	<h2><?= wfMessage( 'insights' )->escaped() ?></h2>
	<ul class="insights-module-list">
		<? foreach( $insightsList as $key => $insight) : ?>
			<?php $key = Sanitizer::encodeAttribute( $key ); ?>
			<li class="insights-module-item insights-icon-<?= strtolower( $key ) ?>">
				<a href="<?= InsightsHelper::getSubpageLocalUrl( $key ) ?>" class="insights-module-link" data-type="<?= $key ?>">
					<?php if ( $insight['count'] ): ?>
						<div class="insights-red-dot<?php if ( $insight['highlighted'] ):?> highlighted<?php endif ?>"><div class="insights-red-dot-count"><?= $insight['count'] ?></div></div>
					<?php endif ?>

					<?= wfMessage( $insight['subtitle'] )->escaped() ?>
				</a>
			</li>
		<? endforeach; ?>
	</ul>
	<a class="more" href="<?= SpecialPage::getTitleFor( 'Insights' )->getFullURL() ?>"><?= wfMessage( 'insights-module-see-more' )->escaped() ?></a>
</section>
