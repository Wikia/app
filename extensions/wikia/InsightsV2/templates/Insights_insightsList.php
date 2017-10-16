<ul class="insights-nav-list">
	<? foreach( $insightsList as $key => $insight ) : ?>
		<?php $type == $key ? $class = 'active' : $class = '' ?>
		<li class="insights-nav-item insights-icon-<?= $key ?> <?= $class ?>">
			<a href="<?= InsightsHelper::getSubpageLocalUrl( $key ) ?>" class="insights-nav-link">
				<?php if ( $insight['count'] ): ?>
					<div class="insights-red-dot<?php if ( $insight['highlighted'] ):?> highlighted<?php endif ?>"><div class="insights-red-dot-count"><?= $insight['count'] ?></div></div>
				<?php endif ?>

				<?= wfMessage(  $insight['subtitle'] )->escaped() ?>
			</a>
		</li>
	<? endforeach; ?>
</ul>
