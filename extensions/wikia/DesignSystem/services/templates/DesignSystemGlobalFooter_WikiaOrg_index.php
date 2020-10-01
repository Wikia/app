<footer class="wds-global-footer-wikia-org">
	<h2 class="wds-global-footer-wikia-org__header">
		<a href="<?= Sanitizer::encodeAttribute( $model['header']['href'] ); ?>"
		   data-tracking-label="<?= Sanitizer::encodeAttribute( $model['header']['tracking_label'] ) ?>"
		   title="<?= DesignSystemHelper::renderText( $model['header']['title'] ); ?>">
			<?= DesignSystemHelper::renderApiImage(
				$model['header']['image-data'],
				'wds-global-footer__header-logo',
				DesignSystemHelper::renderText( $model['header']['title'] )
			) ?>
		</a>
	</h2>
	<ul class="wds-global-footer-wikia-org__links">
		<?php foreach ( $model['site_overview']['links'] as $link ) : ?>
			<li class="wds-global-footer-wikia-org__link">
				<a href="<?= $link['href'] ?>" data-tracking-label="<?= $link['tracking_label'] ?>">
					<?= DesignSystemHelper::renderText( $link ); ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</footer>
