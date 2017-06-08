<div>
	<? if ( $actionButton->shouldDisplay() ): ?>
		<?= $app->renderView( 'Wikia\PageHeader\PageHeader', 'actionButton' ); ?>
	<? endif; ?>
	<?php foreach ( $buttons as $button ): ?>
		<a class="wds-button wds-is-squished <?= $button->class ?>" href="<?= $button->href ?>"
		   id="<?= $button->id ?>">
			<? if ( !empty( $button->icon ) ): ?>
				<?= DesignSystemHelper::renderSvg( $button->icon, 'wds-icon wds-icon-small' ); ?>
			<?php endif; ?>
			<span><?= $button->label ?></span>
		</a>
	<?php endforeach; ?>
</div>
