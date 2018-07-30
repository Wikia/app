<nav class="wds-global-navigation__links">
	<?php foreach ( $model as $item ): ?>
		<?php if ( $item['type'] === 'link-text' ): ?>
			<?= $app->renderPartial( 'DesignSystemGlobalNavigationService', 'linkText',
				[ 'model' => $item, 'standaloneLink' => true ] ); ?>
		<?php else: ?>
			<?= $app->renderPartial( 'DesignSystemGlobalNavigationService', 'linkGroup',
				[ 'model' => $item ] ); ?>
		<?php endif; ?>
	<?php endforeach; ?>
</nav>
