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
	<div class="wds-global-footer__main">
		<div class="wds-global-footer__column">
			<?= $app->renderView(
				'DesignSystemGlobalFooterService',
				'sectionV2',
				[
					'model' => $model['fandom_overview'],
					'name' => 'fandom-overview',
				]
			); ?>
			<?= $app->renderView(
				'DesignSystemGlobalFooterService',
				'sectionV2',
				[
					'model' => $model['follow_us'],
					'name' => 'follow-us',
				]
			); ?>
		</div>
		<div class="wds-global-footer__column">
			<?= $app->renderView(
				'DesignSystemGlobalFooterService',
				'sectionV2',
				[
					'model' => $model['site_overview'],
					'name' => 'site-overview',
				]
			); ?>
		</div>
		<div class="wds-global-footer__column">
			<?= $app->renderView(
				'DesignSystemGlobalFooterService',
				'sectionV2',
				[
					'model' => $model['community'],
					'name' => 'community',
				]
			); ?>
			<?= $app->renderView(
				'DesignSystemGlobalFooterService',
				'sectionV2',
				[
					'model' => $model['advertise'],
					'name' => 'advertise',
				]
			); ?>
		</div>
		<div class="wds-global-footer__column">
			<?= $app->renderView(
				'DesignSystemGlobalFooterService',
				'sectionV2',
				[
					'model' => $model['fandom_apps'],
					'name' => 'fandom-apps',
				]
			); ?>
			<?= $app->renderView(
				'DesignSystemGlobalFooterService',
				'sectionV2',
				[
					'model' => $model['fandom_stores'],
					'name' => 'fandom-stores',
				]
			); ?>
			<?= $app->renderView(
				'DesignSystemGlobalFooterService',
				'sectionV2',
				[
					'model' => $model['ddb_stores'],
					'name' => 'ddb-stores',
				]
			); ?>
		</div>
	</div>
	<div class="wds-global-footer__bottom-bar">
		<?= $app->renderPartial(
			'DesignSystemGlobalFooterService',
			'licensingAndVertical',
			[
				'model' => $model['licensing_and_vertical']
			]
		); ?>

		<?= $app->renderPartial(
			'DesignSystemGlobalFooterService',
			'mobileSiteButton',
			[
				'model' => $model['mobile_site_button']
			]
		); ?>
	</div>

</footer>
