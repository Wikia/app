<div class="page-header__contribution-buttons">
	<? if ( $actionButton->shouldDisplay() ): ?>
		<?= $app->renderView( 'Wikia\PageHeader\PageHeader', 'actionButton', [
			'actionButton' => $actionButton
		] ); ?>
	<? endif; ?>
	<? foreach ( $buttons->buttons as $button ): ?>
		<a class="wds-button wds-is-squished <?= $button->class ?>" href="<?= $button->href ?>"
		   id="<?= $button->id ?>">
			<? if ( !empty( $button->icon ) ): ?>
				<?= DesignSystemHelper::renderSvg( $button->icon, 'wds-icon wds-icon-small' ); ?>
			<? endif; ?>
			<span><?= $button->label ?></span>
		</a>
	<? endforeach; ?>
</div>
