<div class="wds-button-group">
	<a href="<?= $buttonAction['href'] ?>"
	   class="wds-is-squished wds-button"
	   id="<?= $buttonAction['id'] ?>"
	   data-tracking="<?= $buttonAction['data-tracking'] ?>"
	   <?= empty( $buttonAction['accesskey'] ) ? '' : "accesskey=\"{$buttonAction['accesskey']}\"" ?>
	>
		<?= DesignSystemHelper::renderSvg( $buttonAction['icon'], 'wds-icon wds-icon-small' ); ?>
		<span><?= $buttonAction['text'] ?></span>
	</a>
	<div class="wds-dropdown">
		<div class="wds-button wds-is-squished wds-dropdown__toggle">
			<?= DesignSystemHelper::renderSvg( 'wds-icons-dropdown-tiny', 'wds-icon wds-icon-tiny wds-dropdown__toggle-chevron' ); ?>
		</div>
		<div class="wds-dropdown__content wds-is-not-scrollable wds-is-right-aligned">
			<ul class="wds-list wds-is-linked">
				<? foreach( $dropdownActions as $action ): ?>
					<li>
						<a id="<?= $action['id'] ?>"
						   href="<?= $action['href'] ?>"
						   data-tracking="<?= $action['data-tracking'] ?>"
						   <?= empty( $action['accesskey'] ) ? '' : "accesskey=\"{$action['accesskey']}\"" ?>>
							<?= $action['text'] ?>
						</a>
					</li>
				<? endforeach; ?>
			</ul>
		</div>
	</div>
</div>
