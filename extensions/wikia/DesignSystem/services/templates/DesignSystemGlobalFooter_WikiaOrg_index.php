<footer class="wds-global-footer">
	<?php if ( isset ( $model['header'] ) ) : ?>
		<h2 class="wds-global-footer__header">
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
	<?php endif; ?>
	<ul class="wds-global-footer-wikia-org__links">
		<li class="wds-global-footer-wikia-org__link">
			<?= DesignSystemHelper::renderText( [
				'key' => 'global-footer-site-overview-link-wikia-inc',
				'params' => ['year' => date("Y")]
			] ) ?>
		</li>

		<?php foreach ( $model['site_overview']['links'] as $link ) : ?>
			<li class="wds-global-footer-wikia-org__link">
				<a href="<?= $link['href'] ?>" data-tracking-label="<?= $link['tracking_label'] ?>">
					<?= DesignSystemHelper::renderText( $link['title'] ); ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
	<div class="wds-global-footer__bottom-bar">
		<?= $app->renderPartial(
			'DesignSystemGlobalFooterService',
			'mobileSiteButton',
			[
				'model' => $model['mobile_site_button']
			]
		); ?>
	</div>

</footer>
