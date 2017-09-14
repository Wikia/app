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
		<div class="wds-global-footer__fandom-sections">
			<?= $app->renderView(
				'DesignSystemGlobalFooterService',
				'section',
				[
					'model' => $model['fandom_overview'],
					'name' => 'fandom-overview',
					'parentName' => 'fandom'
				]
			); ?>
			<?= $app->renderView(
				'DesignSystemGlobalFooterService',
				'section',
				[
					'model' => $model['follow_us'],
					'name' => 'follow-us',
					'parentName' => 'fandom'
				]
			); ?>
		</div>
		<div class="wds-global-footer__wikia-sections">
			<?= $app->renderView(
				'DesignSystemGlobalFooterService',
				'section',
				[
					'model' => $model['company_overview'],
					'name' => 'company-overview',
					'parentName' => 'wikia'
				]
			); ?>
			<?= $app->renderView(
				'DesignSystemGlobalFooterService',
				'section',
				[
					'model' => $model['site_overview'],
					'name' => 'site-overview',
					'parentName' => 'wikia'
				]
			); ?>
			<?= $app->renderView(
				'DesignSystemGlobalFooterService',
				'section',
				[
					'model' => $model['community'],
					'name' => 'community',
					'parentName' => 'wikia'
				]
			); ?>
			<?= $app->renderView(
				'DesignSystemGlobalFooterService',
				'section',
				[
					'model' => $model['create_wiki'],
					'name' => 'create-wiki',
					'parentName' => 'wikia'
				]
			); ?>
			<?= $app->renderView(
				'DesignSystemGlobalFooterService',
				'section',
				[
					'model' => $model['community_apps'],
					'name' => 'community-apps',
					'parentName' => 'wikia'
				]
			); ?>
			<?= $app->renderView(
				'DesignSystemGlobalFooterService',
				'section',
				[
					'model' => $model['advertise'],
					'name' => 'advertise',
					'parentName' => 'wikia'
				]
			); ?>
		</div>
	</div>
	<?= $app->renderView(
		'DesignSystemGlobalFooterService',
		'licensingAndVertical',
		[
			'model' => $model['licensing_and_vertical']
		]
	); ?>
</footer>
